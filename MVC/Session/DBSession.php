<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBSession
 *
 * @author gatakka
 */
namespace MVC\Session;
class DBSession extends \MVC\DB\SimpleDB implements \MVC\Session\ISession{
    
    private $sessionName;
    private $tableName;
    private $lifetime;
    private $path;
    private $domain;
    private $secure;
    private $sessionId=null;
    private $sessionData = array();
    
    public function __construct($dbconnection, $name, $tableName = 'session', $lifetime = 3600, $path = null, $domain = null, $secure = false) {        
        parent::__construct($dbconnection);
        $this->tableName = $tableName;
        $this->sessionName = $name;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->sessionId = $_COOKIE[$name];
        if (rand(0, 50) == 1) {
            $this->_gc();
        }
        if (strlen($this->sessionId) < 32) {
            $this->_startNewSession();
        } else if (!$this->_validateSession()) {
            $this->_startNewSession();
        }
    }

    private function _startNewSession() {
        $this->sessionId = md5(uniqid('MVC', TRUE));
        $this->prepare('INSERT INTO ' . $this->tableName . ' (sessid,valid_until) VALUES(?,?)',
                array($this->sessionId, (time() + $this->lifetime)))->execute();
        setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
    }
    
    private function _validateSession() {
        if ($this->sessionId) {
            $d = $this->prepare('SELECT * FROM ' . $this->tableName . ' WHERE sessid=? AND valid_until<=?', 
                    array($this->sessionId, (time() + $this->lifetime)))->execute()->fetchAllAssoc();
            if (is_array($d) && count($d) == 1 && $d[0]) {
                $this->sessionData = unserialize($d[0]['sess_data']);
                return true;
            }
        }
        return false;
    }
    
    public function __get($name) {
        return $this->sessionData[$name];
    }

    public function __set($name, $value) {
        $this->sessionData[$name] = $value;        
    }

    public function destroySession() {
        if ($this->sessionId) {
            $this->prepare('DELETE FROM ' . $this->tableName . ' WHERE sessid=?', array($this->sessionId))->execute();
        }
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    public function saveSession() {        
         if ($this->sessionId) {
            $this->prepare('UPDATE ' . $this->tableName . ' SET sess_data=?,valid_until=? WHERE sessid=?', 
                    array(serialize($this->sessionData), (time() + $this->lifetime), $this->sessionId))->execute();
            setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
        }
    }
    
    private function _gc() {
        $this->prepare('DELETE FROM `' . $this->tableName . '` WHERE valid_until<?', array(time()))->execute();
    }
}


