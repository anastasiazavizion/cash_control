<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_icon_id'];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);

    }

    public function icon() :BelongsTo
    {
        return $this->belongsTo(CategoryIcon::class, 'category_icon_id');

    }
}
