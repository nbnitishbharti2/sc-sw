<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistrationMap extends Model
{
    protected $fillable=['session_id','class_id','section_id','student_registration_id','register_by'];
}
