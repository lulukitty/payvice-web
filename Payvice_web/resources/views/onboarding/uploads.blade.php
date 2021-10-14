@extends('onboarding.layout')
@section('content')
    <div id="alert" >
    </div>
    <form id="uploads" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="row justify-content-md-center">
    <div class="col-md-10">
                <h5 class="mt-3 mb-4 text-secondary ">Upload Documents</h5>
                <input type="hidden" class="form-control" name="user_token" value="{{ $token }}"  required="required" disabled>
                <div class=" p-5" style="background: #FFFFFF 0% 0% no-repeat padding-box;  box-shadow: 0px 3px 40px #00000029; opacity: 1;">
                    <div class="form-row">
                        <div class="col-md-4 d-flex align-items-center flex-column bd-highlight p-5">
                            <p class="bd-highlight text-secondary text-center">Upload Passport Photograph  <span class="text-danger"> * </span> <br> <span class="text-danger"> Image Only </span></p>
                            <div class="bd-highlight" style="border: 1px dashed #707070; opacity: 1; top: 349px; left: 295px;  width: 309px; height: 327px;">
                                <img src="..." alt="passport" class="img-thumbnail" id="passportImage">
                                <div class="d-flex align-items-center flex-column bd-highlight">
                                    <div class="bd-highlight p-2 mt-5" id="passportText">
                                        <p class="text-center " style="font-size: 35px">Drag & Drop <br> Files to Upload</p>
                                        <p class="text-secondary bd-highlight text-center">or browse for the file</p>
                                    </div>
                                    <button class="btn btn-primary bd-highlight" style="width: 195px; height: 50px; background: #206EA1 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1;">
                                        Browse
                                    </button>
                                </div>
                                <input type="file" name="Passport" accept="image/gif, image/jpeg, image/png" style="position: relative; top: -50px; opacity: 0;" onchange="readURL(this);" required>
                            </div>
                        </div>
    
                        <div class="col-md-4 d-flex align-items-center flex-column bd-highlight p-5">
                            <p class="bd-highlight text-secondary text-center">Upload Valid ID  <span class="text-danger"> * </span>  <br> <span class="text-danger"> Image Only </span></p>
                            <div class="bd-highlight" style="border: 1px dashed #707070; opacity: 1; top: 349px; left: 295px;  width: 309px; height: 327px;">
                                <img src="..." alt="valid Id" class="img-thumbnail" id="IdImage">
                                <div class="d-flex align-items-center flex-column bd-highlight">
                                    <div class="bd-highlight p-2 mt-5" id="idText">
                                        <p class="text-center " style="font-size: 35px">Drag & Drop <br> Files to Upload</p>
                                        <p class="text-secondary bd-highlight text-center">or browse for the file</p>
                                    </div>
                                    <button class="btn btn-primary bd-highlight" style="width: 195px; height: 50px; background: #206EA1 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1;">
                                        Browse
                                    </button>
                                </div>
                                <input type="file"  name="NationalID" accept="image/gif, image/jpeg, image/png" style="position: relative; top: -50px; opacity: 0;" onchange="readIdURL(this);" required>
                            </div>
                        </div>
    
                         <div class="col-md-4 d-flex align-items-center flex-column bd-highlight p-5">
                            <p class="bd-highlight text-secondary text-center">Upload Cooperate Affairs Document  <br> <span class="text-danger"> Image or Pdf Only </span></p>
                            <div class="bd-highlight" style="border: 1px dashed #707070; opacity: 1; top: 349px; left: 295px;  width: 309px; height: 327px;">
                                <img src="..." alt="cac" class="img-thumbnail" id="cacImage">
                                <div class="d-flex align-items-center flex-column bd-highlight">
                                    <div class="bd-highlight p-2 mt-5" id="cacText">
                                        <p class="text-center " style="font-size: 35px">Drag & Drop <br> Files to Upload</p>
                                        <p class="text-secondary bd-highlight text-center">or browse for the file</p>
                                    </div>
                                    <button class="btn btn-primary bd-highlight" style="width: 195px; height: 50px; background: #206EA1 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1;">
                                        Browse
                                    </button>
                                </div>
                                <input type="file"   name="CAC"  accept="image/gif, image/jpeg, image/png, application/pdf" style="position: relative; top: -50px; opacity: 0;" onchange="readCacURL(this);" >
                            </div>
                        </div>
                    </div>

                    {{-- Guarantors Uploads --}}
                    <hr class="pt-4">                    
                    <h5 class="text-secondry">Guarantors Document Upload  </h5>
                    <div class="form-row">
                        <div class="col-md-4 d-flex align-items-center flex-column bd-highlight p-5">
                            <p class="bd-highlight text-secondary text-center">Upload Guarators Passport  <span class="text-danger"> * </span>  <br> <span class="text-danger"> Image Only </span></p>
                            <div class="bd-highlight" style="border: 1px dashed #707070; opacity: 1; top: 349px; left: 295px;  width: 309px; height: 327px;">
                                <img src="..." alt="passport" class="img-thumbnail" id="guarantorsPassport" required>
                                <div class="d-flex align-items-center flex-column bd-highlight">
                                    <div class="bd-highlight p-2 mt-5" id="guarantorsPassportText">
                                        <p class="text-center " style="font-size: 35px">Drag & Drop <br> Files to Upload</p>
                                        <p class="text-secondary bd-highlight text-center">or browse for the file</p>
                                    </div>
                                    <button class="btn btn-primary bd-highlight" style="width: 195px; height: 50px; background: #206EA1 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1;">
                                        Browse
                                    </button>
                                </div>
                                <input type="file" name="GuarantorPassport" accept="image/gif, image/jpeg, image/png" style="position: relative; top: -50px; opacity: 0;" onchange="readGurImg(this);" required>
                            </div>
                        </div>
    
                        <div class="col-md-4 d-flex align-items-center flex-column bd-highlight p-5">
                            <p class="bd-highlight text-secondary text-center">Guarantors Valid ID  <span class="text-danger"> * </span>  <br> <span class="text-danger"> Image Only </span></p>
                            <div class="bd-highlight" style="border: 1px dashed #707070; opacity: 1; top: 349px; left: 295px;  width: 309px; height: 327px;">
                                <img src="..." alt="valid Id" class="img-thumbnail" id="guarantorsId">
                                <div class="d-flex align-items-center flex-column bd-highlight">
                                    <div class="bd-highlight p-2 mt-5" id="guarantorsIdText">
                                        <p class="text-center " style="font-size: 35px">Drag & Drop <br> Files to Upload</p>
                                        <p class="text-secondary bd-highlight text-center">or browse for the file</p>
                                    </div>
                                    <button class="btn btn-primary bd-highlight" style="width: 195px; height: 50px; background: #206EA1 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1;">
                                        Browse
                                    </button>
                                </div>
                                <input type="file"  name="GuarantorIDCard" accept="image/gif, image/jpeg, image/png" style="position: relative; top: -50px; opacity: 0;" onchange="readGuIdURL(this);" required>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-center flex-column bd-highlight p-5">
                            <p class="bd-highlight text-secondary text-center">Guarantors Utility Bill  <span class="text-danger"> * </span>  <br> <span class="text-danger"> Image Only </span></p>
                            <div class="bd-highlight" style="border: 1px dashed #707070; opacity: 1; top: 349px; left: 295px;  width: 309px; height: 327px;">
                                <img src="..." alt="valid Id" class="img-thumbnail" id="guarantorsBill">
                                <div class="d-flex align-items-center flex-column bd-highlight">
                                    <div class="bd-highlight p-2 mt-5" id="guarantorsBillText">
                                        <p class="text-center " style="font-size: 35px">Drag & Drop <br> Files to Upload</p>
                                        <p class="text-secondary bd-highlight text-center">or browse for the file</p>
                                    </div>
                                    <button class="btn btn-primary bd-highlight" style="width: 195px; height: 50px; background: #206EA1 0% 0% no-repeat padding-box; border-radius: 4px; opacity: 1;">
                                        Browse
                                    </button>
                                </div>
                                <input type="file"  name="GuarantorUtilityBill" accept="image/gif, image/jpeg, image/png" style="position: relative; top: -50px; opacity: 0;" onchange="readBillURL(this);" required>
                            </div>
                        </div>
    
                         
                    </div>
                    

                    <button id="upload" class="btn mt-3 w-100" style="background: #2EB39C 0% 0% no-repeat padding-box; color: white; height: 50px;">
                        <span id="spinner"> <i class="fas fa-spinner fa-spin"></i></span>
                        Upload
                    </button>  
                </div>
    </div>
    </div>
    </form>
    <div class="flex-grow-1"></div>
    <script src="/onboarding/assets/js/jquery-3.3.1.min.js"></script>
    <script src="{{ URL::asset('assets/js/ajax.js') }}" type="text/javascript"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    $('#passportText').hide();
                    $('#passportImage').show();

                    $('#passportImage')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readIdURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#idText').hide();
                    $('#IdImage').show();

                    $('#IdImage')
                        .attr('src', e.target.result)
                        .addClass('pb-2')
                        .width(300)
                        .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readCacURL(input) {
            
            if (input.files && input.files[0]) {
                var filename = input.files[0].name;

                var ext = filename.substring(filename.lastIndexOf('.')+1, filename.length);

                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cacText').hide();
                    $('#cacImage').show();

                    if(ext == 'pdf'){
                        $('#cacImage')
                        .attr('src', '/onboarding/assets/images/pdf.png')
                        .addClass('pb-2')
                        .width(300)
                        .height(250);
                    }else{
                        $('#cacImage')
                        .attr('src', e.target.result)
                        .addClass('pb-2')
                        .width(300)
                        .height(250);
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readGurImg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    $('#guarantorsPassportText').hide();
                    $('#guarantorsPassport').show();

                    $('#guarantorsPassport')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readGuIdURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    $('#guarantorsIdText').hide();
                    $('#guarantorsId').show();

                    $('#guarantorsId')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readBillURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    $('#guarantorsBillText').hide();
                    $('#guarantorsBill').show();

                    $('#guarantorsBill')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#spinner').hide();
            $('#passportImage').hide();
            $('#cacImage').hide();
            $('#IdImage').hide();
            $('#guarantorsPassport').hide();
            $('#guarantorsId').hide();
            $('#guarantorsBill').hide();

            $("form#uploads").submit(function(e) {
                e.preventDefault();
                $('#spinner').show();
                $('#upload').prop('disabled', true);

                var formData = new FormData(this);

                var token = $("input[name=user_token]").val();

                $.ajax({
                    headers: {
                        'Authorization': token,
                    },
                    url: 'https://payvice.itexapp.com:5009/v1/agents/uploadAgentDocs',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('div#alert').text(data.message);
                        $("div#alert").addClass("alert");
                        $("div#alert").addClass("alert-success");

                        var delay = 5000; 
                        var url = '/vice/agents/completed'
                        setTimeout(function(){ window.location = url; }, delay);
                    },
                    error: function (data){
                        console.log(data)
                        console.log(typeof(data))
                        $('div#alert').text(data.statusText);
                        $("div#alert").addClass("alert");
                        $("div#alert").addClass("alert-danger");
                        $('#spinner').hide();
                        $('#upload').prop('disabled', false);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

        });
    </script>
@endsection

