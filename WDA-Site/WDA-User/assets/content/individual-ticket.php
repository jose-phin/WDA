<!--This php contains the actual ticket content such as name,
    message, etc -->

<div class="panel-group">

  <div class="panel panel-default">

      <div class="panel-body">
        <div class="row individual-ticket-info-row">
          <p class="col-md-12 ticket-info-header-text">
            Full Name
          </p>
          <p class="col-md-12 user-ticket-fullName">
            First Last Name
          </p>
          <!-- End of info row 1 -->
        </div>

        <div class="row individual-ticket-info-row">
          <!-- Category -->
          <div class="col-md-4">
            <p class="ticket-info-header-text">
              Category
            </p>
            <p class="user-ticket-issueCategory">
              {{Issue Category}}
            </p>
          </div>

          <!-- OS -->
          <div class="col-md-4">
            <p class="ticket-info-header-text">
              OS
            </p>
            <p class="user-ticket-osType">
              {{Operating System}}
            </p>
          </div>

          <!-- End of info row 2 -->
        </div>


        <div class="row individual-ticket-info-row">
          <p class="col-md-12 ticket-info-header-text">
            Date
          </p>
          <p class="col-md-12">
            {{DD/MM/YYYY}}
          </p>
          <!-- End of info row 3 -->
        </div>


        <!-- Message -->
        <div class="row individual-ticket-info-row">
          <p class="col-md-12 ticket-info-header-text">
            Message
          </p>
          <p class="col-md-12 user-ticket-originalMessage">
            {{Original ticket message by user}}
          </p>
          <!-- End of info row 4 -->
        </div>
      <!-- End of ticket info  -->
      </div>

      <!-- Add comment -->
      <form id="add-comment-form" name="addCommentForm" method="post" action="" autocomplete="off" novalidate="novalidate">
        <div class="panel-footer panel-comment">

          <p class="ticket-info-header-text">
            Reply
          </p>
          <textarea class="form-control" id="new-message" name="new-message" rows="5" placeholder="Provide more details here..."></textarea>
          <button type="submit" class="btn btn-primary add-reply-button">Add Reply</button>
        </div>
      </form>

  </div>
</div>
