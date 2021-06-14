<?php

namespace Hosomikai\Ezship\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;

class EzshipMapResponse extends EzshipBaseResponse implements Arrayable, Responsable
{
    /**
     * 網站處理序號/訂單id.
     *
     * @var string
     */
    protected $proccessId;

    /**
     * 取貨通路代號
     *
     * @var string
     */
    protected $stCate;

    /**
     * 取貨門市代號
     *
     * @var string
     */
    protected $stCode;

    /**
     * 取貨門市名稱.
     *
     * @var string
     */
    protected $stName;

    /**
     * 取貨門市地址
     *
     * @var string
     */
    protected $stAddr;

    /**
     * 取貨門市電話.
     *
     * @var string
     */
    protected $stTel;

    /**
     * 取貨超商選擇後回傳參數.
     *
     * @var array
     */
    protected $responseData = [];

    public function __construct(array $responseData)
    {
        parent::__construct($responseData);

        $this->proccessId = $responseData['processID'] ?? null;
        $this->stCate = $responseData['stCate'] ?? null;
        $this->stCode = $responseData['stCode'] ?? null;
        $this->stName = $responseData['stName'] ?? null;
        $this->stAddr = $responseData['stAddr'] ?? null;
        $this->stTel = $responseData['stTel'] ?? null;
    }

    /**
     * 是否成功
     */
    public function isSuccess(): bool
    {
        return !is_null($this->getStoreCode());
    }

    /**
     * 取得網站處理id.
     */
    public function getId(): ?string
    {
        return $this->proccessId;
    }

    /**
     * 取得建立物流訂單用的超商代碼
     */
    public function getStoreCode(): ?string
    {
        return $this->stCate . $this->stCode;
    }

    /**
     * 取貨門市名稱.
     */
    public function storeName(): ?string
    {
        return $this->stName;
    }

    /**
     * 超商地址
     */
    public function getStoreAddress(): ?string
    {
        return $this->stAddr;
    }

    /**
     * 超商電話.
     */
    public function getStoreTel(): ?string
    {
        return $this->stTel;
    }
}
