<?php

namespace Hosomikai\Ezship\Responses;

/**
 * Handle ezship api post back response.
 */
class EzshipQueryResponse extends EzshipResponse
{
    /**
     * 網站自訂訂單編號
     */
    public function getOrderId(): ?string
    {
        return $this->responseData['order_no'] ?? null;
    }

    /**
     * 格式為1位數字，其值為1、2、8或9。代表意義如下
     * 1：本配送狀態，係由第一次配送所產生
     * 2：本配送狀態，係由第二次配送所產生
     * 8：本配送狀態，係由退還給寄件人所產生
     * 9：本配送狀態，係由非常規配送所產生
     *
     * @return string|null
     */
    public function getTimes(): ?int
    {
        return $this->responseData['times'] ?? null;
    }

    /**
     * 格式為yyyy/mm/dd(四碼西元年/兩碼月份/兩碼日期)。
     * 本配送狀態的發生日期。此日期為超商或宅配公司所提供。
     */
    public function getUpdateStatusDate(): ?string
    {
        return $this->responseData['sdate'] ?? null;
    }

    /**
     * 格式為yyyy/mm/dd hh24:mi
     *   (四碼西元年/兩碼月份/兩碼日期 24小時制的兩碼小時:兩碼分鐘)。
     *      ezShip從超商或宅配公司，接收到本配送狀態的時間。
     *
     * @return void
     */
    public function getReceiveStatusDate()
    {
        return $this->responseData['udate'] ?? null;
    }

    /**
     * 取得自訂參數.
     */
    public function getWebPara(): ?array
    {
        if (is_null($this->web_para)) {
            return [];
        }

        parse_str($this->web_para, $params);

        return $params;
    }
}
