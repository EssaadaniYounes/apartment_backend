<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id',
        'property_id',
        'date_sale',
        'advanced_amount',
        'rest',
        'payment_nature',
        'agreed_amount',
        'sale_type',
        'payment_date',
        'monthly_amount'];
}
