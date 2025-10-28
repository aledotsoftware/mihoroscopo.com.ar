<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailLog
 * 
 * @property int $id
 * @property int $subscription_id
 * @property string $service_type
 * @property int $content_id
 * @property Carbon|null $sent_at
 * @property Carbon|null $opened_at
 * @property string $status
 * 
 * @property Subscription $subscription
 *
 * @package App\Models
 */
class EmailLog extends Model
{
	protected $table = 'email_logs';
	public $timestamps = false;

	protected $casts = [
		'subscription_id' => 'int',
		'content_id' => 'int',
		'sent_at' => 'datetime',
		'opened_at' => 'datetime'
	];

	protected $fillable = [
		'subscription_id',
		'service_type',
		'content_id',
		'sent_at',
		'opened_at',
		'status'
	];

	public function subscription()
	{
		return $this->belongsTo(Subscription::class);
	}
}
