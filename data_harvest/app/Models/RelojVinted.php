<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelojVinted extends Model
{
    use HasFactory;

    protected $table ='relojes_vinted';
    protected $guarded = [];


    public function relojesViejos(){
        return $this->hasMany(RelojViejo::class, 'reloj_vinted_id');
    }
}
