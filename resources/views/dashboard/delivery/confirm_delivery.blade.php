@extends('layouts.admin-master')

@section('content')

  <section class="content">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">
        
      <div class="box-header with-border">
        <h2 class="box-title">Delivery Items</h2>
        <div class="pull-right">
            &nbsp;
            <a href="{{ route('dashboard.delivery.index') }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-arrow-left"></i>Back</a>
        </div> 
      </div>

      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>PO No.</th>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Status</th>
            <th style="width:200px;">Action</th>
          </tr>
          @foreach($delivery->deliveryItem as $data) 
            <tr> 
              <td id="mid-vert">{{ optional($data->purchaseOrderItem)->po_no }}</td>
              <td id="mid-vert">{{ optional($data->purchaseOrderItem->item)->name }}</td>
              <td id="mid-vert">
                {{ optional($data->purchaseOrderItem)->displayAmount() }}
              </td>
              <td id="mid-vert">
                {!! optional($data->purchaseOrderItem)->displayDeliveryConfirmStatus() !!}
              </td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.delivery.confirm_delivered_post', $global_user_submenus))
                     <a type="button" class="btn btn-success" id="confirm_delivered_button" data-action="confirm-delivered" data-url="{{ route('dashboard.delivery.confirm_delivered_post', optional($data->purchaseOrderItem)->po_item_id) }}">
                        Delivered
                      </a>
                  @endif
                  @if(in_array('dashboard.delivery.confirm_returned_post', $global_user_submenus))
                     <a type="button" class="btn btn-danger" id="confirm_returned_button" data-action="confirm-returned" data-url="{{ route('dashboard.delivery.confirm_returned_post', optional($data->purchaseOrderItem)->po_item_id) }}">
                        Returned
                      </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </table>
      </div>

      @if($delivery->deliveryItem->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

    </div>

  </section>

  <form id="frm-confirm-delivered" method="POST" style="display: none;">
    @csrf
  </form>

  <form id="frm-confirm-returned" method="POST" style="display: none;">
    @csrf
  </form>

@endsection





@section('scripts')

  <script type="text/javascript"> 

    $(document).on("click", "#confirm_delivered_button", function () {
      if($(this).data("action") == "confirm-delivered"){
        $("#frm-confirm-delivered").attr("action", $(this).data("url"));
        $("#frm-confirm-delivered").submit();
      }
    });

    $(document).on("click", "#confirm_returned_button", function () {
      if($(this).data("action") == "confirm-returned"){
        $("#frm-confirm-returned").attr("action", $(this).data("url"));
        $("#frm-confirm-returned").submit();
      }
    });

    {{-- UPDATE TOAST --}}
    @if(Session::has('DELIVERY_PO_ITEM_UPDATE_DELIVERY_STATUS_SUCCESS'))
      {!! __js::toast(Session::get('DELIVERY_PO_ITEM_UPDATE_DELIVERY_STATUS_SUCCESS')) !!}
    @endif

  </script>
    
@endsection