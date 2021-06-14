<p align="center">
    <a href="https://www.ezship.com.tw/service_doc/service_home_w18v1.jsp?vDocNo=1702&vDefPage=04" target="_blank">
    <img src="https://www.ezship.com.tw/images/logo-ezship2.gif">
    </a>
</p>

# Laravel Ezship Api - 台灣便利配非官方套件
Made with ❤️ by [hosomikai](https://github.com/HosomiKai)

<hr>

## Requirement for laravel

## Installation
Before you include the package, ensure you are exactly a member of hosomikai and you have access right to access all about packages of php team.

Via Composer

### 1. Require the Package
After creating your new Laravel application and composer setting, you can include the package with the following command:

``` bash
$ composer require hosomikai/laravel-ezship
```
### 2. Publish

```bash
php artisan vendor:publish --provider="Hosomikai\Ezship\EzshipServiceProvider"
```
### 3. Add your `.env` :
```
EZSHIP_APP_ID={YOUR_EZSHIP_APP_ID}
EZSHIP_RETURN_URL=${APP_URL}/ezship
EZSHIP_MAP_REDIRECT_URL=${APP_URL}/ezship_map
```

如果你想載入demo範例 `config/app.php`
```
'providers' => [
    ...
    Hosomikai\Ezship\EzshipDemoServiceProvider::class,
]
```
設定完成後瀏覽 `http://localhost:8000/ezship/order`

## Usage


### 1. 設定回傳網址

`routes/web.php`

```
    Route::match(['GET', 'POST'], 'ezship', 'EzshipController@handle');
```
註：需將你的ezship網址註冊到 VerifyCsrfToken middleware 裡的 $except裡， 查詢訂單回傳是post

`EzshipController:`

```
    use Illuminate\Http\Request;
    use Hosomikai\Ezship\EzshipResponse;

    ...

    public function handle(Request $request)
    {
        $response = new EzshipResponse($request->all());

        //your handle or just default
        //you can redirect your handle page or 
        //if you use api to get this response
        //just return response object

        return $response;
    }
```

### 2. 宅配串接

```
    use Ezship
    ...

    $orderId = now()->format('YmdHis');                     //商店訂單編號                 
    $amount = 100;                                          //包裹價值金額或代收金額
    $needPay = true;                                        //是否需要代收款(取貨付款或單純取貨)
    $recipientName = 'hosomikai';                           //取貨人或收件人姓名(需與收件人證件姓名一致)
    $recipientEmail = 'service@hosomikai.com';              //取貨人或收件人信箱
    $recipientMobile = '0953539459';                        //取貨人或收件人電話
    $zipCode = '104';                                       //收貨人郵遞區號
    $recipientAddr = '12, No. 80號復興北路中山區台北市104';     //收貨人地址

    $order = Ezship::newOrder($amount, $needPay, $orderId)
                ->recipient($recipientName', $recipientMobile, $recipientEmail')
                ->homeDelivery($zipCode, $recipientAddr);

    
    //post by redirect form
    return $order->checkout();
```

### 3. 超商取貨串接

產生電子地圖連結:
```
    use Hosomikai\Ezship\EzshipMapGenerator;

    //你想夾帶回來的參數
    $params = [
        //
    ];

    //運用此api產生的連結 選擇取貨超商
    $mapUrl = $mapGenerator
            ->withWebParams($params)
            ->mapUrl();
```

`routes/web.php:`

```
Route::post('ezship_map', 'EzshipController@handleMap');
```

`EzshipController:`
```
    use Illuminate\Http\Request;
    use Illuminate\Support\Arr;
    use Hosomikai\Ezship\EzshipMapResponse;
    ...

    public function handleMap(Request $request)
    {
        $mapResponse = new EzshipMapResponse($request->all());

        if ($mapResponse->fails()) {
            //handle fail
            return;
        }

        //成功選取的超商完整代碼
        $strCode = $mapResponse->getStoreCode()();
        
        //當時夾帶的 回來需要判別的使用的參數
        $yourparams = $mampResponse->getWebPara();

        //....
        // handle your flow
    }
```

新建超商取貨訂單
```
    use Ezship
    use Hosomikai\Ezship\EzshipResponse;
    ...

    $orderId = now()->format('YmdHis');                     //商店訂單編號                 
    $amount = 100;                                          //包裹價值金額或代收金額
    $needPay = true;                                        //是否需要代收款(取貨付款或單純取貨)
    $recipientName = 'hosomikai';                              //取貨人或收件人姓名(需與收件人證件姓名一致)
    $recipientEmail = 'service@hosomikai.com';                 //取貨人或收件人信箱
    $recipientMobile = '0953539459';                        //取貨人或收件人電話
    $stCode = 'yourstcode';                                 //code you get from (EzshipMapResponse)->getCode();

    $order = Ezship::newOrder($amount, $needPay, $orderId)
                ->recipient($recipientName', $recipientMobile, $recipientEmail')
                ->toStore($stCode);

    
    //post by redirect form
    return $order->checkout();

    ....
```

### 4. Hosomikai\Ezship\EzshipOrderStatusConstant
| 參數            |     值     | 說明                |
|-----------------|:------------:|:-----------------:|
| STORE_NEW_TYPE1 |    A01       |   超商取貨新訂單，不需在ezShip上確認訂單，可直接印單 (ezShip系統將回覆sn_id)        |
| STORE_NEW_TYPE2 |    A02       |   超商取貨新訂單，需在ezShip上確認訂單，確認後才可進行印單 (ezShip系統預設值, 且系統將回覆sn_id)        |
| STORE_NEW_TYPE3 |    A03       |   超商取貨新訂單，使用 輕鬆袋或迷你袋 (ezShip系統不回覆sn_id，不需在ezShip網站上確認訂單，但需至ezShip網站後台登錄專用編號)        |
| STORE_NEW_TYPE4 |    A04       |   超商取貨新訂單，使用 輕鬆袋或迷你袋 (ezShip系統不回覆sn_id，需在ezShip網站上確認訂單，且需至ezShip網站後台登錄專用編號)        |
| HOME_DELIVERY_TYPE1 |    A05       |   宅配新訂單 不需在ezShip上確認訂單，可直接印單 (ezShip系統將回覆sn_id)         |
| HOME_DELIVERY_TYPE2 |    A06       |   宅配新訂單 需在ezShip上確認訂單，確認後才可進行印單 (ezShip系統將回覆sn_id)        |


you can set in env:
```
EZSHIP_NEW_ORDER_STATUS_STORE=
EZSHIP_NEW_ORDER_STATUS_HOME_DELIVERY=
```

or you can publish config & change in `config/ezship.php:`
```
    ...

    /**
     * 建立新訂單狀態類型.
     */
    'order_status' => [
        'store' => env('EZSHIP_NEW_ORDER_STATUS_STORE', EzshipOrderStatusConstant::STORE_NEW_TYPE2),                      //超取新訂單狀態類型
        'home_delivery' => env('EZSHIP_NEW_ORDER_STATUS_HOME_DELIVERY', EzshipOrderStatusConstant::HOME_DELIVERY_TYPE2),  //宅配新訂單狀態類型
    ],
```

### 5. 查詢物流配送狀態

```
    $snId = '3514114054';

    //this will return EzshipResponse object (by our config before)
    $order = Ezship::queryBySnId($snId);

    // return data
```

## Referrece
[台灣便利通/Ezship](https://www.ezship.com.tw/service_doc/service_home_w18v1.jsp?vDocNo=1702&vDefPage=04)


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## TODO
- 查詢自動查詢物流狀態
- 觸發事件
- 紀錄ezship配送log
- 內容完善校正
- 測試
- web params exception
- 優化回傳response model