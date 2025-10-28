<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FieldValue
 * 
 * @property int $id
 * @property int $field_definition_id
 * @property string $value
 * 
 * @property FieldDefinition $field_definition
 * @property Collection|ExtraField[] $extra_fields
 *
 * @package App\Models
 */
class FieldValue extends Model
{
	protected $table = 'field_values';
	public $timestamps = false;

	protected $casts = [
		'field_definition_id' => 'int'
	];

	protected $fillable = [
		'field_definition_id',
		'value'
	];

	public function field_definition()
	{
		return $this->belongsTo(FieldDefinition::class);
	}

	public function extra_fields()
	{
		return $this->hasMany(ExtraField::class);
	}
}
