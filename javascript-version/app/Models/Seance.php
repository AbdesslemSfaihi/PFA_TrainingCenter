<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    protected $fillable = [
        'trainingcourse_id',
        'date',
        'startH',
        'endH',
        'sess_id',
        'trainer_id',
        'subject_id'
    ];

    public function sesses()
    {
        return $this->belongsTo(Sess::class);
    }
}
