@extends('onboarding.layout')
@section('content')

    <div id="alert" >
    </div>

    <form  id="agent-form" >
    {{csrf_field()}}
    <div class="row justify-content-md-center">
    <div class="col-md-10"> 
            <input type="hidden" class="form-control" name="userCode" value="{{ $userCode }}"  required="required" disabled>           
            <!-- One "tab" for each step in the form: -->
            <div class="tab pl-3 pr-3">
                <h5 class="mt-3 mb-4 text-secondary ">Personal & Business Information    <small>Fields marked <span class="text-danger"> * </span> are compulsory</small></h5>
                <div class="row pr-3 pl-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group form-row mb-4">
                                    <div class="col-md-6 pr-2 mr-2 no-padding">
                                        <label>Gender  <span class="text-danger"> * </span></label>
                                        <select name="gender" class="form-control">
                                            <option value="">-Select Options- </option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div clas="col-md-6">
                                        <label>Profession  <span class="text-danger"> * </span></label>
                                        <input type="text" class="form-control" name="profession" placeholder="Your Profession" required>
                                    </div>    
                                </div>
        
                                <div class="form-group form-row mb-4">
                                    <div class="col-md-7 pr-3 no-padding">
                                        <label>Password <span class="text-danger">(Min 8 Digits & Numbers Only) * </span></label>
                                        <input type="password" class="form-control" name="password" placeholder="Create a password" required>
                                    </div> 
                
                                    <div class="col-md-5 pl-3 no-padding">
                                        <label>Confirm Password  <span class="text-danger"> * </span></label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Verify Password" required>
                                    </div>        
                                </div>
        
                                <div class="form-group form-row mb-4">
                                    <div class="col-md-6 pr-3 no-padding">
                                        <label>Pin  <span class="text-danger">(4 digit Number) * </span></label>
                                        <input type="password" class="form-control" name="pin" placeholder="Crate a Pin" required>
                                    </div> 
                
                                    <div class="col-md-6 pl-3 no-padding">
                                        <label>Confirm Pin  <span class="text-danger"> * </span></label>
                                        <input type="password" class="form-control" name="pin_confirmation" placeholder="Verify Pin" required>
                                    </div>
                                </div>
        
                                <div class="form-group mb-4">
                                    <label>Date of Birth  <span class="text-danger"> * </span></label>
                                    <p><span class="text-danger"> Must Match BVN Records </span></p>
                                    <div class="form-row">
                                            <input class="col-md-6 form-control" type="text" id="datepicker"  name="date_of_birth" placeholder="DD-MM-YYYY" required style="width: 150px">
                                            <span class="col-md-6"> <img src="/onboarding/assets/images/calendar.svg" alt="" style="width: 46px; height: 40px;"></span> 
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="form-group mb-4 pr-5 no-padding">
                            <label>Residential Address  <span class="text-danger"> * </span></label>
                            <input type="text" name="residential_address" class="form-control" required>
                            {{-- <textarea class="form-control" name="residential_address" aria-label="With textarea"></textarea> --}} 
                        </div>
                    </div>

                    {{-- next column --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4 pr-5 no-padding">
                            <label>Business Name  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="business_name" placeholder="Business name" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Office Address  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="office_address" placeholder="E.g 163A Sinari Daranijo Street" required>
                        </div>
                        
                        <div class="form-group form-row mb-4">
                            <div class="col-md-4 pr-4 no-padding">
                                <label>State / Province  <span class="text-danger"> * </span></label>
                                <select class="form-control" name="office_state" id="state" required>
                                    <option value="" selected="selected">- Select Option -</option>
                                    <option value="FCT">Abuja FCT</option>
                                    <option value="Abia">Abia</option>
                                    <option value="Adamawa">Adamawa</option>
                                    <option value="Akwa-Ibom">Akwa Ibom</option>
                                    <option value="Anambra">Anambra</option>
                                    <option value="Bauchi">Bauchi</option>
                                    <option value="Bayelsa">Bayelsa</option>
                                    <option value="Benue">Benue</option>
                                    <option value="Borno">Borno</option>
                                    <option value="Cross-River">Cross River</option>
                                    <option value="Delta">Delta</option>
                                    <option value="Ebonyi">Ebonyi</option>
                                    <option value="Edo">Edo</option>
                                    <option value="Ekiti">Ekiti</option>
                                    <option value="Enugu">Enugu</option>
                                    <option value="Gombe">Gombe</option>
                                    <option value="Imo">Imo</option>
                                    <option value="Jigawa">Jigawa</option>
                                    <option value="Kaduna">Kaduna</option>
                                    <option value="Kano">Kano</option>
                                    <option value="Katsina">Katsina</option>
                                    <option value="Kebbi">Kebbi</option>
                                    <option value="Kogi">Kogi</option>
                                    <option value="Kwara">Kwara</option>
                                    <option value="Lagos">Lagos</option>
                                    <option value="Nassarawa">Nassarawa</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Ogun">Ogun</option>
                                    <option value="Ondo">Ondo</option>
                                    <option value="Osun">Osun</option>
                                    <option value="Oyo">Oyo</option>
                                    <option value="Plateau">Plateau</option>
                                    <option value="Rivers">Rivers</option>
                                    <option value="Sokoto">Sokoto</option>
                                    <option value="Taraba">Taraba</option>
                                    <option value="Yobe">Yobe</option>
                                    <option value="Zamfara">Zamfara</option>
                                </select>
                            </div> 
                            
                            <div class="col-md-4 pl-4 no-padding">
                                <label>Local Government  <span class="text-danger"> * </span></label>
                                <select name="office_lga" class="form-control"> </select><span id="lga_spinner" class="text-primary"> <i class="fas fa-spinner fa-spin p-2"></i>Fetching LGA's</span>
                            </div>

                            <div class="col-md-4 pl-4 no-padding">
                                <label>Ward</label>
                                <input type="text" class="form-control" name="ward" placeholder="Ward">
                            </div>
                        </div>

                        
                        
                        <div class="form-group mb-4 form-row">
                            <div class="col-md-6 pr-4 no-padding">
                                <label>Position / Status  <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="position" placeholder="Position" required>
                            </div>
                            <div class="col-md-6 pl-4 no-padding">
                                <label>Trade Partner  <span class="text-danger"> * </span></label>
                                <select name="trade_partners" class="form-control">
                                    <option value="">-Select Options- </option>
                                    @foreach ($TP as $tps)
                                    <?php 
                                            foreach($tps as $key => $value){
                                                echo"<option value='$value'>$value</option>";
                                            }
                                    ?>
                                    @endforeach
                                </select>
                            </div>    
                        </div>

                        <div class="form-group mb-4">
                            <label style="display: block; width: 100%; margin-bottom: 10px;">Outlet Type  <span class="text-danger"> * </span></label>
                            <label class="radio mr-4 d-inline-flex radio-outline-primary">
                                <input type="radio" name="outlet" value="Shop">
                                <span>Shop</span>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio mr-4 d-inline-flex radio-outline-primary">
                                <input type="radio" name="outlet" value="Kiosk">
                                <span>Kiosk</span>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio mr-4 d-inline-flex radio-outline-primary">
                                <input type="radio" name="outlet" value="Umbrella">
                                <span>Umbrella</span>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio mr-4 d-inline-flex radio-outline-primary">
                                <input type="radio" name="outlet" value="Office">
                                <span>Office</span>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio mr-4 d-inline-flex radio-outline-primary">
                                <input type="radio" name="outlet" value="Others">
                                <span>Others</span>
                                <span class="checkmark"></span>
                            </label> 
                        </div>     
                    </div>
                </div>
               
                <hr>
                <h5 class="text-secondary">Next of Kin Details</h5>

                <div class="form-row pt-3 mb-4 pr-3 no-padding">
                    <div class="col-md-6">
                        <label>Full Name  <span class="text-danger"> * </span></label>
                        <input type="text" class="form-control" name="next_of_kin_fullname" placeholder="Next of kin's Full Name" required>
                    </div> 

                    <div class="col-md-3 pr-3 no-padding">
                        <label>Email  <span class="text-danger"> * </span></label>
                        <input type="email" class="form-control" name="next_of_kin_email" placeholder="Nex of Kin's email" required>
                    </div> 

                    <div class="col-md-3">
                        <label>Phone Number  <span class="text-danger"> * </span></label>
                        <div class="form-row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="nok_phone_code" value="234" disabled required>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="next_of_kin_phone" placeholder="810000000" required>
                            </div>
                        </div>
                    </div>                    
                </div>

                {{-- <p><input placeholder="First name..." oninput="this.className = ''"></p>
              <p><input placeholder="Last name..." oninput="this.className = ''"></p> --}}
              {{-- <p><input placeholder="First name..." oninput="this.className = ''"></p>
              <p><input placeholder="Last name..." oninput="this.className = ''"></p> --}}
            </div>
            
            <div class="tab">
                <h5 class="text-secondary mt-4">Guarantors Information</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label>First Name  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="guarantors_first_name" placeholder="Guarantors First Name" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Last Name  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="guarantors_last_name" placeholder="Guarantors Last Name" required>
                        </div>

                        <div class="form-grup mb-4">
                            <label>Profession  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="guarantors_profession" placeholder="Guarantors Profession" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Email  <span class="text-danger"> * </span></label>
                            <input type="email" class="form-control" name="guarantors_email" placeholder="Guarantor's email" required>
                        </div> 
    
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label>Residential Address  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="guarantors_residence" placeholder="Guarantors Residential Address" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Office Address  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="guarantors_office" placeholder="Guarantors Office Address" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Phone  <span class="text-danger"> * </span></label>
                            <div class="form-row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="gt_phone_code" value="234" disabled required>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="guarantors_phone" placeholder="81000000" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Relationship  <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="guarantors_relationship" placeholder="Guarantors relationship status" required>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="tab">
                <h5 class="text-secondary mt-4">Bank Information</h5>                
                
                <div class="form-row mt-3">
                    
                    <div class="col-md-4 mb-4">
                        <label>Bank Account Number  <span class="text-danger"> * </span></label>
                        <input type="text" name="bank_account" placeholder="Bank Account Number" class="form-control" required />
                    
                    </div>
                    <div class="col-md-4 mb-4">
                        <label>Bank Name  <span class="text-danger"> * </span></label>
                        <select class="form-control" name="bank_code">
                            <option value="">Select Bank -- </option>
                            <option value="044150149">ACCESS BANK PLC</option>
                            <option value="023150005">CITI BANK</option>
                            <option value="063150162">DIAMOND BANK PLC</option>
                            <option value="050150311">ECOBANK NIGERIA</option>
                            <option value="084150015">ENTERPRISE BANK</option>
                            <option value="040150101">ETB</option>
                            <option value="214150018">FCMB PLC</option>
                            <option value="070150003">FIDELITY BANK PLC</option>
                            <option value="011152303">FIRST BANK PLC</option>
                            <option value="030159992">HERITAGE BANK</option>
                            <option value="301080020">JAIZ BANK</option>
                            <option value="082150017">KEYSTONE BANK PLC</option>
                            <option value="014150030">MAIN STREET BANK</option>
                            <option value="023150005">NIB</option>
                            <option value="076151006">SKYE BANK PLC</option>
                            <option value="221159522">STANBIC IBTC BANK</option>
                            <option value="068150057">STANDARD CHARTERED</option>
                            <option value="232150029">STERLING BANK PLC</option>
                            <option value="033154282">UBA PLC</option>
                            <option vallue="032156825">UNION BANK PLC</option>
                            <option value="215082334">UNITY BANK PLC</option>
                            <option value="035150103">WEMA BANK PLC</option>
                            <option value="057150013">ZENITH BANK PLC</option>
                            <option value="058152052">GT BANK</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label>BVN <span class="text-danger"> Dial *565*0# To Verify  * </span></label>
                        <input type="text" name="bvn" placeholder="Bank Verification Number" class="form-control" />
                    </div>                
                </div>

                <div class="form-group form-row pt-3">
                    <div class="col-md-1">
                        <span class="text-danger"> * </span><input type="checkbox" class="form-check-input" style="margin-left: 35px;" id="declaration" onclick="enableSubmit()">
                    </div>
                    <div class="col-md-11">
                        <p>I do hereby and solemnly declare with my full knowledge and consent to take up Agency with ITEX and I hereby 
                            declare that the particulars given by me hereof are valid and correct.</p>
                    </div>
                  </div>
              
            </div>
            
            <div style="overflow:auto;">
              <div class="d-flex justify-content-center" style="">
                <button type="button" class="btn" class="btn" style="background: #A3A3A3 0% 0% no-repeat padding-box; margin-right: 5px; 
                border-radius: 4px; color: white;  width: 230px; margin-top: 10px; height: 50px;" id="prevBtn" onclick="nextPrev(-1)">Back</button>

                <button type="button" class="btn" style="background: #2EB39C 0% 0% no-repeat padding-box; margin-left: 5px;
                border-radius: 4px; color: white;  width: 230px; margin-top: 10px; height: 50px;" id="nextBtn" onclick="nextPrev(1)">
                Next</button><span id="spinner" class="pl-3 text-secondary"> <i class="fas fa-spinner fa-spin" style="margin: 25px"></i></span> 
              </div>
            </div>
            
            <div>
                <button type="submit" id="regAgent">
                </button>
            </div>
            
            {{-- <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:40px;">
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
            </div> --}}
    </div>
    </div>
    </form>
    <div class="flex-grow-1"></div>
    <script src="/onboarding/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/onboarding/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/onboarding/assets/js/jquery.smartWizard.min.js"></script>
    <script src="/onboarding/assets/js/script.min.js"></script>
    <script src="/onboarding/assets/js/smart.wizard.script.js"></script>

    <script src="/assets/js/ajax.js"></script>

    <script type="text/javascript">

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $( function() {
            var year = new Date().getFullYear();
            $( "#datepicker" ).datepicker({ changeMonth: true, changeYear: true, yearRange: "1940:"+year });
        } );

        jQuery(document).ready(function($){
                $('#spinner').hide();
                $('#regAgent').hide();
                
                $( '#regAgent' ).on('click', function(e) {
                    e.preventDefault();
                    $('#spinner').show();
                    $('#nextBtn').prop('disabled', true);
                    $('div#alert').text("");
                    $("div#alert").removeClass("alert");
                    $("div#alert").removeClass("alert-danger");
    
                    var $inputs = $('#agent-form :input');

                    // not sure if you wanted this, but I thought I'd add it.
                    // get an associative array of just the values.
                    var data = {};
                    $inputs.each(function() {
                        data[this.name] = $(this).val();
                    });    
    
                        $.ajax({
                            type:'POST',
                            url:'/vice/agents/save-biodata',
                            data,
        
                            success:function(data){
                                if(data.status === 200){
                                    $('div#alert').text(data.message);
                                    $("div#alert").addClass("alert");
                                    $("div#alert").addClass("alert-success");
        
                                    var delay = 2000; 
                                    var url = '/vice/agents/uploads'
                                    setTimeout(function(){ window.location = url; }, delay);
                                }else{
                                    $('div#alert').text(data.message);
                                    $("div#alert").addClass("alert");
                                    $("div#alert").addClass("alert-danger");
                                    $('#spinner').hide();
                                    $('#nextBtn').prop('disabled', false);
                                }
                            },
                            error: function(data){
                                console.log(data);
                                $('div#alert').text(data.message);
                                $("div#alert").addClass("alert");
                                $("div#alert").addClass("alert-danger");
                                $('#spinner').hide();
                                $('#nextBtn').prop('disabled', false);
                            }
                        });
    
                });
            })

            $(document).ready(function() {
            $('#lga_spinner').hide();
            $('select[name="office_state"]').on('change', function() {
                $('#lga_spinner').show();
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: 'https://payvice.itexapp.com:5009/v1/location/statelgas/'+stateID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('#lga_spinner').hide();

                            $('select[name="office_lga"]').empty();
                            $.each(data.data, function( lga, code ) {
                                $('select[name="office_lga"]').append('<option value="'+ code.code +'">'+ code.name +'</option>');
                            });
                        },
                        c
                    });
                }else{
                    $('#lga_spinner').hide();
                    $('select[name="office_lga"]').empty();
                }
            });
        });
</script>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
        document.getElementById("nextBtn").disabled = true;
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
        // var checked = document.getElementById("declaration").checked
        document.getElementById("nextBtn").disabled = false;
        document.getElementById("declaration").checked = false
    }
    // ... and run a function that displays the correct step indicator:
    // fixStepIndicator(n)
    }

    function nextPrev(n) {
        $('div#alert').text("");
        $("div#alert").removeClass("alert");
        $("div#alert").removeClass("alert-danger");
    var checkSubmit = document.getElementById("nextBtn").innerHTML;

    if(n === 1 && checkSubmit === "Submit"){
        document.getElementById("regAgent").click();
    }else{
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :
            // if (currentTab >= x.length) {
            // //...the form gets submitted:
            // document.getElementById("regForm").submit();
            // return false;
            // }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }
    }

    function validateForm() {
        var validate = false;
        if(currentTab == 0){
            validate = validateFirstTab();
        }else if (currentTab == 1){
            validate = validateSecondTab();
        }
    return validate
    }

    function validateFirstTab(){
        var res = true
        var allFields = {
            profession: document.querySelector('[name="profession"]').value,
            password: document.querySelector('[name="password"]').value,
            password_confirmation: document.querySelector('[name="password_confirmation"]').value,
            pin: document.querySelector('[name="pin"]').value,
            pin_confirmation: document.querySelector('[name="pin_confirmation"]').value,
            date_of_birth: document.querySelector('[name="date_of_birth"]').value,
            residential_address: document.querySelector('[name="residential_address"]').value,
            business_name: document.querySelector('[name="business_name"]').value,
            office_address: document.querySelector('[name="office_address"]').value,
            office_state: document.querySelector('[name="office_state"]').value,
            office_lga: document.querySelector('[name="office_lga"]').value,
            position: document.querySelector('[name="position"]').value,
            trade_partners: document.querySelector('[name="trade_partners"]').value,
            outlet: document.querySelector('[name="outlet"]').value,
            next_of_kin_fullname: document.querySelector('[name="next_of_kin_fullname"]').value,
            next_of_kin_email: document.querySelector('[name="next_of_kin_email"]').value,
            next_of_kin_phone: document.querySelector('[name="next_of_king_phone"]').value,
            nok_phone_code: document.querySelector('[name="nok_phone_code"]').value,
            gender: document.querySelector('[name="gender"]').value,
        }
        // var allValues = Object.keys(allFields);
        var errorFields = [];
        Object.keys(allFields).forEach(el => {
            if (allFields[el] == ""){
                errorFields.push(el.replace(/_/g, " "));
                res = false
            }
        })
        if(res == false){
            var errText = errorFields.toString();
            var text = "The following fields are required: " + errText.replace(/,/g, ", ")
            $('div#alert').text(text);
            $("div#alert").addClass("alert");
            $("div#alert").addClass("alert-danger");
        }else{
            if (allFields.password !== allFields.password_confirmation || allFields.pin !== allFields.pin_confirmation){
                res = false
                let text = "";
                if(allFields.password !== allFields.password_confirmation) text = text + "Passwords does not match"
                if(allFields.pin !== allFields.pin_confirmation) text = text + " Pin does not match"
                $('div#alert').text(text);
                $("div#alert").addClass("alert");
                $("div#alert").addClass("alert-danger");
            }else if(isNaN(allFields.password) || (allFields.password).length < 8){
                res = false
                let text = "Password must be numbers only and Minimum 8 digits";
                $('div#alert').text(text);
                $("div#alert").addClass("alert");
                $("div#alert").addClass("alert-danger");
            }else if(isNaN(allFields.pin) || (allFields.pin).length !== 4 ){
                res = false
                let text = "Pin must be a 4 digit Number";
                $('div#alert').text(text);
                $("div#alert").addClass("alert");
                $("div#alert").addClass("alert-danger");
            }
        }
        return res
    }

    function validateSecondTab(){
        var res = true;
        var allFields = {
            guarantors_first_name: document.querySelector('[name="guarantors_first_name"]').value,
            guarantors_last_name: document.querySelector('[name="guarantors_last_name"]').value,
            guarantors_profession: document.querySelector('[name="guarantors_profession"]').value,
            guarantors_email: document.querySelector('[name="guarantors_email"]').value,
            guarantors_residence: document.querySelector('[name="guarantors_residence"]').value,
            guarantors_office: document.querySelector('[name="guarantors_office"]').value,
            guarantors_phone: document.querySelector('[name="guarantors_phone"]').value,
            guarantors_relationship: document.querySelector('[name="guarantors_relationship"]').value,
        }
        var errorFields = [];
        Object.keys(allFields).forEach(el => {
            if (allFields[el] == ""){
                errorFields.push(el.replace(/_/g, " "));
                res = false
            }
        })
        if(res == false){
            var errText = errorFields.toString();
            var text = "The following fields are required: " + errText.replace(/,/g, ", ")
            $('div#alert').text(text);
            $("div#alert").addClass("alert");
            $("div#alert").addClass("alert-danger");
        }
        
        return res
    }

    function enableSubmit(){
        document.getElementById("nextBtn").disabled = false;
    }
</script>

@endsection

