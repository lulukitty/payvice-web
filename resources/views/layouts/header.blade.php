<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->


<!-- Remove Tap Highlight on Windows Phone IE -->
<meta name="msapplication-tap-highlight" content="no">


<title>Payvice - Airtime Recharge | Pay Utility Bills with Ease </title>
<link rel="shortcut icon" href="
{{ URL::asset('assets/img/favicon.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ URL::asset('assets/img/favicon.ico') }}" type="image/x-icon">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ URL::asset('assets/css/swiper.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/animate.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/hover.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/ionicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/linea.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/cardcss.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/waves.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/sweetalert.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/magnific-popup.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/blockui.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.scrollbar.css') }}">
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">


<style>
.swiper-container {
  /* width: 100%;*/
  width:270px;
  height: 100%;
  background-image: url("{{ URL::asset('assets/img/mockup4.png') }}");
  height: 550px;
  background-size: contain;
}
.swiper-slide {
  text-align: center;
  font-size: 18px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  -webkit-justify-content: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  -webkit-align-items: center;
  align-items: center;
}
#app {
    display: none;
}

.splash{
    margin:200px auto;
}
h1{
    color:#FFF;
    font-size:16px;
    letter-spacing:1px;
    font-weight:200;
    text-align:center;
}
.splash span{
    width:16px;
    height:16px;
    border-radius:50%;
    display:inline-block;
    position:absolute;
    left:50%;
    margin-left:-10px;
    -webkit-animation:3s infinite linear;
    -moz-animation:3s infinite linear;
    -o-animation:3s infinite linear;

}


.splash span:nth-child(2){
    background:blue;
    -webkit-animation:kiri 1.2s infinite linear;
    -moz-animation:kiri 1.2s infinite linear;
    -o-animation:kiri 1.2s infinite linear;

}
.splash span:nth-child(3){
    background:red;
    z-index:100;
}
.splash span:nth-child(4){
    background:red;
    -webkit-animation:kanan 1.2s infinite linear;
    -moz-animation:kanan 1.2s infinite linear;
    -o-animation:kanan 1.2s infinite linear;
}


@-webkit-keyframes kanan {
    0% {-webkit-transform:translateX(20px);
    }

    50%{-webkit-transform:translateX(-20px);
    }

    100%{-webkit-transform:translateX(20px);
    z-index:200;
    }
}
@-moz-keyframes kanan {
    0% {-moz-transform:translateX(20px);
    }

    50%{-moz-transform:translateX(-20px);
    }

    100%{-moz-transform:translateX(20px);
    z-index:200;
    }
}
@-o-keyframes kanan {
    0% {-o-transform:translateX(20px);
    }

    50%{-o-transform:translateX(-20px);
    }

    100%{-o-transform:translateX(20px);
    z-index:200;
    }
}

@-webkit-keyframes kiri {
     0% {-webkit-transform:translateX(-20px);
    z-index:200;
    }
    50%{-webkit-transform:translateX(20px);
    }
    100%{-webkit-transform:translateX(-20px);
    }
}

@-moz-keyframes kiri {
     0% {-moz-transform:translateX(-20px);
    z-index:200;
    }
    50%{-moz-transform:translateX(20px);
    }
    100%{-moz-transform:translateX(-20px);
    }
}
@-o-keyframes kiri {
     0% {-o-transform:translateX(-20px);
    z-index:200;
    }
    50%{-o-transform:translateX(20px);
    }
    100%{-o-transform:translateX(-20px);
    }
}

</style>

</head>
