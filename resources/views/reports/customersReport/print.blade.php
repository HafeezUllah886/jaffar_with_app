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
                                        <h1>JAFFAR & BROTHERS</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Customers CNIC Report</h3>
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
                                                <th scope="col" class="text-start">Contact</th>
                                                <th scope="col" class="text-start">Address</th>
                                                <th scope="col" class="text-start">CNIC</th>
                                                <th scope="col" class="text-start">NTN</th>
                                                <th scope="col" class="text-start">STRN</th>
                                                <th scope="col" class="text-start">Category</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                        @foreach ($accounts as $key => $account)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td class="text-start">{{ $account->title }}</td>
                                                <td class="text-start">{{ $account->contact }}</td>
                                                <td class="text-start">{{ $account->address }}</td>
                                                <td class="text-start">{{ $account->cnic }}</td>
                                                <td class="text-start">{{ $account->ntn }}</td>
                                                <td class="text-start">{{ $account->strn }}</td>
                                                <td class="text-start">{{ $account->c_type }}</td>
                                               
                                            </tr>
                                        @endforeach
                                        </tbody>
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



