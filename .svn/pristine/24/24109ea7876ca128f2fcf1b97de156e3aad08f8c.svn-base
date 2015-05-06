<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validation
 *
 * @author gatakka
 */

namespace MVC;

class Validation {

    private $_rules = array();
    private $_errors = array();

    public function setRule($rule, $value, $params = null, $name = null) {
        $this->_rules[] = array('val' => $value, 'rule' => $rule, 'par' => $params, 'name' => $name);
        return $this;
    }

    public function validate() {
        $this->_errors = array();
        if (count($this->_rules) > 0) {
            foreach ($this->_rules as $v) {
                if (!$this->$v['rule']($v['val'], $v['par'])) {
                    if ($v['name']) {
                        $this->_errors[] = $v['name'];
                    } else {
                        $this->_errors[] = $v['rule'];
                    }
                }
            }
        }
        return (bool) !count($this->_errors);
    }

    public function getErrors() {
        return $this->_errors;
    }

    public function __call($a, $b) {
        throw new \Exception('Invalid validation rule', 500);
    }

    public static function required($val) {
        if (is_array($val)) {
            return !empty($val);
        } else {
            return $val != '';
        }
    }

    public static function matches($val1, $val2) {
        return $val1 == $val2;
    }

    public static function matchesStrict($val1, $val2) {
        return $val1 === $val2;
    }

    public static function different($val1, $val2) {
        return $val1 != $val2;
    }

    public static function differentStrict($val1, $val2) {
        return $val1 !== $val2;
    }

    public static function minlength($val1, $val2) {
        return (mb_strlen($val1) >= $val2);
    }

    public static function maxlength($val1, $val2) {
        return (mb_strlen($val1) <= $val2);
    }

    public static function exactlength($val1, $val2) {
        return (mb_strlen($val1) == $val2);
    }

    public static function gt($val1, $val2) {
        return ($val1 > $val2);
    }

    public static function lt($val1, $val2) {
        return ($val1 < $val2);
    }

    public static function alpha($val1) {
        return (bool) preg_match('/^([a-z])+$/i', $val1);
    }

    public static function alphanum($val1) {
        return (bool) preg_match('/^([a-z0-9])+$/i', $val1);
    }

    public static function alphanumdash($val1) {
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $val1);
    }

    public static function numeric($val1) {
        return is_numeric($val1);
    }

    public static function email($val1) {
        return filter_var($val1, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function emails($val1) {
        if (is_array($val1)) {
            foreach ($val1 as $v) {
                if (!self::email($val1)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public static function url($val1) {
        return filter_var($val1, FILTER_VALIDATE_URL) !== false;
    }

    public static function ip($val1) {
        return filter_var($val1, FILTER_VALIDATE_IP) !== false;
    }

    public static function regexp($val1, $val2) {
        return (bool) preg_match($val2, $val1);
    }

    public static function custom($val1, $val2) {
        if ($val2 instanceof \Closure) {
            return (boolean) call_user_func($val2, $val1);
        } else {
            throw new \Exception('Invalid validation function', 500);
        }
    }

}

