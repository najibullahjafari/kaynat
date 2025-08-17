<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileManager extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'nullable|string|min:8|confirmed',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updatedEmail($value)
    {
        // Allow user to keep their current email
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . Auth::id();
    }

    public function save()
    {
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . Auth::id();
        $this->validate();
        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        $user->save();
        session()->flash('status', 'Profile updated successfully!');
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.admin.profile-manager')->layout('layouts.admin');
    }
}
