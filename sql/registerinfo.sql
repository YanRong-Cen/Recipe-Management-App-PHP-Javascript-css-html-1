CREATE DATABASE IF NOT EXISTS user_management;
GRANT USAGE ON *.* TO user_management@localhost IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON user_management.* TO user_management@localhost;
FLUSH PRIVILEGES;




-- 切换到数据库
USE user_management;

-- 创建用户表
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    promotion TINYINT(1) DEFAULT 0,
    terms TINYINT(1) DEFAULT 0
);


