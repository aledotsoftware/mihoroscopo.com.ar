<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContentDailyAstroAdvice
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
class ContentDailyAstroAdvice extends Model
{
	protected $table = 'content_daily_astro_advice';

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'content',
		'zodiac_sign',
		'date'
	];
}
