@extends('layouts.master')
@section('title')
    قائمة الفواتير
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('update_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تعديل الفاتورة بنجاح",
                    type: "primary"
                })
            }
        </script>
    @endif
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-sm-5 col-md-3 col-xl-2">
                            @can('اضافة فاتورة')
                            <a class="modal-effect btn btn-outline-primary btn-block" href="invoices/create">
                                <i class="fas fa-plus"></i>&nbsp; اضافة فاتورة
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الأستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الأجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">الملاحظات</th>
                                <th class="border-bottom-0" >العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0  ?>
                            @foreach($invoices as $invoice)
                                    <?php $i ++ ?>

                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $invoice -> invoice_number }}</td>
                                    <td>{{ $invoice -> invoice_Date}}</td>
                                    <td>{{ $invoice -> Due_date}}</td>
                                    <td>{{ $invoice -> product}}</td>
                                    <td> <a href="{{ url('InvoicesDetails') }}/{{ $invoice->id}}">{{ $invoice -> section -> section_name}}</a></td>
                                    <td>{{ $invoice -> Discount}}</td>
                                    <td>{{ $invoice -> Rate_VAT}}</td>
                                    <td>{{ $invoice -> Value_VAT}}</td>
                                    <td>{{ $invoice -> Total}}</td>
                                    <td>
                                        @if($invoice -> Value_Status == 1)
                                            <span class="text-success">{{ $invoice -> Status }}</span>
                                        @elseif($invoice -> Value_Status == 3)
                                            <span class="text-warning">{{ $invoice -> Status }}</span>
                                        @else()
                                            <span class="text-danger">{{ $invoice -> Status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice -> note}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button style="line-height: 8px; padding: 5px 15px;" aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
                                                data-toggle="dropdown" id="dropdownMenuButton" type="button"> العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                            <div  class="dropdown-menu tx-10">
                                                @can('تعديل الفاتورة')
                                                <a class="dropdown-item" href="{{ url('invoices_edit') }}/{{ $invoice->id }}"><i class="text-primary fas fa-edit"></i>
                                                    تعديل الفاتورة
                                                </a>
                                                @endcan
                                                @can('حذف الفاتورة')
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                    data-toggle="modal" data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                    الفاتورة
                                                </a>
                                                @endcan
                                                @can('تغير حالة الدفع')
                                                <a class="dropdown-item" href="{{ URL::route('Status_show',[$invoice->id]) }}"><i class="text-success fas fa-money-bill"></i>&nbsp;&nbsp;
                                                    تغير حالة الدفع
                                                </a>
                                                @endcan
                                                @can('ارشفة الفاتورة')
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                    data-toggle="modal" data-target="#Transfer_invoice"><i
                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                    الارشيف
                                                </a>
                                                @endcan
                                                @can('طباعةالفاتورة')
                                                <a class="dropdown-item" href="Print_invoice/{{ $invoice->id }}"><i
                                                    class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                    الفاتورة
                                                </a>
                                                @endcan
                                            </div>
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
    </div>
    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    @csrf
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الارشفة ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="id_page" id="id_page" value="2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-success">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

@endsection