<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
  public function checks()
  {
    return $this->hasMany('App\Check');
  }
}