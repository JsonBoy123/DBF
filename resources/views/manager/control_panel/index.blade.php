@extends('layouts.dbf')

@section('content')

<div class="container">
   <div class="row">
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-12" id="tabs">
               <ul class="nav nav-tabs" data-tabs="tabs" id="rowTab">
                  <li class="active" id="liactiv" role="presentation">
                     <a data-toggle="tab" href="#Cashiers" onclick="load_cashier('Cashiers');" title="Cashiers">Cashiers</a>
                  </li>
                  <li class="" role="presentation">
                     <a data-toggle="tab" href="#addCashier" onclick="load_cashier_details('addCashier');" title="Cashiers">Cashiers Detail</a>
                  </li>
                  <li role="presentation" id="offer_bundle_tab">
                     <a data-toggle="tab" href="#offerBundles" onclick="load_offer_bundle('offerBundles');" title="Offer Bundles">Offer Bundles</a>
                  </li>
                  <li role="presentation " id="location_tab">
                     <a data-toggle="tab" href="#groupLocation" onclick="load_loc_group('groupLocation')" title="Locations groups">Locations groups</a>
                  </li>
                  <li role="presentation " id="custom_tab">
                     <a data-toggle="tab" href="#customField" onclick="load_custom_tab('customField')" title="Locations groups">Custom Field</a>
                  </li>
               </ul>
            </div>
            <hr>
            <div class="clearfix"> </div>
            <div id="Data"></div>
         </div>
      </div>
   </div>
</div>



<script>
    function load_cashier(e){
      $('#Data').load("{{ 'cashier' }}");
      sessionStorage.setItem('activeTab', '#'+e);
    }
    function load_cashier_details(e){
      $('#Data').load("{{ 'cashier_detail' }}");
      sessionStorage.setItem('activeTab', '#'+e);
    }
    function load_offer_bundle(e){
      $('#Data').load("{{ 'offer_bundle' }}");
      sessionStorage.setItem('activeTab', '#'+e);
    }
    function load_loc_group(e){
      $('#Data').load("{{ 'group_location' }}");
      sessionStorage.setItem('activeTab', '#'+e);
    }
    function load_custom_tab(e){
      $('#Data').load("{{ 'custom_tab' }}");
      sessionStorage.setItem('activeTab', '#'+e);
    }

    var activeTab = sessionStorage.getItem('activeTab');
    $('#Data').load("{{ 'cashier' }}");
    if(activeTab){
      $('#rowTab a[href="' + activeTab + '"]').tab('show');

      if(activeTab == '#Cashiers'){
          $('#Data').load("{{ 'cashier' }}");
      }
      if(activeTab == '#addCashier'){
          $('#Data').load("{{ 'cashier_detail' }}");
      }
      if(activeTab == '#offerBundles'){
          $('#Data').load("{{ 'offer_bundle' }}");
      }
      if(activeTab == '#groupLocation'){
          $('#Data').load("{{ 'group_location' }}");
      }
      if(activeTab == '#customField'){
          $('#Data').load("{{ 'custom_tab' }}");
      }
    }
    
    window.onload = function(){
      sessionStorage.removeItem('incharge_val');
      sessionStorage.removeItem('activeTab');
    }
</script>

<style type="text/css">
  .select2{
      width: 100% !important;
  }
</style>

@endsection
