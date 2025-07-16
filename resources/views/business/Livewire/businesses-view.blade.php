@if($businesses->isEmpty())
    <div class="text-center text-gray-500 py-8">
        <i class="bi bi-emoji-frown text-3xl mb-2"></i>
        <p>لا توجد نتائج حالياً.</p>
    </div>
@else
    @if($view === 'grid')
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($businesses as $business)
                @include('business.Livewire.business-card', ['business' => $business])
            @endforeach
        </div>
    @else
        <div class="space-y-4">
            @foreach($businesses as $business)
                @include('business.Livewire.business-card', ['business' => $business])
            @endforeach
        </div>
    @endif
@endif
