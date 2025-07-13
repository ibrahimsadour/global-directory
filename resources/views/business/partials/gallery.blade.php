{{-- معرض الصوور --}}
@php
    $gallery = [];
    if($business->gallery) {
        $gallery = is_array($business->gallery) ? $business->gallery : json_decode($business->gallery, true);
    }
@endphp

@if($gallery && count($gallery))
    <div class="overview products shadow-sm no-margin">
        <h2 class="border-bottom homepage-title">معرض الصور</h2>
        <div class="row no-margin">
            @foreach($gallery as $img)
                <div class="col-md-3 col-sm-4 col-6 mb-3 p-2">
                    <a href="{{ asset('storage/' . $img) }}" target="_blank">
                        <img 
                            src="{{ asset('storage/' . $img) }}" 
                            alt="صورة من المعرض"
                            style="width: 100%; height: 160px; object-fit: cover; border-radius: 10px; border: 1px solid #eee;"
                        >
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif