{{-- صاحب النشاط --}}
<div class="bycard shadow-sm overview mb-4">
    <h2 class="border-bottom">تم نشره بواسطة</h2>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <g clip-path="url(#clip0_3387_26479)">
                        <path d="M7.99984 0.666626C6.96781 0.666626 6.08268 1.19705 5.5117 1.98101C4.54887 1.83055 3.54245 2.08367 2.813 2.81312C2.08243 3.54368 1.83522 4.55048 1.9869 5.50808C1.20431 6.08082 0.666504 6.96446 0.666504 7.99996C0.666504 9.03546 1.20431 9.9191 1.9869 10.4918C1.83522 11.4494 2.08243 12.4562 2.813 13.1868C3.54384 13.9176 4.55031 14.1641 5.50646 14.0169C6.08037 14.8008 6.96558 15.3333 7.99984 15.3333C9.03117 15.3333 9.92201 14.8033 10.4952 14.0172C11.4508 14.1638 12.4563 13.9171 13.1867 13.1868C13.9154 12.458 14.1694 11.4519 14.0188 10.4918C14.8016 9.9179 15.3332 9.03333 15.3332 7.99996C15.3332 6.96659 14.8016 6.08202 14.0188 5.50807C14.1694 4.54804 13.9154 3.54188 13.1867 2.81312C12.4584 2.08487 11.4532 1.83073 10.4937 1.98069C9.92048 1.19574 9.03028 0.666626 7.99984 0.666626Z" fill="#0284C7"/>
                        <path d="M10.7655 6.14544C10.9883 6.47175 10.9044 6.91691 10.5781 7.13973L10.516 7.18215C9.45671 7.90546 8.57549 8.85981 7.93872 9.97325C7.82808 10.1667 7.63359 10.2976 7.41269 10.3272C7.1918 10.3568 6.96972 10.2817 6.81204 10.1242L5.37632 8.69005C5.09677 8.4108 5.09653 7.95781 5.37578 7.67826C5.65503 7.39871 6.10803 7.39847 6.38758 7.67772L7.19287 8.48215C7.8746 7.51282 8.72627 6.67157 9.70906 6.00047L9.77118 5.95805C10.0975 5.73523 10.5427 5.81912 10.7655 6.14544Z" fill="white"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_3387_26479">
                            <rect width="16" height="16" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
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