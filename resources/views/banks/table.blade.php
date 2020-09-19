@extends('layouts.app')
@section('content')
{!! $dataTable->table() !!}
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script>
    $(function() {
        $('#bank-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('bankdatatable.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
              
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' }
            ]
        });
    });
    </script>
{!! $dataTable->scripts() !!}
@endpush
