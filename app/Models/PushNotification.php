<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;
    protected $table='push_notifications';
    protected $fillable=['user_id','title','message','created_id','updated_id'];
}