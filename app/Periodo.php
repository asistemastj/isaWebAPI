<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    #indicamos a que tabla apunta
  protected $table = 'periodo';
 
  protected $fillable = [
  	'codigo' , 'descripcion', 'inicio', 'final', 'estado', 'modalm', 'modcxc', 'modcxp','modtes', 'modact', 'modpla', 'modcon', 'modtri', 'usuario'
  ];
}
