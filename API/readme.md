#API
This API will allow you to interact with the database VIA AJAX calls,
this API is designed to be used with JSON POST requests and uses RESTful API
URL names
## How to use the API
In order to send an AJAX call to this API, an example of sending an Jquery AJAX
call would be
```
//NOTE: HAVENT TESTED IF THIS EXACT SYNTAX WORKS FROM A PHP FILE, ONLY IN POSTMAN!!!!!

$.post("user/new", {
  "user": {
    "firstName": "John",
    "lastName": "Doe",
    "email": "XxSephiroth477xX@hotmail.com"
  }
});
```

##Endpoints
###User
This endpoint deals with setting and getting user information
####new
```
localhost/user/new
```
This endpoint will attempt to create a new user with the given params

```
{
  "user": {
    "firstName": "User's First Name",
    "lastName": "User's Last Name",
    "email": "The user's email address"    
  }
}
```

and will return a response object

```
//if the user was created successfully
{"success": true}

//else, if the user was not created
{"success": false}
```

###ticket
####new
```
localhost/ticket/new
```
This endpoint will attempt to create a new ticket for the specified user with
 the given params, if the user does not exist, this endpoint call will attempt
 to create the user

```
{
  "user": {
    "firstName": "User's First Name (NOT NEEDED IF USER EXISTS)",
    "lastName": "User's Last Name (NOT NEEDED IF USER EXISTS)",
    "email": "The user's email address"    
  },
  "ticket": {
    "osType": "The users Operating System",
    "primaryIssue": "the issue the user is having",
    "additionalNotes": "Any additional notes for the user's issue"
  }
}
```

and will return a response object

```
//if the ticket was created successfully
{"success": true}

//else, if the ticket was not created
{"success": false}
```
