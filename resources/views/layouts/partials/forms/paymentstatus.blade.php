<div class="form-group row">
     {!! Form::label('payment_status','Payment Status:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}

<div class="col-md-6">
{!!Form::select('payment_status', 
[
 '' => '',
"Full"=>"Full",
"Part"=>"Part"
], 0, ['class' => 'form-control'])!!}
</div>
</div>