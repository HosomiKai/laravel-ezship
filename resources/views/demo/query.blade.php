@extends('ezship::demo.layouts.app')

@section('title', '訂單查詢')

@section('content')
<div class="container">
  <div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://www.ezship.com.tw/images/logo-ezship2.gif" alt="">
    <h2>訂單結果查詢</h2>
    <a class="btn btn-primary btn-sm" href="{{ route('ezship.order.create') }}">新增物流訂單</a>
  </div>
  <div class="row">
    <div class="col-md-12 order-md-1">

    <form id="ezship-order-form" method="post" action="{{ route('ezship.query.send') }}">
      
        <div class="mb-3">
            <label for="username">台灣便利配寄件APP ID</label>
            <div class="input-group">
            <input type="text" class="form-control" id="username" name="suId" placeholder="your ezship app id" value="{{ $suId }}" required>
            </div>
        </div>

        <hr class="mb-4">

        <h4 class="mb-3">查詢方式</h4>
        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="query-by-sn-input" name="queryBy" type="radio" class="custom-control-input" value="{{ Ezship::QUERY_BY_SN }}"  @if($queryBy == Ezship::QUERY_BY_SN) checked @endif required>
            <label class="custom-control-label" for="query-by-sn-input">sn編號查詢</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="query-by-order-input" name="queryBy" type="radio" class="custom-control-input" value="{{ Ezship::QUERY_BY_ORDER }}" @if($queryBy == Ezship::QUERY_BY_ORDER) checked @endif required>
            <label class="custom-control-label" for="query-by-order-input">網站訂單編號查詢</label>
          </div>
        </div>
     
        <div class="row">
          <div class="col-md-12 mb-3">
            <label for="query-id-input">查詢編號</label>
            <input type="text" class="form-control" id="query-id-input" name="queryId" placeholder="訂單編號" value="{{ $queryId }}" required>
          </div>
        </div>

        <hr class="mb-4">

        @isset($queryResult)
            <h4 class="mb-3">查詢結果</h4>
            @include('ezship::demo.partials.result-table', $queryResult)
        @endisset
        
        <hr class="mb-4">

        <button class="btn btn-primary btn-lg btn-block" type="submit">查詢</button>
      </form>
    </div>
  </div>
</div>

@endsection
