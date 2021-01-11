<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id',
         'url'
    ];


    /**
     * The belongTo relationship on model Topic referencing 
     * the topic id on subscription table .
     *
     * @var array
     */
    public function topic(){
        return $this->belongsTo('App\Models\Topic' , 'topic_id');
    }
}
