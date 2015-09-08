<?php namespace App\Http\Controllers;

class HomeController extends Controller {
    
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function home()
	{
		return view('pages.home');
	}

}
