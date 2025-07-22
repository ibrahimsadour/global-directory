<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Category;
use App\Models\Governorate;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $sort = 'latest';
    public string $view = 'list';
    public ?int $selectedCategory = null;
    public ?int $selectedGovernorate = null;
    public ?int $ratingFilter = null;
    public ?string $initialCategorySlug = null;

    protected $queryString = [
        'sort' => ['except' => 'latest'],
        'view' => ['except' => 'list'],
        'selectedCategory' => ['except' => null, 'as' => 'cat'],
        'ratingFilter' => ['except' => null, 'as' => 'rating'],
        'selectedGovernorate' => ['except' => null, 'as' => 'gov'],
    ];

    protected $casts = [
        'selectedCategory' => 'integer',
        'selectedGovernorate' => 'integer',
        'ratingFilter' => 'integer',
    ];

    public function mount($categorySlug = null)
    {
        $this->initialCategorySlug = $categorySlug;

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
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
        $this->reset([
            'sort',
            'view',
            'selectedCategory',
            'ratingFilter',
            'selectedGovernorate',
        ]);

        // إذا كان هناك slug للفئة، أعد التوجيه إليها
        if ($this->initialCategorySlug) {
            return redirect()->route('categories.show', ['slug' => $this->initialCategorySlug]);
        }

        // إذا لم يكن هناك فئة محددة، أعد التوجيه إلى صفحة كل النشاطات
        return redirect()->route('categories.index');
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
            $query->whereHas('googleData', function ($q) {
                $q->where('google_rating', '>=', $this->ratingFilter);
            });
        }

        switch ($this->sort) {
            case 'oldest':
                $query->oldest();
                break;

            case 'high_rating':
                $query->leftJoin('business_google_data', 'businesses.id', '=', 'business_google_data.business_id')
                    ->orderByDesc('business_google_data.google_rating')
                    ->select('businesses.*');
                break;

            case 'low_rating':
                $query->leftJoin('business_google_data', 'businesses.id', '=', 'business_google_data.business_id')
                    ->orderBy('business_google_data.google_rating')
                    ->select('businesses.*');
                break;

            case 'latest':
            default:
                $query->latest();
        }

        $parentCategory = null;
        $categories = [];

        if ($this->initialCategorySlug) {
            $parentCategory = Category::where('slug', $this->initialCategorySlug)->first();
            if ($parentCategory) {
                $categories = $parentCategory->children()->where('is_active', true)->get();
            }
        } else {
            $categories = Category::with('children')
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->get();
        }

        return view('livewire.business-list', [
            'businesses' => $query->paginate(10),
            'governorates' => Governorate::where('is_active', true)->get(),
            'categories' => $categories,
            'selectedCategory' => $this->selectedCategory,
            'selectedGovernorate' => $this->selectedGovernorate,
            'ratingFilter' => $this->ratingFilter,
            'parentCategory' => $parentCategory,
        ]);
    }
}
