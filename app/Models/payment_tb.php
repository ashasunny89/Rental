<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_tb extends Model
{
    use HasFactory;
    protected $table='payment_tb';
    protected $fillable=['p_id','phone','name','district','amount','status','payment_type','created_id','updated_id','payment_id'];
}