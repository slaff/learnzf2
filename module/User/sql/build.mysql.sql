DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id integer(11) auto_increment primary key,
	email varchar(255) NOT NULL unique,
	password varchar(80) NOT NULL,
	name varchar(255) NOT NULL,
	phone varchar(255),
	photo varchar(255),
	role varchar(50), -- we will store here the role of the user
	cdate datetime, -- created date
	mdate datetime -- modified date
);