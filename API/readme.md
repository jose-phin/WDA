#API
## How to use API
To use this API with the built in php developer server, navigate a terminal to
this folder (The API folder of this PHP Project) and run the following command

```
php -S localhost:3001 ./route/router.php
```

this will setup a php dev server, next, you'll need to make a GET or POST
request to localhost:3001, If you are using Chrome, I'd highly recommend you use
this RESTful API tool called [POSTman](http://www.getpostman.com/)

Launch postman and make a GET or POST request to localhost:3001 with any url and
params that you want. You should get a responce echo'd back of the URL that you
sent the request to, and the contents of the request
(the params you sent through).

#Reference
[Guide to making an API in PHP](http://coreymaynard.com/blog/creating-a-restful-api-with-php/)
