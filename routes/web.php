<?php

use Hosomikai\Ezship\Controllers\EzshipController;

Route::match(['GET', 'POST'], 'ezship/order', [EzshipController::class, 'newOrder'])->name('ezship.order.create');  //建立物流訂單頁面
Route::post('ezship/map', [EzshipController::class, 'map'])->name('ezship.map');                                    //導向超商電子地圖
Route::post('ezship/order/send', [EzshipController::class, 'send'])->name('ezship.order.send');                     //送出物流訂單
Route::get('ezship', [EzshipController::class, 'handleReturn'])->name('ezship.order.return');                       //物流訂單結果回傳
Route::get('ezship/query', [EzshipController::class, 'queryOrder'])->name('ezship.query');                          //查詢訂單頁面
Route::post('ezship/query', [EzshipController::class, 'queryPost'])->name('ezship.query.send');                     //查詢訂單狀態
Route::get('ezship/query/result', [EzshipController::class, 'queryResult'])->name('ezship.query.result');           //查詢訂單結果
