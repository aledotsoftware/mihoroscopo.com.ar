<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; // Asumiendo que tienes un modelo Page
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function show($slug)
    {
        // ⚡ Bolt: Cache optimization.
        // What: Added caching to the Page retrieval.
        // Why: Static pages (like Privacy Policy, Terms) are rarely updated but frequently accessed.
        //      Fetching them from the database on every request adds unnecessary latency and database load.
        //      Caching the model directly prevents repeated queries. The cache key includes the page slug.
        // Impact: Reduces database queries to zero for cached pages, improving response time.
        $cacheKey = 'page_' . $slug;
        $page = Cache::remember($cacheKey, 86400, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
