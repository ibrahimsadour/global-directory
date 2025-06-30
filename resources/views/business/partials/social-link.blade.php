{{-- social Links --}}
<div class="overview services shadow-sm no-margin ">

        @if(!empty($business->facebook))
            <h2 class="border-bottom"> الروابط الاجتماعية </h2>
            <ul class="list-group social-link timilist list-group-flush">
            <li class="list-group-item">
                    <a href="{{ $business->facebook }}" target="_blank" rel="nofollow">
                        <i class="bi bi-facebook"></i> {{ $business->facebook }}
                    </a>
            </li>
        @endif

        @if(!empty($business->twitter))
            <li class="list-group-item">
                <a href="{{ $business->twitter }}" target="_blank" rel="nofollow">
                    <i class="bi bi-twitter"></i> {{ $business->twitter }}
                </a>
            </li>
        @endif

        @if(!empty($business->instagram))
            <li class="list-group-item">
                <a href="{{ $business->instagram }}" target="_blank" rel="nofollow">
                    <i class="bi bi-instagram"></i> {{ $business->instagram }}
                </a>
            </li>
        @endif

        @if(!empty($business->linkedin))
            <li class="list-group-item">
                <a href="{{ $business->linkedin }}" target="_blank" rel="nofollow">
                    <i class="bi bi-linkedin"></i> {{ $business->linkedin }}
                </a>
            </li>
        @endif

        @if(!empty($business->youtube))
            <li class="list-group-item">
                <a href="{{ $business->youtube }}" target="_blank" rel="nofollow">
                    <i class="bi bi-youtube"></i> {{ $business->youtube }}
                </a>
            </li>
        @endif
    </ul>

</div>