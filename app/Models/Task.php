<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = 'task_ext';
    
    protected $fillable = [
        'task_id', 'request_for','extend_date','c_remarks','a_remarks','status','category','attach','c_by'

    ];
}
