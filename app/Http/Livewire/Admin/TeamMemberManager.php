<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class TeamMemberManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'order';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'name' => '',
        'position' => '',
        'bio' => '',
        'avatar' => null,
        'order' => 0,
        'social_links' => [],
        'is_active' => true,
    ];
    public $tempAvatar;
    public $social_links_string = '';
    public $confirmDeleteId = null;

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.position' => 'nullable|string|max:255',
        'form.bio' => 'nullable|string',
        'form.order' => 'integer|min:0',
        'form.is_active' => 'boolean',
        'tempAvatar' => 'nullable|image|max:2048',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->resetValidation();
        $this->currentItem = null;
        $this->form = [
            'name' => '',
            'position' => '',
            'bio' => '',
            'avatar' => null,
            'order' => 0,
            'social_links' => [],
            'is_active' => true,
        ];
        $this->social_links_string = '';
        $this->tempAvatar = null;
        $this->showModal = true;
    }

    public function edit(TeamMember $item)
    {
        $this->resetValidation();
        $this->currentItem = $item;
        $this->form = [
            'name' => $item->name,
            'position' => $item->position,
            'bio' => $item->bio,
            'avatar' => $item->avatar,
            'order' => $item->order,
            'social_links' => $item->social_links ?? [],
            'is_active' => $item->is_active,
        ];
        $this->social_links_string = is_array($item->social_links) ? implode(',', $item->social_links) : '';
        $this->tempAvatar = null;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Handle social links as array
        $this->form['social_links'] = array_filter(array_map('trim', explode(',', $this->social_links_string)));

        // Handle avatar upload
        if ($this->tempAvatar) {
            if ($this->form['avatar']) {
                Storage::disk('public')->delete($this->form['avatar']);
            }
            $this->form['avatar'] = $this->tempAvatar->store('team', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $msg = 'Team member updated successfully';
        } else {
            TeamMember::create($this->form);
            $msg = 'Team member created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $msg]);
    }

    public function confirmDelete($id)
    {
        $this->confirmDeleteId = $id;
    }

    public function delete($id)
    {
        $item = TeamMember::findOrFail($id);
        if ($item->avatar) {
            Storage::disk('public')->delete($item->avatar);
        }
        $item->delete();
        $this->confirmDeleteId = null;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Team member deleted']);
    }

    public function render()
    {
        $items = TeamMember::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.team-member-manager', compact('items'))->layout('layouts.admin');
    }
}
