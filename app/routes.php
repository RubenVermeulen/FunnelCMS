<?php
require INC_ROOT . '/app/routes/home.php';
require INC_ROOT . '/app/routes/test.php';

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
|
| All routes concerning authentication.
|
*/

require INC_ROOT . '/app/routes/auth/login.php';
require INC_ROOT . '/app/routes/auth/logout.php';

require INC_ROOT . '/app/routes/auth/password/change.php';
require INC_ROOT . '/app/routes/auth/password/recover.php';
require INC_ROOT . '/app/routes/auth/password/reset.php';

/*
|--------------------------------------------------------------------------
| Account
|--------------------------------------------------------------------------
|
| All routes concerning the user account.
|
*/

require INC_ROOT . '/app/routes/account/profile.php';

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
| All routes concerning users, profiles, etc.
|
*/

require INC_ROOT . '/app/routes/user/all.php';
require INC_ROOT . '/app/routes/user/create.php';
require INC_ROOT . '/app/routes/user/activate.php';
require INC_ROOT . '/app/routes/user/edit.php';
require INC_ROOT . '/app/routes/user/delete.php';

/*
|--------------------------------------------------------------------------
| Errors
|--------------------------------------------------------------------------
|
| Route concerning custom 404.
|
*/

require INC_ROOT . '/app/routes/errors/404.php';

/*
|--------------------------------------------------------------------------
| Article
|--------------------------------------------------------------------------
|
| All routes concerning articles.
|
*/

require INC_ROOT . '/app/routes/article/all.php';
require INC_ROOT . '/app/routes/article/create.php';
require INC_ROOT . '/app/routes/article/edit.php';
require INC_ROOT . '/app/routes/article/delete.php';

/*
|--------------------------------------------------------------------------
| Newsletter
|--------------------------------------------------------------------------
|
| All routes concerning newsletters.
|
*/

require INC_ROOT . '/app/routes/newsletter/all.php';
require INC_ROOT . '/app/routes/newsletter/create.php';
require INC_ROOT . '/app/routes/newsletter/edit.php';
require INC_ROOT . '/app/routes/newsletter/delete.php';
require INC_ROOT . '/app/routes/newsletter/mailinglist/all.php';
require INC_ROOT . '/app/routes/newsletter/mailinglist/create.php';
require INC_ROOT . '/app/routes/newsletter/show.php';