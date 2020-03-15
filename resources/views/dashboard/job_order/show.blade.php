@extends('layouts.admin-master')

@section('content')


<section class="content">
    
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="padding-top: 5px;">Job Orders</h2>
      <div class="pull-right">
          {!! __html::back_button(['dashboard.job_order.create',]) !!}
      </div> 
    </div>
    <div class="box-body">

      <div class="col-md-12" style="padding-top:10px;"></div>

        @foreach ($po_item->jobOrder as $data)

          <div class="row">

            <div class="col-sm-6">
              <strong>Reference PO No. :</strong> <span>{{ $po_item->po_no }}</span><br>
              <strong>Product Name :</strong> <span>{{ $data->item_name }}</span><br>
              <strong>Date Required :</strong> <span>{{ __dataType::date_parse($data->date, 'm/d/Y') }}</span><br>
              <strong>Batch Size :</strong> <span>{{ number_format($data->batch_size, 3) .' '. $data->batch_size_unit }}</span><br>
              <strong>Pack Size :</strong> <span>{{ number_format($data->batch_size, 3) .' '. $data->batch_size_unit }}</span><br>
            </div>

          </div>
          
        @endforeach

      <div class="col-md-12" style="padding-top:10px;"></div>

      <div class="row no-print">
        <div class="col-xs-12">
          <a href="{{ route('dashboard.job_order.print', $po_item->slug) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

    </div>
  </div>

</section>


@endsection