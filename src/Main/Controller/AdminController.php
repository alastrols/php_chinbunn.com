<?php

namespace Main\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends BaseController
{
  public function getIndex(Request $req, Response $res)
  {
    $container = $this->ci;
    $session = $container->session;
    $segment = $session->getSegment("admin");
    if ($segment->get('admin_id')) {
      return $this->ci->view->render($res, 'admin/index.twig');
    } else {
      return $this->ci->view->render($res, 'admin/login.twig');
    }
  }

  public function getLogin(Request $req, Response $res)
  {
    return $this->ci->view->render($res, 'admin/login.twig');
  }

  public function postLogin(Request $req, Response $res)
  {
    $container = $this->ci;
    $session = $container->session;
    $segment = $session->getSegment('admin');
    $db = $this->ci->medoo;
    $varPost = $req->getParsedBody();
    $username = $varPost['username'];
    $password = $varPost['password'];
    if ($admin = $db->get('admin',['id','username','email','mobile','first_name','last_name'],[ 'AND' => [ 'username' => $username , 'password' => $password]])) {
      $segment->set('admin_id',$admin['id']);
      $segment->set('admin_username',$admin['username']);
      $segment->set('admin_first_name',$admin['first_name']);
      $segment->set('admin_last_name',$admin['last_name']);
      $session->commit();
      return $res->withStatus(301)->withHeader('Location', '/admin');
    } else {
      $segment->setFlash("err_msg", "username or password error");
      $session->commit();
      return $container->view->render($res, "/admin/login.twig",["message"=> $segment->getFlash("err_msg")]);
    }
  }

  public function getLogout(Request $req, Response $res) {
    $container = $this->ci;
    $session = $container->session;
    $session->clear();
    $session->destroy();
    $session->commit();
    return $res->withStatus(301)->withHeader('Location', '/admin/login');
  }

  public function getJobCategoryLv1(Request $req, Response $res)
  {
    $xcrud = $this->ci->xcrud->getInstance();
    $xcrud->table('job_category_lv1');
    $xcrud->unset_title();
    return $this->ci->view->render($res, 'admin/jobCategoryLv1.twig', ['xcrud'=> $xcrud]);
  }

  public function getJobCategoryLv2(Request $req, Response $res)
  {
    $xcrud = $this->ci->xcrud->getInstance();
    $xcrud->table('job_category_lv2');
    $xcrud->unset_title();
    return $this->ci->view->render($res, 'admin/jobCategoryLv2.twig', ['xcrud'=> $xcrud]);
  }

  public function getShop(Request $req, Response $res)
  {
    $xcrud = $this->ci->xcrud->getInstance();
    $xcrud->table('shop');
    $xcrud->unset_title();
    $xcrud->change_type("shop_logo","image");
    return $this->ci->view->render($res, 'admin/shop.twig', ['xcrud'=> $xcrud]);
  }


}
