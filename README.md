# Maximized Living Public Website

# Setup
Run 
```
npm install
```
```
composer install
```

Compiling / Watching
--------------------
Run 
```
npm run dev
```

# Login to WordPress

Run the following SQL Command in PHPMyAdmin or Sequel Pro. (Be sure to edit your password)
```
UPDATE `mlpw_users` SET `user_pass`= MD5('yourpassword') WHERE `user_login`='arcane-admin';
```
Visit /wp-admin   
Username: arcane-admin   
Password: yourpassword   
Email: dev@arcane.ws

# ACF
Updating ACF may require core plugin files to be edited.

See: https://github.com/ArcaneDigital/maximized-living-public-website/wiki/REQUIRED-ACF-CORE-CHANGES

