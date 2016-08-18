<?php

use PHPUnit\Framework\TestCase;
include("../db/DatabaseHandler.php");

/**
 * Created by PhpStorm.
 * User: joshuapancho
 * Date: 16/08/2016
 * Time: 1:31:14PM
 */

class DatabaseHandlerCommentTest extends TestCase
{
    protected static $dbh;

    public static function setUpBeforeClass()
    {
        self::$dbh = new DatabaseHandler("test_database", true);
        self::$dbh->createUser("Jon", "Snow", "jsnow@gmail.com", 0);
        self::$dbh->createTicket("Mac OSX", "It won't turn on!", "", "Pending", 1);
    }

    public static function tearDownAfterClass()
    {
        self::$dbh = null;
    }

    public function testAddCommentValidUserValidTicketIDReturnsTrue()
    {
        $this->assertTrue(self::$dbh->addComment(1, "Comment", 1));
    }

    public function testAddCommentValidUserInvalidTicketIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->addComment(2, "Comment", 1));
    }

    public function testAddCommentInvalidUserValidTicketIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->addComment(1, "Comment", 2));
    }

    public function testAddCommentInvalidUserInvalidTicketIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->addComment(2, "Comment", 2));
    }

    public function testGetCommentValidCommentIDReturnsNotNull()
    {
        $this->assertNotNull(self::$dbh->getComment(1));
    }

    public function testGetCommentInvalidCommentIDReturnsNull()
    {
        $this->assertNull(self::$dbh->getComment(2));
    }

    public function testUpdateCommentValidCommentIDReturnsTrue()
    {
        $this->assertTrue(self::$dbh->updateComment(1, "Edited comment"));
    }

    public function testUpdateCommentInvalidCommentIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->updateComment(2, "Edited comment"));
    }

    public function testDeleteCommentInvalidCommentIDReturnsFalse()
    {
        $this->assertFalse(self::$dbh->deleteComment(2));
    }

    public function testDeleteCommentValidCommentIDReturnsTrue()
    {
        $this->assertTrue(self::$dbh->deleteComment(1));
    }
}