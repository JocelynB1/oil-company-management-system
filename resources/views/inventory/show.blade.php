@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">View Record</div>
                <div class="card-body">

                    <table class="table table-striped table-responsive">
<thead>
<tr>
      <th>Supplier Name</th>
      <th>Truck Number</th>
      <th>Driver Name</th>
      <th>Driver Phone</th>
      <th>Product Type</th>
      <th>Litres Loaded</th>
      <th>Entry By</th>
      <th>Modified By</th>
    </tr>
</thead>
<tbody>
<tr >
<td>
{{ $inventory->supplier_name }}
</td>
<td>
{{ $inventory->truck_number}}
</td>
<td>
{{ $inventory->driver_name}}
</td>
<td>
 {{ $inventory->driver_phone}}
 </td>
<td>
{{ $inventory->product_type}}
</td>
<td>
{{ $inventory->litres_loaded}}
</td>
<td>
{{ $inventory->created_by}}
</td>
 <td>
 {{ $inventory->modified_by}}
 </td>        
</tr>

<tbody>
</table>


<br><br><br>
<a href="{{ route('inventory.index') }}" class="btn btn-info">Back to all Inventory</a>
<a href="{{ route('inventory.edit', $inventory->id) }}"  class="btn btn-primary">edit</a>



</div>
</div>
</div>
</div>
</div>
</div>

@stop