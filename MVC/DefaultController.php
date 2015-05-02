<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultController
 *
 * @author gatakka
 */

namespace MVC;

class DefaultController {

	/**
	 *
	 * @var \MVC\App
	 */
	public $app;
	/**
	 *
	 * @var \MVC\View
	 */
	public $view;
	/**
	 *
	 * @var \MVC\Config
	 */
	public $config;
	/**
	 *
	 * @var \MVC\InputData
	 */
	public $input;

	public function __construct() {
		$this->app = \MVC\App::getInstance();
		$this->view = \MVC\View::getInstance();
		$this->config = $this->app->getConfig();
		$this->input = \MVC\InputData::getInstance();
	}

	public function jsonResponse() {

	}

}
