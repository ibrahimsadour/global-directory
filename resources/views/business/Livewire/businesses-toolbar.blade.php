<div class="flex justify-between items-center mb-4 gap-4 w-full">
    <!-- ✅ يسار الواجهة (لكن فعلياً يظهر في أقصى اليمين بسبب LTR) -->
    <p class="text-sm hidden md:block">
        عرض <strong>{{ $businesses->count() }} من {{ $businesses->total() }} نتائج</strong>
    </p>

    <!-- ✅ يمين الواجهة (فعلياً يسار بـ LTR) -->
    <div class="flex gap-3 items-center">
        <!-- الترتيب -->
        <div class="flex items-center gap-2 relative">
            <label for="sort" class="text-sm whitespace-nowrap">ترتيب حسب:</label>

            <div class="relative w-28">
                <select
                    wire:model.change="sort"
                    id="sort"
                    name="sort"
                    class="border-gray-300 text-sm rounded p-1 pr-8 w-full bg-none"                
                    >
                    <option value="latest">الأحدث</option>
                    <option value="oldest">الأقدم</option>
                    <option value="high_rating">الأعلى تقييماً</option>
                    <option value="low_rating">الأدنى تقييماً</option>
                </select>

                <!-- السهم -->
                <div class="pointer-events-none absolute inset-y-0 end-2 flex items-center text-gray-500">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>


        <!-- العرض -->
        <div class="flex items-center gap-2">
            <span class="text-sm">العرض:</span>
            <div class="flex border rounded overflow-hidden">
                <button wire:click="$set('view', 'list')" class="px-3 py-1 border-l {{ $view === 'list' ? 'bg-blue-100 text-blue-700' : 'text-gray-600' }}">
                    <i class="bi bi-list-ul"></i>
                </button>
                <button wire:click="$set('view', 'grid')" class="px-3 py-1 {{ $view === 'grid' ? 'bg-blue-100 text-blue-700' : 'text-gray-600' }}">
                    <i class="bi bi-grid"></i>
                </button>
            </div>
        </div>
    </div>
</div>