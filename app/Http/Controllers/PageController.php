<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();
        $page->increment('views_count');

        return view('pages.show', compact('page'));
    }
}
