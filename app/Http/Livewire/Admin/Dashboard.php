<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contact;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'recentContacts' => Contact::latest()->take(5)->get(),
            'testimonialCount' => Testimonial::count(),
            'teamCount' => TeamMember::count(),
            'unreadMessages' => Contact::where('is_read', false)->count()
        ])->layout('layouts.admin');
    }
}
