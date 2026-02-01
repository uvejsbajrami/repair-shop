<?php

namespace App\Livewire;

use App\Models\Repair;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\App;

class TrackRepair extends Component
{
    #[Url]
    public $tracking_code = '';
    public $repair = null;
    public $notFound = false;

    public function mount()
    {
        // Automatically search if tracking code is in URL
        if (!empty($this->tracking_code)) {
            $this->trackRepair();
        }
    }

    public function trackRepair()
    {
        $this->notFound = false;
        $this->repair = null;

        if (empty($this->tracking_code)) {
            return;
        }

        $this->repair = Repair::where('tracking_code', strtoupper($this->tracking_code))->first();

        if (!$this->repair) {
            $this->notFound = true;
        } else {
            // Set locale based on shop's language setting
            $languageCode = $this->repair->shop?->settings?->language_code;
            if ($languageCode) {
                App::setLocale($languageCode);
            }
        }
    }

    public function render()
    {
        // Ensure locale is set for rendering if repair exists
        if ($this->repair) {
            $languageCode = $this->repair->shop?->settings?->language_code;
            if ($languageCode) {
                App::setLocale($languageCode);
            }
        }

        return view('livewire.track-repair');
    }
}
