{{-- social Links --}}
@if ($business->socialLinks && (
        $business->socialLinks->facebook ||
        $business->socialLinks->twitter ||
        $business->socialLinks->instagram ||
        $business->socialLinks->linkedin ||
        $business->socialLinks->youtube ||
        $business->socialLinks->tiktok
    ))
    <div class="overview services shadow-sm no-margin">
        <h2 class="border-bottom homepage-title"> الروابط الاجتماعية </h2>
        <ul class="list-group social-link timilist list-group-flush">

            @if (!empty($business->socialLinks->facebook))
                <li class="list-group-item">
                    <a href="{{ $business->socialLinks->facebook }}" target="_blank" rel="nofollow">
                        <i class="bi bi-facebook"></i> {{ $business->socialLinks->facebook }}
                    </a>
                </li>
            @endif

            @if (!empty($business->socialLinks->twitter))
                <li class="list-group-item">
                    <a href="{{ $business->socialLinks->twitter }}" target="_blank" rel="nofollow">
                        <i class="bi bi-twitter"></i> {{ $business->socialLinks->twitter }}
                    </a>
                </li>
            @endif

            @if (!empty($business->socialLinks->instagram))
                <li class="list-group-item">
                    <a href="{{ $business->socialLinks->instagram }}" target="_blank" rel="nofollow">
                        <i class="bi bi-instagram"></i> {{ $business->socialLinks->instagram }}
                    </a>
                </li>
            @endif

            @if (!empty($business->socialLinks->linkedin))
                <li class="list-group-item">
                    <a href="{{ $business->socialLinks->linkedin }}" target="_blank" rel="nofollow">
                        <i class="bi bi-linkedin"></i> {{ $business->socialLinks->linkedin }}
                    </a>
                </li>
            @endif

            @if (!empty($business->socialLinks->youtube))
                <li class="list-group-item">
                    <a href="{{ $business->socialLinks->youtube }}" target="_blank" rel="nofollow">
                        <i class="bi bi-youtube"></i> {{ $business->socialLinks->youtube }}
                    </a>
                </li>
            @endif

            @if (!empty($business->socialLinks->tiktok))
                <li class="list-group-item">
                    <a href="{{ $business->socialLinks->tiktok }}" target="_blank" rel="nofollow">
                        <i class="bi bi-tiktok"></i> {{ $business->socialLinks->tiktok }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
