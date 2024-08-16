<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body {
            font-family: 'Arial, sans-serif', serif;
        }
        .container {
            margin: 0 auto;
            padding: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            font-size: 12px;
        }

        .category{
            color: white;
            padding: 8px;
            margin-bottom: 8px;
            margin-top: 8px;
        }
        .category-main-div{
            margin-bottom: 8px;
            margin-top: 8px;
        }

        .payment{
            padding: 8px;
        }

        .payment div {
            float: left;
            margin-right: 10px;
        }

        .payment div:first-child {
            width: 90%;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Payments</h1>
    </div>
    <div class="content">
       @foreach($data as $key=>$items)
           <div class="category-main-div">
               <div style="background-color: {{$items['category']->icon->color}}" class="category">{{$items['category']->name}}  ({{$items['total_amount']}})</div>
               @foreach($items['payments'] as $payment)
                   <div class="payment">
                       <div>{{$payment->amount}}</div>
                      <div>{{$payment->payment_date}}</div>
                   </div>
               @endforeach
           </div>
        @endforeach
    </div>
</div>
</body>
</html>
