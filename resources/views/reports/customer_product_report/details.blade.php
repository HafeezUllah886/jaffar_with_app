@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-success ml-4"><i class="ri-whatsapp-line mr-4"></i> Whatsapp</a>
                                <a href="{{ route('reportCustomerProductsPrint', [$from, $to, $customer->id]) }}" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Customer Wise Product Report</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end card-header-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">From</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($from)) }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">To</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($to)) }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Customer</p>
                                        <h5 class="fs-14 mb-0">{{ $customer->title }}</h5>
                                    </div>
                                    <!--end col-->
                                    <!--end col-->
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Printed On</p>
                                        <h5 class="fs-14 mb-0"><span id="total-amount">{{ date("d M Y") }}</span></h5>
                                        {{-- <h5 class="fs-14 mb-0"><span id="total-amount">{{ \Carbon\Carbon::now()->format('h:i A') }}</span></h5> --}}
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0" id="datatables">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col" class="text-start">Product</th>
                                                <th scope="col" class="text-start">Avg Price</th>
                                                <th scope="col" class="text-start">Avg TP</th>
                                                <th scope="col" class="text-start">Qty Sold</th>
                                                <th scope="col" class="text-start">Total Volume</th>
                                                <th scope="col" class="text-start">Bonus</th>
                                                <th scope="col" class="text-start">Discounts</th>
                                                <th scope="col">Total GST</th>
                                                <th scope="col">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @php
                                                
                                                $total_volume = 0;
                                            @endphp

                                        @foreach ($salesDetails as $key => $product)
                                        @php
                                            $total_volume += $product->total_qty * $product->product->volume;
                                        @endphp
                                            <tr>
                                                <td>{{ $key+1}}</td>
                                                <td class="text-start">{{ $product->product->name }}</td>
                                                <td class="text-start">{{ number_format($product->avg_price,2) }}</td>
                                                <td class="text-start">{{ number_format($product->avg_tp,2) }}</td>
                                                <td class="text-start">{{ number_format($product->total_qty) }}</td>
                                                <td class="text-end">{{ ml_to_ltr($product->total_qty * $product->product->volume) }}</td>
                                                <td class="text-end">{{ number_format($product->total_bonus) }}</td>
                                                <td class="text-end">{{ number_format($product->total_discount) }}</td>
                                                <td class="text-end">{{ number_format($product->total_gst, 2) }}</td>
                                                <td class="text-end">{{ number_format($product->total_ti, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-end">Total</th>
                                                <th class="text-end">{{ml_to_ltr($total_volume)}}</th>
                                                <th class="text-end">{{number_format($salesDetails->sum('total_bonus'), 2)}}</th>
                                                <th class="text-end">{{number_format($salesDetails->sum('total_discount'), 2)}}</th>
                                                <th class="text-end">{{number_format($salesDetails->sum('total_gst'), 2)}}</th>
                                                <th class="text-end">{{number_format($salesDetails->sum('total_ti'), 2)}}</th>
                                            </tr>
                                        </tfoot>
                                    </table><!--end table-->
                                </div>
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
@endsection
@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
<!--datatable responsive css-->
<link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js')}}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <script>
        $('#datatables').DataTable({
    responsive: false,
    dom: 'Bfrtip',
    buttons: ['print', 'excel', 'pdf'],
    footerCallback: function (row, data, start, end, display) {
        var api = this.api();

        // Helper function to get integer or float from string
        var intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };

        // Total for Bill Amount (RP) column
        var totalBillAmount = api
            .column(6, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for GST (18%) column
        var totalGst = api
            .column(7, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
        var totalTi = api
            .column(8, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

      

        // Update the footer
        $(api.column(6).footer()).html(totalBillAmount.toFixed(2));
        $(api.column(7).footer()).html(totalGst.toFixed(2));
        $(api.column(8).footer()).html(totalTi.toFixed(2));
    },
});
    </script>
@endsection


