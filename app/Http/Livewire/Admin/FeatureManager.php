<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Feature;
use Livewire\WithPagination;

class FeatureManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'title';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'title' => '',
        'description' => '',
        'icon' => 'fas fa-cog',
        'order' => 0,
        'is_active' => true
    ];

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.description' => 'required|string',
        'form.icon' => 'required|string',
        'form.order' => 'integer',
        'form.is_active' => 'boolean'
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
        $this->reset('form');
        $this->form['order'] = Feature::max('order') + 1;
        $this->showModal = true;
    }

    public function edit(Feature $item)
    {
        $this->currentItem = $item;
        $this->form = $item->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $message = 'Feature updated successfully';
        } else {
            Feature::create($this->form);
            $message = 'Feature created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $message]);
    }
    public function confirmDelete($id)
    {
        $this->dispatchBrowserEvent('confirm-delete', [
            'id' => $id,
            'message' => 'Are you sure you want to delete this feature?'
        ]);
    }

    public function delete(Feature $item)
    {
        $item->delete();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Feature deleted']);
    }

    public function render()
    {
        $items = Feature::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.feature-manager', [
            'items' => $items
        ])->layout('layouts.admin');
    }
}
