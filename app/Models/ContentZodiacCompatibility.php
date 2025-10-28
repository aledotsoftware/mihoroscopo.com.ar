<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContentZodiacCompatibility
 * 
 * @property int $id
 * @property string $content
 * @property string $zodiac_sign
 * @property Carbon $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ContentZodiacCompatibility extends Model
{
	protected $table = 'content_zodiac_compatibility';

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'content',
		'zodiac_sign',
		'date'
	];
}
