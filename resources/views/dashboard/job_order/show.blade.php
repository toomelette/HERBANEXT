@extends('layouts.admin-master')

@section('content')


<section class="content">
    
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="padding-top: 5px;">Print Job Orders</h2>
      <div class="pull-right">
          {!! __html::back_button(['dashboard.job_order.create',]) !!}
      </div> 
    </div>
    <div class="box-body">

      <div class="col-md-12" style="padding-top:10px;"></div>

        <div class="row" style="padding:20px;">

          @foreach ($po_item->jobOrder as $key => $data)

            <div class="col-sm-6">
              <div class="box">
                <div class="box-header with-border">
                  <h2 class="box-title">#{{ $key + 1 }}</h2>
                </div>
                <div class="box-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                          <td>Reference PO No. :</td>
                          <td>{{ $po_item->po_no }}</td>
                          <td>Lot No :</td>
                          <td>{{ $data->lot_no }}</td>
                        </tr>
                        <tr>
                          <td>Product Name :</td>
                          <td>{{ $data->item_name }}</td>
                          <td>Job Order No :</td>
                          <td>{{ $data->jo_no }}</td>
                        </tr>
                        <tr>
                          <td>Date Required :</td>
                          <td>{{ __dataType::date_parse($data->date, 'm/d/Y') }}</td>
                          <td>QTY Required :</td>
                          <td>{{ number_format($data->amount, 3) .' '. $data->unit }}</td>
                        </tr>
                        <tr>
                          <td>Batch Size :</td>
                          <td>{{ $data->batch_size }}</td>
                          <td>Theoritical Yield :</td>
                          <td>{{ $data->theo_yield }}</td>
                        </tr>
                        <tr>
                          <td>Pack Size :</td>
                          <td>{{ $data->pack_size }}</td>
                          <td></td>
                          <td></td>
                        </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
            
          @endforeach

        </div>

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