<?php

use Hosomikai\Ezship\Contracts\EzshipOrder;

return [
    'app_id' => env('EZSHIP_APP_ID'),

    /**
     * 建立物流訂單api url.
     */
    'post_order_api' => env('EZSHIP_POST_ORDER_API', 'https://www.ezship.com.tw/emap/ezship_request_order_api_ex.jsp'),

    /**
     * 物流訂單查詢 api.
     */
    'query_order_api' => env('EZSHIP_QUERY_ORDER_API', 'https://www.ezship.com.tw/emap/ezship_request_order_status_api.jsp'),

    /**
     * 建立訂單成功後回傳URL.
     */
    'return_url' => env('EZSHIP_RETURN_URL'),

    'map' => [
        'url' => env('EZSHIP_MAP_URL', 'https://map.ezship.com.tw/ezship_map_web.jsp'),                     //選擇超商電子地圖基礎網址
        'return_url' => env('EZSHIP_MAP_RETURN_URL'),                                                       //超商選擇完畢之後導回接收網址
    ],

    /**
     * 建立新訂單狀態類型.
     */
    'order_status' => [
        'store' => env('EZSHIP_NEW_ORDER_STATUS_STORE', EzshipOrder::STORE_NEW_TYPE2),                      //超取新訂單狀態類型
        'home_delivery' => env('EZSHIP_NEW_ORDER_STATUS_HOME_DELIVERY', EzshipOrder::HOME_DELIVERY_TYPE2),  //宅配新訂單狀態類型
    ],
];
