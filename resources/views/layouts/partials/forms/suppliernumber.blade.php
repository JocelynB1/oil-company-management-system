<?php
$customer=\App\Supplier::orderBy('id','desc')->get(['id']);
if(!isset($customer[0])){
    $idString=1;
}else
{
    $idString=(string)($customer[0]->id+1);
}

$accountNumLength=4;
$sizeOfId=count($idString);
$numberOfZerosNeeded=$accountNumLength-$sizeOfId;
$padding="";
for($i=0;$i<$numberOfZerosNeeded;$i++){
    $padding.="0";
}

$customer_number="S".$padding.$idString;

?>

<div class="form-group row">
{!! Form::label('supplier_number','Supplier Number:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('supplier_number',$customer_number,['class'=> 'form-control']) !!}
</div>
</div>
