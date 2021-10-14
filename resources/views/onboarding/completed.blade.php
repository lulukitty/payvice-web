@extends('onboarding.layout')
@section('content')
    <div id="alert" >
    </div>
    
    <div class="row justify-content-md-center">
        <div class="col-md-3"></div>
        <div class="col-md-8 pt-5">

            <div class="p2">
                <div class="mb-2" style="background: #2EB39C 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1; width: 80%;">
                    <div class="pt-5 mb-3 d-flex align-items-center flex-column bd-highlight">
                        <div class="bd-highlight">
                            <i class="fas fa-check-circle text-white text-center" style="font-size: 200px; position: relative;"></i>
                        </div>
                    </div>
                    <div class="pt-3 pb-5 d-flex align-items-center flex-column bd-highlight" style="background-color: #F8F8F8; position: relative; width: 100%;"> 
                        <div class="bd-highlight">
                            <p class="text-center" style="color: #2EB39C; width: 475px; font-size: 22px;">
                                <strong> GREAT! </strong> <br> You have successfully completed your onboarding process.
                            </p>
                        </div>
                        <div class="bd-highlight">
                            <a href="/">
                            <button class="btn" style="width: 230px; height: 60px; background: #D8D8D8 0% 0% no-repeat padding-box; opacity: 1; color: white;">
                                CLOSE
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection

