<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Page; // Asumiendo que tienes un modelo Page

class PageController extends Controller
{
    public function show($slug)
    {
        // ⚡ Bolt: Database and memory optimization.
        // What: Wrapped the Page model retrieval inside Cache::remember for 24 hours.
        // Why: The 'pages' table contains static content (like Terms and Conditions, Privacy Policy)
        //      that rarely changes but is frequently accessed by users. Retrieving the model from the DB
        //      on every request causes unnecessary database queries and model hydration overhead.
        // Impact: Eliminates redundant database SELECT queries and Eloquent ORM hydration for static content,
        //         significantly improving response times under high load.
        $page = Cache::remember('page_' . $slug, 86400, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });

        return view('mihoroscopo/pages.show', compact('page'));
    }
}
