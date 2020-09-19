<?php

$list = \App\Inventory::pluck( 'supplier_name','supplier_number');

if($list->isEmpty()){
    $list = collect([""=>"Inventory is Empty!"]);    
}else{
$list = collect(['' => ''] + $list->all());
}
?>

<div class="form-group row">
{!!Form::label('supplier_name_from_inventory','Supplier name :',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('supplier_name_from_inventory', $list, null, ['class' => 'form-control'])!!}
</div>
</div>