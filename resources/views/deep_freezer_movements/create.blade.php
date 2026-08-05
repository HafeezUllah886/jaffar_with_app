@extends('layout.popups')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Create Movement</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('deep_freezer_movements.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mt-2">
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->title }} ({{ $customer->contact }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="deep_freezer_id">Deep Freezer</label>
                                <select name="deep_freezer_id" id="deep_freezer_id" class="form-control" required>
                                    <option value="">Select Deep Freezer</option>
                                    @foreach($freezers as $freezer)
                                        <option value="{{ $freezer->id }}">{{ $freezer->code }} - {{ $freezer->type }} ({{ $freezer->status }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="type">Movement Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="Issue">Issue / Dispatch</option>
                                    <option value="Collect">Collect</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="date">Date</label>
                                <input type="date" name="date" id="date" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="vehicleNo">Vehicle Num</label>
                                <input type="text" name="vehicleNo" id="vehicleNo" class="form-control">
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="driver">Driver Name</label>
                                <input type="text" name="driver" id="driver" class="form-control">
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="doc_no">Doc Number</label>
                                <input type="text" name="doc_no" id="doc_no" class="form-control">
                            </div>
                            <div class="col-md-6 form-group mt-2">
                                <label for="reason">Movement Reason</label>
                                <input type="text" name="reason" id="reason" class="form-control" placeholder="e.g. Dispatch : New Customer">
                            </div>
                            <div class="col-12 form-group mt-2">
                                <label for="remarks">Remarks (Optional)</label>
                                <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Save Movement</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
