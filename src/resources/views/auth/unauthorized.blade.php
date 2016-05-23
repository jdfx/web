@extends('web::layouts.app-mini')

@section('title', trans('web::seat.unauthorized_request'))

@section('content')

  <div class="login-logo">
    S<b>e</b>AT <br>
    <hr>
    <i class="fa fa-exclamation-triangle"></i>
    {{ trans('web::seat.unauthorized_request') }}
  </div>

  <hr>

  <div class="login-box-body">
    <p class="login-box-msg">

      {{ trans('web::seat.unauthorized_request_logged') }}
    </p>

    <a href="#" class="btn btn-primary btn-block" onclick="window.history.back()">
      {{ trans('web::seat.back') }}
    </a>

  </div>

@stop
