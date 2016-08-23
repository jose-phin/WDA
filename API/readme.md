#API
This API will allow you to interact with the database VIA AJAX calls,
this API is designed to be used with JSON POST requests and uses RESTful API
URL names

## Contents
* [How to use](https://github.com/chloe747/WDA/tree/feature/REST-API/API#how-to-use-the-api)
* [Endpoints](https://github.com/chloe747/WDA/tree/feature/REST-API/API#endpoints)
* [Ticket](https://github.com/chloe747/WDA/tree/feature/REST-API/API#ticket)
  * [new](https://github.com/chloe747/WDA/tree/feature/REST-API/API#new)
  * [close](https://github.com/chloe747/WDA/tree/feature/REST-API/API#close)
* [Comment](https://github.com/chloe747/WDA/tree/feature/REST-API/API#comment)
  * [new](https://github.com/chloe747/WDA/tree/feature/REST-API/API#new-1)
  * [viewall](https://github.com/chloe747/WDA/tree/feature/REST-API/API#view-all)
* [User](https://github.com/chloe747/WDA/tree/feature/REST-API/API#user)
  * [new](https://github.com/chloe747/WDA/tree/feature/REST-API/API#new-2)

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
