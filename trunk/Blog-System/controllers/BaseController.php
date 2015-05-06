<?php
namespace Controllers;

abstract class BaseController  {
    /**
     * @var \MVC\View
     */
    protected $view;
    /**
     * @var \MVC\Config
     */
    protected $config;
    /**
     * @var \MVC\App
     */
    protected $app;
    /**
     * @var \MVC\InputData
     */
    protected $input;
    /**
     * @var \MVC\Session\ISession
     */
    protected $session;

    protected function __construct(){
        $this->view = \MVC\View::getInstance();
        $this->input = \MVC\InputData::getInstance();
        $this->app = \MVC\App::getInstance();
        $this->session = $this->app->getSession();
        $this->config = $this->app->getConfig();

        $this->view->appendToLayout('header', 'inc.header');
        $this->view->appendToLayout('footer', 'inc.footer');
        $this->view->appendToLayout('side-bar', 'inc.side-bar');
    }

    protected function redirect($url)
    {
        if ($url) {
            header("Location: $url");
            die;
        } else {
            throw new \Exception('Invalid url', 500);
        }
    }

}