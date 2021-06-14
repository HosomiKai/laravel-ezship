<?php

namespace Hosomikai\Ezship;

use Hosomikai\Ezship\Contracts\EzshipStore;

class EzshipMapGenerator extends EzshipApi implements EzshipStore
{
    /**
     * 接收地圖選擇結果回傳網址
     *
     * @var string
     */
    protected $mapReturnUrl;

    /**
     * 電子地圖網址
     *
     * @var string
     */
    protected $mapUrl;

    /**
     * 選定超商代號.
     *
     * @var string 3碼
     */
    protected $stCate;

    /**
     * 選定超商代碼
     *
     * @var string 5碼
     */
    protected $stCode;

    public function __construct(string $appId = null)
    {
        parent::__construct($appId);

        $this->mapUrl = config('ezship.map.url');
        $this->mapReturnUrl = config('ezship.map.return_url');
    }

    /**
     * 設定電子地圖選擇接收網址
     */
    public function setMapReturnUrl(string $url): self
    {
        $this->mapReturnUrl = $url;

        return $this;
    }

    /**
     * 全家超商地圖.
     */
    public function familyMart(): self
    {
        $this->stCate = self::FAMILY_MART;

        return $this;
    }

    /**
     * ok超商地圖.
     */
    public function okMart(): self
    {
        $this->stCate = self::OK_MART;

        return $this;
    }

    /**
     * 萊爾富超商地圖.
     */
    public function hiLife(): self
    {
        $this->stCate = self::HI_LIFE;

        return $this;
    }

    /**
     * 超商代碼
     */
    public function storeCode(string $stCode): self
    {
        $this->stCode = $stCode;

        return $this;
    }

    /**
     * 取得選取超商電子地圖api url.
     *
     * @param array $redirectParams    帶回接收網址所需參數
     * @param string $processId        處理序號或訂單編號
     * @param string $params           網站所需額外判別資料
     *
     * @return string 電子地圖連結網址
     */
    public function mapUrl(?string $processId = null): string
    {
        $query = http_build_query([
            'suID' => $this->appId,
            'rtURL' => $this->mapReturnUrl,
            'processID' => $processId,
            'stCate' => $this->stCate,
            'stCode' => $this->stCode,
            'webPara' => http_build_query($this->webParams),
        ]);

        return "{$this->mapUrl}?{$query}";
    }
}
