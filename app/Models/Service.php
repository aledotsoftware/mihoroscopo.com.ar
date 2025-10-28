<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Plan[] $plans
 * @property Collection|Subscription[] $subscriptions
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';

	protected $fillable = [
		'name',
		'description'
	];

	public function plans()
	{
		return $this->hasMany(Plan::class, 'service');
	}

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}
}
