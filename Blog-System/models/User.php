<?php

namespace Models;

class User extends BaseModel {

	public function getUsers() {
		$result = $this->db->prepare("SELECT id, username, password  FROM users")->execute()->fetchAllAssoc();

		return $result;
	}

    public function register($username, $password){
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, password) VALUES(?, ?)";

        $result = $this->db->prepare($sql)->execute(array($username, $hashedPass))->getLastInsertId();

        return $result;
    }

    public function getUser($username){
        $sql = "SELECT id, username, password, is_admin FROM users where username = ?";

        $result = $this->db->prepare($sql)->execute(array($username))->fetchRowAssoc();

        return $result;
    }

    public function getUserById($id){
        $sql = "SELECT id, username, password, is_admin FROM users where id = ?";

        $result = $this->db->prepare($sql)->execute(array($id))->fetchRowAssoc();

        return $result;
    }

}
