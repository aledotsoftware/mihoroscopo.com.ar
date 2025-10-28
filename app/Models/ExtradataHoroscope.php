<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExtradataHoroscope
 * 
 * @property int $id
 * @property int $subscription_id
 * @property string|null $name
 * @property string $signo
 * @property string|null $gclid
 * @property string|null $gbraid
 * @property string|null $wbraid
 * 
 * @property Subscription $subscription
 *
 * @package App\Models
 */
class ExtradataHoroscope extends Model
{
	protected $table = 'extradata_horoscopes';
	public $timestamps = false;

	protected $casts = [
		'subscription_id' => 'int'
	];

	protected $fillable = [
		'subscription_id',
		'name',
		'signo',
		'gclid',
		'gbraid',
		'wbraid',
		'li_fat_id',
		'li_ed',
		'sub_days',
		'cost',
		'click_id',
		'web_push_creative_id',
		'mobile_brand',
		'city_name',
		'browser_family',
		'os_type',
		'price',
		'country_iso_code',
		'region_name',
		'spot_id',
		'domain',
		'deviceua'
	];

	public function subscription()
	{
		return $this->belongsTo(Subscription::class);
	}
}
