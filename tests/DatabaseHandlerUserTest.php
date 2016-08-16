<?php

use PHPUnit\Framework\TestCase;
include("../db/DatabaseHandler.php");

/**
 * Created by PhpStorm.
 * User: joshuapancho
 * Date: 15/08/2016
 * Time: 11:44:49AM
 */
class DatabaseHandlerUserTest extends TestCase
{
    protected static $dbh;

    public static function setUpBeforeClass()
    {
        self::$dbh = new DatabaseHandler("test_database", true);
    }

    public static function tearDownAfterClass()
    {
        self::$dbh = null;
    }

    public function testInsertNewUserReturnsTrue()
    {
        $this->assertTrue(self::$dbh->createUser('Jon', 'Snow', 'jsnow@gmail.com', 0));
    }

    public function testInsertUserSameEmailReturnsFalse()
    {
        $this->assertFalse(self::$dbh->createUser('John', 'Snow', 'jsnow@gmail.com', 0));
    }

    public function testGetValidUserReturnsNotNull()
    {
        $this->assertNotNull(self::$dbh->getUser(1));
    }

    public function testGetInvalidUserReturnsNull()
    {
        $this->assertNull(self::$dbh->getUser(2));
    }

    public function testUpdateValidUserReturnsTrue()
    {
        $this->assertTrue(self::$dbh->updateUser(1, 'Jon', 'Stark', 'jstark@gmail.com', 0));
    }

    public function testUpdateInvalidUserReturnsFalse()
    {
        $this->assertFalse(self::$dbh->updateUser(3, 'Robb', 'Stark', 'rstark@gmail.com', 0));
    }

    public function testDeleteInvalidUserReturnsFalse()
    {
        $this->assertFalse(self::$dbh->deleteUser(2));
    }

    public function testDeleteValidUserReturnsTrue()
    {
        $this->assertTrue(self::$dbh->deleteUser(1));
    }

}
