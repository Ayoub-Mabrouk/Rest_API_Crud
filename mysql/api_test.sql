CREATE TABLE addresses(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
location VARCHAR(20)
);
CREATE TABLE users(
    id INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10),
    address INT UNSIGNED,
    FOREIGN KEY(address) REFERENCES addresses(id)
);
insert into addresses values (1,"Shimaohori,Yamagata,Japan"),(2,"Nabasama,Chiba,Japan"),(3,"khitanosa,berboka,tayara");
insert into users VALUES (1,"Amato",2),(2,"kimaru",1),(3,"khringo",3)