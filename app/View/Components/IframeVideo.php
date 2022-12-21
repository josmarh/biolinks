<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IframeVideo extends Component
{
    public $videoUrl;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.iframe-video');
    }
}
