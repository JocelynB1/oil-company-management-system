<?php

$bank_list = \App\Supplier::pluck( 'supplier_name','supplier_number');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('supplier_name_and_number','Supplier name :',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('supplier_name_and_number', $bank_list, null, ['class' => 'form-control'])!!}
</div>
</div>