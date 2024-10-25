<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model; 

class ModelController extends Controller
{
    public function show(Request $request)
    {
        $data = Model::all(); 
        return response()->json($data, 200);
    }
}

