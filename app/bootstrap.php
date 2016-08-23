<?php
use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;

use FunnelCms\Middleware\BeforeMiddleware;
use FunnelCms\Middleware\CsrfMiddleware;

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
|
| Set the default timezone.
|
*/

date_default_timezone_set('Europe/Brussels');

/*
|--------------------------------------------------------------------------
| Time language
|--------------------------------------------------------------------------
|
| Set the time language.
|
*/

setlocale(LC_TIME, 'nl_NL');

/*
|--------------------------------------------------------------------------
| Sessions
|--------------------------------------------------------------------------
|
| Start sessions.
|
*/

session_cache_limiter(false);
session_start();

/*
|--------------------------------------------------------------------------
| Error reporting
|--------------------------------------------------------------------------
|
| Show error reports or not.
|
*/

ini_set('display_errors', 'On');

/*
|--------------------------------------------------------------------------
| Root URL
|--------------------------------------------------------------------------
|
| Set up the root URL as a constant.
|
*/

define('INC_ROOT', dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Dependencies
|--------------------------------------------------------------------------
|
| Autoload the dependencies from the vendor folder.
|
*/

require INC_ROOT . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Slim instance
|--------------------------------------------------------------------------
|
| Create a new slim instance and define the current application mode.
| Pull in Twig and define the views path.
|
*/

$app = new Slim([
    'mode' => file_get_contents(INC_ROOT . '/mode.php'),
    'view' => new Twig(),
    'templates.path' => INC_ROOT . '/app/views'
]);

/*
|--------------------------------------------------------------------------
| Middlewares
|--------------------------------------------------------------------------
|
| Load all middelwares.
|
*/

$app->add(new BeforeMiddleware());
$app->add(new CsrfMiddleware());

/*
|--------------------------------------------------------------------------
| Load config
|--------------------------------------------------------------------------
|
| Load config into Slim.
|
*/

$app->configureMode($app->config('mode'), function() use ($app) {
    $app->config = Config::load(INC_ROOT . '/app/config/' . trim($app->mode) . '.php');
});


/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
|
| Constants who use config.
|
*/

define('SOURCE_UPLOADS', $app->config->get('app.uploadUrl'));
define('SOURCE_UPLOADS_THUMBS', $app->config->get('app.uploadUrl') . '/thumbs');

/*
|--------------------------------------------------------------------------
| Eloquent
|--------------------------------------------------------------------------
|
| Boot up Eloquent for further use.
| New models will be able to extend Eloquent.
|
*/

require 'database.php';

/*
|--------------------------------------------------------------------------
| Filters
|--------------------------------------------------------------------------
|
| Include all filters.
|
*/

require 'filters.php';

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| Include all routes.
|
*/

require 'routes.php';

/*
|--------------------------------------------------------------------------
| Authenticates user
|--------------------------------------------------------------------------
|
| Will hold the User instance of the logged in user.
| Callable throughout the application.
|
| Assigned by the BeforeMiddleware.
|
*/

$app->auth = false;

/*
|--------------------------------------------------------------------------
| Containers
|--------------------------------------------------------------------------
|
| Include all containers.
|
*/

require 'containers.php';

/*
|--------------------------------------------------------------------------
| Twig
|--------------------------------------------------------------------------
|
| Retrieve the view attribute which will be used to set up Twig.
|
*/

$view = $app->view();

/*
|--------------------------------------------------------------------------
| Twig debug mode
|--------------------------------------------------------------------------
|
| Set the debug mode for Twig.
|
*/

$view->parserOptions = [
    'debug' => $app->config->get('twig.debug')
];

/*
|--------------------------------------------------------------------------
| Twig Extension
|--------------------------------------------------------------------------
|
| Gives the ability to use helpers in the views.
|
*/

$view->parserExtensions = [
    new TwigExtension()
];
