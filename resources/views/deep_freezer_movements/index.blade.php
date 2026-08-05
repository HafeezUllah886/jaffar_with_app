@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Deep Freezer Movements</h3>
                    <button class="btn btn-primary" onclick="newWindow('{{ route('deep_freezer_movements.create') }}')">Create New Movement</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Deep Freezer Code</th>
                            <th>Type</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($movements as $key => $movement)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('d-M-Y', strtotime($movement->date)) }}</td>
                                    <td>{{ $movement->customer->title ?? 'N/A' }}</td>
                                    <td>{{ $movement->deep_freezer->code ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $movement->type == 'Issue' ? 'success' : 'warning' }}">{{ $movement->type }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="newWindow('{{ route('deep_freezer_movements.print', $movement->id) }}')">Print PDF</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
