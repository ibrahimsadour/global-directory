<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('key');

        $query = Business::where('is_active', 1)
                         ->where('is_approved', 1);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        $businesses = $query->latest()->paginate(10);

        return view('search.index', [
            'businesses' => $businesses,
            'keyword' => $keyword,
        ]);
    }
}
