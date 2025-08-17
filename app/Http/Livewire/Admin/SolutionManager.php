<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Solution;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class SolutionManager extends Component
{
    use WithFileUploads, WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'title';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'title' => '',
        'slug' => '',
        'description' => '',
        'icon' => null,
        'image' => null,
        'order' => 0,
        'is_featured' => false,
        'is_active' => true
    ];
    public $tempImage;
    public $tempIcon;

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.slug' => 'required|alpha_dash|unique:solutions,slug',
        'form.description' => 'required|string',
        'tempImage' => 'nullable|image|max:2048',
        'tempIcon' => 'nullable|image|max:1024',
        'form.order' => 'integer',
        'form.is_featured' => 'boolean',
        'form.is_active' => 'boolean'
    ];

    public function updatedFormTitle($value)
    {
        $this->form['slug'] = Str::slug($value);
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
        $this->form['order'] = Solution::max('order') + 1;
        $this->showModal = true;
    }

    public function edit(Solution $item)
    {
        $this->currentItem = $item;
        $this->form = $item->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.title' => 'required',
            'form.slug' => $this->currentItem ?
                'required|alpha_dash|unique:solutions,slug,' . $this->currentItem->id :
                'required|alpha_dash|unique:solutions,slug',
            'tempImage' => 'nullable|image|max:2048',
            'tempIcon' => 'nullable|image|max:1024',
        ]);

        if ($this->tempImage) {
            if ($this->currentItem && $this->currentItem->image) {
                Storage::disk('public')->delete($this->currentItem->image);
            }
            $this->form['image'] = $this->tempImage->store('solutions', 'public');
        }

        if ($this->tempIcon) {
            if ($this->currentItem && $this->currentItem->icon) {
                Storage::disk('public')->delete($this->currentItem->icon);
            }
            $this->form['icon'] = $this->tempIcon->store('icons', 'public');
        }

        if ($this->currentItem) {
            $this->currentItem->update($this->form);
            $message = 'Solution updated successfully';
        } else {
            Solution::create($this->form);
            $message = 'Solution created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $message]);
    }

    public function delete(Solution $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        if ($item->icon) {
            Storage::disk('public')->delete($item->icon);
        }
        $item->delete();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Solution deleted']);
    }

    public function render()
    {
        $items = Solution::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.solution-manager', [
            'items' => $items
        ])->layout('layouts.admin');
    }
}
