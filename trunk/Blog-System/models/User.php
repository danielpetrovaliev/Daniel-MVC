<?php

namespace Models;

class User extends BaseModel {

	public function getUsers() {
		$result = $this->db->prepare("SELECT id, username, password  FROM users")->execute()->fetchAllAssoc();

		return $result;
	}

}
