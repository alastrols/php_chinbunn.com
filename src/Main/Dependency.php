<?php
namespace Main;
use Slim\App;
use Slim\Container;
use Main\Dependency\Session;
use Main\Dependency\View;
use Main\Auth\Storage\RedisStorage;
use Main\Auth\Storage\SessionStorage;
use Interop\Container\ContainerInterface;
use Aura\Session\SessionFactory;

class Dependency
{
  public function __construct(App $app)
  {
    $this->app = $app;
  }

  public function run()
  {
    $container = $this->app->getContainer();
    $container["view"] = new View();
    $container["auth"] = function(ContainerInterface $ci){
      // $storage = new RedisStorage($ci->predis);
      $storage = new SessionStorage();
      $auth = new \Main\Auth\Auth($ci, $storage);
      return $auth;
    };
    // $container["predis"] = function(ContainerInterface $ci){
    //   return new \Predis\Client('tcp://redis_justklass:6379');
    // };
    $container["session"] = function(ContainerInterface $ci){
      $session_factory = new SessionFactory();
      // session_set_cookie_params(1209600);
      return $session_factory->newInstance($_COOKIE);
    };
    $container["medoo"] = function(ContainerInterface $container)
    {
      return new \medoo($container["config"]["medoo"]);
    };
  }
}
