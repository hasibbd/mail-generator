<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenMail extends Model
{
    use HasFactory;
    protected $fillable =[
        'cus_id','recover_mail','password','target_dot','gen_mail','posted_time','target_mail','target_provider'
    ];
}
