<?php

namespace App\Plugins\agpchat\src\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Agpchat extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'agpchat';
    public $timestamps = false;

}
