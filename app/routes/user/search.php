<?php

$app->get('/users/search', $authenticated(), function() use($app) {

    $keyword = $app->request->get('keyword');

    if (empty($keyword) || strlen($keyword) == 0)
        $app->redirect($app->urlFor('user.all'));

    $users = $app->user
        ->where('id', '!=', $app->auth->id)
        ->where(function($query) use ($keyword) {
            return $query->where('email', 'LIKE', "%{$keyword}%")
                ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                ->orWhere('last_name', 'LIKE', "%{$keyword}%");
        })
        ->orderBy('email')
        ->get();

    $app->render('user/all.twig', [
        'users' => $users,
        'searchCount' => count($users),
        'keyword' => $keyword,
    ]);

})->name('user.search');