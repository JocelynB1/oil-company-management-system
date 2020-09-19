<?php

$bank_list = \App\Bank::pluck('bank_name', 'bank_name');
$bank_list = collect(['' => ''] + $bank_list->all());
?>


<div class="form-group row">

{!! Form::label('transfer_bank','Bank Name:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('transfer_bank', $bank_list, $bank_list, ['class' => 'form-control'])!!}
</div>
</div>