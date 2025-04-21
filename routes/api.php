<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Column; 

Route::get('/search/id', function(Request $request) {
    
    $column = $request->input('column');
    $id = $request->input('id');
    $rows = Column::get_search($column, $id, false);
    return response()->json(['data' => $rows[0] ?? []]);
});

Route::get('/search', function(Request $request) {
    
    $column = $request->input('column');
    $text = $request->input('text');
    $rows = Column::get_search($column, $text, true);
    return response()->json(['data' => $rows]);
});