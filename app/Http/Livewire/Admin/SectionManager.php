<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class SectionManager extends Component
{
    use WithFileUploads, WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'name' => '',
        'slug' => '',
        'content' => [],
        'image' => null,
        'icon' => null,
        'order' => 0,
        'is_active' => true
    ];
    public $tempImage;
    public $tempIcon;
    public $languages = ['en', 'fa', 'ps'];

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.slug' => 'required|alpha_dash|unique:sections,slug',
        'form.content.*' => 'nullable|string',
        'tempImage' => 'nullable|image|max:2048',
        'tempIcon' => 'nullable|image|max:1024',
        'form.order' => 'integer',
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
        $this->reset(['form', 'tempImage', 'tempIcon']);
        $this->form['order'] = Section::max('order') + 1;
        $this->showModal = true;
    }

    public function edit(Section $item)
    {
        $this->currentItem = $item;
        $this->form = $item->toArray();
        $this->form['content'] = $item->content ?? [];
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required',
            'form.slug' => $this->currentItem ?
                'required|alpha_dash|unique:sections,slug,' . $this->currentItem->id :
                'required|alpha_dash|unique:sections,slug',
            'tempImage' => 'nullable|image|max:2048',
            'tempIcon' => 'nullable|image|max:1024',
        ]);

        if ($this->tempImage) {
            if ($this->currentItem && $this->currentItem->image) {
                Storage::disk('public')->delete($this->currentItem->image);
            }
            $this->form['image'] = $this->tempImage->store('sections', 'public');
        }

        if ($this->tempIcon) {
            if ($this->currentItem && $this->currentItem->icon) {
                Storage::disk('public')->delete($this->currentItem->icon);
            }
            $this->form['icon'] = $this->tempIcon->store('icons', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $message = 'Section updated successfully';
        } else {
            Section::create($this->form);
            $message = 'Section created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $message]);
    }

    public function delete(Section $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        if ($item->icon) {
            Storage::disk('public')->delete($item->icon);
        }
        $item->delete();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Section deleted']);
    }

    public function render()
    {
        $items = Section::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
                    ->orWhereJsonContains('content', $this->search);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.section-manager', [
            'items' => $items
        ])->layout('layouts.admin');
    }
}
