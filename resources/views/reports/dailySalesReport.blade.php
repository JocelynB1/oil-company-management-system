@extends('layouts.app')
<?php
$litresSold=0;
$totalSales=0;
$totalAmountPaid=0;
$totalBalance=0;
$closingStock=0;
$totalLoad=0;
$totalBank=0;
$totalCredit=0;
$totalCash=0;
for($i=0;$i<count($transactions);$i++){
    $litresSold+=$transactions[$i]->liters;
    $totalSales+=$transactions[$i]->total_cost;
    $totalAmountPaid+=$transactions[$i]->amount_paid;
    $totalBalance+=$transactions[$i]->balance;
    if($transactions[$i]->payment_mode=="Bank"||$transactions[$i]->payment_mode=="Cheque"||$transactions[$i]->payment_mode=="Transfer"){
        $totalBank+=$transactions[$i]->amount_paid;
    }
     if($transactions[$i]->payment_mode=="Cash"){
        $totalCash+=$transactions[$i]->amount_paid;
    }
}
$totalCredit=$totalBalance;
for($i=0;$i<count($inventory);$i++){
    $totalLoad+=$inventory[$i]->litres_loaded;
}

if($transactions->isEmpty()){
    $tdate=date("jS F Y");
    
}else{
$tdate=new DateTime($transactions[0]->transaction_date);
 $tdate=$tdate->format("jS F Y");
}



$bal=0;
$field = \App\Product::pluck( 'product_type','product_type');
$fieldList = collect(['' => ''] + $field->all()+['ALL' => 'ALL']);

/*
 CAR NO.  OF TRUCK
 Supplier LITERS
                                <td>Opening Stock</td>
                                <td>{{$openingStock}}</td>
                        
                                */
?>
@section('content')
<div class="container">
    <div class="row">
        {!! Form::open([
        'method' => 'GET',
        'class'=>"form-inline",                                          
        'action'=>'DisplayRecordsController@displayDailySalesReport'
        ])!!}
        @csrf
        {!! Form::label('product_type','Product Type:',
        ['class'=>'col-auto col-form-label']) !!}
        <div class="col-auto">
            {!!Form::select('product_type',$fieldList ,null, 
            ['class' => 'form-control'])!!}
        </div>
        <div class="form-row align-items-center">
            {!! Form::label('dateQuery','Start Date:',['class'=>
            'col-auto col-form-label']) !!}
            {!! Form::date('dateQuery',date("Y-m-d"),['class'=> 'form-control', 
            "id"=>"dateQuery"]) !!}
            
                              {!! Form::label('dateQueryEnd','End Date:',['class'=>
            'col-auto col-form-label']) !!}    
                            {!! Form::date('dateQueryEnd',date("Y-m-d"),['class'=> 'form-control', "id"=>"dateQueryEnd"]) !!}
                    

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <h1>Daily Sales Report for {{$productType}}</h1>
    <h2>Date: {{$tdate}}</h2>
            <div class="row">
                 <div class="col-md-2">
                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Summary</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Sales</td>
                                   <td style="text-decoration: underline;"><b>{{number_format($totalSales,2)}}</b></td>   
                            </tr>              
                            <tr>
                                        <td>Total Bank Sales</td>    
                                   <td style="text-decoration: underline;"><b>{{number_format($totalBank,2)}}</b></td>
                                   </tr> 
                                   <tr>
                                       <td>Total Credit</td>
                                <td style="text-decoration: underline;"><b>{{number_format($totalBalance,2)}}</b></td>
                                   </tr>
                                 <tr>
                                     <td>Total Cash</td>  
                                <td style="text-decoration: underline;"><b>{{number_format($totalCash,2)}}</b></td>
                                 </tr>
                                 <tr>
                                     <td>Litres Sold</td>
                                <td style="text-decoration: underline;"><b>{{number_format($litresSold,2)}}</b></td>

                                 </tr>

                            </tr>
                        </tbody>
                    </table>
                 </div>
                <?php
                /*
                <div class="col-md-2">
                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>CAR NO.  OF TRUCK</th>
                                <th>Supplier LITERS</th>
                            </tr>
                        <tbody>
                            <tr>
                                <td>Opening Stock</td>
                                <td>{{$openingStock}}</td>
                            </tr>
                            @foreach($inventory as $inv)

                            <tr>
                                <td>{{$inv->truck_number." ".$inv->driver_name}}</td>
                                <td>{{number_format($inv->litres_loaded,2)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td><b>Total Load</b></td>
                                <td style="text-decoration: underline;"><b>{{number_format($totalLoad,2)}}</b></td>
                            </tr>
                        </tbody>
                        </thead>
                    </table>


                </div>*/
                ?>
                <div class="col-md-10">
                 @if(isset($transactions))
                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>SOLD TO</th>
                                <th>Litres Loaded</th>
                                <th>Product Type</th>
                                <th>Mode Of Payment</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transactions as $transaction)
<?php
                            $bal+=$transaction->balance;
                            ?>
                            <tr>
                                <td>{{$transaction->customer_name}}</td>
                                <td>{{number_format($transaction->liters,2)}}</td>
                                <td>{{$transaction->product_type}}</td>
                                <td>{{$transaction->payment_mode}}</td>
                                <td>{{number_format($transaction->unit_price,2)}}</td>
                                <td>{{number_format($transaction->total_cost,2)}}</td>
                                <td>{{number_format($transaction->amount_paid,2)}}</td>
                                <td>{{number_format($transaction->balance,2)}}</td>
                            </tr>
                            @endforeach
                            <?php
                            /*
                            <tr>
                                <td><b>Litres Sold</b></td>
                                <td style="text-decoration: underline;"><b>{{number_format($litresSold,2)}}</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total Sales</b></td>
                                <td></td>
                                <td style="text-decoration: underline;"><b>{{number_format($totalSales,2)}}</b></td>
                                <td></td>
                                <td style="text-decoration: underline;"><b>{{number_format($totalBalance,2)}}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-decoration: underline;"><b>{{number_format($totalAmountPaid,2)}}</b></td>
                                <td> Transfer to Cash Sheet</td>
                                <td></td>
                                <td></td>
                            </tr>*/
?>
                        </tbody>
                    </table>
 {{$transactions->appends($_GET)->links()}}
            @endif
                </div>
            </div>
        </div>
  
@endsection
@section("scripts")
<?php
    //echo $a;
?>
@endsection
    