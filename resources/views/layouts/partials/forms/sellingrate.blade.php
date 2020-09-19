<?php
/*
<div class="form-group row">
    <label for="selling_rate" class="col-md-4 col-form-label text-md-right">Selling Rate </label>

    <div class="col-md-6">
        <input id="selling_rate" type="number" class="form-control{{ $errors->has('selling_rate') ? ' is-invalid' : '' }}" name="selling_rate" value="{{ 0 }}" required autofocus>
            @if ($errors->has('selling_rate'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('selling_rate') }}</strong>
                </span>
            @endif
    </div>
</div>
*/
?>

<div class="form-group row">
{!! Form::label('selling_rate','Selling Rate:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('selling_rate',null,['class'=> 'form-control']) !!}
</div>
</div>