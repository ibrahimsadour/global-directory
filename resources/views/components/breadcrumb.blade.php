
<div class="breadcrumb contaienr-fluid">
    <div class="container">
        <div class="row">
            <h2>{{ end($items)['title'] ?? '' }}</h2>
            <ul>
                @foreach($items as $index => $item)
                    <li>
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                        @else
                            {{ $item['title'] }}
                        @endif
                        @if($index < count($items) - 1)
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M10.061 19.061 17.121 12l-7.06-7.061-2.122 2.122L12.879 12l-4.94 4.939z"></path></svg>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
