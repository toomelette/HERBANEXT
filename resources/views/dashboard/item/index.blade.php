<?php

  $table_sessions = [ Session::get('ITEM_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                        'cat' => Request::get('cat'),
                        's' => Request::get('s'),
                      ];

?>

@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Items</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.index') }}">

      {!! __html::filter_open() !!}


        {!! __form::select_dynamic_for_filter(
          '4', 'cat', 'Categories', old('cat'), $global_item_categories_all, 'item_category_id', 'name', 'submit_item_filter', 'select2', 'style="width:100%;"'
        ) !!}

        {!! __form::select_dynamic_for_filter(
          '4', 's', 'Supplier', old('s'), $global_suppliers_all, 'supplier_id', 'name', 'submit_item_filter', 'select2', 'style="width:100%;"'
        ) !!}

      {!! __html::filter_close('submit_item_filter') !!}

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.item.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('product_code', 'Product Code')</th>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('current_balance', 'Balance')</th>
            <th>@sortablelink('', 'Pending Check Out')</th>
            <th style="width: 400px">Action</th>
          </tr>
          @foreach($items as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->product_code }}</td>
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{!! $data->displayCurrentBalance() !!}</td>
              <td id="mid-vert">{!! $data->displayPendingCheckout() !!}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.item.check_in', $global_user_submenus) || in_array('dashboard.item.check_in_existing_batch', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="check_in_button" 
                       data-action="check_in" 
                       data-ci="{{ route('dashboard.item.check_in', $data->slug) }}"
                       data-cieb="{{ route('dashboard.item.check_in_existing_batch', $data->slug) }}">
                      Check in
                    </a>
                  @endif

                  @if(in_array('dashboard.item.check_out', $global_user_submenus) || in_array('dashboard.item.check_out_by_batch', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="check_out_button" 
                       data-action="check_out" 
                       data-co="{{ route('dashboard.item.check_out', $data->slug) }}"
                       data-cobb="{{ route('dashboard.item.check_out_by_batch', $data->slug) }}">
                      Check out
                    </a>
                  @endif

                  @if(in_array('dashboard.item.fetch_batch_by_item', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="batch_button" href="{{ route('dashboard.item.fetch_batch_by_item', $data->slug) }}">
                      <i class="fa fa-cubes "></i>
                    </a>
                  @endif

                  @if(in_array('dashboard.item.fetch_logs_by_item', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="batch_button" href="{{ route('dashboard.item.fetch_logs_by_item', $data->slug) }}">
                      <i class="fa fa-file-text-o "></i>
                    </a>
                  @endif

                  @if(in_array('dashboard.item.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.item.edit', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif

                  @if(in_array('dashboard.item.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.item.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif

                </div>
              </td>
            </tr>
            @endforeach
          </table>
      </div>

      @if($items->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($items) !!}
        {!! $items->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection





@section('modals')

  {!! __html::modal_delete('item_delete') !!} 

  {{-- CHECK IN --}}
  <div class="modal fade" id="check_in_modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-refresh "></i> Options</h4>
        </div>
        <div class="modal-body" id="check_in_modal_body">
          <a id="check_in_redirect" type="button" class="btn btn-success btn-block">
            Check in New Batch
          </a>
          <a id="check_in_redirect_eb" type="button" class="btn btn-success btn-block">
            Check in to Existing Batch
          </a>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- CHECK OUT --}}
  <div class="modal fade" id="check_out_modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-refresh "></i> Options</h4>
        </div>
        <div class="modal-body" id="check_out_modal_body">
          <a id="check_out_redirect" type="button" class="btn btn-success btn-block">
            Default Check out (First in - First Out)
          </a>
          <a id="check_out_redirect_bb" type="button" class="btn btn-success btn-block">
            Check out specific batch
          </a>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection 





@section('scripts')

  <script type="text/javascript">
    

    $(document).on("click", "#check_in_button", function () {
      if($(this).data("action") == "check_in"){
        $("#check_in_modal").modal("show");
        $("#check_in_modal_body #check_in_redirect").attr("href", $(this).data("ci"));
        $("#check_in_modal_body #check_in_redirect_eb").attr("href", $(this).data("cieb"));
      }
    });
    

    $(document).on("click", "#check_out_button", function () {
      if($(this).data("action") == "check_out"){
        $("#check_out_modal").modal("show");
        $("#check_out_modal_body #check_out_redirect").attr("href", $(this).data("co"));
        $("#check_out_modal_body #check_out_redirect_bb").attr("href", $(this).data("cobb"));
      }
    });


    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('item_delete') !!}


    {{-- UPDATE TOAST --}}
    @if(Session::has('ITEM_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_UPDATE_SUCCESS')) !!}
    @endif


    {{-- DELETE TOAST --}}
    @if(Session::has('ITEM_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_DELETE_SUCCESS')) !!}
    @endif


    {{-- Batch About to expire toast --}}
    @foreach ($global_item_batches_all as $data)

      @if ($data->isAboutToExpire() == true)

        @php  
          $txt = $data->item->name .' Batch '. $data->batch_code .' is about to expire in '. $data->expiry_date->format('F d,Y');
        @endphp

        $.toast({
          text: "{{ $txt }}",
          showHideTransition: "slide",
          allowToastClose: true,
          hideAfter: 3000,
          loader: false,
          position: "bottom-right",
          bgColor: "#800000",
          textColor: "white",
          textAlign: "left",
        });

      @endif

    @endforeach


  </script>
    
@endsection