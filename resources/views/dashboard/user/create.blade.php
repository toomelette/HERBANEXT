@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h3 class="box-title">Create User</h3>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form id="user_create_form" class="form-horizontal" method="POST" autocomplete="off" action="{{ route('dashboard.user.store') }}">

        <div class="box-body">

            @csrf

            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">User Info</h3>
                </div>
                <div class="box-body">

                  {!! __form::textbox(
                    '12', 'firstname', 'text', 'Firstname *', 'Firstname', old('firstname'), $errors->has('firstname'), $errors->first('firstname'), 'data-transform="uppercase"'
                  ) !!}
                  
                  {!! __form::textbox(
                    '12', 'middlename', 'text', 'Middlename *', 'Middlename', old('middlename'), $errors->has('middlename'), $errors->first('middlename'), 'data-transform="uppercase"'
                  ) !!}
                  
                  {!! __form::textbox(
                    '12', 'lastname', 'text', 'Lastname *', 'Lastname', old('lastname'), $errors->has('lastname'), $errors->first('lastname'), 'data-transform="uppercase"'
                  ) !!}
                  
                  {!! __form::textbox(
                    '12', 'position', 'text', 'Position / Plantilla *', 'Position / Plantilla', old('position'), $errors->has('position'), $errors->first('position'), 'data-transform="uppercase"'
                  ) !!}

                  {!! __form::textbox(
                    '12', 'email', 'email', 'Email *', 'Email', old('email'), $errors->has('email'), $errors->first('email'), ''
                  ) !!}
                  
                  {!! __form::textbox(
                    '12', 'username', 'text', 'Username *', 'Username', old('username'), $errors->has('username'), $errors->first('username'), ''
                  ) !!}
                  
                  {!! __form::textbox(
                    '12', 'password', 'password', 'Password *', 'Password', '', $errors->has('password'), $errors->first('password'), ''
                  ) !!}
                  
                  {!! __form::textbox(
                    '12', 'password_confirmation', 'password', 'Confirm Password *', 'Confirm Password', '', '', '', ''
                  ) !!}

                </div>
              </div>
            </div>




            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">User Modules</h3>
                </div>
                <div class="box-body">

                  @if(old('menu'))

                    @foreach($global_menus_all as $menu)

                      <div class="col-md-12">
                        <div class="box">
                          <div class="box-header with-border">
                            <h3 class="box-title">
                              <input type="checkbox" class="minimal" name="menu[]" id="menu" value="{{ $menu->menu_id }}" {{ in_array($menu->menu_id, old('menu')) ? 'checked' : '' }}>
                              &nbsp; {{ $menu->name }}
                            </h3>
                          </div>
                          <div class="box-body">
                            <input type="checkbox" class="minimal" id="select_all" value="{{ $menu->menu_id }}">
                            &nbsp; Select All
                            <table class="table table-bordered" id="{{ $menu->menu_id }}" style="margin-top: 10px;">
                              @foreach($menu->submenu as $submenu)
                              <tr>  
                                <td>
                                  <label>
                                    <input type="checkbox" class="minimal submenu" name="submenu[]" value="{{ $submenu->submenu_id }}" {{ in_array($submenu->submenu_id, old('submenu')) ? 'checked' : '' }}>
                                    &nbsp;{{ $submenu->name }}
                                  </label>
                                </td>
                              </tr>
                              @endforeach
                            </table>
                          </div>
                        </div>
                      </div>

                    @endforeach


                  @else 

                    @foreach($global_menus_all as $menu)

                      <div class="col-md-12">
                        <div class="box">
                          <div class="box-header with-border">
                            <h3 class="box-title">
                              <input type="checkbox" class="minimal" name="menu[]" id="menu" value="{{ $menu->menu_id }}"> 
                              &nbsp; {{ $menu->name }}
                            </h3>
                          </div>
                          <div class="box-body">
                            <input type="checkbox" class="minimal" id="select_all" value="{{ $menu->menu_id }}">
                            &nbsp; Select All
                            <table class="table table-bordered" id="{{ $menu->menu_id }}" style="margin-top: 10px;">
                              @foreach($menu->submenu as $submenu)
                              <tr>  
                                <td>
                                  <label>
                                    <input type="checkbox" class="minimal submenu" name="submenu[]" value="{{ $submenu->submenu_id }}">
                                    &nbsp;{{ $submenu->name }}
                                  </label>
                                </td>
                              </tr>
                              @endforeach
                            </table>
                          </div>
                        </div>
                      </div>

                    @endforeach

                  @endif



                </div>
              </div>
            </div>



        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </form>

    </div>

</section>

@endsection





@section('scripts')

<script type="text/javascript">

  $( document ).ready(function() {

    {{-- Disable Submenus if there is no Form Errors --}}
    @if(!old('menu') && !old('menu'))
      $('.submenu').iCheck('disable')
    @endif


    {{-- Menu Enable --}}
    $('input').on('ifChecked', function(e){
      if (this.id == 'menu') {
        $('table[id='+this.value+']').find('td input:checkbox').iCheck('enable')
      }
    });

    $('input').on('ifUnchecked', function(e){
      if (this.id == 'menu') {
        $('table[id='+this.value+']').find('td input:checkbox').iCheck('disable')
      }
    });


    {{-- Select All --}}
    $('input').on('ifChecked', function(e){
      if (this.id == 'select_all') {
        $('table[id='+this.value+']').find('td input:checkbox').iCheck('check')
      }
    });

    $('input').on('ifUnchecked', function(e){
      if (this.id == 'select_all') {
        $('table[id='+this.value+']').find('td input:checkbox').iCheck('uncheck')
      }
    });

  });

  @if(Session::has('USER_CREATE_SUCCESS'))
    {!! __js::toast(Session::get('USER_CREATE_SUCCESS')) !!}
  @endif

</script>
    
@endsection