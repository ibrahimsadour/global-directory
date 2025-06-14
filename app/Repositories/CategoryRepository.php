<?php 
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
public function getActiveCategories()
{
    return Category::with('children')
        ->where('is_active', 1)
        ->whereNull('parent_id')
        ->orderBy('order', 'asc')
        ->get();
}

}
