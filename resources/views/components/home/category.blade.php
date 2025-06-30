{{-- عرض الفئات --}}
<style>
    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* افتراضيًا 3 فئات */
        gap: 1rem;
        padding: 1rem;
    }

    @media (min-width: 992px) {
        .category-grid {
            grid-template-columns: repeat(6, 1fr); /* على الشاشات الكبيرة 6 فئات */
        }
    }

    .category-card {
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 4px 14px rgb(0 0 0 / 19%);
        text-align: center;
        padding: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .category-icon {
        width: 70px;
        height: 70px;
        background: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .category-icon img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .category-name {
        font-size: 0.9rem;
        line-height: 1.4;
        font-weight: 500;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-align: center;
    }

</style>
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