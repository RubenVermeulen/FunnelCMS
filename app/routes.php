<?php

$app->group('/funnelcms', function() use($app, $guest, $admin, $authenticated) {

    require INC_ROOT . '/app/routes/home.php';

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
    require INC_ROOT . '/app/routes/user/search.php';

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
    require INC_ROOT . '/app/routes/article/search.php';

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
    require INC_ROOT . '/app/routes/newsletter/search.php';

    require INC_ROOT . '/app/routes/newsletter/mailinglist/all.php';
    require INC_ROOT . '/app/routes/newsletter/mailinglist/create.php';
    require INC_ROOT . '/app/routes/newsletter/mailinglist/edit.php';
    require INC_ROOT . '/app/routes/newsletter/mailinglist/delete.php';
    require INC_ROOT . '/app/routes/newsletter/mailinglist/search.php';

    require INC_ROOT . '/app/routes/newsletter/show.php';

    /*
    |--------------------------------------------------------------------------
    | File
    |--------------------------------------------------------------------------
    |
    | All routes concerning files.
    |
    */

    require INC_ROOT . '/app/routes/file/all.php';
    require INC_ROOT . '/app/routes/file/create.php';
    require INC_ROOT . '/app/routes/file/edit.php';
    require INC_ROOT . '/app/routes/file/delete.php';
    require INC_ROOT . '/app/routes/file/search.php';

    /*
    |--------------------------------------------------------------------------
    | Page
    |--------------------------------------------------------------------------
    |
    | All routes concerning pages.
    |
    */

    require INC_ROOT . '/app/routes/page/all.php';
    require INC_ROOT . '/app/routes/page/create.php';
    require INC_ROOT . '/app/routes/page/edit.php';
    require INC_ROOT . '/app/routes/page/delete.php';
    require INC_ROOT . '/app/routes/page/search.php';
    require INC_ROOT . '/app/routes/page/order.php';

});