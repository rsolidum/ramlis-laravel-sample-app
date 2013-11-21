<?php

class MicropostsController extends BaseController {

	protected $layout = "layouts.main";
	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('store, destroy')));
	}

	public function index() {
		$users = User::paginate(10);
		$this->layout->content = View::make('users.index', array('users' => $users));
	}

	public function store() {
		$validator = Validator::make(Input::all(), Micropost::$rules);

		if ($validator->passes()) {
			$micropost = new Micropost;
			$micropost->body = Input::get('body');
			$micropost->user_id = Auth::user()->id;
			$micropost->save();

			return Redirect::route("users.show",Auth::user()->id)->with('message', 'Micropost created!');
		} else {
			return Redirect::route("users.show",Auth::user()->id)->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	public function destroy($id) {
		$micropost = Micropost::find($id);
		if ( Auth::check() and Auth::user()->id == $micropost->user->id ) {
			$micropost->delete();
			return Redirect::route("users.show",Auth::user()->id)->with('message', 'Micropost deleted!');
		} else {
			return Redirect::route("users.show",Auth::user()->id)->with('message', 'You do not have the permissions to delete that micropost');
		}
	}

}