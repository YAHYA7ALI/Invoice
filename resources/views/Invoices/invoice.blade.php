@extends('layouts.master')
@section('css')
	<style>
		@media print {
			#Print_Button{
				display: none;
			}
		}
	</style>
@endsection
@section('title')
	معاينة طباعة الفواتير
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معاينة طباعة الفواتير</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">فاتورة تحصيل</h1>
										<div class="billed-from">
											<h6>Name: {{Auth::user()->name }}</h6>
											<br>
											<p>Email: {{Auth::user()->email }}</p>
										</div><!-- billed-from -->
									</div>
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Company</label>
											<div class="billed-to">
												<h6>Alshbliy</h6>
												<p>Tel No: +201023800994<br>
												Email: youremail@alshbliy.com</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">معلومات الفاتورة</label>
											<p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{ $invoices -> invoice_number }}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاصدار</span> <span>{{ $invoices -> invoice_Date }}</span></p>
											<p class="invoice-info-row"><span>تاريخ الأستحقاق</span> <span>{{ $invoices -> Due_date }}</span></p>
											<p class="invoice-info-row"><span>القسم</span> <span>{{ $invoices -> sections -> section_name }}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">#</th>
													<th class="wd-40p">المنتج</th>
													<th class="tx-center">مبلغ التحصيل</th>
													<th class="tx-right">مبلغ العمولة</th>
													<th class="tx-right">الاجمالي</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td class="tx-12">{{ $invoices -> product }}</td>
													<td class="tx-center">{{ number_format( $invoices -> Amount_collection ,2) }}</td>
													<td class="tx-right"> {{ number_format( $invoices -> Amount_Commission ,2) }}</td>
													<?php
														$total = $invoices -> Amount_collection + $invoices -> Amount_Commission ;
													?>
													<td class="tx-right">
														{{ number_format( $total, 2 ) }}
													</td>
												</tr>
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">#</label>
														</div>
													</td>
													<td class="tx-right">الاجمالي</td>
													<td class="tx-right" colspan="2">{{ number_format( $total, 2 ) }}</td>
												</tr>
												<tr>
													<td class="tx-right">  نسبة الضريبة ({{ $invoices -> Rate_VAT }}) </td>
													<td class="tx-right" colspan="2">{{ $invoices -> Value_VAT }}</td>
												</tr>
												<tr>
													<td class="tx-right">قيمة الخصم</td>
													<td class="tx-right" colspan="2">{{ number_format( $invoices -> Discount ,2) }}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبة</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">{{ number_format( $invoices -> Total , 2 ) }}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									<button class="btn btn-danger float-left mt-3" id="Print_Button" onclick="printDiv()"> <i class="mdi mdi-printer ml-1"></i>طباعة</button>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
	<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
	<script type="text/javascript">
		function printDiv()
			{
				const printContents = document.getElementById('print').innerHTML;
				const originalContents = document.body.innerHTML;
				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
				location.reload();
			}
	</script>
@endsection