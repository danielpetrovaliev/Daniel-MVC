<?php
$cnf['default_controller'] = 'Home';
$cnf['default_method'] = 'index';
$cnf['namespaces']['Controllers'] = 'C:\xampp\htdocs\Php-projects\Daniel-MVC\Blog-System\controllers';
$cnf['namespaces']['Views'] = 'C:\xampp\htdocs\Php-projects\Daniel-MVC\Blog-System\views';
$cnf['namespaces']['Models'] = 'C:\xampp\htdocs\Php-projects\Daniel-MVC\Blog-System\models';

$cnf['viewsDirectory'] = 'C:\xampp\htdocs\Php-projects\Daniel-MVC\Blog-System\views';

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'native';
$cnf['session']['name'] = '__sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;
$cnf['session']['dbConnection'] = 'default';
$cnf['session']['dbTable'] = 'sessions';
return $cnf;
