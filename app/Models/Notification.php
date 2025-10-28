<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id
 * @property string $type
 * @property string $data_id
 * @property string $status
 * @property string|null $details
 * @property string|null $response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';

	protected $fillable = [
		'type',
		'data_id',
		'status',
		'details',
		'response'
	];
}
