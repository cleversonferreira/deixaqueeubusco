<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = [
        'user_id',
        'status', 
        'street', 
        'number', 
        'neighborhood', 
        'city', 
        'state', 
        'cep',  
        'whatsapp', 
        'lat', 
        'long'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
