<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 * 
 * @property string|null $country
 * @property string|null $title
 * @property string|null $company
 * @property string|null $sent_candidature
 * @property string|null $location
 * @property string|null $link
 *
 * @package App\Models
 */
class Job extends Model
{
	protected $table = 'jobs';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'country',
		'title',
		'company',
		'sent_candidature',
		'location',
		'link'
	];
}
