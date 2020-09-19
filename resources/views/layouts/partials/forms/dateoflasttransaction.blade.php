<?php
/*
       <div class="form-group row">
   <label for="date_of_last_transaction" class="col-sm-4 col-form-label text-md-right">Date of entry</label>

    <div class="col-md-6">
        <input id="date_of_last_transaction" type="date" class="form-control{{ $errors->has('date_of_last_transaction') ? ' is-invalid' : '' }}" name="date_of_last_transaction" value="{{date("Y-m-d") }}" required  autofocus>
            @if ($errors->has('date_of_last_transaction'))
                <span class="invalid-feedback">
                   <strong>{{ $errors->first('date_of_last_transaction') }}</strong>
                </span>
            @endif
    </div>
 </div>

 */
?>
<div class="form-group row">
{!! Form::label('date_of_last_transaction','Date Of Last Transaction:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::date('date_of_last_transaction',date("Y-m-d"),['class'=> 'form-control']) !!}
</div>
</div>