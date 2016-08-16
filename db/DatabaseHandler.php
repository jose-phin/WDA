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

    function __construct($databaseName, $testingMode = false)
    {
        try {
            if ($testingMode) {
                $this->db = new PDO('sqlite::memory:');
            } else {
                $this->db = new PDO('sqlite:'.$databaseName.'.db');
            }

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Turn foreign key constraints on
            $this->db->exec('PRAGMA foreign_keys = ON;');

            echo 'Connected'.'<br/>';

            $this->setUpTables();
        } catch (PDOException $e) {
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create database: " . $e->getMessage() . "\n", 3, "errors.log");
            die();
        }

    }

    function __destruct()
    {
        // close our DB connection
        $this->db = null;
    }

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

            echo 'Created tables (if they didn\'t exist already)<br/>';

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create tables: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    /****************************************
     *  USER FUNCTIONS
     ****************************************/

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create user: " . $e->getMessage() . "\n", 3, "errors.log");

            return false;
        }
    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to get user: " . $e->getMessage() . "\n", 3, "errors.log");

            return null;
        }
    }

    function updateUser($userId, $firstName, $lastName, $email, $isITS)
    {
        try {
            $this->db->beginTransaction();

            $update = "UPDATE users SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        is_its = :is_its
                        WHERE user_id = :user_id";

            $stmt = $this->db->prepare($update);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $userId);
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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update user: " . $e->getMessage() . "\n", 3, "errors.log");

            return false;
        }
    }

    function deleteUser($userId)
    {
        try {
            $this->db->beginTransaction();

            $delete = "DELETE FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($delete);

            $stmt->bindParam(':user_id', $userId);
            $res =$stmt->execute();

            $this->db->commit();

            if ($stmt->rowCount() != 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to delete user: " . $e->getMessage() . "\n", 3, "errors.log");
        }

    }

    /****************************************
     *  TICKET FUNCTIONS
     ****************************************/

    function createTicket($osType, $primaryIssue, $additionalNotes, $status, $submitterId)
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

            $res = $stmt->execute();
            $this->db->commit();

            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create ticket: " . $e->getMessage() . "\n", 3, "errors.log");

            return false;
        }
    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to get ticket: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update ticket: " . $e->getMessage() . "\n", 3, "errors.log");

            return false;
        }
    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to delete ticket: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }


    /****************************************
     *  COMMENT FUNCTIONS
     ****************************************/

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

            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to add comment: " . $e->getMessage() . "\n", 3, "errors.log");

            return false;
        }

    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to get comment " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update comment: " . $e->getMessage() . "\n", 3, "errors.log");
        }

    }

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
            error_log('['.date("d/m/y H:i:s").'] '."Failed to delete comment: " . $e->getMessage() . "\n", 3, "errors.log");

            return false;
        }
    }

}