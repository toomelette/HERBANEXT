@extends('layouts.admin-master')

@section('content')

<section class="content">



</section>

@endsection




@section('scripts')

  <script type="text/javascript">

    @if(Session::has('ITEM_CATEGORY_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_CATEGORY_CREATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection