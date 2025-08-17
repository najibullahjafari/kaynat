<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DynamicContent;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class DynamicContentManager extends Component
{
    use WithFileUploads, WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'key';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'key' => '',
        'content' => [],
        'image' => null,
        'is_active' => true
    ];
    public $tempImage;
    public $languages = ['en', 'fa', 'ps'];

    protected $rules = [
        'form.key' => 'required|unique:dynamic_contents,key',
        'form.content.*' => 'nullable|string',
        'tempImage' => 'nullable|image|max:2048',
        'form.is_active' => 'boolean'
    ];

    public function mount()
    {
        foreach ($this->languages as $lang) {
            $this->form['content'][$lang] = '';
        }
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
        $this->reset(['form', 'tempImage']);
        $this->showModal = true;
    }

    public function edit(DynamicContent $item)
    {
        $this->currentItem = $item;
        $this->form = $item->toArray();
        $this->form['content'] = $item->content ?? [];
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.key' => $this->currentItem ?
                'required|unique:dynamic_contents,key,' . $this->currentItem->id :
                'required|unique:dynamic_contents,key',
            'tempImage' => 'nullable|image|max:2048',
        ]);

        if ($this->tempImage) {
            if ($this->currentItem && $this->currentItem->image) {
                Storage::disk('public')->delete($this->currentItem->image);
            }
            $this->form['image'] = $this->tempImage->store('dynamic-content', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $message = 'Content updated successfully';
        } else {
            DynamicContent::create($this->form);
            $message = 'Content created successfully';
        }

        $this->showModal = false;

        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $message]);
    }

    public function delete(DynamicContent $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Content deleted']);
    }

    public function render()
    {
        $items = DynamicContent::query()
            ->when($this->search, function ($query) {
                $query->where('key', 'like', '%' . $this->search . '%')
                    ->orWhereJsonContains('content', $this->search);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.dynamic-content-manager', [
            'items' => $items
        ])->layout('layouts.admin');
    }
}
