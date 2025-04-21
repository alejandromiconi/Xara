<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

const UDCs = "udcs";   

class UdcController extends CrudController
{
    public function udcs($udc)
    {
        $this->name = UDCs;

        $prepare = $this->prepare(false, 
        function($query) use ($udc) {
            $query->where('udc', $udc);
        });

        $prepare['title'] = "UDC $udc";

        return view("pages.search", $prepare);
    }

    public function show($udc, $action, $id, $callback = null)
    {
        $setParameters = function ($parameters) use ($udc, $action, $id) {
            $parameters['title'] = "UDC $udc";
            $parameters["data"]["udc"] = $udc;
            $parameters["columns"] = array_map(function($column) {
                if ($column->id == "udc") {
                    $column->type = "hidden";
                }
                return $column;
            }, $parameters["columns"]);

            //Log::debug(print_r($parameters, true));

            return $parameters;
        };

        return Parent::show(UDCs, $action, $id, $setParameters);
    }

    public function export($udc, $callback = null) {
        return Parent::export(UDCs, 
        function($query) use ($udc) {
            $query->where('udc', $udc);
        });
    }

    public function import($udc)
    {
        return view("pages.import", ["name" => UDCs]);
    }
}
