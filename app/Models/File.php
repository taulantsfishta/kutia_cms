<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    public $primary_key = 'id';
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
