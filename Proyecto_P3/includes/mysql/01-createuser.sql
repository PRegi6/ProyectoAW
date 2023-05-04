CREATE USER 'beathouse'@'%' IDENTIFIED BY 'beathouse';
GRANT ALL PRIVILEGES ON `beatHouse`.* TO 'beathouse'@'%';

CREATE USER 'beathouse'@'localhost' IDENTIFIED BY 'beathouse';
GRANT ALL PRIVILEGES ON `beatHouse`.* TO 'beathouse'@'localhost';