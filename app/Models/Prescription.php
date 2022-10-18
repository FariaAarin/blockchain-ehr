<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function patient(){
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function pathologyTest(){
        return $this->hasMany(PathologyTest::class);
    }
}
