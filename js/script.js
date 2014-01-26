$(document).ready(function(){


		$('#registration-form').validate({
	    rules: {
            twitterhandle: {
                required: true,
                minlength:2
            },

            name: {
	            required: true,
                minlength:2,
                maxlength:50
	        },
		  
            email: {
                required: true,
                email: true
            },

            sometext: {
                required: false,
                maxlength:200
            },

            agree: "required"

	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
//				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); // end document.ready