1.) 
Don't name your methods exactly like the controller! This will result in a broken application.
Reason is that methods that have the same name as their classes are an (outdated) PHP4-equivalent (!) to "__construct"
which has not been removed in PHP5 yet.
http://stackoverflow.com/questions/6872915/whats-difference-between-construct-and-function-with-same-name-as-class-has

2.) There are two different URL variables [currently constants] available:
FULL_URL will give you the full URL with index.php in the end, like
http://www.domain.tld/subfolder/index.php
URL will give you the URL without index.php in the end, like
http://www.domain.tld/subfolder/

Use FULL_URL when you create navigateable links, use URL when you want to create a path to CSS, images or JavaScript 
files (as it wouldn't be useful to have index.php in the URL when creating a path to a .css).

4.) 
sudo a2enmod rewrite
sudo service apache2 restart

5.) If your .htaccess (to block folder access) doesn't work, make sure you DONT have "AllowOverride None" in your
Apache config (/etc/apache2/sites-available/default)
sudo nano /etc/apache2/sites-available/default
sudo service apache2 restart

https://www.digitalocean.com/community/tutorials/how-to-use-the-htaccess-file


TODO: wie sieht der AllowOverride-Standard in 14.04 LTS aus ?



--> index.html aus /var/www/html

http://httpd.apache.org/docs/current/howto/htaccess.html