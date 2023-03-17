# Simple Seminar Website

A simple website designed for an academic seminar, to be hosted on a typical academic webserver running Apache and PHP. Previously used to host the [Imperial Junior Geometry Seminar](https://www.ma.imperial.ac.uk/~jbm18/ijg/) in 2021/22.

Uses .htaccess to control access to a simple admin page which allows talks to be added, edited, or deleted. Password stored outside of public root in .htpasswd (default username/password is admin/admin). 

Talks are added by addtalk.php (file permissions 774)

Talks are stored in talks.xml (file permissions 777)