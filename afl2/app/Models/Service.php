<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory; // <-- Tambahkan juga

    protected $fillable = ['name', 'icon', 'description'];
}
