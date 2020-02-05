<?php
  
  $user_menu = $user->userMenu->pluck('menu_id')->toArray();
  $user_submenu = $user->userSubmenu->pluck('submenu_id')->toArray();

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h3 class="box-title" style="padding-top: 5px;">Edit User</h3>
        <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
          &nbsp;
          {!! __html::back_button(['dashboard.user.index']) !!}
        </div>
      </div>
      
      <form class="form-horizontal" method="POST" autocomplete="off" action="{{ route('dashboard.user.update', $user->slug) }}">

        <div class="box-body">

          <input name="_method" value="PUT" type="hidden">

          @csrf    

          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">User Info</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'firstname', 'text', 'Firstname *', 'Firstname', old('firstname') ? old('firstname') : $user->firstname, $errors->has('firstname'), $errors->first('firstname'), 'data-transform="uppercase"'
                ) !!}
                
                {!! __form::textbox(
                  '12', 'middlename', 'text', 'Middlename *', 'Middlename', old('middlename') ? old('middlename') : $user->middlename, $errors->has('middlename'), $errors->first('middlename'), 'data-transform="uppercase"'
                ) !!}
                
                {!! __form::textbox(
                  '12', 'lastname', 'text', 'Lastname *', 'Lastname', old('lastname') ? old('lastname') : $user->lastname, $errors->has('lastname'), $errors->first('lastname'), 'data-transform="uppercase"'
                ) !!}
                
                {!! __form::textbox(
                  '12', 'position', 'text', 'Position / Plantilla *', 'Position / Plantilla', old('position') ? old('position') : $user->position, $errors->has('position'), $errors->first('position'), 'data-transform="uppercase"'
                ) !!}

                {!! __form::textbox(
                  '12', 'email', 'email', 'Email *', 'Email', old('email') ? old('email') : $user->email, $errors->has('email'), $errors->first('email'), ''
                ) !!}
                
                {!! __form::textbox(
                  '12', 'username', 'text', 'Username *', 'Username', old('username') ? old('username') : $user->username, $errors->has('username'), $errors->first('username'), ''
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
                            <input type="checkbox" class="minimal" name="menu[]" id="menu" value="{{ $menu->menu_id }}" {{ in_array($menu->menu_id, $user_menu) ? 'checked' : '' }}> 
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
                                  <input type="checkbox" class="minimal submenu" name="submenu[]" value="{{ $submenu->submenu_id }}" {{ in_array($submenu->submenu_id, $user_submenu) ? 'checked' : '' }}>
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


    {{-- Menu Enable --}}
    $('input').on('ifChecked', function(e){
      if (this.id == 'menu') {
        $('table[id='+this.value+']').find('td input:checkbox').iCheck('enable')
      }
    });

    $('input').on('ifUnchecked', function(e){
      if (this.id == 'menu') {
        $('table[id='+this.value+']').find('td input:checkbox').iCheck('disable')
         $('table[id='+this.value+']').find('td input:checkbox').iCheck('uncheck')
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