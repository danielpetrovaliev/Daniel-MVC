<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SimpleDB
 *
 * @author gatakka
 */

namespace MVC\DB;

class SimpleDB {

    protected $connection = 'default';
    private $db = null;    
    private $stmt = null;
    private $params = array();    
    private $sql;
    
    public function __construct($connection = null) {
        if ($connection instanceof \PDO) {
            $this->db = $connection;
        } else if ($connection != null) {
            $this->db = \MVC\App::getInstance()->getDBConnection($connection);
            $this->connection = $connection;
        } else {
            $this->db = \MVC\App::getInstance()->getDBConnection($this->connection);
        }
    }
    
    /**
     * 
     * @param type $sql
     * @param type $params
     * @param type $pdoOptions
     * @return \MVC\DB\SimpleDB
     */
    public function prepare($sql, $params = array(), $pdoOptions = array()) {
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;
        return $this;
    }
    
    /**
     * 
     * @param type $params
     * @return \MVC\DB\SimpleDB
     */
    public function execute($params = array()) {
        if ($params) {
            $this->params = $params;
        }        
        $this->stmt->execute($this->params);        
        return $this;
    }    
    
    public function fetchAllAssoc() {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function fetchRowAssoc() {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function fetchAllNum() {
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }

    public function fetchRowNum() {
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }

    public function fetchAllObj() {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function fetchRowObj() {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAllColumn($column) {
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN, $column);
    }

    public function fetchRowColumn($column) {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $column);
    }

    public function fetchAllClass($class) {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function fetchRowClass($class) {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $class);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getAffectedRows() {
        return $this->stmt->rowCount();
    }

    public function getSTMT() {
        return $this->stmt;
    }
}


