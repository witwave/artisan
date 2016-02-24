@extends('layouts.master')
@section('title')
订单详情
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
            <li><a href="{{ URL::to('admin/orders') }}">{{ Lang::get('menus.orders') }}</a></li>
            <li class="active">订单详情</li>
        </ol>
    </div>
</div>




    <section class="content-block default-bg">
        <!-- Container -->
        <div class="container cont-pad-y-sm">
            <!-- Row -->
            <div class="row">
              <div class="container">
                <style>
                .bs-wizard {margin-top: 40px;}

/*Form Wizard*/
.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step > .progress {background-color: #f5f5f5}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #99CC00 ; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #00CC00 ; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #99CC00  ;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
.order-view >dt {margin-bottom: 3px}
.order-view >dd {margin-bottom: 5px}
                </style>

            <div class="row bs-wizard" style="border-bottom:0;">

                <div class="col-xs-3 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum">提交订单</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">时间:{{ $order->created_at }}</div>
                </div>

                <div class="col-xs-3 bs-wizard-step {{ $order->payment_status=='success'?'complete':'active' }}"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">付款</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                   <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">时间:{{ $order->payment_status=='success'?$order->payment_time:'' }}</div>

                </div>

                @if ($order->payment_status=='success')
                  <div class="col-xs-3 bs-wizard-step  {{ $order->status>1?'complete':'active' }}" ><!-- complete -->
                    <div class="text-center bs-wizard-stepnum">等待{{$order->self_get==1?'上门取货':'收货' }}</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="bs-wizard-dot"></a>
                    <div class="bs-wizard-info text-center"></div>
                  </div>

                  <div class="col-xs-3 bs-wizard-step {{ $order->status==2?'complete':'disabled' }}" >
                    <div class="text-center bs-wizard-stepnum">完成</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="bs-wizard-dot"></a>
                    <div class="bs-wizard-info text-center"> </div>
                  </div>
                @else
                  <div class="col-xs-3 bs-wizard-step disabled"><!-- complete -->
                    <div class="text-center bs-wizard-stepnum">等待{{$order->self_get==1?'上门取货':'收货' }}</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="bs-wizard-dot"></a>
                    <div class="bs-wizard-info text-center"></div>
                  </div>

                  <div class="col-xs-3 bs-wizard-step disabled"><!-- active -->
                    <div class="text-center bs-wizard-stepnum">完成</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="bs-wizard-dot"></a>
                    <div class="bs-wizard-info text-center"> </div>
                  </div>
                @endif
            </div>
        </div>

          <!-- Row -->

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
              <div class="col-md-4 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        订单信息
                    </div>
                    <div class="panel-body">
                      <dl class="order-view">
                        <dt>收货地址</dt>
                        <dd>{{$order->receiver_name}} {{$order->receiver_mobile}} {{$order->receiver_phone}}
                          {{$order->receiver_address}}</dd>
                        <dt>订购人信息</dt>
                        <dd>{{$order->booker_name}} {{$order->booker_email}} {{$order->booker_phone}}</dt>
                        <dt>配送信息</dt>
                        <dd>{{$order->self_get==1?'上门取货':'送货上门' }}</dt>
                        <dd>要求到货时间:{{ date('Y-m-d',strtotime($order->require_send_day))}} {{ $order->require_send_type}} {{$order->require_send_time}}</dt>
                        <dt>贺卡内容</dt>
                        <dd>{{$order->card }}</dt>
                        @if ($order->has_special)
                        <dt>备注</dt>
                        <dd>{{$order->special_content}}</dt>
                        @endif
                      </dl>
                    </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12 rows">
                @if ($order->payment_status!=='success')
                  <form  class="form-horizontal" action="/pay/{{$order->out_order_id}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="inputPayType" class="col-sm-2 control-label">支付方式</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label>
                                    <input name="pay_type" type="radio"
                                           value="1" {{ $order->pay_type==1?'checked':'' }}>支付宝
                                </label>
                            </div>
                            <div class="radio hide">
                                <label><input value="微信支付" name="pay_type" type="radio"
                                              value="2" {{ $order->pay_type==2?'checked':'' }}
                                              disabled>微信支付
                                    <small>(尽请期待)</small>
                                </label>
                            </div>
                            <div class="radio hide">
                                <label><input value="网银" name="pay_type" type="radio"
                                              disabled {{ $order->pay_type==3?'checked':'' }}
                                              value="3">网银
                                    <small>(尽请期待)</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary checkout hide">去付款
                        </button>
                      </div>
                    </div>
                </form>
                @endif
              </div>
            </div>
            </div>
          </div>
                  <table class="cart-contents table table-bordered">
                      <thead>
                      <tr>
                          <th class="hidden-xs" style="text-align:center">商品</th>
                          <th class="hidden-xs" style="text-align:center">单价(元)</th>
                          <th style="text-align:center">数量</th>
                          <th style="text-align:center">运费</th>
                          <th style="text-align:center">实付款(元)</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($order->products as $index=>$product)
                            <tr>
                                <td>
                                  <a href="http://bdbeloved.com/product/{{$product->product_id}}.html">
                                      <img src="http://bdbeloved.com/img/{{$product->product_id}}"/>
                                      {{ $product->name}}
                                  </a>
                                </td>
                                <td style="text-align:center;vertical-align:middle">{{ $product->price}}</td>
                                <td style="text-align:center;vertical-align:middle">{{ $product->qty}}</td>
                                <td style="text-align:center;vertical-align:middle">{{ $product->mail_fee}}</td>
                                @if($index==0)
                                  <td style="text-align:center;vertical-align:middle" rowspan="{{ count($order->products)}}">
                                    {{ $order->paid}}<br/>
                                    (含运费：{{ $order->mail_fee}})
                                  </td>
                                  @endif
                            </tr>
                        @endforeach
                      </tbody>
                  </table>

      </div>
  </div>

@endsection
