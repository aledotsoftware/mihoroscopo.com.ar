<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FieldDefinition
 * 
 * @property int $id
 * @property string $name
 * @property int $service_id
 * 
 * @property Service $service
 * @property Collection|ExtraField[] $extra_fields
 *
 * @package App\Models
 */
class FieldDefinition extends Model
{
	protected $table = 'field_definitions';
	public $timestamps = false;

	protected $casts = [
		'service_id' => 'int'
	];

	protected $fillable = [
		'name',
		'service_id'
	];

	public function service()
	{
		return $this->belongsTo(Service::class);
	}

	public function extra_fields()
	{
		return $this->hasMany(ExtraField::class);
	}
}
