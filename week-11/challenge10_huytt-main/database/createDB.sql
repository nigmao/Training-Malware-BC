CREATE TABLE Users (
  user_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  full_name varchar(50) NOT NULL,
  username varchar(50) unique,
  password varchar(50) NOT NULL,
  email varchar(150) NOT NULL,
  phone_number varchar(20) NOT NULL,
  role_id int(11) NOT NULL 
);

CREATE TABLE Assignment (
  assign_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  description longtext,
  path varchar(500) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE submission (
    submission_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    assign_id int(11) NOT NULL,
    student_id int(11) NOT NULL,
    title varchar(255) NOT NULL,
    path varchar(500) NOT NULL,
    description longtext,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messenger(
  messenger_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  from_id int(11) NOT NULL,
  to_id int(11) NOT NULL,
  content varchar(500) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE challenges(
  challenges_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  path varchar(500) NOT NULL,
  hint varchar(500) NOT NULL
);
-- DROP TABLE challenges;
---------------------------------------------------------------------

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'TranTrongHuy', 'student1', 'passwd1', 'test1@gmail.com', '0971535450', '1');
INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'DaoXuanManh', 'student2', 'passwd2', 'test2@gmail.com', '0922222222', '1');
INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenNgocManh', 'student3', 'passwd3', 'test3@gmail.com', '0933333333', '1');
INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenVanHung', 'teacher1', 'passwd01', 'test01@gmail.com', '0901010101', '2');
INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NgoThanhVan', 'teacher2', 'passwd02', 'test02@gmail.com', '0902020202', '2');

-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenHaiAnh', 'student1', '123456a@A', 'test1@gmail.com', '0901010101', '1');
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenDinhHai', 'student2', '123456a@A', 'test2@gmail.com', '0902020202', '1');
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenVanHung', 'teacher1', '123456a@A', 'test3@gmail.com', '0901010101', '2');
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NgoThanhVan', 'teacher2', '123456a@A', 'test4@gmail.com', '0902020202', '2');

-- DELETE FROM `users` WHERE `users`.`user_id` = 6

-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'TranTrongHuy', 'student1', 'passwd1', 'test1@gmail.com', '0971535450', '1')
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'DaoXuanManh', 'student2', 'passwd2', 'test2@gmail.com', '0922222222', '2')
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenNgocManh', 'student3', 'passwd3', 'test3@gmail.com', '0933333333', '3')
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NguyenVanHung', 'teacher1', 'passwd01', 'test01@gmail.com', '0901010101', '4')
-- INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `email`, `phone_number`, `role_id`) VALUES (NULL, 'NgoThanhVan', 'teacher2', 'passwd02', 'test02@gmail.com', '0902020202', '5')

-- ALTER TABLE users
-- DROP COLUMN full_name;

