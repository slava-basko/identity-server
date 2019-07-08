Identity Server
===============

Server for domains entity, permissions, roles management and user identification.

How to start
------------
1. Clone
2. Run ```composer install```
3. php -S localhost:8090 public/index.php
4. Start integrating IS with you own system (SDK: https://github.com/slava-basko/identity-server-sdk)

Test
----
Open ```IS.jmx``` in jmeter and run.

Dev
---
Last error: -32017

Service requires 
ctype
iconv

Configs
.env 
replace: mysql_user, mysql_pass, mysql_host, mysql_port credentials in DATABASE_URL (DATABASE_URL=mysql://mysql_user:mysql_pass@mysql_host:mysql_port/is)