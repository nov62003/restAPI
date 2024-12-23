<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasFactory;
    protected $fillable = ["email", "password", "name", "active"];
    
    protected $hidden = ["password"];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}