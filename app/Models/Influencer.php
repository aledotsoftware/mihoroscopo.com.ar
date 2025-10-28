<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Influencer
 * 
 * @property int $id
 * @property string $nombre
 * @property string $usuario
 * @property string $red_social
 * @property string|null $contacto
 * @property string|null $anotacion
 * @property Carbon|null $creado_en
 *
 * @package App\Models
 */
class Influencer extends Model
{
	protected $table = 'influencers';
	public $timestamps = false;

	protected $casts = [
		'creado_en' => 'datetime'
	];

	protected $fillable = [
		'nombre',
		'usuario',
		'red_social',
		'contacto',
		'anotacion',
		'creado_en'
	];
}
