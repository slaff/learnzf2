This module provides user management and page protection based on access control lists.

Installation
------------
1. Create a database using the sql build file in the sql/ directory.
2. Copy the module config/database.local.php.dist file to the applicaiton/config/autoload/database.local.php
and edit the copied file to match your database setup.
3. Enable the module in the application config.

Events
-------
Id|Name|Params|Description
-------
user|register|user:user object|Triggered when a new user is created.
user|log-fail|username:string|Triggered when the login action fails with the provided username and password.
user|deny|match:route match object,user:user object,acl:acl object|Triggered when a user is denid access to a page.
------

Customization
-------
If you want to have user with different properties just create a new user entity with the needed properties and overwrite the
user-entity service to point to the new class.
