<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected $fillable = ['num_person', 'date', 'time', 'duration', 'reservation_type', 'status', 'dp_proof', 'user_id', 'table_id'];

    use HasFactory;
    public function orderedmenus(): HasMany {
        return $this->hasMany(OrderedMenu::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function table(): BelongsTo {
        return $this->belongsTo(Table::class);
    }
}
