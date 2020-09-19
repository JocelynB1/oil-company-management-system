<?php
/*
<div class="form-group row">
    <label for="sales_date" class="col-sm-4 col-form-label text-md-right">Sales Date</label>

    <div class="col-md-6">
        <input id="sales_date" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="sales_date" value="{{date("Y-m-d") }}" required autofocus>
            @if ($errors->has('sales_date'))
                <span class="invalid-feedback">
                   <strong>{{ $errors->first('sales_date') }}</strong>
                </span>
            @endif
    </div>
 </div>
 */
?>
<div class="form-group row">
{!! Form::label('sales_date','Sales Date:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::date('sales_date',date("Y-m-d"),['class'=> 'form-control']) !!}
</div>
</div>