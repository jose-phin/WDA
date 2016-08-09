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
        try {
            $this->db = new PDO('sqlite:'.$databaseName.'.db');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
                            email TEXT NOT NULL
                        )");

            $this->db->exec("CREATE TABLE IF NOT EXISTS its_members (
                            its_id INTEGER PRIMARY KEY,
                            first_name TEXT NOT NULL,
                            last_name TEXT NOT NULL,
                            email TEXT NOT NULL
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
                            FOREIGN KEY(comment_id) REFERENCES comments(comment_id)
                        )");

            $this->db->exec("CREATE TABLE IF NOT EXISTS its_comments (
                            id INTEGER PRIMARY KEY,
                            comment_id INT NOT NULL,
                            its_id INT NOT NULL,
                            FOREIGN KEY (comment_id) REFERENCES comments(comment_id),
                            FOREIGN KEY (its_id) REFERENCES its_members(its_id)
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

    function createUser($firstName, $lastName, $email)
    {
        try {
            $this->db->beginTransaction();

            $insert = "INSERT INTO users (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
            $stmt = $this->db->prepare($insert);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create user: " . $e->getMessage() . "\n", 3, "errors.log");
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
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to get user: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function updateUser($userId, $firstName, $lastName, $email)
    {
        try {
            $this->db->beginTransaction();

            $update = "UPDATE users SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email
                        WHERE user_id = :user_id";

            $stmt = $this->db->prepare($update);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $userId);

            $stmt->execute();
            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update user: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function deleteUser($userId)
    {
        try {
            $this->db->beginTransaction();

            $delete = "DELETE FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($delete);

            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $this->db->commit();

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

            $stmt->execute();
            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create ticket: " . $e->getMessage() . "\n", 3, "errors.log");
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

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update ticket: " . $e->getMessage() . "\n", 3, "errors.log");
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

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to delete ticket: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    /****************************************
     *  ITS FUNCTIONS
     ****************************************/

    function createITSMember($firstName, $lastName, $email)
    {
        try {
            $this->db->beginTransaction();

            $insert = "INSERT INTO its_members (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
            $stmt = $this->db->prepare($insert);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to create ITS Member: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function getITSMember($itsId)
    {
        try {
            $this->db->beginTransaction();

            $query = "SELECT * FROM its_members WHERE its_id = :its_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':its_id', $itsId, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to get ITS Member: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function updateITSMember($itsId, $firstName, $lastName, $email)
    {
        try {
            $this->db->beginTransaction();

            $update = "UPDATE its_members SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email
                        WHERE its_id = :its_id";

            $stmt = $this->db->prepare($update);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':its_id', $itsId);

            $stmt->execute();
            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update ITS Member: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function deleteITSMember($itsId)
    {
        try {
            $this->db->beginTransaction();

            $delete = "DELETE FROM its_members WHERE its_id = :its_id";
            $stmt = $this->db->prepare($delete);

            $stmt->bindParam(':its_id', $itsId);
            $stmt->execute();
            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to delete ITS Member: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }


    /****************************************
     *  COMMENT FUNCTIONS
     ****************************************/

    /****************************************
     *  USER COMMENT FUNCTIONS
     ****************************************/

    function addUserComment($ticketId, $commentText)
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

            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to add comment: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function getAllUserCommentsForTicket($ticketId)
    {
        try {
            $this->db->beginTransaction();
            $comments = array();

            $query = "SELECT users.user_id, tickets.ticket_id, tickets.os_type, tickets.primary_issue, tickets.additional_notes, tickets.status, comments.comment_id, comments.comment_text
                        FROM users
                        INNER JOIN tickets ON users.user_id = tickets.submitter_id
                        INNER JOIN ticket_comments ON tickets.ticket_id = ticket_comments.ticket_id
                        INNER JOIN comments ON ticket_comments.comment_id = comments.comment_id
                        WHERE tickets.ticket_id = :ticket_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':ticket_id', $ticketId);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($comments, $row);
            }

            $this->db->commit();

            return $comments;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to get user comment for this ticket: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    function updateUserComment($commentId, $newText)
    {
        try {
            $this->db->beginTransaction();

            $updateCommentTable = "UPDATE comments SET comment_text = :comment_text WHERE comment_id = :comment_id";
            $stmt = $this->db->prepare($updateCommentTable);
            $stmt->bindParam(':comment_text', $newText);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->execute();

            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to update user comment: " . $e->getMessage() . "\n", 3, "errors.log");
        }

    }

    function deleteUserComment($commentId)
    {
        try {
            $this->db->beginTransaction();

            // Delete the comment from the actual comments table
            $deleteFromComments = "DELETE FROM comments WHERE comment_id = :comment_id";
            $stmt = $this->db->prepare($deleteFromComments);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->execute();

            // Remove the link between the ticket and comment by deleting from the junction table
            $deleteTicketCommentLink = "DELETE FROM ticket_comments WHERE comment_id = :comment_id";
            $stmt = $this->db->prepare($deleteTicketCommentLink);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->execute();

            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('['.date("d/m/y H:i:s").'] '."Failed to delete user comment for this ticket: " . $e->getMessage() . "\n", 3, "errors.log");
        }
    }

    /****************************************
     *  ITS COMMENT FUNCTIONS
     ****************************************/

    function addITSComment($ticketId, $commentText)
    {
        
    }

    function getAllITSCommentsForTicket($ticketID)
    {

    }

    function updateITSComment($ticketId, $commentId, $commentText)
    {

    }

    function deleteITSComment($ticketId, $commentId)
    {

    }
}