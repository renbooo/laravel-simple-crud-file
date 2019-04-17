<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $primaryKey = 'file_id';
    protected $table = 'file'; //cek ke table File
}