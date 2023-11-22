<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirApproval extends Model
{
    use HasFactory;
    protected $table = 'formulir_approval';
    public $timestamp = true;

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'approved_by');
    }
}
