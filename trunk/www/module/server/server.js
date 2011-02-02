$().ready(function() {
	
	// validate signup form on keyup and submit
	$("#addserver").validate({
		rules: {
			servername: {
				required: true,
				minlength: 5				
			},
			hostname: {
				required: true,
				minlength: 5
			}
		},
		messages: {
			servername: {
				required: " <br>Please provide a server name",
				minlength: " <br>Server name must be at least 5 characters"
			},
			hostname: {
				required: " <br>Please provide FQDN or IP Address",
				minlength: " <br>FQDN or IP Address must be at least 5 characters"
			}
		}
	});

	$("#editserver").validate({
		rules: {
			servername: {
				required: true,
				minlength: 5				
			},
			hostname: {
				required: true,
				minlength: 5
			}
		},
		messages: {
			servername: {
				required: " <br>Please provide a server name",
				minlength: " <br>Server name must be at least 5 characters"
			},
			hostname: {
				required: " <br>Please provide FQDN or IP Address",
				minlength: " <br>FQDN or IP Address must be at least 5 characters"
			}
		}
	});
		
});
