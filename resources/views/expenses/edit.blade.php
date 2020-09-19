@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Update Expenses Category</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
                {!! Form::model($expenses, [
                    'method' => 'PATCH',
                    'route' => ['expenses.update', $expenses->id]
                ]) !!}
                
                        @csrf
                   @include('layouts.partials.forms.expensecategory')
                   @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Update Expense Category',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
