<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelojWallapop extends Model
{
    use HasFactory;
    protected $table ='relojes_wallapop';
    protected $guarded = [];

    public function relojesViejos(){
        return $this->hasMany(RelojViejo::class, 'reloj_wallapop_id');
    }
}
