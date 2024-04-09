<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table='student';
    protected $fillable=['u_id','user_name','course','institute_name','institute_dist','institute_state','institute_country','remarks','expiry_date','created_at','updated_at'];
    protected $dates = ['created_at', 'updated_at', 'expiry_date'];
}