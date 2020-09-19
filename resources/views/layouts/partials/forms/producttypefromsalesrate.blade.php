

<?php

$bank_list = \App\SalesRate::pluck( 'product_type','selling_rate');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('product_type','Product Name:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('product_type', $bank_list, null, ['class' => 'form-control'])!!}
</div>
</div>
