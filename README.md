# Simple Seminar Website

A simple website designed for an academic seminar, to be hosted on a typical academic webserver running Apache and PHP. Previously used to host the Imperial Junior Geometry Seminar in 2021/22. An archived version of the website can be accessed at https://jmccarthy.au/ac/ijg/

Uses .htaccess to control access to a simple admin page which allows talks to be added, edited, or deleted. Password stored outside of public root in .htpasswd (default username/password is admin/admin). 

Talks are displayed paginated on the home page. Emails are displayed using email.php, which builds a graphical display of the email text (served to the page as ?email=base64) which is immune to web crawlers.
![image](https://user-images.githubusercontent.com/500991/226085027-95847e4f-c057-49b3-a4a8-db68bd264aa0.png)

Talks are added by addtalk.php (file permissions 774):
![image](https://user-images.githubusercontent.com/500991/226085042-89d09eb6-b2f1-4244-87c4-d85167f04504.png)

Talks are stored in talks.xml (file permissions 777)
