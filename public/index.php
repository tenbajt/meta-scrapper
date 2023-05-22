<?php

use App\Session;
use App\Controller;
use App\Scrapper;
use App\Logger;

date_default_timezone_set('Europe/Warsaw');

/**
 * Require composer autoloader.
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Require helper methods.
 */
require_once __DIR__.'/../app/helpers.php';

/**
 * Initialize session.
 */
$session = new Session();

/**
 * Simple router.
 */
switch ($_SERVER['REQUEST_URI']) {
    case '/':
        Controller::index($session, new Logger());
        break;
    case '/download':
        Controller::download($session, new Scrapper(), new Logger());
        break;
    case '/clear':
        Controller::clear($session);
        break;
    default:
        echo "Page not found";
        break;
}
