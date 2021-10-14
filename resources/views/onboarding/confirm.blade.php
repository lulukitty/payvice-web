@extends('onboarding.layout')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="breadcrumb">
                <h1>Merchant onboarding</h1>
            </div>
        </div>
    </div>
    <div id="alert" >
    </div>
    <form >
    {{csrf_field()}}
    <div class="row justify-content-md-center">
    <div class="col-md-10">

    <div class="sw-theme-dots">
        <div>
            <div class="">
                <h3 class="border-bottom border-gray mt-3 mb-5">Verify Activation Code</h3>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Activation Code</label>
                            <input type="text" class="form-control" name="code" placeholder="Activation Code" required="required">
                        </div>
    
                        <div class="form-group">
                            <label>Phone Number <span style="font-size: 10px; font-weight: bold;"><i>(Your temporary login parameter)</i></span></label>
                            <input class="form-control" name="mobile" placeholder="Valid Phone Number" required value="{{ $mobile }}" disabled >
                        </div>

                        <button id="validateCode" class="btn btn-primary">
                            <span id="spinner"> <i class="fas fa-spinner fa-spin"></i></span>
                            Verify
                        </button>    
                    </div>  
                </div>
     
            </div>            
        </div>


    </div>
    </div>
    </div>
    </form>
    <div class="flex-grow-1"></div>
    <script type="text/JavaScript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" ></script>
    <script src="{{ URL::asset('assets/js/ajax.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        jQuery(document).ready(function($){
            $('#spinner').hide();
            
            $( '#validateCode' ).on( 'click', function(e) {
                e.preventDefault();
                $('#spinner').show();
                $('#validateCode').prop('disabled', true);
                $('div#alert').text("");
                $("div#alert").removeClass("alert");
                $("div#alert").removeClass("alert-danger");

                    var code = $("input[name=code]").val();
                    var mobile = $("input[name=mobile]").val();

                    $.ajax({
                    type:'POST',
                    url:'/vice/agents/verify-activation-code',
                    data:{code, mobile},

                    success:function(data){
                        if(data.status === 200){
                            $('div#alert').text(data.message);
                            $("div#alert").addClass("alert");
                            $("div#alert").addClass("alert-success");

                            var delay = 2000; 
                            var url = '/vice/agents/merchant-details'
                            setTimeout(function(){ window.location = url; }, delay);
                        }else{
                            $('div#alert').text(data.message);
                            $("div#alert").addClass("alert");
                            $("div#alert").addClass("alert-danger");
                            $('#spinner').hide();
                            $('#validateCode').prop('disabled', false);
                        }
                    }
                });

            });
        })
    </script>
@endsection

