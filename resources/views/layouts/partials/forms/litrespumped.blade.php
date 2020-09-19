<?php
/*
<div class="form-group row">
    <label for="litres" class="col-md-4 col-form-label text-md-right">Litres Pumped </label>

    <div class="col-md-6">
        <input id="litres" type="number" class="form-control{{ $errors->has('litres') ? ' is-invalid' : '' }}" name="liters" value="{{ 0 }}" required autofocus>
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('litres') }}</strong>
                </span>
            @endif
    </div>
</div>
*/
?>
<div class="form-group row">
{!! Form::label('litres_pumped','Litres Pumped:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('litres_pumped',null,['class'=> 'form-control']) !!}
</div>
</div>