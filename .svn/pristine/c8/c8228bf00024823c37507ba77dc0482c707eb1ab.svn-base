<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultRouter
 *
 * @author gatakka
 */

namespace MVC\Routers;

class DefaultRouter implements \MVC\Routers\IRouter {

	private $controller = null;
	private $method = null;
	private $params = array();
	public function getUri() {
		$uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
		return $uri;
	}
	public function getPost() {
		return $_POST;
	}

}
