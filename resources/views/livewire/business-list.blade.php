<x-filters-popup 
    :categories="$categories" 
    :governorates="$governorates"
    :selectedCategory="$selectedCategory"
    :selectedGovernorate="$selectedGovernorate"
    :ratingFilter="$ratingFilter"
>
    {{-- ✅ شريط الأدوات والنتائج --}}
    @include('business.Livewire.businesses-toolbar', [
        'businesses' => $businesses, 
        'view' => $view
    ])

    @include('business.Livewire.businesses-view', [
        'businesses' => $businesses, 
        'view' => $view
    ])

    <div class="mt-6">
        {{ $businesses->links() }}
    </div>
</x-filters-popup>
