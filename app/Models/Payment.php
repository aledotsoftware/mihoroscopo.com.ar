<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property string $external_reference
 * @property string $payment_id
 * @property string $preapproval_id
 * @property float $net_received_amount
 * @property float $total_paid_amount
 * @property string $status
 * @property string $currency_id
 * @property string $payer_email
 * @property string $payer_identification_number
 * @property string $payer_identification_type
 * @property string|null $payer_first_name
 * @property string|null $payer_last_name
 * @property string $payment_method_id
 * @property string|null $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payment';

	protected $casts = [
		'net_received_amount' => 'float',
		'total_paid_amount' => 'float'
	];

	protected $fillable = [
		'external_reference',
		'payment_id',
		'preapproval_id',
		'net_received_amount',
		'total_paid_amount',
		'status',
		'currency_id',
		'payer_email',
		'payer_identification_number',
		'payer_identification_type',
		'payer_first_name',
		'payer_last_name',
		'payment_method_id',
		'payload'
	];
}
