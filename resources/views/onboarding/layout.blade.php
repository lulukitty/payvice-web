<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payvice | Itex Merchant Onboarding</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="/onboarding/assets/css/smart_wizard.min.css">
    <link rel="stylesheet" href="/onboarding/assets/css/smart_wizard_theme_arrows.min.css">
    <link rel="stylesheet" href="/onboarding/assets/css/smart_wizard_theme_circles.min.css">
    <link rel="stylesheet" href="/onboarding/assets/css/smart_wizard_theme_dots.min.css">
    <link rel="stylesheet" href="/onboarding/assets/css/lite-purple.min.css">
    <link rel="stylesheet" href="/onboarding/assets/css/onboard.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="app-admin-wrap">
       
        
        <div class="main-header" style="">
            {{-- <div class="logo"> --}}
                <a href="/vice/agents/onboard"> <img src="/onboarding/assets/images/onboarding.png" style="top: 0px; left: 98px; width: 180px; height: 80px; position: relative" alt=""></a>
            {{-- </div> --}}
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="main-content-wrap d-flex flex-column">
            <div class="row">
                <div class="col-md-10 offset-1">
                    <div class="breadcrumb">
                        <h1  style="color: #206EA1; padding-left: 10px;">Merchant Onboarding Form</h1>
                    </div>
                    <div style="border: 1px solid #dee2e6"> </div>
                </div>
            </div>
            @yield('content')
        </div>
       
    </div>

    
    
</body>


</html>