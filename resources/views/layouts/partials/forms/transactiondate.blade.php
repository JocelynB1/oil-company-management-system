<div class="form-group row">
        {!! Form::label('transaction_date','Transaction Date:',['class'=>
        'col-md-4 col-form-label text-md-right']) !!}
        <div class="col-md-6">
        {!! Form::date('transaction_date',date("Y-m-d") ,['class'=> 'form-control']) !!}
        </div>
        </div>