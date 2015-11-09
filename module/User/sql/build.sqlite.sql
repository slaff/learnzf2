DROP TABLE IF EXISTS "users";
CREATE TABLE "users" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "email" varchar(255) NOT NULL,
  "password" varchar(80) NOT NULL,
  "name" varchar(255) NOT NULL,
  "phone" varchar(255) DEFAULT NULL,
  "photo" varchar(255) DEFAULT NULL,
  "role" varchar(50) DEFAULT NULL,
  "cdate" datetime DEFAULT NULL,
  "mdate" datetime DEFAULT NULL
);