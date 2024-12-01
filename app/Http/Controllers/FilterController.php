<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filter(Request $request, $page)
    {   
        $request->session()->put($page, $request->except(['_token']));
        // Salvar os filtros na sessão
        return redirect()->back();
    }

    public function clear(Request $request, $page)
    {
        $request->session()->forget($page);
        return redirect()->back(); 
    }
}
