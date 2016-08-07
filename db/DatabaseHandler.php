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

    # User Functions
    function addUser($firstName, $lastName, $email)
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

    function updateUser($userId)
    {

    }

    function deleteUser($userId)
    {

    }

    # Ticket Functions


    # ITS Functions


    # Comment Functions
}