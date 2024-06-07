<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModule extends Model
{
    protected $table = 'subject_module';
    use HasFactory;
    protected $fillable = [
        'subject_id', 'module_id', 'nbHours'
    ];
    public $timestamps = false;
}
