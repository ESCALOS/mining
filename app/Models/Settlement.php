<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    public function InternationalPayment() {
        $this->hasOne(InternationalPayment::class);
    }

    public function PercentagePayable() {
        $this->hasOne(PercentagePayable::class);
    }

    public function Law() {
        $this->hasOne(Law::class);
    }

    public function Protection() {
        $this->hasOne(Protection::class);
    }

    public function Deduction() {
        $this->hasOne(Deduction::class);
    }

    public function Refinement() {
        $this->hasOne(Refinement::class);
    }

    public function Requirement() {
        $this->hasOne(Requirement::class);
    }

    public function Penalty() {
        $this->hasOne(Penalty::class);
    }

    public function AllowedAmount() {
        $this->hasOne(AllowedAmount::class);
    }
}
