<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Order extends Authenticatable {
    use HasFactory;
    protected $fillable = ['user_id'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}