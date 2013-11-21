<?php

class HomeController extends BaseController {

  protected $layout = "layouts.main";
  /**
   * User Repository
   */
  protected $user;

  /**
   * Inject the User Repository
   */
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function index()
  {
    if (Auth::check())
    {
      $this->layout->content =  View::make('home.dashboard', compact('posts'));
    }
    $this->layout->content =  View::make('home.landing');
  }

  public function about()
  {
    $this->layout->content = View::make('home.about');
  }

}