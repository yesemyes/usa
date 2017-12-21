jQuery(document).ready(function($)
{
	function getDayDelta(leadDate, paymenDate)
    {
        var leadDate = new Date(leadDate[0],leadDate[1]-1,leadDate[2]),
        paymenDate = new Date(paymenDate[0], paymenDate[1]-1, paymenDate[2]), delta;
        paymenDate.setHours(0);
        paymenDate.setMinutes(0);
        paymenDate.setSeconds(0);
        paymenDate.setMilliseconds(0);
        delta = leadDate - paymenDate;
        return Math.round(delta / 1000 / 60 / 60/ 24);
    }

	$(function () {$('.datetimepicker').datetimepicker({format: 'DD-MM-YYYY'});});

	$(document).on("blur",".datetimepicker",function()
    {
    	var dataPickers = $(this).parents('.tablerow').find('.datetimepicker > input');
    	var lead_date = $(dataPickers[0]).val();
    	var payment_date = $(dataPickers[1]).val();
    	if( lead_date != "" && payment_date != "" ){
	    	var arr_lead = lead_date.split('-');
	    	var arr_payment = payment_date.split('-');
	    	var age_val = getDayDelta( [ arr_payment[2],arr_payment[1],arr_payment[0] ], [ arr_lead[2],arr_lead[1],arr_lead[0] ] );
	    	var age = $(this).parents('.tablerow').find('.age').val(age_val);
    	}
    });

    $(document).on("change","select[name='payment_method_id[]']",function(){
		if($(this).val()==14){
            $(this).parents('.tablerow').find('.return_check').css({"display":"table"});
		}else{
            $(this).parents('.tablerow').find('.return_check').hide();
		}
	});

    $(document).on("click",".add",function()
    {
    	$(document).on("click",".del",function(){$(this).parent().parent().parent().remove();});

    	var total_price = parseInt($("#total_price").val());
    	if( isNaN(total_price) ) total_price = 0;
    	var amount_due = parseInt($(this).parents('.tablerow').find('.amount_due').val());
    	var lead_date = $(this).parents('.tablerow').find("input[name='lead_date[]']");
    	var lead_dates = $(this).parent().parent().parent().parent().find("input[name='lead_date[]']");
    	var payment_date = $(this).parents('.tablerow').find("input[name='payment_date[]']");
    	var age = parseInt($(this).parents('.tablerow').find("input[name='age[]']").val());
    	if( isNaN(age) ) age = 0;
    	var this_select_pay = $(this).parents('.tablerow').find('.pay').html();
    	var this_select_pay_type = $(this).parents('.tablerow').find('.pay_type').html();
	    var this_select_worker = $(this).parents('.tablerow').find('.worker').html();

		if( lead_date.val() != '' && payment_date.val() != '' && total_price > 0 ) {
    		if( amount_due == total_price ) {
    			$('#total_price').css({"border":"1px solid #efc80c"});
    			$(this).parents('.tablerow').find('.amount_due').css({"border":"1px solid #efc80c"});
				return false;
			} else if( lead_dates.length == 1 && amount_due < total_price ) var second_amount_due = total_price - amount_due;
    		else var second_amount_due = '';
    		
			$("#cont").append('<div class="row tablerow"><input type="hidden" name="tID[]" value="0"><div class="col-md-1"><div class="form-group"><a class="btn btn-success form-control add"><i class="fa fa-plus"></i></a></div></div><div class="col-md-2"><div class="form-group"><div class="input-group date datetimepicker"><input type="text" name="lead_date[]" class="form-control" required /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group date datetimepicker"><input type="text" name="payment_date[]" class="form-control" required /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><div class="col-md-1"><div class="form-group"><input type="text" name="age[]" readonly required class="form-control age" /></div></div><div class="col-md-2"><div class="form-group"><select name="payment_method_id[]" class="form-control pay" required></select><div class="input-group date return_check none"><input type="text" name="check_price[]" class="form-control amCol" placeholder="Check (m or i)"/><span class="input-group-addon"><i class="fa fa-usd"></i><input type="checkbox" class="" name="check[]"/></span></div></div></div><div class="col-md-2"><div class="form-group"><select name="payment_type_id[]" class="form-control pay_type" required></select></div></div><div class="col-md-2"><div class="form-group"><select name="worker_id[]" class="form-control worker" required></select></div></div><div class="col-md-2"><div class="form-group"><div class="input-group date"><input type="text" name="amounts_due[]" class="form-control amount_due" value="'+second_amount_due+'" required><span class="input-group-addon"><input type="checkbox" class="payed" name="payed[]"></span></div></div></div></div>');
			$('.datetimepicker').datetimepicker({format: 'DD-MM-YYYY'});
	    	
			$(this).parents('.tablerow').next().find('.pay').html(this_select_pay);
			$(this).parents('.tablerow').next().find('.pay_type').html(this_select_pay_type);
			$(this).parents('.tablerow').next().find('.worker').html(this_select_worker);
	    	
		    if( lead_dates.length != 1 ) {
    			$(this).find(".fa-plus").toggleClass('fa-plus fa-minus');
				$(this).toggleClass('btn-success btn-danger');
				$(this).toggleClass('add del');
				if( $(this).hasClass('updateTransaction') ) $(this).parent().parent().parent().remove();
    		} else $(this).remove();
		}
	});
	
	$(document).on("click","#updateTransaction",function(){
		var total = $("#total_price").val();
		var amout_total = parseInt(0);
	    var amout = $('.tablerow .amount_due');
	    $.each(amout,function(index,value){
			amout_total += parseInt($(this).val());
		});
		if( parseInt(amout_total) == parseInt(total) ){
			$('#total_price').css({"border":"1px solid #efc80c"});
    		$('.amount_due').css({"border":"1px solid #efc80c"});
    		$('.add').hide();
    		
		}else if( parseInt(amout_total) > parseInt(total) ) {
			$('#total_price').css({"border":"1px solid #efc80c"});
    		$('.amount_due').css({"border":"1px solid #efc80c"});
    		$('.add').hide();
			return false;
		}
		else{
			$('#total_price').css({"border":"1px solid #ccc"});
    		$('.amount_due').css({"border":"1px solid #ccc"});
			$('.add').show();
		}
		
		$(".pMsR").remove();
	});
		
    $(document).on("click","a[id^='del-']",function() {
    	var del_tDetalisID = this.id.split('-')[1];
    	var this_element = $(this).parent().parent().parent();
	    $.ajaxSetup({
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	    });
	    $.ajax(
	    {
	        url: "/deleteTrDetalis/"+del_tDetalisID,
	        type: 'POST',
	        data: {"id": del_tDetalisID},
	        success: function (response) {
	            if(response=="ok"){
    				this_element.remove();
	            }
	        },
	        error: function(xhr) {
	         	console.log(xhr.responseText);
	       }
	    });
    });

});