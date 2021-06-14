@extends('ezship::demo.layouts.app')

@section('title', '建立訂單')

@section('content')
<div class="container">
  <div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://www.ezship.com.tw/images/logo-ezship2.gif" alt="">
    <h2>物流訂單demo</h2>
    <a class="btn btn-primary btn-sm" href="{{ route('ezship.query') }}">查詢貨態狀況</a>
  </div>
  <div class="row">
    <div class="col-md-12 order-md-1">

    <form id="ezship-order-form" method="post" action="{{ route('ezship.order.send') }}">
      
      <div class="mb-3">
        <label for="username">台灣便利配寄件APP ID</label>
        <div class="input-group">
          <input type="text" class="form-control" id="username" name="suId" placeholder="your ezship app id" value="{{ $suId }}" required>
        </div>
      </div>

      <hr class="mb-4">

      <h4 class="mb-3">物流訂單資訊</h4>
     
        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="orderId">網站訂單編號</label>
            <input type="text" class="form-control" id="orderId" name="orderId" placeholder="訂單編號" value="{{ $orderId }}" required>
          </div>
          <div class="col-md-3 mb-3">
            <label for="orderAmount">訂單金額</label>
            <input type="number" class="form-control" id="orderAmount" name="orderAmount" placeholder="訂單金額" value="{{ $orderAmount }}" required>
          </div>
        </div>

        <hr class="mb-4">

        <h4 class="mb-3">收件人資訊</h4>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="input-recipient-name">收件人姓名</label>
            <input type="text" class="form-control" id="input-recipient-name" name="recipientName" placeholder="收件人姓名" value="{{ $recipientName }}" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="input-recipient-mobile">收件人電話</label>
            <input type="text" class="form-control" id="input-recipient-mobile" name="recipientMobile" placeholder="收件人電話" value="{{ $recipientMobile }}" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="input-recipient-email">收件人Email</label>
            <input type="email" class="form-control" id="input-recipient-email" name="recipientEmail" placeholder="you@example.com" value="{{ $recipientEmail }}" required>
          </div>
        </div>

        <hr class="mb-4">

        <h4 class="mb-3">取貨方式</h4>
        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="shipping-store" name="shippingMethod" type="radio" class="custom-control-input" value="{{ Ezship::SHIPPING_STORE }}" @if($shippingMethod == Ezship::SHIPPING_STORE) checked @endif required>
            <label class="custom-control-label" for="shipping-store">超商取貨</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="shipping-home-delivery" name="shippingMethod" type="radio" class="custom-control-input" value="{{ Ezship::SHIPPING_HOME_DELIVERY }}"  @if($shippingMethod == Ezship::SHIPPING_HOME_DELIVERY) checked @endif required>
            <label class="custom-control-label" for="shipping-home-delivery">宅配</label>
          </div>
        </div>

        <div class="row" id="home-delivery-input-block" style="display: none">
          <div class="col-md-3 mb-3">
            <label for="zip">郵遞區號</label>
            <input type="text" class="form-control" id="zip" name="zipCode" placeholder="台灣郵遞區號">
          </div>
          <div class="col-md-9 mb-3">
            <label for="address">收件地址</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="台北市xx區xx路xx號">
          </div>
        </div>

        <div class="row" id="store-input-block" style="display: none">
          <div class="col-md-12 mb-3">
          <button class="btn btn-primary btn-sm" type="button" id="store-selector" data-map-url="{{ route('ezship.map') }}">選擇取貨門市</button>
          </div>
          <div class="col-md-3 mb-3">
            <label for="store-code-input">選擇門市代號</label>
            <input type="text" class="form-control" id="store-code-input" placeholder="門市代號" name="stCode" value="{{ $stCode }}" @if($stCode) readonly @endif>
          </div>
          @if($stCode)
          <div class="col-md-3 mb-3">
            <label for="store-name-input">門市名稱</label>
            <input type="text" class="form-control" id="store-name-input" placeholder="門市名稱" name="stName" value="{{ $stName }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label for="store-address-input">門市地址</label>
            <input type="text" class="form-control" id="store-address-input" placeholder="門市地址" name="stAddr" value="{{ $stCode }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label for="store-phone-input">門市電話</label>
            <input type="text" class="form-control" id="store-phone-input" placeholder="門市電話" name="stTel" value="{{ $stTel }}" readonly>
          </div>
          @endif
        </div>
       
        <hr class="mb-4">

        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="need-pay-checkbox" name="needPay" value="1" @if($needPay == 1) checked @endif>
          <label class="custom-control-label" for="need-pay-checkbox">是否貨到付款</label>
        </div>

        <hr class="mb-4">      

        <button class="btn btn-primary btn-lg btn-block" type="submit">送出物流訂單</button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function setDeliveryInputBlock(enabledId, disabledId) {
    //開啟
    $('#' + enabledId).show();
    $('#' + enabledId + ' :input').each(function () {
      let input = $(this);
      input.prop('required', true);
    });

    //關閉
    $('#' + disabledId).hide();
    $('#' + disabledId + ' :input').each(function () {
      let input = $(this);
      input.prop('required', false);
    }); 
  }

  //顯示收件區塊
  function setShippingMethod() {
    let shippingMethod = $('input[name="shippingMethod"]:checked').val();
    if (shippingMethod == '{{ Ezship::SHIPPING_STORE }}') {
      setDeliveryInputBlock('store-input-block', 'home-delivery-input-block');
    } else if (shippingMethod == '{{ Ezship::SHIPPING_HOME_DELIVERY }}') {
      setDeliveryInputBlock('home-delivery-input-block', 'store-input-block');
    }
  }

  $('input[name="shippingMethod"]').change(function () {
    setShippingMethod();
  })

  $('#store-selector').click(function () {
    $form = $('<form style="display: none;"></form>');
    $form.attr('action', $(this).data('mapUrl'));
    $form.attr('method', 'post');

    $("form#ezship-order-form :input").each(function(){
      var input = $(this);
      $form.append(input);
    });

    $form.appendTo(document.body).submit();
  });

  $(document).ready(function () {
    setShippingMethod();
  })
</script>
@endpush