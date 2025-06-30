{{-- اوقات الدوام --}}
<div class="overview services shadow-sm no-margin ">
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
            $formatted = str_replace('AM', ' صباحاً ', $formatted);
            $formatted = str_replace('PM', ' مساءً ', $formatted);
            return $formatted;
        };

        // التحقق إذا يوجد يوم واحد على الأقل فيه وقت فتح وإغلاق
        $has_open_days = $business->hours->whereNotNull('open_time')
                                        ->whereNotNull('close_time')
                                        ->count() > 0;
    @endphp

    @if($has_open_days)
        {{-- اوقات الدوام --}}
        <div class="overview services shadow-sm no-margin">
            <h2 class="border-bottom">اوقات الدوام</h2>
            <ul class="list-group">
                @foreach($business->hours as $hour)
                    <li class="list-group-item">
                        {{ $days[$hour->day] ?? $hour->day }}
                        @if($hour->open_time && $hour->close_time)
                            <span>
                                {{ $arabic_time($hour->open_time) }}
                                -
                                {{ $arabic_time($hour->close_time) }}
                            </span>
                        @else
                            <span style="color: red; font-weight: bold;">
                                مغلق
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>