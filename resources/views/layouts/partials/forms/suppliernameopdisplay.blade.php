<?php

$bank_list = \App\Supplier::pluck( 'supplier_name','supplier_name');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('supplier_name_display','Supplier name :',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('supplier_name_display', $bank_list, $bank_list, ['class' => 'form-control'])!!}
</div>
</div>