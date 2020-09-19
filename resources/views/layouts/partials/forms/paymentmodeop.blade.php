<?php

$bank_list = \App\PaymentMode::pluck('payment_mode', 'payment_mode');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('payment_mode','Payment Mode:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('payment_mode', $bank_list, [null=>'Please Select'], ['class' => 'form-control'])!!}
</div>
</div>