<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DBF | POS') }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="asset('dbf-style/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dbf-style/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dbf-style/dist/opensourcepos.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<!-- JS Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
      
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<style type="text/css">
  p.help-inline{
    color: #d20000;
    font-weight: bold;
  }
</style>

</head>
<body>
    <div id="app">
        @guest  

        @else
        <div class="wrapper">
           <div class="topbar">
              <div class="container">
                 <div class="navbar-left">
                    <div id="liveclock">
                      <?php
                        date_default_timezone_set('Asia/Kolkata');
                        echo date('d/m/Y h:i:s A');
                      ?>
                    </div>
                 </div>
                 <div class="navbar-right" style="margin:0">
                   {{get_shop_id_name() !='' ? get_shop_id_name()->name : 'DBF MAIN'}}                    |   
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                 </div>
                 <div class="navbar-center" style="text-align:center">
                    <strong>DBF</strong>
                 </div>
              </div>
           </div>
           <div class="navbar navbar-expand-md navbar-light bg-white shadow-sm" role="navigation" style="border-color: #e7e7e7;">
              <div class="container">
                 <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-sm" href="{{ route('home') }}">
                        <img height="45" width="75" src="{{ asset('dbf-style/images/dbflogo.png') }}">
                    </a>
                 </div>

                 <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                      @permission('can_see_home')
                       <li class="active">
                          <a href="{{ route('home') }}" title="Home" class="menu-icon">
                          <img id="menuicon_home" src="{{ asset('dbf-style/images/menubar/home.png') }}" border="0" alt="Module Icon"><br>
                          Home</a>
                       </li>
                       @endpermission
                       @permission('show_customer')
                       <li class="">
                          <a href="{{ route('customers.index') }}" title="Customers" class="menu-icon">
                          <img id="menuicon_customers" src="{{ asset('dbf-style/images/menubar/customers.png') }}" border="0" alt="Module Icon"><br>
                          Customers</a>
                       </li>
                       @endpermission
                       @permission('show_items')
                       <li class="">
                          <a href="{{ route('items.index') }}" title="Items" class="menu-icon">
                          <img id="menuicon_items" src="{{ asset('dbf-style/images/menubar/items.png') }}" border="0" alt="Module Icon"><br>
                          Items</a>
                       </li>
                       @endpermission
                       @permission('show_manager')
                       <li class="">
                          <a href="{{ route('manager.index') }}" title="Manager" class="menu-icon">
                          <img id="menuicon_manager" src="{{ asset('dbf-style/images/menubar/manager.png') }}" border="0" alt="Module Icon"><br>
                          Manager</a>
                       </li>
                       @endpermission
                       @permission('show_reports')
                       <li class="">
                          <a href="{{ route('reports.index') }}" title="Reports" class="menu-icon">
                          <img id="menuicon_reports" src="{{ asset('dbf-style/images/menubar/reports.png') }}" border="0" alt="Module Icon"><br>
                          Reports</a>
                       </li>
                       @endpermission
                       @permission('show_rceivings')
                       <li class="">
                          <a href="{{ route('receivings.index') }}" title="Receivings" class="menu-icon">
                          <img id="menuicon_receivings" src="{{ asset('dbf-style/images/menubar/receivings.png') }}" border="0" alt="Module Icon"><br>
                          Receivings</a>
                       </li>
                       @endpermission
                       @permission('show_sales')
                       <li class="">
                          <a href="{{ route('sales.index') }}" title="Sales" class="menu-icon">
                          <img id="menuicon_sales" src="{{ asset('dbf-style/images/menubar/sales.png') }}" border="0" alt="Module Icon"><br>
                          Sales</a>
                       </li>
                       @endpermission
                       @permission('show_office')
                       <li class="">
                          <a href="{{ route('office.index') }}" title="Office" class="menu-icon">

                          <img id="menuicon_office" src="{{ asset('dbf-style/images/menubar/office.png') }}" border="0" alt="Module Icon"><br>
                          Office</a>
                       </li>
                       @endpermission
                       @permission('repair_panel')
                       <li class="">
                          <a href="{{ route('account.repair-items') }}" title="Office" class="menu-icon">
                          <img id="menuicon_office" src="{{ asset('dbf-style/images/menubar/office.png') }}" border="0" alt="Module Icon"><br>
                          Repair Cost</a>
                       </li>
                       @endpermission
                    </ul>
                 </div>
              </div>
           </div>
        @endguest

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>