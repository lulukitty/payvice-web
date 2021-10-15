<div class="text-center side-bar-header">
 <div id="site-logo">
   <h1 class="txt-avater"><script> 
     var x = '{{ Session::get('curUsr') }}';
     document.write(x.charAt(0));
   </script></h1> 
 </div>
 <h4 class="text-center mt-0 medium fg-white">{{ Session::get('curUsr') }}</h4>
 <div class="block">
  <div id="owl-example" class="owl-carousel">
    <div class="item"> 
      <h1 class="bold big-font no-margin">&#8358;{{ $balance}}</h1>
      <span class="fg-green small mt10">Wallet Balance</span>    
    </div>
    <div class="item" id="commission-tab">
      <h1 class="bold big-font no-margin ">&#8358;{{ $commissionBalance }}</h1>
      <span class="fg-green small mt10">Commission Balance:</span> 
    </div>
  </div>

</div>
<span class="fg-blue mt-20 small block" style="font-weight: bold;">Wallet ID : {{ Session::get('curAcc') }}</span>

</div>

<ul  class="nav sidelist p-10">
  <li><a href="{{url('/tran')}}"><i class="ion-home block fstyle"></i>Home</a></li>
  <li><a href="{{url('/tran/account')}}"><i class="ion-filing block fstyle"></i>Account</a></li>
  <li><a href={{url('/dashboard/transaction-history')}}><i class="ion-document-text block fstyle"></i> History</a></li>
  <li><a href="{{url('/transfer-commission')}}"><i class="ion-cash block fstyle"></i>Commision</a></li> 
  <li><a href="{{url('/tran/settings')}}"><i class="ion-gear-b block fstyle"></i>Settings</a></li>
  <li><a href="{{url('#')}}"><i class="ion-android-contract block fstyle"></i>Support</a></li>
  <li><a href="{{url('/vice/disconnect')}}"><i class="ion-locked block fstyle"></i>Log out</a></li> 
  <!-- <li><a href="{{url('/tran/paybills')}}"><i class="ion-ios-paper-outline block fstyle"></i>Pay Bills</a></li>-->
</ul>
</div>

