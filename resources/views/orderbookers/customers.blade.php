@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>Assign Customers to {{ $orderbooker->name }}</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form action="{{ route('orderbooker.customers.assign', $orderbooker->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="customer_id">Select Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control" required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach($unassignedCustomers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->title }} ({{ $customer->contact }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Assign Customer</button>
                        </div>
                    </div>
                </form>

                <h4>Assigned Customers</h4>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignedCustomers as $key => $customer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $customer->title }}</td>
                                <td>{{ $customer->contact }}</td>
                                <td>
                                    <a href="{{ route('orderbooker.customers.remove', ['id' => $orderbooker->id, 'customer_id' => $customer->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this customer?')">Remove</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No customers assigned yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('orderbooker.index') }}" class="btn btn-secondary">Back to Order Bookers</a>
            </div>
        </div>
    </div>
</div>
@endsection
