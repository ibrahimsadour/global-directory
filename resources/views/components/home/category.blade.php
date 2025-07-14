{{-- عرض الفئات --}}
<section class="container-fluid featured-category">
    <div class="container">
        <div class="section-title mb-3 row">
            <h2 class="homepage-title">إكتشف <strong class="after-category-title"> أقسامنا</strong></h2>
            <p>
                ألقِ نظرة على الفئة المميزة. لم تجد ما تبحث عنه؟
                <a class="text-primary" href="{{ route('categories.index') }}">عرض جميع الفئات</a>
            </p>
        </div>

        <div class="fcatrow row gx-2">
            @foreach($categories as $category)
                <div class="col-lg-2 col-md-3 col-sm-4 col-4 fcatcol mb-3">
                    <a href="{{ route('categories.show', $category->slug) }}">
                        <div class="fcat shado-xs text-center p-1">
                            <div class="icon mx-auto">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                            </div>
                            <p class="text-truncate">{{ $category->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
