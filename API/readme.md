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
```javascript
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
This endpoint is the main ticket creation and closing endpoint
#### New
* **URL**
```
<website>/ticket/new
```

* **Description**
This endpoint will create a new ticket for the specified user, and if the user
does not exist in the database, should you provide a first name and a last
name, the endpoint will also create the user, then create the ticket

* **Parameters**
  **Required**
  ```javascript
{
  "user": [Object] {
    "email": [String]
  },
  "ticket": [Object] {
    "osType": [String],
    "primaryIssue": [String]
  }
}
  ```

  **Optional**
  ```javascript
{
  "user": [Object] {
    "firstName": [String],
    "lastName": [String]
  },
  "ticket": [Object] {
    "additionalNotes": [String]
  }
}
  ```

* **Success Response**
  *Content* `{"success": true, "ticketId": [String]}`

* **Error Response**
  *Content* `{"success": false}`

* **Sample Call**
```javascript
{
    "user":{
        "firstName":"John",
        "lastName":"Doe",
        "email":"poo@ko.com"
    },
    "ticket":{
        "osType": "Mac",
        "primaryIssue": "Lorem ipsum dolor sit amet."
    }
}
```
#### Close
### Comment
#### New
#### View All
### User
#### New
