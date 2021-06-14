<?php

namespace Hosomikai\Ezship\Contracts;

interface EzshipOrder
{
    /**
     * 貨到付款/取貨付款.
     */
    public const PAY = 1;

    /**
     * 一般配送 取貨不付款/純配送
     */
    public const NO_PAY = 3;

    /**
     * 超商取貨新訂單
     * 不需在ezShip上確認訂單，可直接印單 (ezShip系統將回覆sn_id.
     */
    public const STORE_NEW_TYPE1 = 'A01';

    /**
     * 超商取貨新訂單
     * 需在ezShip上確認訂單，確認後才可進行印單 (ezShip系統預設值, 且系統將回覆sn_id).
     */
    public const STORE_NEW_TYPE2 = 'A02';

    /**
     * 超商取貨新訂單
     * 使用 輕鬆袋或迷你袋 (ezShip系統不回覆sn_id，不需在ezShip網站上確認訂單，但需至ezShip網站後台登錄專用編號).
     */
    public const STORE_NEW_TYPE3 = 'A03';

    /**
     * 超商取貨新訂單
     * 使用 輕鬆袋或迷你袋 (ezShip系統不回覆sn_id，需在ezShip網站上確認訂單，且需至ezShip網站後台登錄專用編號).
     */
    public const STORE_NEW_TYPE4 = 'A04';

    /**
     * 宅配新訂單
     * 不需在ezShip上確認訂單，可直接印單 (ezShip系統將回覆sn_id).
     */
    public const HOME_DELIVERY_TYPE1 = 'A05';

    /**
     * 宅配新訂單
     * 需在ezShip上確認訂單，確認後才可進行印單 (ezShip系統將回覆sn_id).
     */
    public const HOME_DELIVERY_TYPE2 = 'A06';
}
