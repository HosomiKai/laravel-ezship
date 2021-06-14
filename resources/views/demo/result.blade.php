@extends('ezship::demo.layouts.app')

@section('title', '訂單')

@section('content')
<div class="container">
  <div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://www.ezship.com.tw/images/logo-ezship2.gif" alt="">
    <h2>物流訂單結果</h2>
  </div>
  <div class="row">
    <div class="col-md-12">
        @include('ezship::demo.partials.result-table')
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <a class="btn btn-primary btn-lg btn-block" href="{{ route('ezship.order.create') }}">繼續下一筆</a>
      <a class="btn btn-primary btn-lg btn-block" href="{{ route('ezship.query', [
          'queryId' => $snId,
          'queryBy' => 1
      ]) }}">
        查詢配送狀態
      </a>
    </div>
  </div>
</div>

@endsection