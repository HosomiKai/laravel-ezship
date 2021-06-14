<?php

namespace Hosomikai\Ezship\Supports;

use Hosomikai\Ezship\Contracts\EzshipApiCode;

class EzshipSupport
{
    /**
     * Get Message by Response Code.
     */
    public static function messageByCode(string $code): string
    {
        $message = trans('ezship::ezship.err_system');

        if (EzshipApiCode::SHIPPING_STATUS_PENDDING_CODE == $code) {
            $message = trans('ezship::ezship.shipping_status_pedding');
        } elseif (EzshipApiCode::SHIPPING_STATUS_SHIPPED_CODE == $code) {
            $message = trans('ezship::ezship.shipping_status_shipped');
        }

        //已送達取件門市
        elseif (EzshipApiCode::SHIPPING_STATUS_ARRIVED_CODE == $code) {
            $message = trans('ezship::ezship.shipping_status_arrived');
        }

        //已完成取貨
        elseif (EzshipApiCode::SHIPPING_STATUS_COMPLETED_CODE == $code) {
            $message = trans('ezship::ezship.shipping_status_completed');
        }

        //未取貨退回
        elseif (EzshipApiCode::SHIPPING_STATUS_RETURN_CODE == $code) {
            $message = trans('ezship::ezship.shipping_status_return');
        }

        //配送異常
        elseif (EzshipApiCode::SHIPPING_STATUS_ERR_CODE == $code) {
            $message = trans('ezship::ezship.shipping_status_err');
        }

        //參數錯誤
        elseif (EzshipApiCode::ERR_PARAMETER_CODE == $code) {
            $message = trans('ezship::ezship.err_parameter');
        }

        //帳號不存在
        elseif (EzshipApiCode::ERR_ACCOUNT_CODE == $code) {
            $message = trans('ezship::ezship.err_account');
        }

        //無網站串接權限
        elseif (EzshipApiCode::ERR_PERMISSION_CODE == $code) {
            $message = trans('ezship::ezship.err_permission');
        }

        //帳號無可用 輕鬆袋或迷你袋
        elseif (EzshipApiCode::ERR_BAG_CODE == $code) {
            $message = trans('ezship::ezship.err_bag');
        }

        //取貨門市錯誤
        elseif (EzshipApiCode::ERR_STORE_CODE == $code) {
            $message = trans('ezship::ezship.err_store');
        }

        //金額有誤
        elseif (EzshipApiCode::ERR_ORDER_AMOUNT_CODE == $code) {
            $message = trans('ezship::ezship.err_order_amount');
        }

        //收件人email格式錯誤
        elseif (EzshipApiCode::ERR_RECIPIENT_EMAIL_CODE == $code) {
            $message = trans('ezship::ezship.err_recipient_email');
        }

        //收件人手機格式錯誤
        elseif (EzshipApiCode::ERR_RECIPIENT_MOBILE_CODE == $code) {
            $message = trans('ezship::ezship.err_recipient_mobile');
        }

        //訂單狀態錯誤
        elseif (EzshipApiCode::ERR_ORDER_STATUS_CODE == $code) {
            $message = trans('ezship::ezship.err_order_status');
        }

        //訂單類型錯誤
        elseif (EzshipApiCode::ERR_ORDER_TYPE_CODE == $code) {
            $message = trans('ezship::ezship.err_order_type');
        }

        //收件人姓名錯誤
        elseif (EzshipApiCode::ERR_RECIPIENT_NAME_CODE == $code) {
            $message = trans('ezship::ezship.err_recipient_name');
        }

        //收件人地址錯誤
        elseif (EzshipApiCode::ERR_RECIPIENT_ADDR_CODE == $code) {
            $message = trans('ezship::ezship.err_recipient_addr');
        }

        //系統發生錯誤無法載入
        elseif (EzshipApiCode::ERR_SYSTEM_LOAD_CODE == $code) {
            $message = trans('ezship::ezship.err_system_load');
        }

        //系統錯誤
        elseif (EzshipApiCode::ERR_SYSTEM_CODE == $code) {
            $message = trans('ezship::ezship.err_system');
        }

        return $message;
    }
}
