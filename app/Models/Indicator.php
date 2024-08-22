<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Malwarefamily;

class Indicator extends Model
{
    use HasFactory;
    protected $fillable = ['type','value','source','created_at','created','malwarefamilies_id'];

    ################ Relations ###########
    public function familyGroup(){
        return $this->belongsTo(Malwarefamily::class, 'malwarefamilies_id');
    }
}
