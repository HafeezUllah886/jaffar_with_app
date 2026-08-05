@extends('layout.popups')
@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                            <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-success ml-4"><i
                                    class="ri-whatsapp-line mr-4"></i> Whatsapp</a>
                            <a href="javascript:window.print()" class="btn btn-success ml-4"><i
                                    class="ri-printer-line mr-4"></i> Print</a>
                        </div>
                        <div class="card-header border-bottom-dashed p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h1>{{ projectName() }}</h1>
                                </div>
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h3>Daily Load Sheet</h3>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Order Booker</p>
                                    <h5 class="fs-14 mb-0">{{ implode(', ', $orderbookers) }}</h5>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                    <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($salesData['date'])) }}</h5>
                                </div>
                                <!--end col-->
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Printed On</p>
                                    <h5 class="fs-14 mb-0"><span id="total-amount">{{ date('d M Y') }}</span></h5>
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
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col" class="text-start">Product</th>
                                            <th scope="col" class="text-start">Category</th>
                                            <th scope="col" class="text-end">Total Ltrs</th>
                                            <th scope="col" class="text-end">Quantity</th>
                                            <th scope="col" class="text-end">CTN / Boxes</th>
                                            <th scope="col" class="text-end">Amount</th>
                                            {{--   <th scope="col" class="text-end">Amount</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                            $total_ctn = 0;
                                            $total_amount = 0;
                                            $total_volume = 0;
                                        @endphp
                                        @foreach ($salesData['sale_details'] as $key => $productDetails)
                                            @php
                                                $total_qty += $productDetails['total_qty'];
                                                $total_ctn +=
                                                    $productDetails['total_qty'] / $productDetails['pack_size'];
                                                $total_amount += $productDetails['total_amount'];
                                                $total_volume +=
                                                    $productDetails['total_qty'] * $productDetails['volume'];
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-start">{{ $productDetails['name'] }}</td>
                                                <td class="text-start">{{ $productDetails['cat'] }}</td>
                                                <td class="text-end">
                                                    {{ ml_to_ltr($productDetails['total_qty'] * $productDetails['volume']) }}
                                                </td>
                                                <td class="text-end">{{ $productDetails['total_qty'] }}</td>

                                                <td class="text-end">
                                                    {{ number_format($productDetails['total_qty'] / $productDetails['pack_size'], 2) }}
                                                    {{ $productDetails['pack_size'] > 1 ? 'Box' : 'Nos' }}</td>
                                                <td class="text-end">
                                                    {{ number_format($productDetails['total_amount'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total</th>
                                            <th class="text-end">{{ ml_to_ltr($total_volume) }}</th>
                                            <th class="text-end">{{ number_format($total_qty, 2) }}</th>
                                            <th class="text-end">{{ number_format($total_ctn, 2) }}</th>
                                            <th class="text-end">{{ number_format($total_amount, 2) }}</th>
                                        </tr>
                                        <tr>
                                            @php
                                                $whTax = $sales->sum('whValue');
                                                $net = $total_amount + $whTax;
                                            @endphp
                                            <th colspan="6" class="text-end">WH Tax</th>
                                            <th class="text-end">{{ number_format($whTax, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-end">Net</th>
                                            <th class="text-end">{{ number_format($net, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table><!--end table-->

                            </div>
                            <div class="row">
                                @foreach ($sales->groupBy('customerID') as $customerSales)
                                    @php
                                        $customer = $customerSales->first()->customer;
                                        $total = $customerSales->sum(function ($sale) {
                                            return $sale->details->sum('ti') + $sale->whValue;
                                        });
                                    @endphp
                                    <div class="col-6">
                                        <h5 class="fs-14 mb-0"><span>{{ $customer->title }}
                                                (Rs {{ number_format($total, 2) }})
                                            </span></h5>
                                    </div>
                                @endforeach

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
@endsection
