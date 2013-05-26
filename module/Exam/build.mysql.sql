DROP TABLE IF EXISTS tests;
CREATE TABLE tests (
	id integer(11) auto_increment primary key,
	name  varchar(255) NOT NULL,
	`locale` char(5) DEFAULT 'en_US',
	description TINYTEXT, 
	duration smallint DEFAULT 60, -- the duration of the test in minutes
	creator integer(11),  
	active boolean,
	definition text, -- serialized definition of the questions and answers in the test
	cdate TIMESTAMP DEFAULT 0, -- created date
	mdate TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP, -- modified date
	unique key(name,locale)
);