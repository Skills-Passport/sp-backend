<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function with(Request $request)
    {
        return $request->query('with') ? explode(',', $request->query('with')) : [];
    }
}
