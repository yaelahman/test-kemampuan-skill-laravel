<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;
    protected $table = 'formulir';
    public $timestamp = true;

    const STATUS = [
        '<span class="badge badge-secondary">Menunggu</span>',
        '<span class="badge badge-success">Diterima</span>',
        '<span class="badge badge-danger">Ditolak</span>',
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function HistoryApproval()
    {
        return $this->hasMany(FormulirApproval::class, 'formulir_id', 'id');
    }
}
