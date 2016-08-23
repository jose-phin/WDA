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
    "primaryIssue": [String],
    "additionalNotes": [String]
  }
}
```

  **Optional**
```javascript
{
  "user": [Object] {
    "firstName": [String],
    "lastName": [String]
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
        "primaryIssue": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fringilla malesuada nisi eget egestas. Aenean sollicitudin euismod tellus, ac bibendum sapien. Nam vestibulum vestibulum nunc sit amet sagittis. Cras nec posuere erat. Sed laoreet odio et turpis vestibulum, in venenatis dolor egestas. Vivamus dui libero, maximus tristique faucibus et, facilisis eget augue. Aliquam vitae dignissim orci. Pellentesque enim urna, vulputate ut arcu accumsan, mattis scelerisque nisl. Quisque dui ipsum, tempor eu dolor vel, finibus euismod dui. Quisque in elit maximus, congue velit ac, porttitor lacus. Aenean malesuada mollis lacus, cursus iaculis metus sodales a. Sed pulvinar sodales lectus. Proin in tempor tellus, at ornare massa. Donec at diam orci. Donec mattis tellus nibh, quis auctor urna porta sit amet. Nullam vel malesuada orci. Vestibulum dolor erat, imperdiet ac leo quis, interdum pellentesque leo. Donec cursus ornare quam quis semper. Donec posuere ullamcorper odio id condimentum. In sit amet sem vulputate, laoreet nisi ac, cursus enim.",
        "additionalNotes": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi viverra pharetra ex, eget imperdiet elit hendrerit sit amet. Mauris ut."
    }
}
```
#### Close
### Comment
#### New
#### View All
### User
#### New
