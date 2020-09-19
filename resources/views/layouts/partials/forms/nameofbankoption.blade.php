<?php

$bank_list = \App\BankAccount::pluck('bank_name', 'bank_name');
$thereAreNoBanks=empty($bank_list->all());
if($thereAreNoBanks){
    $default=['' => 'No Bank Accounts have been set up!'];
}else{
    $default=['' => ''];
}

$bank_list = collect($default + $bank_list->all());
?>

<div class="form-group row" id="bank_name_div">

{!! Form::label('bank_name','Bank Name:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('bank_name', $bank_list, 0, ['class' => 'form-control'])!!}
</div>
</div>
