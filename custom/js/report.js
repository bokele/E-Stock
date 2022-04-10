	$(document).ready(function() {

	$('#navReport').addClass('active');
	// order date picker
	$("#startDate").datepicker();
	// order date picker
	$("#endDate").datepicker();

	//$("#getOrderReportForm").unbind('submit').bind('submit', function() {
		$(document).on("submit","#getOrderReportForm", function(event){
		
			event.preventDefault();
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
		var productStatus = $("#productStatus").val();

		if(startDate == "" || endDate == "" || productStatus=="") {
			if(startDate == "") {
				$("#startDate").closest('.form-group').addClass('has-error');
				$("#startDate").after('<p class="text-danger">Date de debut est obligatoir</p>');
				$("#startDate").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDate").closest('.form-group').addClass('has-success');	
			}

			if(endDate == "") {
				$("#endDate").closest('.form-group').addClass('has-error');
				$("#endDate").after('<p class="text-danger">Date de fin est obligatoir</p>');
				$('#endDate').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDate").closest('.form-group').addClass('has-success');	
			}
			if(productStatus=="") {
				$("#productStatus").closest('.form-group').addClass('has-error');
				$("#productStatus").after('<p class="text-danger">Type de rapport est obligatoir</p>');
				$('#productStatus').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatus").closest('.form-group').addClass('has-success');	
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');	

			//var form = $(this);
			
			if (productStatus == 2) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getOrderReport.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					
				} // /success
			});	// /ajax
			}else if (productStatus == 0) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportLiquids.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					
				} // /success
			});	// /ajax
			}//else liquids

		} // /else

		return false;
			
	});

});