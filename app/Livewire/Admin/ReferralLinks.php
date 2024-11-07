<?php

namespace App\Livewire\Admin;

use App\Models\ReferralLink;
use Livewire\Component;
use Livewire\WithPagination;

class ReferralLinks extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteReferralLink($id)
    {
        ReferralLink::find($id)->delete();
        session()->flash('message', 'Referral link deleted successfully.');
    }

    public function render()
    {
        $links = ReferralLink::where('trainer_name', 'like', "%{$this->search}%")
            ->orWhere('trainer_email', 'like', "%{$this->search}%")
            ->orWhere('code', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.referral-links', [
            'links' => $links
        ]);
    }
}
