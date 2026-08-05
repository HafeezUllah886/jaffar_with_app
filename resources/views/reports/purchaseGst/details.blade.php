@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-success ml-4"><i class="ri-whatsapp-line mr-4"></i> Whatsapp</a>
                                <a href="{{ route('reportPurchasesGstPrint', [$from, $to]) }}" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Purchases GST Report</h3>
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
                                                <th scope="col" style="width: 50px;">Inv #</th>
                                                <th scope="col" class="text-start">Vendor Name</th>
                                                <th scope="col">Bill Date</th>
                                                <th scope="col">Tax Exc</th>
                                                <th scope="col">Bill Amount (RP)</th>
                                                <th scope="col" class="text-end">GST (18%)</th>
                                                <th scope="col" class="text-end">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @php
                                                $totalGst = 0;
                                                $totalQty = 0;
                                                $totalTe = 0;
                                                $totalBA = 0;
                                            @endphp

                                        @foreach ($purchases as $key => $item)
                                        @php
                                                $gst = $item->details->sum('gstValue');
                                                $qty = $item->details->sum('qty');
                                                $bonus = $item->details->sum('bonus');
                                                $ba = $item->totalBill;
                                                $te = $ba - $gst;
                                                $totalGst += $gst;
                                                $totalQty += ($qty + $bonus);
                                                $totalTe += $te;
                                                $totalBA += $ba;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->id}}</td>
                                                <td class="text-start">{{ $item->vendor->title }}</td>
                                                <td>{{ date("d M Y", strtotime($item->date))}}</td>
                                                <td class="text-end">{{ number_format($te, 2) }}</td>
                                                <td class="text-end">{{ number_format($ba, 2) }}</td>
                                                <td class="text-end">{{ number_format($gst, 2) }}</td>
                                                <td class="text-end">{{ number_format($qty + $bonus, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total</th>
                                                <th class="text-end">{{number_format($totalTe, 2)}}</th>
                                                <th class="text-end">{{number_format($totalBA, 2)}}</th>
                                                <th class="text-end">{{number_format($totalBA * 18 / 100, 2)}}</th>
                                                <th class="text-end">{{number_format($totalQty, 2)}}</th>
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

        // Total for Tax Exc column
        var totalTaxExc = api
            .column(3, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for Bill Amount (RP) column
        var totalBillAmount = api
            .column(4, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for GST (18%) column
        var totalGst = api
            .column(5, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for Qty column
        var totalQty = api
            .column(6, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Update the footer
        $(api.column(3).footer()).html(totalTaxExc.toFixed(2));
        $(api.column(4).footer()).html(totalBillAmount.toFixed(2));
        $(api.column(5).footer()).html(totalGst.toFixed(2));
        $(api.column(6).footer()).html(totalQty.toFixed(2));
    },
});
    </script>
@endsection



