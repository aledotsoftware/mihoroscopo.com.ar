<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContentHoroscope
 * 
 * @property int $id
 * @property string $content
 * @property string $zodiac_sign
 * @property Carbon $date
 * @property int|null $video_status
 * @property int|null $video_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ContentHoroscope extends Model
{
	protected $table = 'content_horoscopes';

	protected $casts = [
		'date' => 'datetime',
		'video_status' => 'int',
		'video_url' => 'int'
	];

	protected $fillable = [
		'content',
		'zodiac_sign',
		'date',
		'video_status',
		'video_url'
	];
}
