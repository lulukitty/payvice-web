$(document).ready(function() {  
	$('#airtime').hide();
	$('#data').hide();
  $("#airtime_click").click(function(e){
	e.preventDefault();
	$('.select-billers').hide();
	$('#airtime').fadeIn("slow");
  });

  $("#data_click").click(function(e){
	e.preventDefault();
	$('.select-billers').hide();
	$('#data').fadeIn("slow");
  });
  
  $("#backairtimestepone").click(function(){
  if($('.airtime_stepone').is(":hidden") && $('.airtime_stepthree').is(":hidden")) {
	$(".airtime_stepone").fadeIn("slow");
	$(".airtime_steptwo").hide();
	$(".airtime_stepthree").hide();
  }
  });

  $("#backairtimesteptwo").click(function(){
	if($('.airtime_stepone').is(":hidden") && $('.airtime_steptwo').is(":hidden")) {
	  $(".airtime_steptwo").fadeIn("slow");
	  $(".airtime_stepone").hide();
	  $(".airtime_stepthree").hide();
	}
	});
	
	
$("#backdatasteptwo").click(function(){
			if($('.data_stepone').is(":hidden")) {
				$(".data_stepone").fadeIn("slow");
				$(".data_steptwo").hide();
			}
		});

  }); 