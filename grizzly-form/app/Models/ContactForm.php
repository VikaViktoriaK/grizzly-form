<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'email',
        'country_code',
        'phone',
        'marital_status',
        'about',
        'agreed',
    ];
}
