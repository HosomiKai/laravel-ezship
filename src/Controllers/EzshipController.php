<?php

namespace Hosomikai\Ezship\Controllers;

use Ezship;
use Hosomikai\Ezship\EzshipMapGenerator;
use Hosomikai\Ezship\Responses\EzshipMapResponse;
use Hosomikai\Ezship\Responses\EzshipQueryResponse;
use Hosomikai\Ezship\Responses\EzshipResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EzshipController extends Controller
{
    /**
     * Demo訂單頁面.
     */
    public function newOrder(Request $request): View
    {
        $map = new EzshipMapResponse($request->all());

        $order = array_merge(
            [
                'suId' => config('ezship.app_id'),

                //訂單資訊
                'orderId' => Str::random(10),
                'orderAmount' => null,

                //收件人資訊
                'recipientName' => null,
                'recipientMobile' => null,
                'recipientEmail' => null,

                //超商資訊
                'stName' => $map->storeName(),
                'stAddr' => $map->getStoreAddress(),
                'stTel' => $map->getStoreTel(),
                'stCode' => $map->getStoreCode(),

                'shippingMethod' => Ezship::SHIPPING_STORE,
                'needPay' => 0,
            ],
            $map->getWebPara()
        );

        return view('ezship::demo.order', $order);
    }

    /**
     * 取得超商地圖選擇url.
     */
    public function map(Request $request, EzshipMapGenerator $mapGenerator): RedirectResponse
    {
        $mapGenerator
            ->setMapReturnUrl(
                route('ezship.order.create')
            )
            ->withWebParams($request->all());

        return redirect($mapGenerator->mapUrl());
    }

    /**
     * 送出物流訂單.
     */
    public function send(Request $request): View
    {
        $order = Ezship::newOrder(
            $request->get('orderAmount'),
            $request->has('needPay'),
            $request->get('orderId'),
            $request->get('suId'),
        )
        ->recipient(
            $request->get('recipientName'),
            $request->get('recipientMobile'),
            $request->get('recipientEmail')
        )
        ->setReturnUrl(route('ezship.order.return'));

        //超商取貨
        if (Ezship::SHIPPING_STORE == $request->get('shippingMethod')) {
            $order->toStore($request->get('stCode'));
        }

        //宅配取貨
        if (Ezship::SHIPPING_HOME_DELIVERY == $request->get('shippingMethod')) {
            $order->homeDelivery(
                $request->get('zipCode'),
                $request->get('address'),
            );
        }

        return $order->checkout();
    }

    /**
     * handle API 回傳結果頁
     */
    public function handleReturn(Request $request): View
    {
        $response = new EzshipResponse($request->all());

        return view('ezship::demo.result', [
            'success' => $response->isSuccess(),
            'message' => $response->getMessage(),
            'snId' => $response->getSnId(),
            'orderId' => $response->getOrderId(),
        ]);
    }

    /**
     * 查詢訂單頁面.
     */
    public function queryOrder(Request $request): View
    {
        $order = $this->defaultQueryOrder($request);

        return view('ezship::demo.query', $order);
    }

    /**
     * 查詢Request.
     *
     * @return RedirectResponse|View
     */
    public function queryPost(Request $request)
    {
        $order = Ezship::new($request->get('snId'))
                    ->setReturnUrl(route('ezship.query.result'))
                    ->withWebParams(['queryBy' => $request->get('queryBy')]);

        if (Ezship::QUERY_BY_ORDER == $request->get('queryBy')) {
            return $order->queryBySnId(
                $request->get('queryId')
            );
        }

        if (Ezship::QUERY_BY_SN == $request->get('queryBy')) {
            return $order->queryByOrderId(
                $request->get('queryId')
            );
        }

        return redirect()->back();
    }

    /**
     * 查詢訂單回傳結果.
     */
    public function queryResult(Request $request): View
    {
        $response = new EzshipQueryResponse($request->all());

        $order = $this->defaultQueryOrder($request);

        $order = array_merge(
            $order,
            [
                'queryResult' => [
                    'message' => $response->getMessage(),
                    'snId' => $response->getSnId(),
                    'orderId' => $response->getOrderId(),
                ],
            ],
            $response->getWebPara(),
        );

        return view('ezship::demo.query', $order);
    }

    private function defaultQueryOrder(Request $request): array
    {
        return [
            'suId' => config('ezship.app_id'),
            'queryId' => $request->get('queryId'), //訂單20210614100829   order_no: 094iHoR3nF, sn_id: 3514528677
            'queryBy' => $request->get('queryBy', Ezship::QUERY_BY_SN),
        ];
    }
}
