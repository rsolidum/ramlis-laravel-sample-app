<?php

class UsersController extends BaseController {

	protected $layout = "layouts.main";

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('edit','update')));
	}

	public function index() {
		$users = User::paginate(10);
		$this->layout->content = View::make('users.index', array('users' => $users));
	}

	public function create() {
		$this->layout->content = View::make('users.create');
	}

	public function store() {
		$validator = Validator::make(Input::all(), User::$rules);

		if ($validator->passes()) {
			$user = new User;
			$user->firstname = Input::get('firstname');
			$user->lastname = Input::get('lastname');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('/login')->with('message', 'Thanks for registering!');
		} else {
			return Redirect::to('/register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	public function edit($id) {
		if(!Auth::check()) {
			return Redirect::to('/login')->with('message', 'Please log in to update your settings!');
		} 
		elseif (Auth::user()->id != $id) {
			return Redirect::route("users.show",Auth::user()->id)->with('message', 'You don\'t have permissions to update those settings!');
		}
		else {
			$user = User::find($id);

			$this->layout->content = View::make('users.edit')->with('user', $user);
		}
	}

	public function update($id) {
		$validator = Validator::make(Input::all(), User::$updaterules);
		$user = User::find($id);
		if ($validator->passes()) {
			$user->firstname = Input::get('firstname');
			$user->lastname = Input::get('lastname');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->update();

			return Redirect::route("users.show",$user->id)->with('message', 'Your settings have been updated!');
		} else {
			return Redirect::route('users.edit',$user->id)->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	public function show($id) {
		$user = User::find($id);
		$microposts = $user->getFeed()->paginate(10);
		$this->layout->content = View::make('users.show', array('user' => $user,'microposts' => $microposts));
	}
}