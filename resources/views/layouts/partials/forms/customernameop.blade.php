
<?php
$bank_list = \App\Customer::pluck('customer_name', 'customer_name');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('customer_name','Customer Name:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('customer_name', $bank_list, null, ['class' => 'form-control'])!!}
</div>
</div>
