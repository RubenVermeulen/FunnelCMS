<?php

$app->post('/pages/order', $authenticated, function() use($app) {

    $request = $app->request;

    $orderList = json_decode($request->post('orderList'));

    $result = [
        'success' => false
    ];

    if (count($orderList) > 0) {
        for ($i = 0; $i < count($orderList); $i++) {
            $app->page->where('id', $orderList[$i])->update(['priority' => $i]);
        }

        $result['success'] = true;
    }

    echo json_encode($result);

})->name('page.order');