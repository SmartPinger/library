<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class book extends Model
{
    use HasFactory;

    public function canBeBorrowed(): bool {
        return $this->activeLoans() < $this->stock;
    }

    private function activeLoans():int {
        return $this->loans()
        ->where('is_returned', false)
        ->get()
        ->sum('number_borrowed');
    }

    public function loans(): HasMany{
        return $this->hasMany(Loan::class);
    }

    public function availableCopies(): int {
        return $this->stock - $this->activeLoans();
    }
}
