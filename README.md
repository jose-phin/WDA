# WDA

Meet the team:
- Jacqui

####Running it in your environment (Quick Fix)
In the following file's require statements need to be modified depending on your directory layout
- `.htacces` 
- `API/classes/*.php`
- `API/endpoints/*.php`

e.g My file is located in a WDA sub directory of the server, so my .htaccess looks like 
In the my `.htaccess`
```
RewriteRule ^user(.*)$ /WDA/API/endpoints/user.php?endpoint=$1 [NC,QSA]
RewriteRule ^comment(.*)$ /WDA/API/endpoints/comment.php?endpoint=$1 [NC,QSA]
RewriteRule ^ticket(.*)$ /WDA/API/endpoints/ticket.php?endpoint=$1 [NC,QSA,L]
```

Any require statements also need to be modifiled
e.g, In my `API/classes/AbstractApi.php`

```
<?php
    require($_SERVER['DOCUMENT_ROOT'].'/WDA/db/DatabaseHandler.php');
```

If you're unsure about your directory, insert
` echo $_SERVER['DOCUMENT_ROOT']`
 in your php code to find the directory and preppend the required folder names

This is a quick fix. A better solution will be implemented soon.
