<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContentLovePrediction
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
class ContentLovePrediction extends Model
{
	protected $table = 'content_love_prediction';

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'content',
		'zodiac_sign',
		'date'
	];
}
