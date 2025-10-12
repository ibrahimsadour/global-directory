<div class="selling-section bg-gray-50 py-16">
    <div class="container mx-auto px-4">

        <!-- ✅ العنوان -->
        <div class="section-title mb-12">
            <h2 class="homepage-title text-3xl sm:text-2xl font-semibold text-center text-gray-800">
                مع DalilGo، اكتشف الأعمال التجارية في الكويت بكل سهولة
            </h2>
        </div>

        <!-- ✅ عرض الأرقام -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center">
            @php
                $totalBusinesses = \App\Models\Business::count();
                $totalCategories = \App\Models\Category::count();
                $totalViews = \App\Models\BusinessView::count();
            @endphp

            <!-- عنصر 1 -->
            <div
                class="stat-item bg-white shadow-xl p-6 rounded-xl transform hover:scale-105 transition duration-300 border-r-4 border-blue-600">
                <span class="stat-number text-4xl sm:text-3xl font-extrabold text-blue-600">
                    {{ number_format($totalBusinesses) }}+
                </span>
                <div class="stat-label text-sm sm:text-xs text-gray-500 mt-3">
                    عدد الأعمال التجارية في الكويت
                </div>
            </div>

            <!-- عنصر 2 -->
            <div
                class="stat-item bg-white shadow-xl p-6 rounded-xl transform hover:scale-105 transition duration-300 border-r-4 border-blue-600">
                <span class="stat-number text-4xl sm:text-3xl font-extrabold text-blue-600">
                    {{ number_format($totalCategories) }}
                </span>
                <div class="stat-label text-sm sm:text-xs text-gray-500 mt-3">
                    عدد الفئات المتنوعة
                </div>
            </div>

            <!-- عنصر 3 -->
            <div
                class="stat-item bg-white shadow-xl p-6 rounded-xl transform hover:scale-105 transition duration-300 border-r-4 border-blue-600">
                <span class="stat-number text-4xl sm:text-3xl font-extrabold text-blue-600">٢٤/٧</span>
                <div class="stat-label text-sm sm:text-xs text-gray-500 mt-3">
                    دعم متواصل لجميع الخدمات
                </div>
            </div>

            <!-- عنصر 4 (الآن أيضًا له بوردر) -->
            <div
                class="stat-item bg-white shadow-xl p-6 rounded-xl transform hover:scale-105 transition duration-300 border-r-4 border-blue-600">
                <span class="stat-number text-4xl sm:text-3xl font-extrabold text-blue-600">
                    {{ number_format($totalViews) }}
                </span>
                <div class="stat-label text-sm sm:text-xs text-gray-500 mt-3">
                    عدد مشاهدات الإعلانات
                </div>
            </div>
        </div>

        <!-- ✅ زر إضافة إعلان -->
        <div class="text-center mt-10">
            <a href="{{ route('user.business.step1') }}"
                class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-lg sm:text-base py-3 sm:py-2 px-8 sm:px-6 rounded-full shadow-lg transform hover:scale-105 transition duration-300">
                <span class="icon mr-2">
                    <svg width="24" height="24" viewBox="0 0 19 18" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.5963 4.33333L11.3153 3H7.11533L5.83433 4.33333H3.61533C2.84533 4.33333 2.21533 4.93333 2.21533 5.66667V13.6667C2.21533 14.4 2.84533 15 3.61533 15H14.8153C15.5853 15 16.2153 14.4 16.2153 13.6667V5.66667C16.2153 4.93333 15.5853 4.33333 14.8153 4.33333H12.5963ZM12.7153 9.66667C12.7153 11.5067 11.1473 13 9.21533 13C7.28333 13 5.71533 11.5067 5.71533 9.66667C5.71533 7.82667 7.28333 6.33333 9.21533 6.33333C11.1473 6.33333 12.7153 7.82667 12.7153 9.66667ZM8.91543 9.95237H7.11543V9.38094H8.91543V7.66665H9.51543V9.38094H11.3154V9.95237H9.51543V11.6667H8.91543V9.95237Z"
                            fill="#fff"></path>
                    </svg>
                </span>
                انشر إعلانك مجانا
            </a>
        </div>

    </div>
</div>
