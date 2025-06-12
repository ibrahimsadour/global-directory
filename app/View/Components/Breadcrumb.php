<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * العناصر (العناوين مع الروابط)
     *
     * @var array
     */
    public $items;

    /**
     * أنشئ مكون الـBreadcrumb
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * عرض ملف الـview الخاص بالمكون
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
