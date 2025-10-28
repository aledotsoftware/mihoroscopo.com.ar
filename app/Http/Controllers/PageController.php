<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; // Asumiendo que tienes un modelo Page

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('mihoroscopo/pages.show', compact('page'));
    }
}
