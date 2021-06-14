<?php

namespace Hosomikai\Ezship\Contracts;

interface EzshipApiCode
{
    /**
     * 貨態概念參考
     * shipped 已發貨
     * in transit 送貨途中
     * arrived 已送達
     * complete 已完成或已取貨.
     */

    /**
     * 成功 , 尚未寄件或尚未收到超商總公司提供的寄件訊息.
     */
    public const SUCCESS_CODE = 'S01';

    /**
     * 尚未寄件或尚未收到超商總公司提供的寄件訊息.
     */
    public const SHIPPING_STATUS_PENDDING_CODE = 'S01';

    /**
     * 運往取件門市途中.
     */
    public const SHIPPING_STATUS_SHIPPED_CODE = 'S02';

    /**
     * 已送達取件門市
     */
    public const SHIPPING_STATUS_ARRIVED_CODE = 'S03';

    /**
     * 已完成取貨.
     */
    public const SHIPPING_STATUS_COMPLETED_CODE = 'S04';

    /**
     * 退貨 (包含：已退回物流中心 / 再寄一次給取件人 / 退回給寄件人).
     */
    public const SHIPPING_STATUS_RETURN_CODE = 'S05';

    /**
     * 配送異常 (包含：刪單 / 門市閉店 / 貨故).
     */
    public const SHIPPING_STATUS_ERR_CODE = 'S06';

    /**
     * 參數錯誤.
     */
    public const ERR_PARAMETER_CODE = 'E00';

    /**
     * 帳號不存在.
     */
    public const ERR_ACCOUNT_CODE = 'E01';

    /**
     * 無網站串接權限.
     */
    public const ERR_PERMISSION_CODE = 'E02';

    /**
     * 帳號無可用 輕鬆袋或迷你袋.
     */
    public const ERR_BAG_CODE = 'E03';

    /**
     * 取貨門市錯誤.
     */
    public const ERR_STORE_CODE = 'E04';

    /**
     * 金額有誤.
     */
    public const ERR_ORDER_AMOUNT_CODE = 'E05';

    /**
     * 收件人email格式錯誤.
     */
    public const ERR_RECIPIENT_EMAIL_CODE = 'E06';

    /**
     * 收件人手機格式錯誤.
     */
    public const ERR_RECIPIENT_MOBILE_CODE = 'E07';

    /**
     * 訂單狀態錯誤.
     */
    public const ERR_ORDER_STATUS_CODE = 'E08';

    /**
     * 訂單類型錯誤.
     */
    public const ERR_ORDER_TYPE_CODE = 'E09';

    /**
     * 收件人姓名錯誤.
     */
    public const ERR_RECIPIENT_NAME_CODE = 'E10';

    /**
     * 收件人地址錯誤.
     */
    public const ERR_RECIPIENT_ADDR_CODE = 'E11';

    /**
     * 系統發生錯誤無法載入.
     */
    public const ERR_SYSTEM_LOAD_CODE = 'E98';

    /**
     * 系統錯誤.
     */
    public const ERR_SYSTEM_CODE = 'E99';
}
