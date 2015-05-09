<?php
/**
 * Created by PhpStorm.
 * User: petrovaliev95
 * Date: 07-May-15
 * Time: 7:28 PM
 */

namespace Controllers;

use \Models\User;

class Users extends BaseController{
    /**
     * @var User Model
     */
    private $users;
    private $validation;

    function __construct(){
        parent::__construct();
        $this->users = new User();
        $this->validation = new \MVC\Validation();
    }

    public function login(){
        if($this->session->username != null){
            $this->redirect("/");
        }
        if($this->input->hasPost('submit')){
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $currUser = $this->users->getUser($username);
            if($currUser != null && password_verify($password, $currUser['password'])){
                $this->session->__set('username', $currUser['username']);
                $this->session->__set('user_id', $currUser['id']);
                $this->session->__set('is_admin', $currUser['is_admin']);
                $this->redirect("/");
            } else{
                $this->data['error'] = "User with this username and password does not exist.";
            }
        }

        $this->view->appendToLayout("login", "user.login_template");
        $this->view->display("user.login", $this->data, false);
    }

    public function logout(){
        if($this->session->__get('username') != null){
            $this->session->destroySession();
        }

        $this->redirect("/");
    }

    public function register(){
        if($this->session->username != null){
            $this->redirect("/");
        }
        if($this->input->hasPost('submit')){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $confirmPassword = $this->input->post('confirmPassword');

            if($username != '' && $password != '' && $confirmPassword != '' && $password == $confirmPassword){
                $userFromDb =  $this->users->getUser($username);

                if($userFromDb == null){
                    $id = $this->users->register($username, $password);

                    if($id == null){
                        $error = "Theare are problem with user creating.";
                        return;
                    }

                    $currUser = $this->users->getUserById($id);
                    if($currUser != null){
                        $this->session->__set('username', $currUser['username']);
                        $this->session->__set('user_id', $currUser['id']);
                        $this->session->__set('is_admin', $currUser['is_admin']);
                        $this->redirect("/");
                    } else{
                        $error = "Theare are problem with user creating.";
                        return;
                    }

                } else {
                    $error = "This username is not available.";
                }
            } else{
                $error = "All fields are required.";
                if($password != $confirmPassword){
                    $error = "Passwords don't match.";
                }
            }

            if(isset($error) && $error != ''){
                $this->data['error'] = $error;
            }
        }

        $this->view->appendToLayout("register", "user.register_template");
        $this->view->display("user.register", $this->data, false);
    }
}