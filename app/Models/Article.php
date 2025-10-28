<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * 
 * @property int $id
 * @property string $slug
 * @property string|null $description
 * @property string|null $keywords
 * @property string $title
 * @property string $content
 * @property int|null $author_id
 * @property int $video_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Article extends Model
{
	protected $table = 'articles';

	protected $casts = [
		'author_id' => 'int',
		'video_status' => 'int'
	];

	protected $fillable = [
		'slug',
		'description',
		'keywords',
		'title',
		'content',
		'author_id',
		'video_status'
	];
}
