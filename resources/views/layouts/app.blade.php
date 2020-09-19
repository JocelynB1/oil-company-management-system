<?php 

use App\User;
use App\Role;
use App\UsersRole;
$user=new User();
$role=new Role();
$usersRole=new UsersRole();
if(isset(Auth::user()->id)){
$user->id=Auth::user()->id;
$usersRole=\App\UsersRole::where('user_id',$user->id)->get()->toArray();
$role_id=$usersRole[0]['role_id'];
$role=\App\Role::where('id',$role_id)->get()->toArray();
$role=$role[0]['Description'];
}

?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Agazy Ltd</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}    ">
                    Agazy Ltd
                    
                </a>
             
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li><a class="nav-link"  href="{{ route('password.request') }}">Change Password</a></li>
                            
                        @else
                     
                        <?php
                    switch($role){
                 
                    case "Accountant":
                    ?>
                      @include('layouts.partials.menu.accountant')
                      <?php
                    break;
                     case "Administrator":
                     ?>
                    @include('layouts.partials.menu.administrator')
                    <?php
                     break;
                     
                     case "General manager":
                     ?>
                     @include('layouts.partials.menu.generalmanager')
                     <?php
                     break;

                     case "Stock manager":
                     ?>
                     @include('layouts.partials.menu.stockmanager')
                     <?php
                     break;

                     case "Human resources manager":
                     ?>
                     @include('layouts.partials.menu.humanresourcesmanager')
                     <?php
                     break;

                     case "Rate manager":
                     ?>
                     @include('layouts.partials.menu.ratemanager');
                     <?php
                     break;

                    case "Output manager":
                    ?>
                    @include('layouts.partials.menu.outputmanager');
                    <?php
                    break;

                    case "Inventory manager";
                    ?>
                    @include('layouts.partials.menu.inventorymanager');
                    <?php
                    default:
                    break;
                }
                        
                        ?>
                      
                           
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
        <div class="container">
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
        @endif
        @yield('content')
        
    </div>
        </main>

    </div>



    <div class="box-body" style="display: block;">
            <div class="row">
              <div class="col-md-12">
                <div class="chart-responsive">
                  <canvas width="300" height="300" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
              </div>
            </div>
            <!-- /.row -->
          </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
  <script>
    @yield('scripts')
    </script>
</body>
</html>
