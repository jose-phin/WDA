#API
This API will allow you to interact with the database VIA AJAX calls,
this API is designed to be used with JSON POST requests and uses RESTful API
URL names

## Contents
How to use
Endpoints
ticket
* new
* close
comment
* new
* viewall
user
* new

## How to use the API
In order to send an AJAX call to this API, an example of sending an Jquery AJAX
call would be
```
$.ajax({
  type: "POST",
  url: "/WDA/ticket/new",
  contentType: 'application/json',
  data: JSON.stringify({
    "user": {
      "email": "Email Here"
    },
    "ticket": {
      "osType": "OS Type here"
      "primaryIssue": "Write about issue here",
      "additionalNotes": "Additional Notes Here"
    }
  }),
  //callback function
});
```

## Endpoints
These are the following RESTful endpoints that you can access with POST requests
### Ticket
#### New
#### Close
### Comment
#### New
#### View All
### User
#### New
