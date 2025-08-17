<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'author_name';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'author_name' => '',
        'author_position' => '',
        'author_company' => '',
        'content' => '',
        'avatar' => null,
        'rating' => 5,
        'is_featured' => false,
        'is_active' => true,
    ];
    public $tempAvatar;
    public $confirmDeleteId = null;

    protected $rules = [
        'form.author_name' => 'required|string|max:255',
        'form.author_position' => 'nullable|string|max:255',
        'form.author_company' => 'nullable|string|max:255',
        'form.content' => 'required|string',
        'form.rating' => 'required|integer|min:1|max:5',
        'form.is_featured' => 'boolean',
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
            'author_name' => '',
            'author_position' => '',
            'author_company' => '',
            'content' => '',
            'avatar' => null,
            'rating' => 5,
            'is_featured' => false,
            'is_active' => true,
        ];
        $this->tempAvatar = null;
        $this->showModal = true;
    }

    public function edit(Testimonial $item)
    {
        $this->resetValidation();
        $this->currentItem = $item;
        $this->form = [
            'author_name' => $item->author_name,
            'author_position' => $item->author_position,
            'author_company' => $item->author_company,
            'content' => $item->content,
            'avatar' => $item->avatar,
            'rating' => $item->rating,
            'is_featured' => $item->is_featured,
            'is_active' => $item->is_active,
        ];
        $this->tempAvatar = null;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Handle avatar upload
        if ($this->tempAvatar) {
            if ($this->form['avatar']) {
                Storage::disk('public')->delete($this->form['avatar']);
            }
            $this->form['avatar'] = $this->tempAvatar->store('testimonials', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $msg = 'Testimonial updated successfully';
        } else {
            Testimonial::create($this->form);
            $msg = 'Testimonial created successfully';
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
        $item = Testimonial::findOrFail($id);
        if ($item->avatar) {
            Storage::disk('public')->delete($item->avatar);
        }
        $item->delete();
        $this->confirmDeleteId = null;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Testimonial deleted']);
    }

    public function render()
    {
        $items = Testimonial::query()
            ->when($this->search, fn($q) => $q->where('author_name', 'like', '%' . $this->search . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.testimonial-manager', compact('items'))->layout('layouts.admin');
    }
}
