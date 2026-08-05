@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Customers Balance Report</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end card-header-->
                        </div><!--end col-->

                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0" id="datatables">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col" class="text-start">Title</th>
                                                <th scope="col" class="text-start">Category</th>
                                                <th scope="col" class="text-start">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                        @foreach ($accounts as $key => $account)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td class="text-start">{{ $account->title }}</td>
                                                <td class="text-start">{{ $account->c_type }}</td>
                                                <td class="text-end">{{ number_format($account->balance,2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-end" colspan="3">Total</th>
                                                <th class="text-end">{{number_format($accounts->sum('balance'),0)}}</th>
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
<script>
    setTimeout(() => {
        window.print();
        window.history.back();
    }, 1000);
</script>


