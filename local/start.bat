REM Scripts to end programs after development, e.g. stop server, mysql, etc.

REM Install MariaDB from its ZIP file
REM bin/mysql_install_db.exe --datadir=c:\mydatabase --service=MyDB --password=root_password

cd X:\Programs\nginx\nginx-1.18.0
start-php-fcgi.bat
start nginx
cd X:\Projects\HandwerkerFullstack\local