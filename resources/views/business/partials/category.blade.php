<div class="overview services shadow-sm no-margin ">
    <h2 class="border-bottom homepage-title">الفئة</h2>
    <ul class="list-group cateul list-group-flush">
        <li class="list-group-item align-items-center">
            <span>
            @if($business->category && $business->category->image)
            <img 
                src="{{ asset('storage/' . $business->category->image) }}" 
                alt="{{ $business->category->name }}" 
            >
            @endif

            </span>
            @if($business->category)
                <span class="badge bg-primary">
                    {{ $business->category->name }}
                </span>
            @endif

        </li>
    </ul>
</div>