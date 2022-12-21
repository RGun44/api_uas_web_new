<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
    ];

    public static $rules = [
        "username" => "required",
        "password" => "required",
        "name" => "required",
        "email" => "required|email"
    ];
}
