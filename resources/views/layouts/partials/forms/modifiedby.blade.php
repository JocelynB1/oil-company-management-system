<?php
/*

{!! Form::label('modified_by','Modified By:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}

*/
?>
<div class="form-group row">
<div class="col-md-6">
{!! Form::hidden('modified_by',\Auth::user()->name,['class'=> 'form-control']) !!}
</div>
</div>