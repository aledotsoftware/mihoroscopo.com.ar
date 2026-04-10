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
        // What: Wrapped the Page model retrieval in Cache::remember with a 5-minute TTL.
        // Why: Static pages (like privacy policy, terms) are rarely updated but frequently accessed.
        //      Fetching the Eloquent model from the database on every request adds unnecessary overhead.
        // Impact: Reduces database load and Eloquent hydration overhead for repeatedly visited pages,
        //         speeding up response times.
        $page = Cache::remember('page_' . $slug, 300, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
