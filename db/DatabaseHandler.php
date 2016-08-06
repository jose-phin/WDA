<?php

/**
 * Created by PhpStorm.
 * User: joshuapancho
 * Date: 6/08/2016
 * Time: 8:27:30PM
 */
class DatabaseHandler
{
    private $db = NULL;

    function __construct($databaseName)
    {
        $this->db = new SQLite3($databaseName);
    }

    # User Functions
    function addUser($firstName, $lastName, $email)
    {

    }

    function getUser($userId)
    {

    }

    function updateUser($userId)
    {

    }

    function deleteUser($userId)
    {

    }

    # Ticket Functions


    # ITS Functions


    # Comment Functions
}