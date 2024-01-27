@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2>Create Employee</h2>
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">First Name:</label>
                <input type="text" name="first_name" class="form-control" value="{{ $employee->first_name }}" required>
            </div>
            <div class="form-group">
                <label for="name">Last Name:</label>
                <input type="text" name="last_name" class="form-control" value="{{ $employee->last_name }}" required>
            </div>

            <div class="form-group">
                <label for="company_id" class="form-label">Company</label>
                <select class="form-select" id="company_id" name="company_id" required>
                    <option value="" selected disabled>Select a company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $employee->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="{{ $employee->email }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="website">Phone:</label>
                <input type="number" name="phone" value="{{ $employee->phone }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
