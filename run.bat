REM Scripts to start programs before development, e.g. start server, mysql, etc.

TASKKILL /F /IM "nginx*"

cd X:\Programs\nginx\nginx-1.18.0
start nginx
cd X:\Projects\HandwerkerFullstack
X:\Programs\nginx\nginx-1.18.0\start-php-fcgi.bat



