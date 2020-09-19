<div class="form-group row">
   <!-- <label for="date_modified" class="col-sm-4 col-form-label text-md-right">Date modified</label> -->

    <div class="col-md-6">
        <input id="date_modified" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date_modified" value="{{date("Y-m-d") }}" required hidden autofocus>
            @if ($errors->has('date_modified'))
                <span class="invalid-feedback">
                   <strong>{{ $errors->first('date_modifieddate') }}</strong>
                </span>
            @endif
    </div>
 </div>