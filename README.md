# Pluralsight-Registration-And-Login-Page-Using-PHP
It is a clone of Pluralsight login page. Here I used PHP to make a Registration form and also a Login form.
This is a proper sql injection free login form. To get rid of sql injection I used 'prepared statements'.
For login, a user have to create an account first. In the sign up form I used all the form validations,
so no one can insert wrong informations.

It is also connected to a mysql database. So when a user create an account, the information will be stored in the database.
For that login purpose those informations will be fetched from the database. Alos for security purpose I used hashing. 
I didn't use any md5 or sha1 functions,because they are outdated and not safe.
I used 'password_hash' function and 'PASSWORD_DEFAULT' as a parameter.
After login users can log out from the page.


     # Pluralsight-Registration-And-Login-Page-Using-PHP/Screen-Shot.PNG
      
