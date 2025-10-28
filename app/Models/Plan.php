<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 * 
 * @property int $id
 * @property int $service
 * @property string $name
 * @property int $frequency
 * @property string $frequency_type
 * @property float $transaction_amount
 * @property string $currency_id
 * @property int|null $free_trial
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class Plan extends Model
{
	protected $table = 'plans';

	protected $casts = [
		'service' => 'int',
		'frequency' => 'int',
		'transaction_amount' => 'float',
		'free_trial' => 'int'
	];

	protected $fillable = [
		'service',
		'name',
		'frequency',
		'frequency_type',
		'transaction_amount',
		'currency_id',
		'free_trial'
	];

	public function service()
	{
		return $this->belongsTo(Service::class, 'service');
	}
}
