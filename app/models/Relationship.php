<?php

class Relationship extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'followed_id'=>'required'
	);

	public function follower()
  {
    return $this->belongsTo('User');
  }

  public function followed()
  {
    return $this->belongsTo('User');
  }
}
