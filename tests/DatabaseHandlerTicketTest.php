<?php

use PHPUnit\Framework\TestCase;
include("../db/DatabaseHandler.php");

/**
 * Created by PhpStorm.
 * User: joshuapancho
 * Date: 16/08/2016
 * Time: 1:30:22PM
 */

class DatabaseHandlerTicketTest extends TestCase
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