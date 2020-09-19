<?php

$bank_list = \App\Status::pluck( 'description','description');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('status','Approval Status:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('status', $bank_list, null, ['class' => 'form-control'])!!}
</div>
</div>