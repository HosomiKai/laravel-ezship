<?php

namespace Hosomikai\Ezship\Facades;

use Illuminate\Support\Facades\Facade;

class Ezship extends Facade
{
    /**
     * 用SnId查詢訂單.
     */
    public const QUERY_BY_SN = 'sn-id';

    /**
     * 用網站訂單編號查詢訂單.
     */
    public const QUERY_BY_ORDER = 'order-id';

    /**
     * 超商取貨.
     */
    public const SHIPPING_STORE = 'ezship-store';

    /**
     * 宅配.
     */
    public const SHIPPING_HOME_DELIVERY = 'ezship-home-delivery';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ezship';
    }
}
