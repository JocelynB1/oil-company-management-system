<?php

$bank_list = \App\TransCode::pluck( 'transaction_description','transaction_code');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('transaction_code','Transcation Code:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('transaction_code', $bank_list, $bank_list, ['class' => 'form-control'])!!}
</div>
</div>