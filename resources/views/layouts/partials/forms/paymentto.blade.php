<div class="form-group row">
{!!Form::label('payment_to','Payment To:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('payment_to', ['' => ''], null, ['class' => 'form-control'])!!}
</div>
</div>
