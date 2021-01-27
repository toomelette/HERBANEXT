<?php

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')

  <section class="content">

    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="padding-top: 5px;">Batch by Item</h3>
          <div class="pull-right">
            &nbsp;
            {!! __html::back_button(['dashboard.item.index', 'dashboard.item.check_in', 'dashboard.item.check_out']) !!} 
          </div>
      </div>
      <div class="box-body no-padding" id="pjax-container">
  
        {{-- Form Start --}}
        <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.fetch_batch_by_item', $slug) }}">

          {{-- Table Search --}}        
          <div class="box-header with-border">
            {!! __html::table_search(route('dashboard.item.fetch_batch_by_item', $slug)) !!}
          </div>

        {{-- Form End --}}  
        </form>

        {{-- Table Grid --}}        
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th>@sortablelink('batch_code', 'Batch Code')</th>
              <th>@sortablelink('amount', 'Quantity')</th>
              <th>@sortablelink('expiry_date', 'Expiry Date')</th>
              <th>@sortablelink('remarks', 'Remarks')</th>
              <th>Action</th>
            </tr>
            @foreach($batches as $data) 
              <tr>
                <td id="mid-vert">{{ $data->batch_code }}</td>
                <td id="mid-vert">{{ $data->displayAmount() }}</td>
                <td id="mid-vert">{!! $data->displayExpiryStatusSpan() !!} </td>
                <td id="mid-vert">{!! Str::limit(strip_tags($data->remarks), 50) !!} ...</td>
                <td id="mid-vert">

                  @if(in_array('dashboard.item.batch_add_remarks', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="batch_add_remarks_button" 
                       data-remarks="{{ $data->remarks }}" 
                       data-url="{{ route('dashboard.item.batch_add_remarks', $data->batch_id) }}">
                       Remarks
                    </a>
                  @endif
                
                </td>
              </tr>
              @endforeach
            </table>
        </div>

        @if($batches->isEmpty())
          <div style="padding :5px;">
            <center><h4>No Records found!</h4></center>
          </div>
        @endif

      <div class="box-footer">
        {!! __html::table_counter($batches) !!}
        {!! $batches->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

      </div>

    </div>

  </section>

@endsection

@section('modals')

  <div class="modal fade" id="batch_add_remarks_modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"> Remarks</h4>
        </div>
        <div class="modal-body" id="batch_add_remarks_body">
          <form method="POST" id="form">
            
            @csrf
            
            <div class="row" style="padding-right:20px;">

              {!! 
                __form::textarea('12', 'remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), '', '75') 
              !!}
              
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

  <script type="text/javascript">

    @if(Session::has('ITEM_ADD_BATCH_REMARKS_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_ADD_BATCH_REMARKS_SUCCESS')) !!}
    @endif
		
    $(document).on("click", "#batch_add_remarks_button", function () {
      $("#batch_add_remarks_modal").modal("show");
      $("#batch_add_remarks_body #form").attr("action", $(this).data("url"));
      $("#form #remarks").val($(this).data("remarks"));
      $("#form #remarks").attr("placeholder", $(this).data("remarks"));
    });
    
  </script>

@endsection