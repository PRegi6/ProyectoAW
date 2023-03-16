CREATE USER 'beathouse'@'%' IDENTIFIED BY 'beathouse';
GRANT ALL PRIVILEGES ON `beat_house`.* TO 'beathouse'@'%';

CREATE USER 'beathouse'@'localhost' IDENTIFIED BY 'beathouse';
GRANT ALL PRIVILEGES ON `beat_house`.* TO 'beathouse'@'localhost';