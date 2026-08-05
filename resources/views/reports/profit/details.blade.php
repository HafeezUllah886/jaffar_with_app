@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-success ml-4"><i class="ri-whatsapp-line mr-4"></i> Whatsapp</a>
                                <a href="{{ route('reportProfitPrint', [$from, $to]) }}" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Profit / Loss Report</h3>
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
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0"  id="buttons-datatables">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col" class="text-start">Product</th>
                                                <th scope="col" class="text-start">Category</th>
                                                <th scope="col" class="text-end">Avg Purchase Rate</th>
                                                <th scope="col" class="text-end">Avg Sale Price</th>
                                                <th scope="col" class="text-end">Sold Qty</th>
                                                <th scope="col" class="text-end">Profit / Unit</th>
                                                <th scope="col" class="text-end">Profit</th>
                                                <th scope="col" class="text-end">Stock</th>
                                                <th scope="col" class="text-end">Stock Value</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @php
                                                $total = 0;
                                                $totalPR = 0;
                                                $totalSP = 0;
                                                $totalS = 0;
                                                $totalStock = 0;
                                                $totalValue = 0;
                                                $totalPPU = 0;
                                            @endphp
                                        @foreach ($data as $key => $item)
                                        @php
                                            $total += $item['profit'];
                                            $totalPR += $item['purchaseRate'];
                                            $totalSP += $item['saleRate'];
                                            $totalS += $item['sold'];
                                            $totalStock += $item['stock'];
                                            $totalValue += $item['stockValue'];
                                            $totalPPU += $item['ppu'];
                                        @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td class="text-start">{{ $item['name'] }}</td>
                                                <td class="text-start">{{ $item['cat'] }}</td>
                                                <td class="text-end">{{ number_format($item['purchaseRate'],2) }}</td>
                                                <td class="text-end">{{ number_format($item['saleRate'],2) }}</td>
                                                <td class="text-end">{{ number_format($item['sold'],2) }}</td>
                                                <td class="text-end">{{ number_format($item['ppu'],2) }}</td>
                                                <td class="text-end">{{ number_format($item['profit'],2) }}</td>
                                                <td class="text-end">{{ number_format($item['stock'],2) }}</td>
                                                <td class="text-end">{{ number_format($item['stockValue'],2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total</th>
                                                <th class="text-end">{{number_format($totalPR, 2)}}</th>
                                                <th class="text-end">{{number_format($totalSP, 2)}}</th>
                                                <th class="text-end">{{number_format($totalS, 2)}}</th>
                                                <th class="text-end">{{number_format($totalPPU, 2)}}</th>
                                                <th class="text-end">{{number_format($total, 2)}}</th>
                                                <th class="text-end">{{number_format($totalStock, 2)}}</th>
                                                <th class="text-end">{{number_format($totalValue, 2)}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="text-end">Expense</th>
                                                <th class="text-end">{{number_format($expenses, 2)}}</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="text-end">Net Profit</th>
                                                <th class="text-end">{{number_format($total - $expenses, 2)}}</th>
                                                <th></th>
                                                <th></th>
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
@endsection



