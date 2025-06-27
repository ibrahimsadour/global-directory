<div class="breadcrumb container-fluid">
    <div class="container">
        <div class="row">
            <ul class="flex flex-wrap gap-1 rtl:space-x-reverse">
                @foreach($items as $index => $item)
                    <li class="flex items-center gap-1 text-sm">
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
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
