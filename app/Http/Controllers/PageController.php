<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; // Asumiendo que tienes un modelo Page
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function show($slug)
    {
        // ⚡ Bolt: Database and memory optimization.
        // What: Wrapped the Page model retrieval in Cache::remember with a 300-second TTL.
        // Why: Static pages (like terms, about, etc.) are frequently accessed but rarely updated.
        //      Fetching the Eloquent model from the database on every request adds unnecessary overhead.
        // Impact: Eliminates database query and Eloquent model hydration for cached requests, speeding up page load time.
        $page = Cache::remember('page_' . $slug, 300, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
