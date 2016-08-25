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

    public function testCreateTicketWithValidSubmitterIDReturnsExpectedId()
    {
        $this->assertEquals(self::$dbh->createTicket("My Mac isn't working", "Mac OSX", "It won't turn on!", "", "Pending", 1), 1);
    }

    public function testCreateTicketWithInvalidSubmitterIDReturnsNegative()
    {
        $this->assertEquals(self::$dbh->createTicket("My Windows computer isn't working", "Windows", "Help!", "", "Pending", 2), -1);
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
        $this->assertTrue(self::$dbh->updateTicket(1, "My Ubuntu machine doesn't work", "Ubuntu", "It won't turn on!", "", "Pending", 1));
    }

    public function testUpdateTicketWithValidTicketIDInvalidSubmitterIDReturnsFalse() {
        $this->assertFalse(self::$dbh->updateTicket(1, "My Ubuntu machine doesn't work", "Ubuntu", "It won't turn on!", "", "Pending", 2));
    }

    public function testUpdateTicketWithInvalidTicketIDReturnsFalse() {
        $this->assertFalse(self::$dbh->updateTicket(2, "My Ubuntu machine doesn't work", "Ubuntu", "It won't turn on!", "", "Pending", 1));
    }

    public function testGetUserTicketsValidEmailReturnsCorrectCount() {
        self::$dbh->createTicket("My Mac machine doesn't work", "Mac OSX", "It won't turn on again!", "", "Pending", 1);

        $this->assertCount(2, self::$dbh->getAllTicketsForUser("jsnow@gmail.com"));
    }

    public function testGetUserTicketsInvalidEmailReturnsNull() {
        $this->assertNotNull(self::$dbh->getAllTicketsForUser("rstark@gmail.com"));
    }

    public function testDeleteTicketWithInvalidTicketIDReturnsFalse() {
        $this->assertFalse(self::$dbh->deleteTicket(100));
    }

    public function testDeleteTicketWithValidTicketIDReturnsTrue() {
        $this->assertTrue(self::$dbh->deleteTicket(1));
    }
}