<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Models\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class CrudController extends BaseController
{

    public function apply_filters($query) {
    }

    public function index($name)
    {
        Log::debug("index $name");

        return view("pages.search", $this->prepare());
    }
}
