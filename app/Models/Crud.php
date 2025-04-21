<?php

namespace App\Models;

use App\Constants\Constants;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Crud extends BaseModel
{
    public function setTable($table)
    {
        $this->table = $table;

        $list = \Schema::getColumnListing($table);

        if (($key = array_search(Constants::FD_COMPANY, $list)) !== false) {
            $this->hasCompany = true;
            unset($list[$key]);
        }

        foreach ($list as $name) {

            $column = new Column($table, $name);

            if ($column->timestamp) {
                $this->timestamps = true;
            }

            $this->columns [] = $column;
        }

        //Log::info("Columns: ". print_r($this->columns, true));

        return $this;
    }
}
