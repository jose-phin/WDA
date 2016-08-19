<?php

include("Logger.php");

/**
 * DatabaseHandler
 *
 * A convenience class that wraps around the SQLite DB and exposes CRUD methods on
 * users, tickets and comments.
 *
 * Created by PhpStorm.
 * User: joshuapancho
 * Date: 6/08/2016
 * Time: 8:27:30PM
 */
class DatabaseHandler
{
    private $db = null;
    private $logger = null;

    function __construct($databaseName, $testingMode = false)
    {
        try {

            // Depending on the mode that this instance is created, determine whether to create an
            // in-memory DB, or a production ready one
            if ($testingMode) {
                $this->db = new PDO('sqlite::memory:');
                $this->logger = new Logger("test_db.log");
            } else {
                $this->db = new PDO('sqlite:'.$databaseName.'.db');
                $this->logger = new Logger("prod_db.log");
            }

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Turn foreign key constraints on
            $this->db->exec('PRAGMA foreign_keys = ON;');

            $this->logger->log_info("Connected!");

            $this->setUpTables();
        } catch (PDOException $e) {
            $message = "Failed to create database: " . $e->getMessage();
            $this->logger->log_error($message);
            die();
        }

    }

    function __destruct()
    {
        // close our DB connection
        $this->db = null;
    }

    /**
     * Creates DB tables if they haven't been created already
     */
    private function setUpTables()
    {
        try {
            $this->db->beginTransaction();

            $this->db->exec("CREATE TABLE IF NOT EXISTS users (
                            user_id INTEGER PRIMARY KEY,
                            first_name TEXT NOT NULL,
                            last_name TEXT NOT NULL,
                            email TEXT NOT NULL,
                            is_its INTEGER NOT NULL CHECK (is_its IN (0,1)),
                            UNIQUE(email)
                        )");

            $this->db->exec("CREATE TABLE IF NOT EXISTS tickets (
                            ticket_id INTEGER PRIMARY KEY,
                            os_type TEXT NOT NULL,
                            primary_issue TEXT NOT NULL,
                            additional_notes TEXT NOT NULL,
                            status TEXT NOT NULL,
                            submitter_id INT NOT NULL,
                            FOREIGN KEY (submitter_id) REFERENCES users(user_id)
                        )");

            $this->db->exec("CREATE TABLE IF NOT EXISTS comments (
                            comment_id INTEGER PRIMARY KEY,
                            comment_text TEXT NOT NULL
                        )");

            $this->db->exec("CREATE TABLE IF NOT EXISTS ticket_comments (
                            id INTEGER PRIMARY KEY,
                            ticket_id INT NOT NULL,
                            comment_id INT NOT NULL,
                            FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id),
                            FOREIGN KEY(comment_id) REFERENCES comments(comment_id) ON DELETE CASCADE
                        )");


            $this->db->exec("CREATE TABLE IF NOT EXISTS users_comments (
                            id INTEGER PRIMARY KEY,
                            user_id INT NOT NULL,
                            comment_id INT NOT NULL,
                            FOREIGN KEY (user_id) REFERENCES users(user_id),
                            FOREIGN KEY (comment_id) REFERENCES comments(comment_id) ON DELETE CASCADE
                        )");


            $this->db->commit();

            $this->logger->log_info("Created tables (if they didn't exist already)");

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to create tables: " . $e->getMessage();
            $this->logger->log_error($message);
        }
    }

    /****************************************
     *  USER FUNCTIONS
     ****************************************/

    /**
     * Creates a user in the Users table
     *
     * @param $firstName String
     * @param $lastName String
     * @param $email String note that this must be a unique email
     * @param $isITS Boolean denotes whether a user is an ITS staff member or not
     *
     * @return bool True if the transaction succeeds, False otherwise
     */
    function createUser($firstName, $lastName, $email, $isITS)
    {
        try {
            $this->db->beginTransaction();

            $insert = "INSERT INTO users (first_name, last_name, email, is_its) VALUES (:first_name, :last_name, :email, :is_its)";
            $stmt = $this->db->prepare($insert);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);

            if ($isITS) {
                $its = 1;
            } else {
                $its = 0;
            }

            $stmt->bindParam(':is_its', $its);

            $stmt->execute();

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to create user: " . $e->getMessage();
            $this->logger->log_error($message);

            return false;
        }
    }

    /**
     * Gets a user with the specified ID
     *
     * @param $userId int
     * @return array|null an associative array containing the user's details, or null if the query fails
     */
    function getUser($userId)
    {
        try {
            $this->db->beginTransaction();

            $query = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return null;
            } else {
                return $result;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to get user: " . $e->getMessage();
            $this->logger->log_error($message);

            return null;
        }
    }

    /**
     * Updates a user with a specified email
     *
     * @param $email String
     * @param $firstName String
     * @param $lastName String
     * @param $newEmail String
     * @param $isITS Boolean
     * @return bool True if the query succeeds, False if otherwise
     */
    function updateUser($email, $firstName, $lastName, $newEmail, $isITS)
    {
        try {
            $this->db->beginTransaction();

            $update = "UPDATE users SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :newEmail,
                        is_its = :is_its
                        WHERE email = :email";

            $stmt = $this->db->prepare($update);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':newEmail', $newEmail);
            $stmt->bindParam(':is_its', $isITS);

            $stmt->execute();
            $this->db->commit();

            // Check to see if the UPDATE affected any rows
            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to update user: " . $e->getMessage();
            $this->logger->log_error($message);

            return false;
        }
    }

    /**
     * Deletes a user from the Users table with the specified email
     *
     * @param $email String
     * @return bool True if successfully deleted, False otherwise
     */
    function deleteUser($email)
    {
        try {
            $this->db->beginTransaction();

            $delete = "DELETE FROM users WHERE email = :email";
            $stmt = $this->db->prepare($delete);

            $stmt->bindParam(':email', $email);
            $res = $stmt->execute();

            $this->db->commit();

            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to delete user: " . $e->getMessage();
            $this->logger->log_error($message);
        }

    }

    /****************************************
     *  TICKET FUNCTIONS
     ****************************************/

    /**
     * Creates a new ticket in the Tickets table
     *
     * @param $osType String
     * @param $primaryIssue String
     * @param $additionalNotes String
     * @param $status String (OPTIONAL) will default to 'Pending' if not provided
     * @param $submitterId int
     * @return int the newly created Ticket ID, or -1 if unable to create the ticket
     */
    function createTicket($osType, $primaryIssue, $additionalNotes, $status = "Pending", $submitterId)
    {
        try {
            $this->db->beginTransaction();

            $insert = "INSERT INTO tickets (os_type, primary_issue, additional_notes, status, submitter_id) 
                      VALUES (:os_type, :primary_issue, :additional_notes, :status, :submitter_id)";
            $stmt = $this->db->prepare($insert);

            $stmt->bindParam(':os_type', $osType);
            $stmt->bindParam(':primary_issue', $primaryIssue);
            $stmt->bindParam(':additional_notes', $additionalNotes);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':submitter_id', $submitterId);

            $stmt->execute();

            $ticketId = $this->db->lastInsertId();

            $this->db->commit();
            return $ticketId;

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to create ticket: " . $e->getMessage();
            $this->logger->log_error($message);

            return -1;
        }
    }

    /**
     * Gets the ticket with the specified ID
     *
     * @param $ticketId int
     * @return array|null returns an associative array containing ticket details if successful, or null otherwise
     */
    function getTicket($ticketId)
    {
        try {
            $this->db->beginTransaction();

            $query = "SELECT * FROM tickets WHERE ticket_id = :ticket_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);

            $stmt->execute();
            $this->db->commit();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to get ticket: " . $e->getMessage();
            $this->logger->log_error($message);
        }
    }


    /**
     * Updates a ticket with a specified ID in the Tickets table
     *
     * @param $ticketId int
     * @param $osType String
     * @param $primaryIssue String
     * @param $additionalNotes String
     * @param $status String
     * @param $submitterId int
     * @return bool True if successfully updated, False otherwise
     */
    function updateTicket($ticketId, $osType, $primaryIssue, $additionalNotes, $status, $submitterId)
    {
        try {
            $this->db->beginTransaction();

            $update = "UPDATE tickets SET 
                        os_type = :os_type,
                        primary_issue = :primary_issue,
                        additional_notes = :additional_notes,
                        status = :status,
                        submitter_id = :submitter_id
                        WHERE ticket_id = :ticket_id";

            $stmt = $this->db->prepare($update);

            $stmt->bindParam(':os_type', $osType);
            $stmt->bindParam(':primary_issue', $primaryIssue);
            $stmt->bindParam(':additional_notes', $additionalNotes);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':submitter_id', $submitterId);
            $stmt->bindParam(':ticket_id', $ticketId);

            $stmt->execute();
            $this->db->commit();

            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to update ticket: " . $e->getMessage();
            $this->logger->log_error($message);

            return false;
        }
    }

    /**
     * Deletes a ticket with the specific ID from the Tickets table
     *
     * @param $ticketId int
     * @return bool True if successfully deleted, False otherwise
     */
    function deleteTicket($ticketId)
    {
        try {
            $this->db->beginTransaction();

            $delete = "DELETE FROM tickets WHERE ticket_id = :ticket_id";
            $stmt = $this->db->prepare($delete);

            $stmt->bindParam(':ticket_id', $ticketId);
            $stmt->execute();
            $this->db->commit();

            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to delete ticket: " . $e->getMessage();
            $this->logger->log_error($message);
        }
    }


    /****************************************
     *  COMMENT FUNCTIONS
     ****************************************/


    /**
     * Adds a new comment to a ticket
     *
     * @param $ticketId int
     * @param $commentText String
     * @param $submitterId int
     * @return int the ID of the newly created comment, or -1 if unable to create the comment
     */
    function addComment($ticketId, $commentText, $submitterId)
    {
        try {
            $this->db->beginTransaction();

            // Insert the comment into the comments table
            $commentInsert = "INSERT INTO comments (comment_text) VALUES (:comment_text)";
            $commentStmt = $this->db->prepare($commentInsert);
            $commentStmt->bindParam(':comment_text', $commentText);
            $commentStmt->execute();

            // Bind the comment to the ticket by inserting into the junction table (ticket_comments)
            $ticketInsert = "INSERT INTO ticket_comments (ticket_id, comment_id) VALUES (:ticket_id, :comment_id)";
            $ticketStmt = $this->db->prepare($ticketInsert);
            $ticketStmt->bindParam(':ticket_id', $ticketId);

            $commentId = $this->db->lastInsertId();
            $ticketStmt->bindParam(':comment_id', $commentId);
            $ticketStmt->execute();

            // Insert the comment into the users_comments junction table to link the submitter to the comment
            $submitterInsert = "INSERT INTO users_comments (comment_id, user_id) VALUES (:comment_id, :submitter_id)";
            $insertStmt = $this->db->prepare($submitterInsert);
            $insertStmt->bindParam(':comment_id', $commentId);
            $insertStmt->bindParam(':submitter_id', $submitterId);
            $insertStmt->execute();

            $this->db->commit();

            return $commentId;

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to add comment: " . $e->getMessage();
            $this->logger->log_error($message);

            return -1;
        }

    }

    /**
     * Gets a comment with a specified ID
     *
     * @param $commentId int
     * @return array|null returns an associative array containing the comment details, or null otherwise
     */
    function getComment($commentId)
    {
        try {
            $this->db->beginTransaction();

            $query = "SELECT comments.comment_id, comments.comment_text, ticket_comments.ticket_id
                    FROM comments
                    INNER JOIN ticket_comments ON comments.comment_id = ticket_comments.comment_id
                    WHERE comments.comment_id = :comment_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to get comment: " . $e->getMessage();
            $this->logger->log_error($message);
        }
    }

    /**
     * Updates a comment with a specified ID
     *
     * @param $commentId int
     * @param $newText String
     * @return bool True if successfully updated, False otherwise
     */
    function updateComment($commentId, $newText)
    {
        try {
            $this->db->beginTransaction();

            $updateCommentTable = "UPDATE comments SET comment_text = :comment_text WHERE comment_id = :comment_id";
            $stmt = $this->db->prepare($updateCommentTable);
            $stmt->bindParam(':comment_text', $newText);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->execute();

            $this->db->commit();

            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to update comment: " . $e->getMessage();
            $this->logger->log_error($message);
        }

    }

    /**
     * Deletes a comment from the Comments table
     *
     * @param $commentId int
     * @return bool True if able to successfully delete the comment, False otherwise
     */
    function deleteComment($commentId)
    {
        try {
            $this->db->beginTransaction();

            // Delete the comment from the actual comments table
            $deleteFromComments = "DELETE FROM comments WHERE comment_id = :comment_id";
            $stmt = $this->db->prepare($deleteFromComments);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->execute();

            $this->db->commit();

            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $message = "Failed to delete comment: " . $e->getMessage();
            $this->logger->log_error($message);

            return false;
        }
    }

}