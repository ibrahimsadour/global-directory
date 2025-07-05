{{-- اوقات الدوام --}}
<div class="overview services shadow-sm no-margin">
    @php
        $days = [
            'monday'    => 'الإثنين',
            'tuesday'   => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday'  => 'الخميس',
            'friday'    => 'الجمعة',
            'saturday'  => 'السبت',
            'sunday'    => 'الأحد',
        ];

        $arabic_time = function($time) {
            $formatted = \Carbon\Carbon::parse($time)->format('h:i A');
            $formatted = str_replace('AM', ' صباحاً', $formatted);
            $formatted = str_replace('PM', ' مساءً', $formatted);
            return $formatted;
        };

        $has_open_days = $business->hours->whereNotNull('open_time')
                                         ->whereNotNull('close_time')
                                         ->count() > 0;
    @endphp

    @if($has_open_days)
        <h2 class="border-bottom mb-3">أوقات الدوام</h2>
        <ul class="list-group">
            @foreach($business->hours as $hour)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>{{ $days[$hour->day] ?? $hour->day }}</strong>
                    @if($hour->open_time === '00:00:00' && $hour->close_time === '23:59:59')
                        <span style="color: green; font-weight: bold;">نعمل على مدار 24 ساعة</span>
                    @elseif($hour->open_time && $hour->close_time)
                        <span style="color: #333;">
                            {{ $arabic_time($hour->open_time) }} - {{ $arabic_time($hour->close_time) }}
                        </span>
                    @else
                        <span style="color: red; font-weight: bold;">مغلق</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
