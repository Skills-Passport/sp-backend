<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function loadRelations(Request $request, $default = []): array
    {
        $withs = $request->query('with') ? explode(',', $request->query('with')) : [];
        return array_unique(array_merge($default, $withs));
    }
}

