<?php 
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getActiveCategories()
    {
        return Category::where('is_active', 1)
            ->orderBy('order', 'asc')
            ->get();
    }
}
