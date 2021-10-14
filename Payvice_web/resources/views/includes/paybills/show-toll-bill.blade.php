<div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-12 col-xs-12">
          @if (session('utility_pay_status_success'))
            <div class="alert alert-success text-center">
                {{ session('utility_pay_status_success') }}
            </div>
          @endif
          @if (session('utility_pay_status_error'))
            <div class="alert alert-danger text-center">
                {{ session('utility_pay_status_error') }}
            </div>
          @endif

        <div id="billstepone_toll" class="panel mt-30 bordered panel-default showdisappear">
            <div class="panel-body p-30">
              <form action="#" accept-charset="utf-8" id="utilOption" data-parsley-validate>
                    <div class="form-group">
                          <i class="ion-ios-paper-outline fstylec"></i>
                        <input placeholder="Utility Selected" class="form-control" type="text" required name="utility_unit">
                        <div style="width:50px" class="input-group-addon no-padding no-bg no-bd" id="serviceIcon_utility">
                          <img src="{{ URL::asset('assets/img/null_img.png.png') }}" alt="">
                        </div>
                        <input class="form-control" type="hidden" name="biller">
                    </div>
                    <div id="utilRoute"></div>
                    <div class="form-group-b">
                          <i class="ion-person fstylec"></i>
                        <input placeholder="ACCOUNT NUMBER" class="form-control" type="text" required name="meter"><br>
                    </div>
                    <div class="form-group-b">
                            <i class="fa fa-angle-double-down  fstylec"></i>
                          <select class="form-control" name="service" required>
                            <option value="">Select Service Type</option>
                            <option value="prepaid">Prepaid</option>
                            <option value="postpaid">Postpaid</option>
                          </select>
                    </div>
                    {{-- Inform Processsor of call type : API or View --}}
                    <input type="hidden" name="view" value="{{ rand() }}" />
                     {{-- Inform Processsor of call type : API or View --}}

                    <div id="utilityResponse"></div>
                    <br/>
                    <div class="form-group">
                      <button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                        <span class="billProceedBtnOne">PROCEED</span>
                        <span class="arrow"></span>
                    </button>
                  </div>
            </form> <!-- swapBillAuthForm -->
          </div>
      </div>
      <div class="panel-body" id="subPlan_utility" style="display: none; background: #fff;"></div>
      <!-- SHOW PLANS -->



    </div>  {{-- --end col-lg-8 --}}

    </div> {{-- --end row --}}

    <!-- Authenticate bill-payment -->

  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2 xs-hidden col-xs-12"></div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <div id="billsteptwo_toll" class="panel panel-default  no-bd shadow">

             <div class="no-margin">
                <div class="text-center">
                  <div class="authimg">
                    <img style="margin: 20px auto;" src="{{ URL::asset('assets/img/password.svg') }}">
                  </div>
                  <h4>Your 4 Digit PIN</h4>
                  <P class="medium">This is your personal digit PIN needed to complete this transaction</P>
                </div>
                <div class="no-bd">
                  <div class=" form-group">
                    <input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >
                  </div>

                  <br>
                  <div class="form-group no-margin">
                    <button id="pinProceed" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                      <span class="payBtn">PROCEED</span>
                    <span class="arrow"></span>
                  </button>
                </div>
              </div>
            </div>
          </form>

        </div>

  </div>

</div>

</div>

