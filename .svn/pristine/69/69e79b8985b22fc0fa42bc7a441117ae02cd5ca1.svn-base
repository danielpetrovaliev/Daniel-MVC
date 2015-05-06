<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NativeSession
 *
 * @author gatakka
 */
namespace MVC\Session;
class NativeSession implements \MVC\Session\ISession{
    public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secure = false) {
        if(strlen($name)<1){
            $name='_sess';
        }
        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secure, true);
        session_start();
    }

    public function __get($name) {
        return $_SESSION[$name];
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function destroySession() {
        session_destroy();
    }

    public function getSessionId() {
        return session_id();
    }

    public function saveSession() {
        session_write_close();
    }
}



