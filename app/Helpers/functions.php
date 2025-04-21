<?php

use App\Models\Crud;
use App\Constants\Constants;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

function get_name($name)
{
    $name = Str::replace(['_', '-'], ' ', $name);
    return ucfirst($name);
}

function get_date_from_input($inputdatetime)
{

    try {
        $format = Auth::user()->datetime_format ?? Constants::DATETIME_FORMAT;

        // Chequeamos si solo viene fecha..
        $split = explode(" ", $inputdatetime);
        if (count($split) == 1) {
            $format = explode(" ", $format)[0];
        }

        $dt = Carbon::createFromFormat($format, $inputdatetime)
            ->format(Constants::DATETIME_FORMAT);

        return $dt;

    } catch (Exception $e) {
        Log::error("Parsing date error $inputdatetime: " . $e->getMessage());
    }
}

function get_date_from_database($datetime, $date_only = false)
{
    $format = Auth::user()->datetime_format ?? Constants::DATETIME_FORMAT;

    if ($date_only) {
        $split = explode(" ", $datetime);
        if (count($split) == 1) {
            $format = explode(" ", $format)[0];
        }
    }

    return Carbon::parse($datetime)->format($format);
}

function get_error_messages($errors)
{
    $messages = [];
    if ($errors->any()) {
        foreach ($errors->all() as $error) {
            $messages[] = $error; //->message;
        }
    } else {

        $bags = $errors->getBags(); // Devuelve un array con todos los bags

        foreach ($bags as $bagName => $bag) {
            #echo "Errores en el bag: $bagName <br>";

            foreach ($bag->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    if (!in_array($message, $messages)) {
                        $messages[] = $message;
                    }
                }
            }
        }

    }


    return $messages;
}

function get_url() {

    $path = request()->path();
    $path = explode('/', $path); // Separamos el path por '/'

    return "/$path[0]/$path[1]";  
}

function starts_with($haystack, $needle)
{
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function has_company($table) {

    $list = \Schema::getColumnListing($table);
    return in_array(Constants::FD_COMPANY, $list);
}