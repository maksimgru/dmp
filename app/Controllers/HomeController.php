<?php

namespace Controllers;

// use Controllers\Controller;

/**
 * The default home controller, called when no controller/action has been passed to the app
 */
class HomeController extends Controller
{

    /**
     * The default controller method
     *
     * @return void
     *
     */
    public function indexAction()
    {
        $this->view('home/index', []);
    }

}
