<div class="breadcrumb container-fluid">
    <div class="container">
        <div class="row">
            <ul class="flex flex-wrap gap-1 rtl:space-x-reverse ">
                @foreach($items as $index => $item)
                <li class="flex items-center gap-1 text-sm">
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" class="flex items-center gap-1">
                            @if($index === 0)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 1.707a1 1 0 00-1.414 0l-7 7A1 1 0 003 10h1v7a1 1 0 001 1h4a1 1 0 001-1v-4h2v4a1 1 0 001 1h4a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-7-7z" />
                                </svg>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    @else
                        <span>{{ $item['title'] }}</span>
                    @endif

                    @if($index < count($items) - 1)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="text-gray-400">
                            <path d="M13.939 4.939 6.879 12l7.06 7.061 2.122-2.122L11.121 12l4.94-4.939z"></path>
                        </svg>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
