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
            echo 'Unable to connect: ' . $e->getMessage() . '<br/>';
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
            echo 'Failed to create tables: ' . $e->getMessage() . '<br/>';
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
            echo 'Failed to insert user: ' . $e->getMessage();
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
            echo 'Failed to get user: ' . $e->getMessage();
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
            echo 'Failed to update user: ' . $e->getMessage();
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
            echo 'Failed to delete user: ' . $e->getMessage();
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
            echo 'Failed to insert ticket: ' . $e->getMessage();
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
            echo 'Failed to get ticket: ' . $e->getMessage();
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
            echo 'Failed to update ticket: ' . $e->getMessage();
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
            echo 'Failed to delete ticket: ' . $e->getMessage();
        }
    }

    /****************************************
     *  ITS FUNCTIONS
     ****************************************/

    /****************************************
     *  COMMENT FUNCTIONS
     ****************************************/
}