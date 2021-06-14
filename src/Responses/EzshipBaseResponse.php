<?php

namespace Hosomikai\Ezship\Responses;

use Hosomikai\Ezship\Contracts\EzshipResponseContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;

/**
 * Handle ezship api post back response.
 */
class EzshipBaseResponse implements Arrayable, Responsable, EzshipResponseContract
{
    /**
     * Response data.
     *
     * @var array
     */
    protected $responseData = [];

    /**
     * 自訂網站參數.
     *
     * @var string
     */
    protected $webPara;

    public function __construct(array $responseData)
    {
        $this->responseData = $responseData;

        $this->webPara = $responseData['webPara'] ?? null;
    }

    public function __get(string $get)
    {
        return $this->responseData[$get] ?? null;
    }

    /**
     * 測試回傳是否成功
     */
    public function isSuccess(): bool
    {
        $orderStatus = $this->getOrderStatus();

        return false === strpos($orderStatus, 'E');
    }

    /**
     * 是否失敗.
     */
    public function fails(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * 取得回傳訊息.
     *
     * @return void
     */
    public function getMessage(): ?string
    {
        return $this->isSuccess() ? '成功' : '失敗';
    }

    /**
     * 取得自訂參數.
     */
    public function getWebPara(): ?array
    {
        if (is_null($this->webPara)) {
            return [];
        }

        parse_str($this->webPara, $params);

        return $params;
    }

    public function toArray()
    {
        return $this->responseData;
    }

    public function toResponse($request)
    {
        return response()->json([
            'success' => $this->isSuccess(),
            'message' => $this->getMessage(),
            'data' => $this->responseData,
        ]);
    }
}
