<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable=[
        'city',
        'lounge',
        'room',
        'toilet',
        'cuisine',
        'num_apartment',
        'lodging_id',
        'space',
        'type',
        'class',
        'status',
        'address',
        'price',
        'images'];
}
