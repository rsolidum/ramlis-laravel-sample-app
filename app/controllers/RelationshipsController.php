<?php

class RelationshipsController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('create','store','destroy')));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), Relationship::$rules);

		if ($validator->passes()) {
			$relationship = new Relationship;
			$relationship->followed_id = Input::get('followed_id');
			$relationship->user_id = Auth::user()->id;
			$relationship->save();

			return Redirect::route("users.show",$relationship->followed_id);
		} else {
			return Redirect::route("users.show",Auth::user()->id)->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$relationship = Relationship::find($id);
		if ( Auth::check() and Auth::user()->id == $relationship->user_id ) {
			$followed_id = $relationship->followed_id;
			$relationship->delete();
			return Redirect::route("users.show",$followed_id);
		} else {
			return Redirect::route("users.show",Auth::user()->id);
		}
	}

}
