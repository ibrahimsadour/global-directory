<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Governorate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class BusinessList extends Component
{
    use WithPagination;

    // إذا كنت تستخدم Bootstrap لتنسيق الـ Pagination
    protected $paginationTheme = 'bootstrap';

    public string $sort = 'latest';
    public string $view = 'list';
    public ?int $selectedCategory = null;
    public ?int $selectedGovernorate = null;
    public ?int $ratingFilter = null;
    public ?string $initialCategorySlug = null;

    // حفظ الفلاتر في رابط الصفحة
    protected $queryString = [
        'sort' => ['except' => 'latest'],
        'view' => ['except' => 'list'],
        'selectedCategory' => ['except' => null],
        'ratingFilter' => ['except' => null],
        'selectedGovernorate' => ['except' => null],
    ];

    public function mount($categorySlug = null)
    {
        $this->initialCategorySlug = $categorySlug;

        if ($categorySlug) {
            $category = \App\Models\Category::where('slug', $categorySlug)->first();
            if ($category) {
                $this->selectedCategory = $category->id;
            }
        }
    }

    public function updating($property)
    {
        if (in_array($property, ['sort', 'view', 'selectedCategory', 'ratingFilter', 'selectedGovernorate'], true)) {
            $this->resetPage();
        }
    }
    public function resetFilters()
    {
        $this->reset(['sort', 'view', 'selectedCategory', 'ratingFilter', 'selectedGovernorate']);
    }

    public function render()
    {
        $query = Business::query();

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedGovernorate) {
            $query->where('governorate_id', $this->selectedGovernorate);
        }

        if (!is_null($this->ratingFilter)) {
            $query->where('rating', '>=', $this->ratingFilter);
        }

        switch ($this->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'high_rating':
                $query->orderByDesc('rating');
                break;
            case 'low_rating':
                $query->orderBy('rating');
                break;
            case 'latest':
            default:
                $query->latest();
        }

        return view('livewire.business-list', [
            'businesses' => $query->paginate(10),
            'governorates' => Governorate::where('is_active', true)->get(),
            'categories' => Category::with('children')
                        ->whereNull('parent_id')
                        ->where('is_active', true)
                        ->get(),
            'selectedCategory' => $this->selectedCategory,
            'selectedGovernorate' => $this->selectedGovernorate,
            'ratingFilter' => $this->ratingFilter,
        ]);
    }
}
