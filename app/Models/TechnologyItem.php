<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnologyItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'image',
        'specifications',
        'is_active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_active' => 'boolean'
    ];

    public function getSpecificationList()
    {
        return $this->specifications ?? [];
    }
    public function updatedFormSpecificationsString($value)
    {
        $this->form['specifications'] = array_filter(array_map('trim', explode(',', $value)));
    }

    public function getFormSpecificationsStringProperty()
    {
        return is_array($this->form['specifications'])
            ? implode(', ', $this->form['specifications'])
            : '';
    }
}
