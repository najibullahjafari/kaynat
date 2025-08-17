<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\IndustryCategory;
use Livewire\WithFileUploads;

class IndustryManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $tempImage;
    public $form = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'icon' => '',
        'image' => null,
        'is_active' => true,
    ];

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.slug' => 'required|string|max:255|unique:industry_categories,slug',
        'form.description' => 'nullable|string',
        'form.icon' => 'nullable|string|max:255',
        'form.is_active' => 'boolean',
        'tempImage' => 'nullable|image|max:2048', // <-- validate the upload, not form.image
    ];

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
        $this->reset(['form', 'tempImage']);
        $this->form['is_active'] = true;
        $this->showModal = true;
        $this->currentItem = null;
    }

    public function edit(IndustryCategory $item)
    {
        $this->currentItem = $item;
        $this->form = $item->toArray();
        $this->tempImage = null;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Handle image upload
        if ($this->tempImage) {
            $this->form['image'] = $this->tempImage->store('industries', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $message = 'Industry category updated successfully';
        } else {
            IndustryCategory::create($this->form);
            $message = 'Industry category created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $message]);
        $this->tempImage = null;
    }

    public function delete(IndustryCategory $item)
    {
        $item->delete();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Industry category deleted']);
    }

    public function render()
    {
        $items = IndustryCategory::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.industry-manager', [
            'items' => $items
        ])->layout('layouts.admin');
    }
}
