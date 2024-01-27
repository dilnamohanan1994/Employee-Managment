@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Employees</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add</a><br/><br/>
        <table class="table" id="employees-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
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
            $('#employees-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('employees.index') }}",
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'first_name', name: 'first_name' },
                            { data: 'last_name', name: 'last_name' },
                            { 
                                data: 'company.name',  
                                name: 'company.name', 
                            },
                            { data: 'email', name: 'email' },
                            { data: 'phone', name: 'phone' },
                            {
                                data: 'id',
                                name: 'actions',
                                render: function (data, type, full, meta) {
                                    return '<a href="{{ url('admin/employees') }}/' + data + '/edit" class="btn btn-primary">Edit</a>&nbsp;' +
                                        '<button data-id="' + data + '" class="btn btn-danger delete-company" onclick="confirmDelete(' + data + ')">Delete</button>';
                                }
                            },
                        ],
                    });
                });
        </script>
        <script>
            function confirmDelete(employeeId) {
                if (confirm('Are you sure you want to delete this employee?')) {
                    var deleteUrl = '{{ route('employees.destroy', ':id') }}';
                    deleteUrl = deleteUrl.replace(':id', employeeId);

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            $('#employees-table').DataTable().ajax.reload();
                            alert('employee deleted successfully.');
                        },
                        error: function (xhr, status, error) {
                            alert('Error deleting employee. Please try again.');
                        }
                    });
                }
            }
        </script>
    @endpush
@endsection
