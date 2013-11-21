<?php

use LaravelBook\Ardent\Ardent;

class Micropost extends Ardent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'microposts';

	/**
   * Properties that can be mass assigned
   *
   * @var array
   */
  protected $fillable = array('body, user_id');
 
  public function user()
  {
    return $this->belongsTo('User');
  }

  public function get_created_ago() {
  	$time_created_at = strtotime($this->created_at);
  	$time = time() - $time_created_at; // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
  }

  /**
	 * Factory
	 */
	public static $factory = array(
	  'body' => 'text',
	  'user_id' => 'factory|User',
	);
 
 	/**
	 * Ardent validation rules
	 */
	public static $rules = array(
	  'body' => 'required|between:1,140',
	);  
}