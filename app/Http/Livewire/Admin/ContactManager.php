<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;

class ContactManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $currentItem;
    public $form = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'subject' => '',
        'message' => '',
        'is_read' => false,
    ];

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.email' => 'required|email|max:255',
        'form.phone' => 'nullable|string|max:50',
        'form.subject' => 'required|string|max:255',
        'form.message' => 'required|string',
        'form.is_read' => 'boolean',
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
        $this->reset(['form']);
        $this->showModal = true;
        $this->currentItem = null;
    }

    public function edit(Contact $item)
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
            $message = 'Contact updated successfully';
        } else {
            Contact::create($this->form);
            $message = 'Contact created successfully';
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => $message]);
    }

    public function markAsRead(Contact $item)
    {
        $item->is_read = true;
        $item->save();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Marked as read']);
    }

    public function delete(Contact $item)
    {
        $item->delete();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Contact deleted']);
    }

    public function render()
    {
        $items = Contact::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.contact-manager', [
            'items' => $items
        ])->layout('layouts.admin');
    }
}
