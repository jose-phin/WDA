<?php
  require($_SERVER['DOCUMENT_ROOT'].'/WDA/db/DatabaseHandler.php');
  /**
   * Class that handles the interaction between the API and the Database, Abstracted so that
   * the Concrete class has no idea how the Database works
   */
  abstract class AbstractApi {

    /**
     * @property The Database Object
     */
    private $db = null;

    public function __construct() {
      $this->db = new DatabaseHandler("TestDatabase");
    }

    public function __destruct() {
      if (isset($this->db)) $this->db->__destruct();
    }


    /**
     * Create a non-staff user and add them to the databaseName
     *
     * @param $firstName string - The user's first name
     * @param $lastName string - The user's last name
     * @param $email string - The user's email name
     *
     * @return bool - true is user was created, false if user was not created
     */
    public function createUserDB($firstName, $lastName, $email) {

      $result = $this->db->createUser(
        $firstName,
        $lastName,
        $email,
        FALSE
      );
      return $result;
    }

    /**
     * Get a userID by supplying the user's email from the current database instance
     *
     * @param $email string - the users email address
     * @return int|null - Will return the User's ID, else will return null if user does not exist
     */
    public function getUserIdByEmail($email) {

      $user = $this->db->getUserByEmail($email);
      return isset($user)
        ? $user['user_id']
        : null;
    }

    /**
     * Create a new ticket for the user into the database
     *
     * @param $userId int - the user's ID
     * @param $osType string - the Operating System the user is on
     * @param $primayIssue string- The issue the user is having with the IT Systeem
     * @param $additionalNotes - additional notes for the ticket
     *
     * @return bool
     */
    public function createTicket($userId, $osType, $primaryIssue, $additionalNotes) {

      $result = $this->db->createTicket(
          $osType,
          $primaryIssue,
          $additionalNotes,
          "pending",
          $userId
        );

        return $result;
    }

    /**
     * Create a new ticket for the user into the database
     *
     * @param $ticketId int
     * @param $comment string
     * @param $userId int
     *
     * @return ticketId
     */
    public function createComment( $ticketId, $comment, $userId) {
      $result = $this->db->addComment($ticketId, $comment, $userId);
      return $result;
    }

    /**
     * Create a new ticket for the user into the database
     *
     * @param $ticketId int
     * @return array of comments
     */
    public function getCommentsFromTicket($ticketId) {
      $result = $this->db->getAllCommentsForTicket($ticketId);
      return $result;
    }

    public function getTicketInfo($ticketId) {
      $result = $this->db->getTicket($ticketId);
      return $result;
    }

    public function closeTicketDB($ticketId){

      $ticket = $this->db->getTicket($ticketId);
      if($ticket === null) {
        return false;
      }
      $result = $this->db->updateTicket($ticketId, $ticket["os_type"], $ticket["primary_issue"],$ticket["additional_notes"], "Resolved",$ticket["submitter_id"]);

      return $result;
    }

    public function getAllTickets() {
      $result = $this->db->getTicket();
      return $result;
    }

    public function getTicketHandler() {
      return $this->ticketHandler;
    }

    public function getUserHandler() {
      return $this->userHandler;
    }
  }
?>
