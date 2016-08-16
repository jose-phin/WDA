<?php

use PHPUnit\Framework\TestCase;
include("DatabaseHandler.php");

/**
 * Created by PhpStorm.
 * User: joshuapancho
 * Date: 15/08/2016
 * Time: 11:44:49AM
 */
class TestDBUserFunctions extends TestCase
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

class TestDBTicketFunctions extends TestCase
{
    protected static $dbh;

    public static function setUpBeforeClass()
    {
        self::$dbh = new DatabaseHandler("test_database", true);
        self::$dbh->createUser("Jon", "Snow", "jsnow@gmail.com", 0);
    }

    public static function tearDownAfterClass()
    {
        self::$dbh = null;
    }

    public function testCreateTicketWithValidSubmitterIDReturnsTrue()
    {
        $this->assertTrue(self::$dbh->createTicket("Mac OSX", "It won't turn on!", "", "Pending", 1));
    }

    public function testCreateTicketWithInvalidSubmitterIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->createTicket("Windows", "Help!", "", "Pending", 2));
    }

    public function testGetTicketWithValidIDReturnsNotNull()
    {
        $this->assertNotNull(self::$dbh->getTicket(1));
    }

    public function testGetTicketWithInvalidIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->getTicket(2));
    }

    public function testUpdateTicketWithValidTicketIDAndSubmitterIDReturnsTrue() {
        $this->assertTrue(self::$dbh->updateTicket(1, "Ubuntu", "It won't turn on!", "", "Pending", 1));
    }

    public function testUpdateTicketWithValidTicketIDInvalidSubmitterIDReturnsFalse() {
        $this->assertFalse(self::$dbh->updateTicket(1, "Ubuntu", "It won't turn on!", "", "Pending", 2));
    }

    public function testUpdateTicketWithInvalidTicketIDReturnsFalse() {
        $this->assertFalse(self::$dbh->updateTicket(2, "Ubuntu", "It won't turn on!", "", "Pending", 1));
    }

    public function testDeleteTicketWithInvalidTicketIDReturnsFalse() {
        $this->assertFalse(self::$dbh->deleteTicket(2));
    }

    public function testDeleteTicketWithValidTicketIDReturnsTrue() {
        $this->assertTrue(self::$dbh->deleteTicket(1));
    }
}
