<nav class="navbar f-width fixd-top mb-50">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle abs-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
        </button>
        <a href="/tran" class="navbar-brand">
					<img class="logo-light" src="{{ URL::asset('assets/img/logo_payvice.png') }}" alt="">
					<img class="logo-dark" src="{{ URL::asset('assets/img/logo_payvice.png') }}" alt="">
				</a>
			</div>

			<div class="collapse navbar-collapse no-padding" id="nav-collapse">
			<ul class="nav navbar-nav navbar-right hidden-lg hidden-md hidden-sm no-margin">
			<div class="text-center side-bar-header">
   <div id="site-logo">
   <h1 class="txt-avater"><script> 
   var x = '{{ Session::get('curUsr') }}';
   document.write(x.charAt(0));
   </script></h1> 
  </div>
    <h4 class="text-center mt-0 medium fg-white">{{ Session::get('curUsr') }}</h4>
    <div id="owl-example" class="owl-carousel">
  <div class="item"> 
  <h1 class="bold big-font no-margin">&#8358;{{ $balance }}</h1>
    <span class="fg-green small mt10">Wallet Balance</span>    
</div>
  <div class="item">
  <h1 class="bold big-font no-margin ">&#8358;{{ $commissionBalance }}</h1>
    <span class="fg-green small mt10">Commission Balance:</span> 
</div>
</div>
<span class="fg-blue mt-20 small block">Wallet ID : {{ Session::get('curAcc') }}</span>
    
  </div>



			<li><a href="{{url('/tran/account')}}"><i class="ion-filing mr-5 fstyle"></i>Account</a></li>
    		<li><a href="{{url('dashboard/transaction-history')}}"><i class="ion-document-text mr-5 fstyle"></i> History</a></li>
     		<li><a href="{{url('/transfer-commission')}}"><i class="ion-cash mr-5 fstyle"></i>Commision</a></li> 
     		<li><a href="{{url('/tran/settings')}}"><i class="ion-gear-b mr-5 fstyle"></i>Settings</a></li>
<<<<<<< HEAD
     		<li><a href="{{url('/tran/support')}}"><i class="ion-android-contract mr-5 fstyle"></i>Support</a></li>
=======
     		<li><a href="{{url('#')}}"><i class="ion-android-contract mr-5 fstyle"></i>Support</a></li>
>>>>>>> 457ce7d49e7e84554390407e86f4389abe197130
    		<li><a href="{{url('/vice/disconnect')}}"><i class="ion-locked mr-5 fstyle"></i>Log out</a></li> 
			
			</ul>
		</div>
</nav>