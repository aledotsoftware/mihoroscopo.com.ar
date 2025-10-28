<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdsSubscription
 * 
 * @property int $id
 * @property string|null $hashed_email
 * @property float|null $conversion_value
 * @property string|null $currency_code
 * @property string|null $order_id
 * @property string|null $gclid
 * @property string|null $gbraid
 * @property string|null $wbraid
 * @property Carbon|null $conversion_event_time
 *
 * @package App\Models
 */
class AdsSubscription extends Model
{
	protected $table = 'ads_subscriptions';
	public $timestamps = false;

	protected $casts = [
		'conversion_value' => 'float',
		'conversion_event_time' => 'datetime'
	];

	protected $fillable = [
		'hashed_email',
		'conversion_value',
		'currency_code',
		'order_id',
		'gclid',
		'gbraid',
		'wbraid',
		'conversion_event_time'
	];
}
