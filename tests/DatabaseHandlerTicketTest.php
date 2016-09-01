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

    // Create Ticket tests

    public function testCreateTicketWithValidSubmitterIDReturnsExpectedId()
    {
        $this->assertEquals(self::$dbh->createTicket("My Mac isn't working", "Mac OSX", "It won't turn on!", "", 1), 1);
    }

    public function testCreateTicketWithInvalidSubmitterIDReturnsNegative()
    {
        $this->assertEquals(self::$dbh->createTicket("My Windows computer isn't working", "Windows", "Help!", "", 2), -1);
    }

    // Fetch Ticket tests

    public function testGetTicketWithValidIDReturnsNotNull()
    {
        $this->assertNotNull(self::$dbh->getTicketById(1));
    }

    public function testGetTicketWithInvalidIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->getTicketById(2));
    }

    public function testGetUserTicketsValidEmailReturnsCorrectCount() {
        self::$dbh->createTicket("My Mac machine doesn't work", "Mac OSX", "It won't turn on again!", "", 1);

        $this->assertCount(2, self::$dbh->getTicketsByEmail("jsnow@gmail.com"));
    }

    public function testGetUserTicketsInvalidEmailReturnsNull() {
        $this->assertNotNull(self::$dbh->getTicketsByEmail("rstark@gmail.com"));
    }

    // Update Ticket tests

    public function testUpdateTicketWithValidTicketIDAndSubmitterIDReturnsTrue() {
        $this->assertTrue(self::$dbh->updateTicket(1, "My Ubuntu machine doesn't work", "Ubuntu", "It won't turn on!", "", "Pending", 1));
    }

    public function testUpdateTicketWithValidTicketIDInvalidSubmitterIDReturnsFalse() {
        $this->assertFalse(self::$dbh->updateTicket(1, "My Ubuntu machine doesn't work", "Ubuntu", "It won't turn on!", "", "Pending", 2));
    }

    public function testUpdateTicketWithInvalidTicketIDReturnsFalse() {
        $this->assertFalse(self::$dbh->updateTicket(100, "My Ubuntu machine doesn't work", "Ubuntu", "It won't turn on!", "", "Pending", 1));
    }

    // Delete Ticket tests

    public function testDeleteTicketWithInvalidTicketIDReturnsFalse() {
        $this->assertFalse(self::$dbh->deleteTicket(100));
    }

    public function testDeleteTicketWithValidTicketIDReturnsTrue() {
        $this->assertTrue(self::$dbh->deleteTicket(1));
    }

    // List all tickets tests
    public function testGetAllTicketsForSystemReturnsCorrectCount() {
        $this->assertCount(1, self::$dbh->getAllTicketsInSystem());
    }

    public function testGetAllTicketsInSystemEmptyReturnsEmpty() {
        self::$dbh->deleteTicket(2);

        $this->assertCount(0, self::$dbh->getAllTicketsInSystem());
    }
}