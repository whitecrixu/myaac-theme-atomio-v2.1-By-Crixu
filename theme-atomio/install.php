<?php

defined('MYAAC') or die('Direct access not allowed!');

use MyAAC\Plugins;

$template = 'atomio';

require 'templates/' . $template . '/config.php';
Plugins::installMenus($template, require 'templates/' . $template . '/menus.php');
