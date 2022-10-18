<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyTest extends Model
{
    use HasFactory;

    protected  $fillable  = ['prescription_id', 'pathology_id'];

    public function pathology(){
        return $this->belongsTo(Pathology::class);
    }
}
