
<?php
$bank_list = \App\Expense::pluck('expense_category', 'expense_category');
$bank_list = collect(['' => ''] + $bank_list->all());
?>

<div class="form-group row">
{!!Form::label('expense_category','Expense Category:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('expense_category', $bank_list, null, ['class' => 'form-control'])!!}
</div>
</div>