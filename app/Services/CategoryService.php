<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoriesForHome()
    {
        // هنا يمكن إضافة منطق إضافي لو احتجت.
        return $this->categoryRepository->getActiveCategories();
    }
}
