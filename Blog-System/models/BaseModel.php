<?php

/**
 * Base Model
 */
namespace Models;

use MVC\DB\SimpleDb;

class BaseModel {
	/**
	 * @var SimpleDb
	 */
	protected $db;
	public function __construct() {
		$this->db = new SimpleDb();
	}
}