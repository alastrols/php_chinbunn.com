<?php

namespace Main\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Valitron\Validator;

class IndexController extends BaseController
{

    public function getIndex(Request $req, Response $res)
    {
        $container = $this->ci;
        $session = $container->session;
        $segment = $session->getSegment("views");
        $ip = $_SERVER['REMOTE_ADDR'];
        $db = $this->ci->medoo;
        $checkexist = $db->get('views',['ipaddress'],['ipaddress'=>$ip]);
        if($checkexist == false){
        $getIpaddress = $db->insert('views',['ipaddress'=>$ip]);
        }
        $views = $db->select('views',['ipaddress']);
        $viewcount = count($views);
        $segment->set('counter', $viewcount);

        // if ($req->getUri()->getScheme() !== 'https') {
        // $uri = $req->getUri()->withScheme("https")->withPort(null);
        // return $res->withRedirect( (string)$uri );
        // } else {
        return $this->ci->view->render($res, 'index.twig',['viewcount'=>$viewcount]);
        // }
        
    }

    public function getLandingpage(Request $req, Response $res)
    {
        return $this->ci->view->render($res, 'landingpage.twig');
    }
    

}
