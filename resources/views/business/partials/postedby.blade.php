{{-- صاحب النشاط --}}
<div class="bycard shadow-sm overview mb-2">
    <h2 class="border-bottom homepage-title">تم نشره بواسطة</h2>
    <div class="usercover text-center">

        <!-- صورة المستخدم في المنتصف -->
        @if($business->user?->profile_photo)
            <img 
                src="{{ asset('storage/' . $business->user->profile_photo) }}" 
                alt="{{ $business->user?->name ?? 'غير معروف' }}" 
                class="mx-auto mb-2"
                style="width: 64px; height: 64px; object-fit: cover; border-radius: 50%; border: 2px solid #eee;"
            >
        @else
            <img 
                src="{{ asset('images/default-profile.png') }}" 
                alt="صورة افتراضية"
                class="mx-auto mb-2"
                style="width: 64px; height: 64px; object-fit: cover; border-radius: 50%; border: 2px solid #eee;"
            >
        @endif

        <!-- الاسم + الشارة بجانب بعض -->
        <h4 class="flex justify-center items-center gap-1 text-lg font-semibold">
            {{ $business->user?->name ?? 'غير معروف' }}
            @if($business->user?->is_trusted)
                 <i class="bi bi-patch-check-fill text-primary" title="تم التحقق من صاحب النشاط"></i>
            @endif
        </h4>

        @php
            $months = [
                1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
            ];

            $created = $business->user?->created_at;
            $since = $created ? 'عضو منذ ' . ($months[$created->format('n')] ?? $created->format('F')) . ' ' . $created->format('Y') : '';
        @endphp

        @if($since)
            <p><strong>{{ $since }}</strong></p>
        @endif
    </div>
</div>