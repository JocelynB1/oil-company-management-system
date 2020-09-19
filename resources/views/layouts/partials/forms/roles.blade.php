
<div class="form-group row">
    <label for="Description" class="col-md-4 col-form-label text-md-right">Description </label>

    <div class="col-md-6">
    <?php
$roles=\App\Role::get();

$select = <<<_select
                <select name="Description"  class="form-control" id="Description">
                    <option/ selected>
_select;
$roleLength=count($roles)-1;

if(count($roles) > 0)
{
foreach($roles as $role){
    $role_id =$role->id;
    $desc = $role->Description;
$option = <<<_option
<option value="{$role_id}">{$desc}</option>
_option;

$select.=$option;

}
}


$select.="</select>";
echo $select;

?>
            @if ($errors->has('role'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
    </div>
</div>

