<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelojViejo extends Model
{
    use HasFactory;

    protected $table = 'relojes_viejos';
    protected $guarded = [];



    public function relojVinted(){
        return $this->belongsTo(RelojVinted::class, 'reloj_vinted_id');
    }
    public function relojWallapop(){
        return $this->belongsTo(RelojWallapop::class, 'reloj_wallapop_id');
    }
}
