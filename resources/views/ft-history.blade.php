@extends('layouts.master')
@section('content')
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-body re-padd-modal">
      <h4 class="modal-title" id="exampleModalLongTitle">Transaction Information &nbsp; 
        <button type="button" class="close right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h4>
        <span class="transactionview-dateSentence block mb-10 small"></span>
<br/>
        <div class = "row">
          <div class = "col-md-12">

            <table class="table r-font re-tbl-bordered table-striped table-hover">

              <tbody>
                <tr>
                  <td>Transaction Reference: </td>
                  <td class = "transactionview-productReference"></td>
                </tr>
                <tr>
                  <td>Transaction Sequence (For Requery): </td>
                  <td class = "transactionview-sequence"></td>
                </tr>
                <tr>
                  <td>Token Generated: </td>
                  <td class = "transactionview-token"></td>
                </tr>
                <tr>
                  <td>Terminal: </td>
                  <td class = "transactionview-terminal"></td>
                </tr>
                <tr>
                  <td>Wallet Reference: </td>
                  <td class = "transactionview-reference"></td>
                </tr>
                <tr>
                  <td >Type: </td>
                  <td class = "transactionview-type"></td>
                </tr>
                <tr>
                  <td >Amount: </td>
                  <td class = "transactionview-amount"></td>
                </tr>
                <tr>
                  <td>Payment Method: </td>
                  <td class = "transactionview-paymentMethod"></td>
                </tr>
                <tr>
                  <td>Card PAN: </td>
                  <td class = "transactionview-cardPAN"></td>
                </tr>
                <tr>
                  <td>RRN: </td>
                  <td class = "transactionview-RRN"></td>
                </tr>
                <tr>
                  <td >Commission Earned: </td>
                  <td class = "transactionview-commissionAmount"></td>
                </tr>
                <tr>
                  <td >Balance After: </td>
                  <td class = "transactionview-balanceAfter"></td>
                </tr>
                <tr>
                  <td >Category: </td>
                  <td class = "transactionview-category"></td>
                </tr>
                <tr>
                  <td >Product: </td>
                  <td class = "transactionview-product"></td>
                </tr>
                <tr>
                  <td >Description: </td>
                  <td class = "transactionview-description"></td>
                </tr>
                <tr>
                  <td >Beneficiary: </td>
                  <td class = "transactionview-accountNumber"></td>
                </tr>
                <tr>
                  <td>Customer Address: </td>
                  <td class = "transactionview-Address"></td>
                </tr>
                <tr>
                  <td>IP Address: </td>
                  <td class = "transactionview-ip_address"></td>
                </tr>
                {{-- <tr>
                  <td >Original Transaction </td>
                  <td class = ""> <span class = "transactionview-originalTransactionReference"></span> - <span class = "transactionview-originalTransactionCategory"></span> </td>
                </tr>
                <tr>
                  <td >Original Transaction Type </td>
                  <td class = "transactionview-originalTransactionType"></td>
                </tr>
                <tr>
                  <td >Original Transaction Product</td>
                  <td class = "transactionview-originalTransactionProduct"></td>
                </tr>
                <tr>
                  <td >Original Transaction Description </td>
                  <td class = "transactionview-originalTransactionDescription"></td>
                </tr>
                <tr>
                  <td >Original Transaction Amount </td>
                  <td class = "transactionview-originalTransactionAmount"></td>
                </tr> --}}

              </tbody>
            </table>

          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="productSummarryModal" tabindex="-1" role="dialog" aria-labelledby="productSummarryModal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body re-padd-modal">
        
      <h4 class="modal-title" id="exampleModalLongTitle">Product Summary &nbsp; 
          <button type="button" class="close right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h4>
        <div class = "row">
          <div class = "col-md-12">

              <div class = "table-responsive">
              

                <table class="table r-font re-tbl-bordered table-striped table-hover">
                  <thead>
                    <tr>

                      <th> Product </th>
                      <th> Total Amount </th>
                      <th> Total Count </th>
                      <th> Commission </th>
                      <th> Amount Reversed </th>
                      <th> Times Reversed </th>
                    </tr>

                  </thead>
                  <tbody>
                    @php
                    $sn = 1;
                    @endphp
                    @foreach($transactionSummary->products as $transactionProductKey => $transactionProductValue)
                    @php
                    $transactionProductSummaryViewData = (array) $transactionProductValue;
                    @endphp
                    <tr>
                      <td>{{strtoupper($transactionProductValue->name)}}</td>
                      <td>{{$transactionProductValue->amount}}</td>
                      <td>{{$transactionProductValue->count}}</td>
                      <td>{{$transactionProductValue->commissionAmount}}</td>
                      <td>{{$transactionProductValue->refundAmount}}</td>
                      <td>{{$transactionProductValue->refundCount}}</td>
                    </tr>
                    @php
                    $sn++;
                    @endphp
                    @endforeach
                  </tbody>
                </table>
              
            </div>
          </div>
        </div>
      </div>
     
    </div>
  </div>
</div>

<div id="wrapper" class="toggled" >
	<div role="navigation" class="wrap-body" id="sidebar-wrapper">
  @include('layouts.menu')
  <div class="p-20" id="page-content-wrapper">
<section>
@include('layouts.sub-menu')
<div class="row mt-100">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div id="commissionTransferSection">
                        <h3>Wallet Account History</h3>
                        <hr/>
                        <div class="panel panel-default">
                          <div class="panel-body" id="dashboard">
														<div id ="transactionHistory">
																<div class="row">
																	<div class="col-lg-12 hidden text-center col-md-12 col-sm-12 col-xs-12">
																		<p class="fg-blue medium mt10">Wallet Balance</p>
																		{{-- <h1 class="bold big-font no-margin fg-green">&#8358;{{ number_format($balance, 2) }}</h1>
																		<h6 class="fg-blue">Commission Balance: <b> &#8358;{{ number_format(floatval($commission), 2) }} </b></h6>
																		<h6 class="fg-blue">Wallet ID : {{ Session::get('curAcc') }}</h6> --}}
                                  </div>
																	<div class="col-md-12 col-sm-12 payProcess">
                                    <div class="row">
                                    <form method = "get">
                                      <div class="col-md-3">
                                      <label class="" for="">Please Select Sub Agent</label>
                                       <div class="form-group">
                                        <select class="form-control-alt" name = "subAgent">
                                          {!!$walletsDropDown!!}
                                        </select>
                                      </div> 
                                      </div>
                                      <div class="col-md-3">
                                      <label class="" for="">Filter Product</label>  
                                      <div class="form-group">
                                        <select class="form-control-alt" name = "product">
                                            {!!$productsDropDown!!}
                                        </select>
                                      </div></div>
                                      
                                      <div class="col-md-2">
                                      <label for="" class = "">Start Date</label>
                                      <div class="form-group">
                                        <div class="input-group date" data-provide="datepicker" data-date-format = "yyyy-mm-dd">
                                            <input type="text" class="form-control-alt startdate" name = "startDate" value = "{{request('startDate') ?? date('Y-m-d')}}" autocomplete="off">
                                            <div class="input-group-addon abs-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>                                        
                                      </div>
                                      </div>
                                      
                                      <div class="col-md-2">
                                      <label for="" class = "">End Date</label>  
                                      <div class="form-group">
                                        <div class="input-group date" data-provide="datepicker" data-date-format = "yyyy-mm-dd">
                                            <input type="text" class="form-control-alt enddate" name = "endDate" value = "{{request('endDate') ?? date('Y-m-d')}}" autocomplete="off">
                                            <div class="input-group-addon abs-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                      </div></div>
                                      <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
<button type="submit" id="commissionStepOne" class="btn-primary btn-lg btn btn-block">
Filter <i class="fa ml-5 fa-search"></i>
                                      </button> 
                                        </div>
                                    </div>
                                </form>

                                  @if($errors !== false)
                                    <div class="form-inline">
                                      <div class="form-group text-left">
                                        <br>
                                        @include('layouts.errors')
                                    </div>
                                  </div>

                                  @endif
                                  </div>
                                </div>
                            
                                <div class="col-lg-12">
                                <div class="row">
                                <div class="col-md-4">
                                    <div class="well well-sm">
                                      <p class="mb-20">Total <span class="badge right">{{$transactionSummary->count}}</span> </p>
                                      <h4>&#8358; {{$transactionSummary->amount}}</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="well well-sm">
                                      <p class="mb-20">Credits <span class="badge right">{{$transactionSummary->creditCount}}</span> </p>
                                      <h4>&#8358; {{$transactionSummary->creditAmount}} </h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="well well-sm">
                                      <p class="mb-20">Debits <span class="badge right">{{$transactionSummary->debitCount}}</span></p>
                                      <h4>&#8358; {{$transactionSummary->debitAmount}} </h4>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    {{-- <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#productSummarryModal"><i class="fa mr-5 fa-eye"></i>View Detailed Product Summarry</button> --}}
                                    <a href="{{url('/dashboard/transaction-history')}}" class="btn btn-sm btn-primary"><i class="fa fa-eye mr-5"></i>Reset All Filters</a>
                                </div>
                              </div>
                              </div>

                            <div class="col-lg-12">
                              <div class="row">
                               <div class = "col-lg-12">
                                <div class = "table-responsive">
                                  <table id="accounts" class="table r-font re-tbl-bordered table-striped table-hover">
                                    <thead>
                                      <tr>
                                        <th> # </th>
                                        <th> Wallet ID  </th>
                                        <th> Reference</th>
                                        <th> Product </th>
                                        <th> Debit </th>
                                        <th> Credit </th>
                                        <th> Balance </th>
                                        {{-- <th> Beneficiary </th> --}}
                                        <th> Date </th>

                                      </tr>

                                    </thead>
                                    <tbody>
                                      @php
                                      $sn = 1;
                                      @endphp
                                      @foreach($transactions as $transaction)
                                      <?php 
                                        $transactionViewData = (array) $transaction;
                                        // $vasData = [];
                                        // if($transactionViewData['vasData'] && is_array($transactionViewData['vasData'])){
                                        //     array_merge($transactionViewData, $transactionViewData['vasData']); 
                                        // }
                                      ?>
                                      <tr>
                                        <td>{{$sn}}</td>
                                        <td>{{$historyInfo->walletID}}</td>
                                        <td>{{$transaction->productReference ?? ''}}</td>
                                        <td>{{$transaction->product}} ({{$transaction->category}})</td>
                                      <td style="color: red;">@if($transaction->type == "Debit") &#8358; {{$transaction->amount}} @else {{ "-" }} @endif</td>
                                        <td style="color: green;">@if($transaction->type == "Credit") &#8358; {{$transaction->amount}} @else {{ "-" }} @endif</td>
                                        <td>&#8358; {{$transaction->balanceAfter}}</td>
                                        {{-- <td>{{$transaction->beneficiary}}</td> --}}
                                        <td>{{$transaction->date}}</td>
                                        {{-- <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal" data-transactionview='{!!json_encode($transactionViewData)!!}'>Info</button></td> --}}
                                      </tr>
                                      @php
                                      $sn++;
                                      @endphp
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                <nav aria-label="...">
                                  <ul class="pager">

                                    @if($previousPage !== false)
                                    <li class="previous"><a href = "{{$previousPageUrl}}"><span aria-hidden="true">&larr;</span> Previous Page </a></li>
                                    @endif
                                    @if($nextPage !== false)
                                    <li class="next"><a href = "{{$nextPageUrl}}">Next Page <span aria-hidden="true">&rarr;</span></a></li>
                                    @endif
                                  </ul>
                                </nav>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
</div>
</div>
</section>
</div>


  @section("commissionTransferScripts")
  <!-- <script src="{{ URL::asset('assets/js/jquery-ui.js') }}"></script> -->

 <script>

  $(document).ready(function(){
    $('.startdate').datepicker({format: 'yyyy-mm-dd'});
    $('.enddate').datepicker({format: 'yyyy-mm-dd'});
  });

  
  $('#viewModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var transactionView = button.data('transactionview') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      //modal.find('.transactionview-title').text('New message to ' + recipient)


      for(detail in transactionView){
        if(typeof transactionView[detail] == 'object' && transactionView[detail] !== null){
          for(vasdetail in transactionView[detail]){
            modal.find('.transactionview-' + vasdetail).text(transactionView[detail][vasdetail]);
            console.log({key: vasdetail, value: transactionView[detail][vasdetail]});
          }
        } else {
          modal.find('.transactionview-' + detail).text(transactionView[detail]);
          console.log({key: detail, value: transactionView[detail]});
        }
      
      }

     // posresponse = JSON.stringify(posresponse, undefined, 2);

     // modal.find('.posresponse').html(posresponse)

   })

   $(document).ready( function () {
      $('#accounts').DataTable({
      pageLength: 50,
      bPaginate: true,
      dom: 'Bfrtip',
      buttons: [
          'csv', 'excel', 'print',
          {extend : 'pdfHtml5',
            orientation : 'landscape',
            pageSize : 'LEGAL',
            text : '<i class="fa fa-file-pdf-o"> PDF</i>',
            titleAttr : 'PDF'
          } 
      ]});
  });

 </script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
 @endsection









</div>
</div>    
@stop
