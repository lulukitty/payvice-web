@extends('layouts.master')
@section('content')
<div id="wrapper" class="container">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="margin-top: 20%;">
        @if (isset($responseError))
            <p class="text-danger"><i class="ion-information-circled gstyle"></i>{{ $responseError }}</p>
        @endif

        @if (isset($responseSuccess) && $responseSuccess === true)
            <p class="text-primary"><i class="ion-information-circled gstyle"></i>Transaction Pin Changed Successfully</p>
        @endif
        @if (isset($passwordChanged) && $passwordChanged === true)
            <p class="text-info"><i class="ion-information-circled gstyle"></i>You Must Change Your Pin After Password Change</p>
        @endif
    <form action="/tran/reset-pin" method="post" id="form1">
        <div class=" form-group">
            <input class="form-control" type="text" id="phone" name="phone" placeholder="Your Phone Number" required>
            <p class="text-danger">{{ $errors->first('phone') }}</p>
        </div>
        <div class=" form-group">
            <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
            <p class="text-danger">{{ $errors->first('password') }}</p>
        </div>
        <div class=" form-group">
            <input class="form-control" type="password" id="pin" name="pin" placeholder="Enter New 4 Digit Transaction pin" required maxlength="4">
            <p class="text-danger">{{ $errors->first('pin') }}</p>
        </div>
        <div class=" form-group">
            <input class="form-control" type="password" id="pin confirm" name="pin_confirmation" placeholder="Verify New Transaction Pin" required maxlength="4">
        </div>
        <div class=" form-group">
            <input class="form-control" type="password" id="resetCode" name="resetCode" placeholder="Enter Pin Reset Activation Code sent to your mail" required>
            <p class="text-danger">{{ $errors->first('resetCode') }}</p>
        </div>
        <div class="form-group">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <br/>
            <button type="submit" form="form1" value="Submit" class="btn btn-info">Submit</button>
        </div>
    </form>
    </div>
    <div class="col-md-2"></div>
</div>

@stop


















