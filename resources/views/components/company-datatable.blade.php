@push('styles')

@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#company-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('companies.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    <!-- Add other columns as needed -->
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush

<div class="table-responsive">
    <table class="table table-bordered" id="company-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <!-- Add other headers as needed -->
            <th>Action</th>
        </tr>
        </thead>
    </table>
</div>
