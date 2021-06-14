<?php

namespace Hosomikai\Ezship;

use GuzzleHttp\Client;
use Hosomikai\Ezship\Contracts\EzshipOrder;
use Illuminate\Contracts\View\Factory as View;

/**
 * api document
 * https://www.ezship.com.tw/service_doc/service_home_w18v1.jsp?vDocNo=1702&vDefPage=01.
 */
class Ezship extends EzshipApi implements EzshipOrder
{
    /**
     * api url list.
     *
     * @var array
     */
    private $apiUrl = [];

    /**
     * 商店訂單編號
     *
     * @var string
     */
    private $orderId;

    /**
     * 是否需要代收款.
     *
     * @var int
     */
    private $orderType;

    /**
     * 收件人姓名.
     *
     * @var string
     */
    private $rvName;

    /**
     * 收件人信箱.
     *
     * @var string
     */
    private $rvEmail;

    /**
     * 收件人電話.
     *
     * @var string
     */
    private $rvMobile;

    /**
     * 訂單金額/或代收金額.
     *
     * @var int
     */
    private $amount;

    /**
     * 完整超商代碼
     *
     * @var string
     */
    private $stCode;

    /**
     * 宅配郵遞區號
     *
     * @var string
     */
    private $rvZip;

    /**
     * 宅配地址
     *
     * @var string
     */
    private $rvAddr;

    /**
     * 回傳網址
     *
     * @var string
     */
    private $returnUrl;

    /**
     * 設定訂單種類.
     *
     * @var int
     */
    private $orderStatus;

    public function __construct(?string $appId = null)
    {
        parent::__construct($appId);

        $this->apiUrl['post_order_api'] = config('ezship.post_order_api');
        $this->apiUrl['query_order_api'] = config('ezship.query_order_api');
        $this->returnUrl = config('ezship.return_url');
    }

    public function setReturnUrl(string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    public static function new(?string $appId = null)
    {
        return new static($appId);
    }

    /**
     * 產生 new post data instance for new order.
     *
     * @param int $amount   金額
     * @param bool $needPay  是否代收款
     * @param string $orderId   商店訂單編號
     */
    public static function newOrder(int $amount = 0, bool $needPay = false, string $orderId = null, ?string $appId = null): self
    {
        $order = new static($appId);

        $order->order($orderId)
            ->amount($amount)
            ->needPay($needPay);

        return $order;
    }

    /**
     * 設定商店訂單編號
     *
     * @param string $orderId
     *
     * @return void
     */
    public function order(?string $orderId = null): self
    {
        $this->orderId = is_null($orderId) ? date('YmdHis') : $orderId;

        return $this;
    }

    /**
     * 代收金額 or 包裹價值.
     */
    public function amount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * 設定ezship訂單種類.
     */
    public function setOrderStatus(int $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    /**
     * 此筆訂單是否需要代收款.
     */
    public function needPay(bool $needPay = true): self
    {
        $this->orderType = self::orderType($needPay);

        return $this;
    }

    /**
     * 要送出的訂單類別.
     *
     * @param bool $needPay  是否需要代收款（貨到付款）
     *
     * @return string 是否需要代收辨別字串
     */
    public static function orderType(bool $needPay): int
    {
        return $needPay ? self::PAY : self::NO_PAY;
    }

    /*
     *
     * 設定收貨人或取貨人.
     *
     * @param string $recipientName   取貨人or收件人姓名
     * @param string $recipientEmail  取貨人or收件人email
     * @param string $recipientMobile 取貨人or收件人mobile
     */
    public function recipient(
        string $recipientName,
        string $recipientMobile,
        string $recipientEmail
    ): self {
        $this->rvName = $recipientName;
        $this->rvEmail = $recipientEmail;
        $this->rvMobile = $recipientMobile;

        return $this;
    }

    /**
     * 超商取貨.
     *
     * @param string $stCode    商店代號
     */
    public function toStore(string $stCode): self
    {
        $isStoreOrder = true;

        $this->stCode = $stCode;
        $this->orderStatus = $this->orderStatus($isStoreOrder); //設定訂單種類
        $this->rvZip = null;
        $this->rvAddr = null;

        return $this;
    }

    /**
     * 宅配地址
     *
     * @param strin $zipCode          宅配收件人郵遞區號
     * @param string $recipientAddr   宅配收件人地址
     */
    public function homeDelivery(string $zipCode, string $recipientAddr): self
    {
        $isStoreOrder = false;

        $this->rvZip = $zipCode;
        $this->rvAddr = $recipientAddr;
        $this->orderStatus = $this->orderStatus($isStoreOrder);

        $this->stCode = null;

        return $this;
    }

    /**
     * 送出訂單.
     *
     * @return void
     */
    public function checkout(bool $isServerPost = false)
    {
        $postData = [
            'su_id' => $this->appId,
            'order_id' => $this->orderId,                       //商店訂單編號
            'order_status' => $this->orderStatus,               //取貨訂單類型狀態
            'order_type' => $this->orderType,                   //是否需要代收款
            'order_amount' => $this->amount,                    //貨到付款代收金額/報值金額
            'rv_name' => $this->rvName,                         //超商取貨取件人姓名
            'rv_email' => $this->rvEmail,                       //超商取件人電子郵件
            'rv_mobile' => $this->rvMobile,                     //超商取件人電話
            'st_code' => $this->stCode,                         //超商取貨通路門市代號
            'rv_addr' => $this->rvAddr,                         //宅配收件人地址
            'rv_zip' => $this->rvZip,                           //宅配收件人郵遞區號
            'rtn_url' => $this->returnUrl,                      //完整網址路徑導回
            'web_para' => http_build_query($this->webParams),   //供網站判別用參數
        ];

        $postData = array_filter($postData, function ($value) {
            return null !== $value && false !== $value && '' !== $value;
        });

        return $isServerPost
            ? $this->sendPostRequest($postData, $this->apiUrl['post_order_api'])
            : $this->send($postData, $this->apiUrl['post_order_api']);
    }

    /**
     * 前台送出訂單建立表單到台灣便利配.
     * 網頁表單送出.
     *
     * @return \Illuminate\View\View 回傳自動送出表單
     */
    public function send(array $postData, string $apiUrl)
    {
        return view(
            'ezship::send-order',
            [
                'apiUrl' => $apiUrl,
                'order' => $postData,
            ]
        );
    }

    /**
     * 用Guzzle handle流程.
     *
     * @return array|null 回傳結果(接入我們設定的api回傳)
     */
    public function sendPostRequest(array $postData, string $apiUrl): ?array
    {
        $client = new Client();

        $params = [
            'timeout' => 10,
            'form_params' => $postData,
            'allow_redirects' => [
                'max' => 10,                        // allow at most 10 redirects.
                'strict' => true,                   // use "strict" RFC compliant redirects.
                'referer' => true,                  // add a Referer header
                'protocols' => ['https', 'http'],   // only allow https URLs
            ],
        ];

        $res = $client->request(
            'POST',
            $apiUrl,
            $params
        );

        return is_null($res) ? $res : json_decode($res->getBody(), true);
    }

    /**
     * 查詢訂單貨態.
     *
     * @param string $snId 物流單號
     *
     * @return void
     */
    public function queryBySnId(string $snId, bool $isServerPost = false)
    {
        $postData = [
            'su_id' => $this->appId,
            'sn_id' => $snId,
            'rtn_url' => $this->returnUrl,                       //完整網址路徑導回
            'web_para' => http_build_query($this->webParams),    //供網站判別用參數
        ];

        return $isServerPost
        ? $this->sendPostRequest($postData, $this->apiUrl['query_order_api'])
        : $this->send($postData, $this->apiUrl['query_order_api']);
    }

    /**
     * 使用網站訂單編號查詢訂單貨態.
     *
     * @param string $orderId 網站訂單編號
     */
    public function queryByOrderId(string $orderId, bool $isServerPost = false)
    {
        $postData = [
            'su_id' => $this->appId,
            'order_no' => $orderId,
            'rtn_url' => $this->returnUrl,                       //完整網址路徑導回
            'web_para' => http_build_query($this->webParams),    //供網站判別用參數
        ];

        return $isServerPost
        ? $this->sendPostRequest($postData, $this->apiUrl['query_order_api'])
        : $this->send($postData, $this->apiUrl['query_order_api']);
    }

    /**
     * 設定 webPara.
     * 不可包含字元 ' : @ % & * $ ".
     */
    public function withWebParams(array $params): self
    {
        //TODO: 過濾exception
        $this->webParams = $params;

        return $this;
    }

    /**
     * 取得欲送出訂單種類.
     *
     * @param bool $isStore      是否超商取貨
     *
     * @return string 根據設定取得
     */
    private function orderStatus(bool $isStore): string
    {
        return $isStore ? config('ezship.order_status.store') : config('ezship.order_status.home_delivery');
    }
}
