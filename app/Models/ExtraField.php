<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExtraField
 * 
 * @property int $id
 * @property int $subscription_id
 * @property int $service_id
 * @property int $field_definition_id
 * @property string|null $field_value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Subscription $subscription
 * @property Service $service
 * @property FieldDefinition $field_definition
 *
 * @package App\Models
 */
class ExtraField extends Model
{
	protected $table = 'extra_fields';

	protected $casts = [
		'subscription_id' => 'int',
		'service_id' => 'int',
		'field_definition_id' => 'int'
	];

	protected $fillable = [
		'subscription_id',
		'service_id',
		'field_definition_id',
		'field_value'
	];

	public function subscription()
	{
		return $this->belongsTo(Subscription::class);
	}

	public function service()
	{
		return $this->belongsTo(Service::class);
	}

	public function field_definition()
	{
		return $this->belongsTo(FieldDefinition::class);
	}
}
