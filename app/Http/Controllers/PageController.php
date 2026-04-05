<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; // Asumiendo que tienes un modelo Page

class PageController extends Controller
{
    public function show($slug)
    {
        // ⚡ Bolt: Database and memory optimization.
        // What: Added caching using Cache::remember() for fetching Page models by their slug.
        // Why: Static pages (like Privacy Policy, Terms, etc.) are rarely updated but frequently accessed.
        //      Fetching the entire Page model on every single request consumes unnecessary database connections,
        //      query execution time, and CPU/memory overhead for Eloquent model hydration.
        // Impact: Eliminates redundant database queries for static content, drastically improving response times
        //         and reducing database load under high concurrency.
        $page = \Illuminate\Support\Facades\Cache::remember('page_' . $slug, 300, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
