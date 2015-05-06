<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author gatakka
 */
namespace MVC\Routers;
interface IRouter {
    public function getURI();
    public function getPost();
}
