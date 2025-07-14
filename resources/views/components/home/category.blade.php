{{-- عرض الفئات --}}
<section class="container-fluid featured-category">
    <div class="container">
        <div class="section-title mb-3 row">
            <h2 class="homepage-title">إكتشف <strong class="after-category-title"> أقسامنا</strong></h2>
            <p>ألقِ نظرة على الفئة المميزة. لم تجد ما تبحث عنه؟<a class="text-primary" href="{{ route('categories.index') }}">عرض جميع الفئات</a>
        </div>
    <div class="category-grid">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="category-card">
                <div class="category-icon">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                </div>
                <p class="category-name">{{ $category->name }}</p>
            </a>
        @endforeach
    </div>

</section>