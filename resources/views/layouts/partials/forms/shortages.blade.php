<?php
/*
<div class="form-group row">
    <label for="shortages" class="col-md-4 col-form-label text-md-right">Shortages </label>

    <div class="col-md-6">
        <input id="shortages" type="text" class="form-control{{ $errors->has('shortages') ? ' is-invalid' : '' }}" name="shortages" value="" required autofocus>
            @if ($errors->has('shortagesname'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('shortages') }}</strong>
                </span>
            @endif
    </div>
</div>

*/
?>
<div class="form-group row">
{!! Form::label('shortages','Shortages:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('shortages',0,['class'=> 'form-control']) !!}
</div>
</div>