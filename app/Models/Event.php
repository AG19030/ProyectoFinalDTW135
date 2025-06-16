<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_name',
        'description', // Nuevo campo
        'date',
        'direction',
        'type_event',
        'created_by',
        'updated_by'
    ];
}
