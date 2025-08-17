<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TechnologyItem;
use Illuminate\Support\Facades\Storage;

class TechnologyManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'name' => '',
        'type' => '',
        'description' => '',
        'image' => null,
        'specifications' => [],
        'is_active' => true,
    ];
    public $tempImage;
    public $confirmDeleteId = null;

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.type' => 'nullable|string|max:255',
        'form.description' => 'nullable|string',
        'form.specifications' => 'nullable|array',
        'form.is_active' => 'boolean',
        'tempImage' => 'nullable|image|max:2048',
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
            'type' => '',
            'description' => '',
            'image' => null,
            'specifications' => [],
            'is_active' => true,
        ];
        $this->form['specifications_string'] = '';
        $this->tempImage = null;
        $this->showModal = true;
    }

    public function edit(TechnologyItem $item)
    {
        $this->resetValidation();
        $this->currentItem = $item;
        $this->form = [
            'name' => $item->name,
            'type' => $item->type,
            'description' => $item->description,
            'image' => $item->image,
            'specifications' => $item->specifications ?? [],
            'is_active' => $item->is_active,
        ];
        $this->form['specifications_string'] = is_array($this->form['specifications'])
            ? implode(', ', $this->form['specifications'])
            : '';
        $this->tempImage = null;
        $this->showModal = true;
    }

    public function save()
    {
        // Convert string to array before validation
        if (isset($this->form['specifications_string'])) {
            $this->form['specifications'] = array_filter(array_map('trim', explode(',', $this->form['specifications_string'])));
        }
        $this->validate();

        // Handle image upload
        if ($this->tempImage) {
            if ($this->form['image']) {
                Storage::disk('public')->delete($this->form['image']);
            }
            $this->form['image'] = $this->tempImage->store('technology', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $msg = 'Technology updated successfully';
        } else {
            TechnologyItem::create($this->form);
            $msg = 'Technology created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $msg]);
    }

    public function confirmDelete($id)
    {
        $this->confirmDeleteId = $id;
        $this->dispatchBrowserEvent('confirm-delete', [
            'id' => $id,
            'message' => 'Are you sure you want to delete this technology?'
        ]);
    }

    public function delete($id)
    {
        $item = TechnologyItem::findOrFail($id);
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();
        $this->confirmDeleteId = null;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Technology deleted']);
    }

    public function render()
    {
        $items = TechnologyItem::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.technology-manager', compact('items'))->layout('layouts.admin');
    }
}
