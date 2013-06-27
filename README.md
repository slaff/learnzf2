Learn ZF2
=======================
"Learn ZF2" (http://learnzf2.com) is a book dedicated to help you learn fast and easy Zend Framework 2.

Source Code
------------
The book is accompanied by source code from which you can learn by example.
The source is based on the ZendSkeletonApplication version 2.1.0.
You can get the latest version of the source code from its github repository:
https://github.com/slaff/learnzf2

The book has two edition and this repository contains the source code for the second edition.
If you are looking for the source code of the first edition of the book take a look
at that repository: https://github.com/slaff/learnzf2-v1

Zend Framework Book
-------------------
For more information about the book and purchase options visit its official web site:
http://learnzf2.com

Development Box
---------------
If you do not feel comfortable with setting up the application and its environment then 
as a quick start you can use our [LearnZF2 dev box](https://github.com/slaff/learnzf2-box) which is using Vagrant and VirtualBox.
If you want to experiment with Zend Framework 2 and the upcoming PHP7 you can also use the LearnZF2 VM as described [here](https://github.com/slaff/learnzf2-box#php7).

Application
-----------
[![Build Status](https://travis-ci.org/slaff/learnzf2.svg?branch=master)](https://travis-ci.org/slaff/learnzf2)
The final version of the source code comes with ready to test Zend Framework 2 web
application with prefilled SQLite database.

The steps below are needed if you don't use the LearnZF2 dev box. 
But we would strongly encourage you to take a look at these steps and understand their meaning.

### Preparation ###

In order to get the dependant packages, like Zend Framework 2 for example, we have to 
run the following commands once in the beginning.  

```
cd learnzf2/
./composer.phar self-update
./composer.phar install
```

### Run from PHP built-in server
The easiest way to run the code, if you have PHP 5.4 or newer is to type:
```
cd learnzf2/
php -S 127.0.0.1:8080 -t public/
```

And then open in your browser the following URL: http://127.0.0.1:8080/

### Run from separate web server
In order to use the application with via separate web server(Apache, NGINX, etc) make sure that:

The data/db/tc.sqlite file is readable from the web server user.
The following commands can help you set the group to www-data and adjust the permissions.
```
chgrp www-data -R data/db
chmod g+rx data/db
chmod g+w data/db/tc.sqlite
```

### Application Users
There are two users that you can use.

1. Admin user with email: admin@learnzf2.com and password admin123
2. Member user with email: member@learnzf2.com and password member123.

If you want to take some of the sample exams that come with this application then
you have to login and go to Exam -> List and choose one from the list.

