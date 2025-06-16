<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = ['name', 'category', 'price', 'is_available', 'image_url'];

    use HasFactory;
    public function orderedmenus(): HasMany {
        return $this->hasMany(OrderedMenu::class);
    }
}
