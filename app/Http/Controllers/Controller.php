<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function loadRelations(Request $request)
    {
        return $request->query('with') ? explode(',', $request->query('with')) : [];
    }
}

