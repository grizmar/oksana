<?php

namespace App\Http\Controllers;

class BaseRestController extends Controller
{

    public function show()
    {
        return \response()->rest(['hello']);
    }

    public function index()
    {
        return \response()->rest(['method' => 'index']);
    }
}
