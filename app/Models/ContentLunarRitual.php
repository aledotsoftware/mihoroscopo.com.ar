<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContentLunarRitual
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
class ContentLunarRitual extends Model
{
	protected $table = 'content_lunar_ritual';

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'content',
		'zodiac_sign',
		'date'
	];
}
