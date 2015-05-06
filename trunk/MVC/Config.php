<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 * 
 * @author gatakka
 */

namespace MVC;

class Config {

    private static $_instance = null;
    private $_confiMVColder = null;
    private $_configArray = array();

    private function __construct() {
        
    }

    public function getConfiMVColder() {
        return $this->_confiMVColder;
    }

    public function setConfiMVColder($confiMVColder) {
        if (!$confiMVColder) {
            throw new \Exception('Empty config folder path:');
        }
        $_confiMVColder = realpath($confiMVColder);
        if ($_confiMVColder != FALSE && is_dir($_confiMVColder) && is_readable($_confiMVColder)) {
            //clear old config data
            $this->_configArray = array();
            $this->_confiMVColder = $_confiMVColder . DIRECTORY_SEPARATOR;
            $ns = $this->app['namespaces'];
	    if (is_array($ns)) {
		\MVC\Loader::registerNamespaces($ns);
	    }
        } else {
            throw new \Exception('Config directory read error:' . $confiMVColder);
        }
        
    }
    
    public function includeConfiMVCile($path) {
        if (!$path) {
            //TODO
            throw new \Exception;
        }
        $_file = realpath($path);
        if ($_file != FALSE && is_file($_file) && is_readable($_file)) {
            $_basename = explode('.php', basename($_file))[0];
            $this->_configArray[$_basename]=include $_file;            
        } else {
            //TODO
            throw new \Exception('Config file read error:' . $path);
        }
    }
    
    public function __get($name) {

        if (!$this->_configArray[$name]) {            
            $this->includeConfiMVCile($this->_confiMVColder . $name . '.php');
        }
        if (array_key_exists($name, $this->_configArray)) {            
            return $this->_configArray[$name];
        }
        return null;
    }
    
    /**
     * 
     * @return \MVC\Config
     */
    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new \MVC\Config();
        }
        return self::$_instance;
    }

}

