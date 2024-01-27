@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Companies</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add</a><br/><br/>
        <table class="table" id="company-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function () {
            $('#company-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('companies.index') }}",
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'name', name: 'name' },
                            { data: 'email', name: 'email' },
                            {
                                data: 'logo',
                                name: 'logo',
                                render: function (data, type, full, meta) {
                                    return '<img src="{{ asset('storage/') }}/' + data + '" alt="Logo" width="50" height="50"/>';
                                }
                            },
                            { data: 'website', name: 'website' },
                            {
                                data: 'id',
                                name: 'actions',
                                render: function (data, type, full, meta) {
                                    return '<a href="{{ url('admin/companies') }}/' + data + '/edit" class="btn btn-primary">Edit</a>&nbsp;' +
                                        '<button data-id="' + data + '" class="btn btn-danger delete-company" onclick="confirmDelete(' + data + ')">Delete</button>';
                                }
                            },
                        ],
                    });
                });
        </script>
        <script>
            function confirmDelete(companyId) {
                if (confirm('Are you sure you want to delete this company?')) {
                    var deleteUrl = '{{ route('companies.destroy', ':id') }}';
                    deleteUrl = deleteUrl.replace(':id', companyId);

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            $('#company-table').DataTable().ajax.reload();
                            alert('Company deleted successfully.');
                        },
                        error: function (xhr, status, error) {
                            alert('Error deleting company. Please try again.');
                        }
                    });
                }
            }
        </script>
    @endpush
@endsection
