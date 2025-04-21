<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

const TRANSACTION = "transactions";

class TransactionController extends BaseController
{
    private $doctype;
    
    public function __construct()
    {
        Log::info("Constructor");
        Parent::__construct(TRANSACTION);
    }

    public function apply_filters($query) {
        $query->where('doc_type', $this->doctype);
    }
/* 
    public function config($doctype) {

        $this->name = TRANSACTION;


        $prepare['title'] = "Transaction $this->doctype";
        $prepare["data"]["doc_type"] = $this->doctype;
        $prepare["columns"] = array_map(function($column) {
            if ($column->id == "doc_type") {
                $column->type = "hidden";
            }
            return $column;
        }, $prepare["columns"]);

        return $prepare;
    }
 */

    public function transaction($doctype)
    {
        $this->doctype = $doctype;

        Log::info("transaction $doctype $this->name");

        return Parent::index(TRANSACTION);
    }

    public function show($doctype, $action, $id)
    {
        return Parent::show(TRANSACTION, $action, $id);
    }
/* 
    public function export($doctype, $callback = null) {
        
        return Parent::export(TRANSACTION, 
        $this->config($doctype));
    }

    public function import($doctype)
    {
        return view("pages.import", ["name" => TRANSACTION]);
    } */
}
