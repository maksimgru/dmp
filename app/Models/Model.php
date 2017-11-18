<?php

namespace Models;

use Core\Database;

/**
 * This is Description of Model class
 *
 */
abstract class Model
{

    protected $db;

    /**
     * Description:
     *
     */
    function __construct()
    {
        $this->db = Database::connect()->database;
    }
}