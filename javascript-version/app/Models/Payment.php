<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'trainingcourse_id',
        'trainee_id',
        'sess_id',
        'paymentDate',
        'paidAmount',
        'paymentStatus',

    ];
    public $timestamps = false;
}
