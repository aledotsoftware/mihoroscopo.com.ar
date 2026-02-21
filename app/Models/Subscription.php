<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property string|null $email
 * @property int $service_id
 * @property int|null $payment_provider_id
 * @property string|null $subscription_id
 * @property string $status
 * @property int|null $first_send
 * @property Carbon|null $valid_until
 * @property string $country
 * @property string|null $currency
 * @property string $external_reference
 * @property string|null $payment_type
 * @property int|null $charged_quantity
 * @property float|null $charged_amount
 * @property string|null $response
 * @property float|null $pending_charge_amount
 * @property string|null $semaphore
 * @property Carbon|null $last_charged_date
 * @property float|null $last_charged_amount
 * @property Carbon|null $next_payment_date
 * @property string|null $payment_method_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Service $service
 * @property Collection|EmailLog[] $email_logs
 * @property Collection|ExtradataHoroscope[] $extradata_horoscopes
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscriptions';

	protected $casts = [
		'service_id' => 'int',
		'payment_provider_id' => 'int',
		'first_send' => 'int',
		'valid_until' => 'datetime',
		'charged_quantity' => 'int',
		'charged_amount' => 'float',
		'pending_charge_amount' => 'float',
		'last_charged_date' => 'datetime',
		'last_charged_amount' => 'float',
		'next_payment_date' => 'datetime'
	];

	protected $fillable = [
		'email',
		'service_id',
		'payment_provider_id',
		'subscription_id',
		'status',
		'first_send',
		'valid_until',
		'country',
		'currency',
		'external_reference',
		'payment_type',
		'charged_quantity',
		'charged_amount',
		'response',
		'pending_charge_amount',
		'semaphore',
		'last_charged_date',
		'last_charged_amount',
		'next_payment_date',
		'payment_method_id'
	];

	public function service()
	{
		return $this->belongsTo(Service::class);
	}

	public function email_logs()
	{
		return $this->hasMany(EmailLog::class);
	}

	public function extradata_horoscopes()
	{
		return $this->hasMany(ExtradataHoroscope::class);
	}
}
