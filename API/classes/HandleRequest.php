<?php
  require($_SERVER['DOCUMENT_ROOT'] . '\API\classes\AbstractApi.php');

  class HandleRequest extends AbstractApi{

    /**
     * @property array - The parsed JSON request
     */
    private $jsonRequest = null;

    public function __construct() {
      parent::__construct();
      $this->jsonRequest = json_decode(file_get_contents('php://input'), TRUE);
    }

    public function __destruct() {
      parent::__destruct();
    }

    /**
     * Create a new ticket for the user
     *
     * @return bool
     */
    public function createNewTicket() {

      //grab the user and the ticket data from the JSON
      $user = $this->jsonRequest["user"];
      $ticket = $this->jsonRequest["ticket"];

      //if the user or the ticket data is not set, return false
      if( !isset($user) || !isset($ticket) ) return false;

      //check to see if the user is already in the databaseName
      $userId = parent::getUserIdByEmail($user['email']);
      if(!isset($userId)) {
        //if the user does not exist, create the user
        $couldCreateUser = parent::createUser($user["firstName"], $user["lastName"], $user["email"]);

        //if we could not create the user, return false
        if(!$couldCreateUser) return false;

        //grab the userID
        $userId = parent::getUserIdByEmail($user['email']);

        //if we still cannot get the user ID, return false
        if(!isset($userId)) return false;
      }

      //create the ticket
      $couldCreateTicket = parent::createTicket($userId, $ticket['osType'], $ticket['primaryIssue'], $ticket['additionalNotes']);

      return $couldCreateTicket;
    }
  }
?>
