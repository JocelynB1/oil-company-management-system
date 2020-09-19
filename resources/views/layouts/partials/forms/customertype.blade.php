
<?php
$customertype = [
    '' => '',
"customer"=>"Customer",
"supplier"=>"Supplier",
"employee"=>"Staff",
"guest"=>"Non Staff"
];
?>

<div class="form-group row">
{!!Form::label('customer_type','Customer Type:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('customer_type', $customertype, null, ['class' => 'form-control'])!!}
</div>
</div>