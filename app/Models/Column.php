<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Termwind\Components\BreakLine;

class Column
{
    public $id, $name, $type, $table, $initial, $timestamp, $options, $multiple, $select;

    protected $guarded = [];

    public function is_numeric(): bool
    {
        return
            $this->type == Constants::FT_INTEGER ||
            $this->type == Constants::FT_FLOAT;
    }

    public function is_datetime(): bool
    {
        return
            $this->type == Constants::FT_DATE ||
            $this->type == Constants::FT_DATETIME;
    }

    public static function get_search($column_id, $id, $is_text = false) {

        if (empty($id)) {
            return [];
        }

        $column = DB::table("columns")
            ->where("column", $column_id)
            ->first();

        if (!$column) return false;

        $query = DB::table($column->table);

        if ($is_text) {
            $query->where($column->column_name, 'like', "%$id%");
        } else {
            $query->where("id", $id);
        }

        return $query
            ->select(DB::raw($column->search))
            ->get()
            ->map(function ($item)  {
                return array_values((array) $item);
            })
            ->toArray();
    }

    private function get_select($value) {

        $rows = DB::select($this->select, [$value]);
        if (count($rows) == 1) {
            $values = array_values((array) $rows[0]);
            return $values[1] ?? $value;
        }

        else {
            return "$value N/A"; 
        }
    }

    public function format($value, $isedition = false)
    {
        if ($isedition) {
            return $value;
        }

        switch ($this->type) {
            
            /*case Constants::FT_DATE:
                return get_date_from_database($value, true);

            case Constants::FT_DATETIME:
                return get_date_from_database($value);
            */
            
            case Constants::FT_SEARCH:
            case Constants::FT_SELECT:
                return $this->get_select($value);
        }

        return $value;
    }

    public function __construct($table, $id)
    {
        $this->id = $id;
        $this->name = get_name($id);
        $this->timestamp = in_array($id, Constants::timestampColumns());
        $this->options = [];
        $this->multiple = false;
        $this->initial = "";

        $type = \Schema::getColumnType($table, $id);

        $column = DB::table("columns")->where("column", $id)->first();

        $main = false;
        if ($column) {
            $type = $column->column_type;
            $this->name = $column->name;
            $this->multiple = $column->multiple == 1 ?? false;
            $this->table = $column->table;
            $main = $table == $this->table;

            if ($column->initial) {
                $this->initial = DB::select("SELECT $column->initial as value")[0]->value;
            }
        }

        if ($main) {
            $type = "";
        }

        else if (UDC::isUDC($id)) {

            $type = Constants::FT_SELECT;

            $this->options = array_map(function ($item) {
                return [
                    "value" => $item["udc_code"],
                    "label" => $item["udc_label"],
                ];
            }, UDC::getAll($id));

            $this->select = 
                "SELECT udc_code , udc_label 
                FROM udcs WHERE udc='$id' AND udc_code=?";


        } elseif ($column) {

            if ($type === Constants::FT_SELECT) {

                $this->options = array_map(
                    function ($item) {

                        $values = array_values((array) $item);
                        return [
                            "value" => $values[0],
                            "label" => $values[1],
                        ];

                    },
                    DB::table($column->table)
                        ->select(DB::raw($column->search))
                        ->get()
                        ->toArray()
                );

                $this->select = 
                    "SELECT $column->search 
                    FROM $column->table WHERE $id=?";
            }

            elseif ($type === Constants::FT_SEARCH) {
            
                $this->select = 
                    "SELECT $column->search 
                    FROM $column->table WHERE " . Constants::ID . "=?";
            
            }

        } elseif (str_contains($type, "int")) {
            $type = Constants::FT_INTEGER;
        }

        $this->type = $type;

    }
}
