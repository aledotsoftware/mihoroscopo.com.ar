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
        // What: Wrapped the Page::where() query in a Cache::remember block with a 300-second TTL.
        // Why: The 'Page' content is relatively static and rarely changes. Executing an Eloquent hydration
        //      query on every request for the same slug wastes database and CPU resources under load.
        // Impact: Eliminates database hits for frequent page views, improving response times.
        $page = Cache::remember("page_{$slug}", 300, function () use ($slug) {
            return Page::where('slug', $slug)->firstOrFail();
        });
        return view('mihoroscopo/pages.show', compact('page'));
    }
}
