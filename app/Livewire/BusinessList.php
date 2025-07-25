<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Category;
use App\Models\Governorate;
use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;

class BusinessList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $sort = 'latest';
    public string $view = 'list';
    public $selectedCategory = null;
    public $selectedGovernorate = null;
    public $ratingFilter = null;
    public $selectedLocation = null;
    public ?string $initialCategorySlug = null;
    public $governorates = [];
    public $locations;

    protected $queryString = [
        'sort' => ['except' => 'latest'],
        'view' => ['except' => 'list'],
        'selectedCategory' => ['except' => null, 'as' => 'cat'],
        'ratingFilter' => ['except' => null, 'as' => 'rating'],
        'selectedGovernorate' => ['except' => null, 'as' => 'gov'],
        'selectedLocation' => ['except' => null, 'as' => 'loc'],
    ];

    protected $casts = [
        'selectedCategory' => 'integer',
        'selectedGovernorate' => 'integer',
        'ratingFilter' => 'integer',
        'selectedLocation' => 'integer',
    ];

    public function mount($categorySlug = null)
    {
        $this->initialCategorySlug = $categorySlug;
        $this->governorates = Governorate::all();
        $this->locations = collect(); // Collection فارغة        
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $this->selectedCategory = $category->id;
            }
        }

        
    }
    public function updatedSelectedGovernorate($value)
    {
        $this->selectedLocation = null; // تصفير المدينة
        $govId = (int) $value;
        $this->locations = Location::where('governorate_id', $govId)->get();

        logger()->info('Governorate Selected', [
            'gov_id' => $govId,
            'locations_count' => $this->locations->count()
        ]);
    }


    public function updating($property)
    {
        if (in_array($property, ['sort', 'view', 'selectedCategory', 'ratingFilter', 'selectedGovernorate', 'selectedLocation'], true)) {
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
            'selectedLocation',
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
        logger()->info('Governorate ID', ['selected' => $this->selectedGovernorate]);

        $query = Business::query();

        // فلترة حسب الفئة
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // فلترة المدن عند اختيار المحافظة
        if ($this->selectedGovernorate && $this->locations->isEmpty()) {
            $this->locations = Location::where('governorate_id', (int)$this->selectedGovernorate)->get();
        }

        // فلترة حسب المدينة
        if ($this->selectedLocation) {
            $query->where('location_id', $this->selectedLocation);
        }

        // فلترة حسب التقييم
        if (!is_null($this->ratingFilter)) {
            $query->whereHas('googleData', function ($q) {
                $q->where('google_rating', '>=', $this->ratingFilter);
            });
        }

        // ترتيب النتائج
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

        // الفئات
        $parentCategory = null;
        $categories = [];

        if ($this->initialCategorySlug) {
            $parentCategory = Category::where('slug', $this->initialCategorySlug)->first();
            if ($parentCategory) {
                $categories = $parentCategory->children()->where('is_active', true)->get();
            }
        } else {
            $categories = Category::withCount('businesses')
                ->with(['children' => function ($q) {
                    $q->withCount('businesses')->where('is_active', 1);
                }])
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
            'locations' => $this->locations, // الخاصية الرئيسية
            'selectedLocation' => $this->selectedLocation,
        ]);
    }

}
