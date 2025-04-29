@extends('layouts.master')
@section('title')
    Customers

@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">


@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Customers</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    @foreach (['Error', 'Add', 'delete', 'edit'] as $msg)
        @if (session()->has($msg))
            <div class="alert alert-{{ $msg == 'Error' || $msg == 'delete' ? 'danger' : 'success' }} alert-dismissible fade show"
                role="alert">
                <strong>{{ session()->get($msg) }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endforeach











    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">


                <div class="card-header pb-0">
@can('Add')
                    <a class="btn btn-outline-primary btn-block" href="{{ route('customer.create') }}"> Add
                        Customer </a>
  @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th> Operations </th>
                                    <th>Customer Name </th>
                                    <th>Customer Abb </th>
                                    <th>Customer type </th>
                                    <th> Logo </th>
                                    <th> Customer Contact name </th>
                                    <th> Customer contact position </th>
                                    <th>Email </th>
                                    <th>Phone</th>

                                </tr>

                            </thead>

                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($custs as $cust)
                                    <?php $i++; ?>

                                    <td>{{ $i }}</td>
                                    <td>
                                        @can('Edit')

                                        <a href="{{ route('customer.edit', $cust->id) }}" class=" btn btn-sm btn-info"><i
                                                class="las la-pen"></i></a>
                                        @endcan
                                        @can('Delete')

                                        <a class=" btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $cust->id }}" data-name="{{ $cust->name }}"
                                            data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                class="las la-trash"></i></a>
                                        @endcan
                                    </td>
                                    <td>{{ $cust->name }}</td>
                                    <td>{{ $cust->abb }}</td>
                                    <td>{{ $cust->tybe }}</td>
                                    {{-- <td>{{ $cust->custs_attachments->logo }}</td> --}}
                                    {{-- <td>{{ $cust->logo }}</td> --}}
                                    <td>

                                        <a href="{{ asset('storage/' . $cust->logo) }}" data-lightbox="gallery"
                                            height='500' width='500'>
                                            <img src="{{ asset('storage/' . $cust->logo) }}" alt="No Photo"  height="50"
                                                width="50"> </a>
                                    </td>
                                    <td>{{ $cust->customercontactname }}</td>
                                    <td>{{ $cust->customercontactposition }}</td>
                                    <td>{{ $cust->email }}</td>
                                    <td>{{ $cust->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>

                <form action="customer/destroy" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
            </div>
            </form>

        </div>
    </div>



    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>



    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var abb = button.data('abb');
            var tybe = button.data('tybe');
            var logo = button.data('logo');
            var customercontactname = button.data('customercontactname');
            var customercontactposition = button.data('customercontactposition');
            var email = button.data('email');
            var phone = button.data('phone');
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #abb').val(abb);
            modal.find('.modal-body #tybe').val(tybe);
            modal.find('.modal-body #logo').val(logo);
            modal.find('.modal-body #customercontactname').val(customercontactname);
            modal.find('.modal-body #customercontactposition').val(customercontactposition);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #abb').val(abb);

        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var name = button.data('name');
            var abb = button.data('abb');
            var tybe = button.data('tybe');
            var logo = button.data('logo');
            var customercontactname = button.data('customercontactname');
            var customercontactposition = button.data('customercontactposition');
            var email = button.data('email');
            var phone = button.data('phone');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #abb').val(abb);
            modal.find('.modal-body #tybe').val(tybe);
            modal.find('.modal-body #logo').val(logo);
            modal.find('.modal-body #customercontactname').val(customercontactname);
            modal.find('.modal-body #customercontactposition').val(customercontactposition);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #abb').val(abb);

        })
    </script>
@endsection
