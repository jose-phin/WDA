# WDA

Meet the team:
- Jacqui

####HTACCESS
Please modify the `.htacces` depending on your file location. If your file is **not** the in the **root directory** of the server.

e.g My file is located in a WDA sub directory, so my .htaccess looks like 

```
RewriteRule ^user(.*)$ /WDA/API/endpoints/user.php?endpoint=$1 [NC,QSA]
RewriteRule ^comment(.*)$ /WDA/API/endpoints/comment.php?endpoint=$1 [NC,QSA]
RewriteRule ^ticket(.*)$ /WDA/API/endpoints/ticket.php?endpoint=$1 [NC,QSA,L]
```