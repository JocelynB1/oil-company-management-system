<?php

$bank_list = \App\Status::pluck( 'Description','id');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('description','Status Description:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('description', $bank_list,null, ['class' => 'form-control'])!!}
</div>
</div>