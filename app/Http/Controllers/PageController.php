<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(string $slug)
    {
        // قائمة المسارات المحجوزة
        $reservedSlugs = ['admin', 'login', 'register', 'logout', 'categories', 'businesses', 'blog', 'contact', 'faq', 'dashboard', 'filament'];

        if (in_array($slug, $reservedSlugs)) {
            abort(404);
        }

        $page = Page::where('slug', $slug)
                    ->where('is_active', true)
                    ->firstOrFail();

        return view('pages.show', compact('page'));
    }

}
