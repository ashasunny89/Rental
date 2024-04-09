<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $table='faculty';
    protected $fillable=['u_id','user_name','regno','reg_state','working_status','working_place','institute_name','institute_dist','institute_state','institute_country','remarks','expiry_date','created_at','updated_at'];
    protected $dates = ['created_at', 'updated_at', 'expiry_date'];
}