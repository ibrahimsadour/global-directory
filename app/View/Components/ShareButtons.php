<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShareButtons extends Component
{
    public string $title;
    public string $url;

    public function __construct(string $title, ?string $url = null)
    {
        $this->title = $title;
        $this->url = $url ?? url()->current();
    }

    public function render()
    {
        return view('components.share-buttons', [
            'url' => $this->url,
        ]);
    }
}
