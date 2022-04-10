	$(document).ready(function() {

	$('#navUser').addClass('active');
$('#topNavSociete').addClass('active');
	$("#logoImage").fileinput({
	      overwriteInitial: true,
		    maxFileSize: 2500,
		    showClose: false,
		    showCaption: false,
		    browseLabel: '',
		    removeLabel: '',
		    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-1',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
	  		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
			});  

$("#submitLogoForm").unbind('submit').bind('submit', function() {
	var logoImage 		= $("#logoImage").val();

	if (logoImage == "") {
		$('#add-societe-messages').html('<div class="alert alert-danger">'+
	        '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>Veillez Ajoute un logo</div>'
		);
	}else{

		alert(logoImage );
			$("#createLogoBtn").button('loading');

				var form = $(this);
				// button loading
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						// button loading
						

						if(response.success == true) {
							$("#createLogoBtn").button('loading');
							$("#submitLogoForm")[0].reset()

							$('#add-societe-messages').html('<div class="alert alert-success">'+
		            		'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            		'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          			'</div>');
						}else{
							$("#submitLogoForm")[0].reset()
							$('#add-societe-messages').html('<div class="alert alert-danger">'+
		            		'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            		'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          			'</div>');
						}
					}
				});
	}

});

});