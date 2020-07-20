<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function listarSeries(Request $request)
    {
        var_dump($request->query());
        $series = [
            'Grey\'s Anatomy',
            'Lost',
            'Agents of SHIELD'
        ];

        $html = '<ul>';
        foreach ($series as $serie) {
            $html .= '<li>' . $serie . '</li>';
        }

        $html .= '</ul>';
        echo $html;
    }
}
