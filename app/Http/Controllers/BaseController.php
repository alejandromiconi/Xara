<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Models\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

abstract class BaseController extends Controller
{
    protected $name;
 
    /**
     * Modelo asociado al controlador
     * Debe ser definido en las clases hijas
     */
    protected $model;
    

    public function __construct($name)
    {
        $this->name = $name;

        // Validate table name exists in database
        if (!Schema::hasTable($this->name)) {
            abort(404, "Table $this->name, not found");
        }

        // Create generic model instance
        $this->model = $model = (new Crud())->setTable($this->name);
    }


    abstract protected function apply_filters($query);

    protected function prepare($all = false)
    {
        $model = $this->model;

        $timestamps = request()->get("include_timestamps", false);
        $columns = $timestamps ? $model->columns :
            array_filter($model->columns, fn($column) => $column->timestamp == false);

        $query = $model->newQuery();

        foreach ($columns as $column) {
            if (request()->filled($column->id)) {
                $str = str_replace("*", "%", request()->get($column->id));
                $query->where($column->id, 'like', $str);
            }
        }

        $this->apply_filters($query);
        
        $data = $all ?
            $query->limit(Constants::EXPORT_LIMITS)->get() :
            $query->simplePaginate(Constants::PAGINATION);

        $prepare = [
            "name" => $this->name,
            "columns" => $columns,
            "actions" => $this->get_actions($this->name),
            "values" => request()->all(),
            "data" => $data,
            "count" => $query->count(),
        ];

        return $prepare;
    }

    public function index($name)
    {
        return view("pages.search", $this->prepare());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name, string $action, string $id)
    {
        $record = [
            "name" => $name,
            "id" => $id,
            "columns" => $this->model->columns,
            "data" => $this->model->find($id),
            "action" => $action,
        ];

        return view("pages.edit", $record); 
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $json = json_decode($request->_json);
        $name = $json->name;
        $action = $json->action;
        $id = $json->id;

        $model = (new Crud())->setTable($name);

        $except = [Constants::ID, '_json', '_token'];
        if ($model->timestamps) {
            $except[] = Constants::FD_CREATED_AT;
            $except[] = Constants::FD_UPDATED_AT;
        }

        foreach($model->columns as $column) {
            if ($column->type === 'checkbox') {
                $request->merge([$column->id => $request->input($column->id) === "on" ? 1 : 0]);
            }
        }

        try {

            switch ($action) {

                case Constants::ACTION_CREATE:
                case Constants::ACTION_COPY:

                    if ($model->hasCompany) {
                        $request->merge(["company_id" => session("company_id")]);
                    }

                    foreach ($request->except($except) as $key => $value) {
                        $model->setAttribute($key, $value);
                    }

                    $model->save();
                    $id = $model->id;
                    break;

                case Constants::ACTION_EDIT:
                    $model->where('id', $id)->update($request->except($except));
                    break;

                case Constants::ACTION_DELETE:
                    $model->find($id)->delete();

                    return redirect()->to(get_url())
                        ->with("success", get_name($name) . " $action!");

            }

            /*return redirect()->route($url,
                ["name" => $name, "action" => Constants::ACTION_VIEW, Constants::ID => $id]
            ) */
            
            $url = get_url() . "/" . Constants::ACTION_VIEW . "/" . $id;
            
            return redirect()->to($url)
                ->with("success", get_name($name) . " updated!");

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', "Error $action $name, " . $e->getMessage());
        }
    }


    public function export($name, $callback = null)
    {
        $this->name = $name;

        $prepare = $this->prepare(true);

        $filename = $name . "_" . date('Ymd') . ".csv";

        $callback = function () use ($prepare) {

            //$data = $prepare["data"]->toArray();
            $data = $prepare["data"];
            $file = fopen('php://output', 'w');

            $columns = $this->model->getColumnsList("name");  

            // Add CSV headers
            fputcsv($file, $columns);

            // Add data rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        // Set headers for CSV download
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return Response::stream($callback, 200, $headers);
    }

    public function import($name)
    {
        return view("pages.import", ["name" => $name]);
    }

    public function upload(Request $request)
    {

        $json = json_decode($request->_json);
        $this->name = $json->name;


        // Create generic model instance
        $model = (new Crud())->setTable($this->name);

        try {

            if (request()->file('file')->isValid()) {

                $storage = $request->file('file')->store('uploads');

                // Get the full filesystem path
                $path = Storage::path($storage);

                $file = fopen($path, 'r');

                // Apply a function to each element
                $columns = array_map(function ($item) {
                    return str_replace(" ", "_", strtolower($item));
                }, fgetcsv($file));

                foreach ($columns as $index => $column) {

                    // Chequeamos que el tipo de dato y que se encuentre en la tabla
                    $founder = array_filter($model->columns, function ($item) use ($column) {
                        return $item->id == $column;
                    });

                    if (count($founder) != 1)
                        continue;

                    foreach ($founder as $found) {
                        $found->index = $index;
                    }
                }

                $chunkSize = 1000;
                $chunk = [];
                while ($row = fgetcsv($file)) {

                    $newrow = [];
                    foreach ($model->columns as $column) {

                        if ($request->ignore_id && $column->id == Constants::ID) {
                            continue;
                        } elseif (isset($column->index)) {

                            $value = $row[$column->index];

                            switch ($column->type) {
                                case "date":
                                    $value = get_date_from_input($value);
                                    break;

                            }

                            $newrow[$column->id] = $value;

                        } elseif ($column->timestamp) {
                            $newrow[$column->id] = now();
                        }
                    }

                    if ($model->hasCompany) {
                        $newrow["company_id"] = session("company_id");
                    }

                    $chunk[] = $newrow; //array_combine($columns, $row);
                    if (count($chunk) >= $chunkSize) {
                        $model->insert($chunk);
                        $chunk = [];
                    }
                }

                // Insert remaining records
                if (!empty($chunk)) {
                    $model->insert($chunk);
                }

                fclose($file);

                return back()->with('success', 'File uploaded successfully!')
                    ->with('path', $path);
            } else {
                throw new \Exception("Error Processing Request");
            }


        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function get_actions($name)
    {
        $this->name = $name;

        $actions = [];
        $actions[] = $this->get_action(Constants::ACTION_CREATE, "", Constants::PART_HEADER);

        $export = $this->get_action("export", "bi-cloud-arrow-down", Constants::PART_HEADER, true);
        //$export["name"] .= " (Max " . Constants::EXPORT_LIMITS . " rows)";
        $export["submit"] = true;

        $actions[] = $export;

        $actions[] = $this->get_action("import", "bi-cloud-arrow-up", Constants::PART_HEADER, true);

        $actions[] = $this->get_action(Constants::ACTION_VIEW, "bi-search");
        $actions[] = $this->get_action(Constants::ACTION_EDIT, "bi-pencil-square.blue");
        $actions[] = $this->get_action(Constants::ACTION_COPY, "bi-clipboard-check.green");
        //$actions[] = ["part" => Constants::PART_DETAIL];
        $actions[] = $this->get_action(Constants::ACTION_DELETE, "bi-trash.red");

        $bulk_delete = $this->get_action("b_delete", "", Constants::PART_BULK);
        $bulk_delete["name"] = "Delete";

        $actions[] = $bulk_delete;
        
        return $actions;
    }

    private function get_action($action, $icons, $part = Constants::PART_DETAIL, $route = false)
    {
        $array = explode(".", $icons);

        if (count($array) == 2) {
            $icon = $array[0];
            $color = $array[1];

        } else {
            $icon = $icons;
            $color = "";
        }

        return
            [
                "id" => $action,
                "name" => get_name($action),
                //"route" => $route ? "crud.$action" : "crud.show",
                "byid" => !$route,
                "part" => $part,
                "color" => $color,
                "icon" => $icon,
            ];
    }
}
