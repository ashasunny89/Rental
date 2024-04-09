<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    use HasFactory;
    protected $table='user_profile';
    protected $fillable=['u_id','user_name','name','email','whatsapp','dob','bloodgroup','address','membership','district','photo','phone_number','remarks','created_at', 'updated_at', 'expiry_date'];
    protected $dates = ['created_at', 'updated_at', 'expiry_date'];
}