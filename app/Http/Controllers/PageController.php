<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Page; // Asumiendo que tienes un modelo Page

class PageController extends Controller
{
    public function show($slug)
    {
        // ⚡ Bolt: Database/Memory optimization.
        // What: Added Cache::remember to cache the Page model retrieval by slug.
        // Why: Static pages (like terms, privacy) are rarely updated but frequently accessed.
        //      Caching the result prevents redundant Eloquent ORM hydration and database load on every request.
        // Impact: Eliminates database query and memory allocation overhead per request for static pages.
        $page = Cache::remember('page_' . $slug, 86400, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
