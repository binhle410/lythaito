$(document).ready(function() { 

	$('button[type=\'submit\']').on('click', function() {
		$("form[id*='form-']").submit();
	});

	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
			
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	}); 
	
	$('body').on('click', '.alert i.fa-times', function(){
		$(this).parent().slideUp( "slow", function() {
			$(this).remove();
		});
		 
	})
	
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
}); 
