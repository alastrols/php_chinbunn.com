<?php

namespace Main;

use Slim\App;
use Main\Controller\IndexController;
use Main\Controller\XcrudAjaxAction;
use Main\Controller\AdminController;
class Route
{
    private $slim;

    public function __construct(App $slim)
    {
        $this->slim = $slim;
    }

    public function run()
    {
        $this->slim->get('/', IndexController::class.':getIndex');
        // $this->slim->get('/index', IndexController::class.':getIndex');
        


        $this->slim->post('/sentmessage', IndexController::class.':postSentMessage');
    }
}
