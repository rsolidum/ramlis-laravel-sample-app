<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	public static $rules = array(
		'firstname'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'email'=>'required|email|unique:users',
		'password'=>'required|alpha_num|between:6,12|confirmed',
		'password_confirmation'=>'required|alpha_num|between:6,12'
	);

	public static $updaterules = array(
		'firstname'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'password'=>'required|alpha_num|between:6,12|confirmed',
		'password_confirmation'=>'required|alpha_num|between:6,12'
	);

	public function microposts()
  {
    return $this->hasMany('Micropost');
  }

  public function relationships()
  {
    return $this->hasMany('Relationship');
  }

  public function followed_users()
  {
    return Relationship::where('user_id','=',$this->id);
  }

  public function following_users()
  {
    return Relationship::where('followed_id','=',$this->id);
  }


  public function following($otheruser)
  {
    return Relationship::where( 'user_id', '=', $this->id )->where( 'followed_id', '=', $otheruser->id )->first();
  }

  public function getFeed(){
  	return Micropost::where('user_id','=',$this->id);
  }

  public function follow($otheruser)
  {
    $relationship = new Relationship;
    $relationship->follower_id = $this->id;
    $relationship->followed_id = $otheruser->id;
    $relationship.save();
  }

  public function unfollow($otheruser)
  {
    Relationship::where( 'user_id', '=', $this->id )->where( 'followed_id', '=', $otheruser->id )->delete();
  }

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}