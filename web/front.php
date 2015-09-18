<?php //-->
require ROOT_DIR.'vendor'.DS.'autoload.php';
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
require ROOT_DIR.'front.php';

/* Get Application
-------------------------------*/
print front()

/* Set Debug
-------------------------------*/
->setDebug(E_ALL, true)

/* Set Autoload
-------------------------------*/
->setLoader(NULL, '/module')

/* Set Paths
-------------------------------*/
->setPaths()
->routeClasses(true)
->routeMethods(true)

/* Start Filters
-------------------------------*/
->setFilters()

/* Trigger Init Event
-------------------------------*/
->trigger('init')

/* Set Database
-------------------------------*/
->setDatabases()

/* Set Timezone
-------------------------------*/
->setTimezone('Asia/Manila')

/* Trigger Init Event
-------------------------------*/
->trigger('config')

/* Start Session
-------------------------------*/
->startSession()

/* Trigger Session Event
-------------------------------*/
->trigger('session')

/* Set Request
-------------------------------*/
->setRequest()

/* Trigger Request Event
-------------------------------*/
->trigger('request')

/* Set Response
-------------------------------*/
->setResponse('Front_Page_Index')

/* Trigger Response Event
-------------------------------*/
->trigger('response');