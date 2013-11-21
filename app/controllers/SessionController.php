<?php

class SessionController extends BaseController {

  /**
   * User Repository
   */
  protected $user;

  /**
   * The layout that should be used for responses.
   */
  protected $layout = 'layouts.main';

  /**
   * Inject the User Repository
   */
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  /**
   * Show the form for creating a new Session
   */
  public function create()
  {
    $this->layout->content = View::make('session.create');
  }

  public function store()
  {
    if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
      return Redirect::route("users.show",Auth::user()->id)->with('message', 'Welcome to the Sample App!');
    } else {
      return Redirect::to('/login')
        ->with('message', 'Your username/password combination was incorrect')
        ->withInput();
    }
  }

  public function destroy()
  {
    Auth::logout();
    return Redirect::to('/')->with('message', 'Your are now logged out!');
  }

}