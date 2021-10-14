@extends('layouts.master')
@section('content')
    <script>
        function now(){
            window.location.reload(true);
        }
        document.body.style.overflowY = 'hidden';
    </script>


<div id="wrapper" class="toggled" >
    <div role="navigation" class="wrap-body" id="sidebar-wrapper">
        @include('layouts.menu')
        <div class="p-20" id="page-content-wrapper">
            <section>
                @include('layouts.sub-menu')
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
                                <div id="paybills">
                                    <div class="row">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-12 fillh"  >
                                                <div class="mb-30">
                                                    <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                                                    <h4 class="inline right">Movie Tickets</h4>
                                                    <hr class="no-margin f-width"/>
                                                </div>
                                                

                                                <div class="utility-slide" >
                                                    <div><a class="showCableBill" data-img="gotv" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/genesis.png') }}" /></a></div>
                                                    <div><a class="showCableBill" data-img="dstv" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/silverbird.png') }}" /></a></div>
                                                    <div><a class="showCableBill" data-img="startime" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/viva.png') }}" /></a></div>
                                                    <div><a class="showCableBill" data-img="ozone" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/ozone.png') }}" /></a></div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('layouts.side-adv')
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@stop
@push('scripts')

<script>
    $('.showCableBill').click(function() {
        var img = $(this).attr('data-img');
        var servImg ="";
        var servType = "";

        switch(img){
          case 'gotv':
          servImg = 'util_gotv.png';
          servType = "GOTV";
          break;
          case 'dstv':
          servImg = 'util_dstv.png';
          servType = "DSTV";
          break;
          case 'startime':
          servImg = 'util_startime.png';
          servType = "STARTIMES";
          break;
          case 'ozone':
          servImg = 'util_startime.png';
          servType = "STARTIMES";
          break;

        }

