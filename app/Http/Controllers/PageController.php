<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; // Asumiendo que tienes un modelo Page
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function show($slug)
    {
        // ⚡ Bolt: Database query optimization.
        // What: Wrapped Page retrieval in Cache::remember with a 300s TTL.
        // Why: The 'pages' table contains rarely updated static content, but is fetched frequently.
        //      Caching this query prevents redundant Eloquent ORM hydration and database load on every request.
        // Impact: Eliminates database roundtrips for page views, drastically reducing database load.
        $page = Cache::remember('page_' . $slug, 300, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
