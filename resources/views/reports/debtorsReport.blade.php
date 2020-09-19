
@extends('layouts.app')
@section('content')

<div class="container">
             
                <div class="row">
                    <div class="col-auto">
                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",
                    'action'=>'DisplayRecordsController@displayDebtorsReport'
                    ])!!}
                    @csrf

                    <div class="col-auto" style="display:none">
                        {!!Form::text('export',null, ['class' => 'form-control'])!!}
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Export</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <h1>List Of Current Debtors</h1>
                </div>
            </div><br><br>
            <div class="row">
                <div class="col-auto">
                 @if(isset($custAccss))
                <table class="table table-striped table-borded table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                    <th>Transaction Date</th>
                            <th>Customer Name</th>
                            <th>Customer Number</th>
                            <th>Balance</th>
                                </tr>
                    </thead>

                    <tbody>
                        @foreach($custAccss as $custAccs)
                        <tr>
                              <td>
                                 <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$custAccs['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                               
                                {{$custAccs['transaction_date']}}
                                 </a>
                            </td>                                        
                            
                            <td>
                                 <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$custAccs['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                               
                                {{$custAccs['customer_name']}}
                                 </a>
                            </td>

<td>
                                 <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$custAccs['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                               
                                {{$custAccs['customer_number']}}
                                 </a>
                            </td>

                            <td>
                                 <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$custAccs['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                               
                                {{number_format($custAccs['balance'],2)}}
                                 </a>
                                </td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$custAccss->appends($_GET)->links()}}
            @endif
 
                </div>
            </div>
        

@endsection
