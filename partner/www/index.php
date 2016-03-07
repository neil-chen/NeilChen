<?php

header('Content-Type:text/html;charset=UTF-8');
include dirname(__FILE__) . '/../Lib/Init.php';
C('APP_GROUP', 'Index');
SuiShiPHP::run();
