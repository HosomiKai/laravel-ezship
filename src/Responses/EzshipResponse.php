<?php

namespace Hosomikai\Ezship\Responses;

use Hosomikai\Ezship\Supports\EzshipSupport;

/**
 * Handle ezship api post back response.
 */
class EzshipResponse extends EzshipBaseResponse
{
    /**
     * 測試回傳是否成功
     */
    public function isSuccess(): bool
    {
        $orderStatus = $this->getOrderStatus();

        return false === strpos($orderStatus, 'E');
    }

    /**
     * 取得回傳訊息.
     *
     * @return void
     */
    public function getMessage(): string
    {
        $orderStatus = $this->getOrderStatus();

        return EzshipSupport::messageByCode($orderStatus);
    }

    /**
     * 取得Ezship回傳的 order status code.
     *
     * @return void
     */
    public function getOrderStatus(): string
    {
        return $this->responseData['order_status'] ?? self::ERR_SYSTEM_CODE;
    }

    /**
     * 取得物流編號
     */
    public function getSnId(): ?string
    {
        return $this->responseData['sn_id'] ?? null;
    }

    /**
     * 網站自訂訂單編號
     */
    public function getOrderId(): ?string
    {
        return $this->responseData['order_id'] ?? null;
    }
}
