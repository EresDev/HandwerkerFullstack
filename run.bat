REM Scripts to start programs before development, e.g. start server, mysql, etc.

TASKKILL /F /IM "nginx*"
X:\Programs\mariadb\mariadb-10.4.12-winx64\bin\mysqladmin -u root shutdown


start X:\Programs\mariadb\mariadb-10.4.12-winx64\bin\mysqld --defaults-file=X:\Programs\mariadb\mariadb-10.4.12-winx64\data\my.ini
REM mysql -u root
cd X:\Programs\nginx\nginx-1.18.0
start nginx
cd X:\Projects\HandwerkerFullstack
X:\Programs\nginx\nginx-1.18.0\start-php-fcgi.bat
cd X:\Projects\HandwerkerFullstack



