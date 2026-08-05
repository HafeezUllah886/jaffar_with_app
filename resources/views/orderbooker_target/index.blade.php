@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{route('orderbooker_targets.index')}}" method="get">
                <div class="row">
                    <div class="col-3">
                        <select name="orderbookerID" class="form-control">
                            <option value="All" {{ $orderbookerID == "All" ? "selected" : "" }}>All</option>
                            @foreach ($orderbookers as $orderbooker)
                                <option value="{{ $orderbooker->id }}" {{ $orderbookerID == $orderbooker->id ? "selected" : "" }}>{{ $orderbooker->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select name="status" class="form-control">
                            <option value="All" {{ $status == "All" ? "selected" : "" }}>All</option>
                            <option value="Pending" {{ $status == "Pending" ? "selected" : "" }}>Pending</option>
                            <option value="Completed" {{ $status == "Completed" ? "selected" : "" }}>Completed</option>
                            <option value="Failed" {{ $status == "Failed" ? "selected" : "" }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between">
                    <h3>Order Booker Targets</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Create New</button>
                </div>
                <div class="card-body">
                    <table class="table" id="buttons-datatables">
                        <thead>
                            <th>#</th>
                            <th>Orderbooker</th>
                            <th>Total Target</th>
                            <th>Achieved</th>
                            <th>Percent</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($targets as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->orderbooker->name }}</td>
                                    <td>{{ number_format($item->target,2) }}ltr</td>
                                    <td>{{ number_format($item->achieved,2) }}ltr</td>
                                    <td>{{ number_format($item->achieved / $item->target * 100,2) }}%</td>
                                    <td>{{ date('d M Y', strtotime($item->start_date)) }} <br>{{ date('d M Y', strtotime($item->end_date)) }}</td>
                                    <td>
                                        @if ($item->status == "Pending")
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($item->status == "Completed")
                                            <span class="badge bg-success">Completed</span>
                                        @elseif ($item->status == "Failed")
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item text-danger" href="{{route('orderbooker_target.delete', $item->id)}}">
                                                        <i class="ri-delete-bin-2-fill align-bottom me-2 text-danger"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Default Modals -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Target</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('orderbooker_targets.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="orderbooker_id">Orderbooker</label>
                            <select name="orderbookerID" id="orderbooker_id" required class="form-control">
                                <option value="">Select Orderbooker</option>
                                @foreach ($orderbookers as $orderbooker)
                                    <option value="{{ $orderbooker->id }}">{{ $orderbooker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="target">Target</label>
                            <div class="input-group">
                                <input type="number" name="target" required step="any" min="1" id="target" class="form-control">
                                <span class="input-group-text">ltr</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" name="startDate" id="startDate" value="{{date('Y-m-d')}}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" name="endDate" id="endDate" value="{{date('Y-m-d')}}" required class="form-control">
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
            </div>
        </div>
    </div>    
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
@endsection

@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script>
        $(".selectize").selectize();
    </script>
@endsection
