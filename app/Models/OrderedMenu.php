<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderedMenu extends Model
{
    protected $fillable = ['quantity', 'notes', 'reservation_id', 'menu_id'];

    use HasFactory;
    public function reservation(): BelongsTo {
        return $this->belongsTo(Reservation::class);
    }

    public function menu(): BelongsTo {
        return $this->belongsTo(Menu::class);
    }
}
