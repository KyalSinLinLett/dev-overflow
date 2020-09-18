{

	// member search //

	$(document).ready(function(){
	  $("#clearbtn").hide();
	});	

	$('body').on('keyup', '#search-member', function(){
	    var search_query = $(this).val();
		var group_id = $(this).attr("name");

		$(document).ready(function(){
		  $("#clearbtn").show();
		});	


	    // console.log(search_query);
	    $.ajax({
	    	method: 'get',	
	    	url: '/group/member/search',
	    	dataType: 'json',
	    	data: {
	    		'_token': '{{ csrf_token() }}',
	    		search_query: search_query,
	    		group_id: group_id,
	    	},

	    	success: function(res){
				var tableRow = '';

				$('#dyn-row').html('');

				$.each(res, function(index, value){

					tableRow = '<tr><td class="d-flex align-items-center"><a href="/profile/' + value.user_id + '"><strong class="ml-3">' + value.name + '</strong></a></td><td>' + value.profession + '</td><td><a onclick="return confirm(`Are you sure you want to make this member an admin?`);" href="/group/admin/make-admin/'+ value.profile_id +'/' + value.group_id + '">Make admin</a> | <a onclick="return confirm(`Are you sure you want to remove this member?`);" href="/group/admin/remove-member/'+ value.profile_id +'/' + value.group_id + '">Remove member</a></td></tr>';	

					$('#dyn-row').append(tableRow);
				});

				
	    	}
	    });
	});

	$(document).ready(function(){
	  $("#clearbtn").click(function(){
	    location.reload();
	  });
	});

	// member search //


	// user search for public invite //

	$(document).ready(function(){
	  $("#clearbtn2").hide();
	});	

	$('body').on('keyup', '#search-user', function(){
	    var search_query = $(this).val();
		var group_id = $(this).attr("name");

		$(document).ready(function(){
		  $("#clearbtn2").show();
		});	


	    // console.log(search_query);
	    $.ajax({
	    	method: 'get',	
	    	url: '/group/inv-pub/search',
	    	dataType: 'json',
	    	data: {
	    		'_token': '{{ csrf_token() }}',
	    		search_query: search_query,
	    		group_id: group_id,
	    	},

	    	success: function(res){

				var tableRow = '';

				$('#dyn-users-row').html('');

				$.each(res, function(index, value){

					if(!value.sent){
						tableRow = '<tr><td><div class="card d-flex align-items-center px-4 py-2" style="border-radius: 2rem;"><img src="' + value.recipient_pi + '" width="50" height="50"><strong>' + value.recipient_name + '</strong><a href="/grp/send-inv/pub/'+ value.sender_uid +'/'+ value.recipient_uid +'/'+ value.group_id +'">Send invite</a></div></td></tr>';
					}
					
					$('#dyn-users-row').append(tableRow);
				});
	    	}
	    });
	});

	$(document).ready(function(){
	  $("#clearbtn2").click(function(){
	    location.reload();
	  });
	});

	// user search for public invite //

	// user search for private invite //

	$(document).ready(function(){
	  $("#clearbtn3").hide();
	});	

	$('body').on('keyup', '#search-user-private', function(){
	    var search_query = $(this).val();
		var group_id = $(this).attr("name");

		$(document).ready(function(){
		  $("#clearbtn3").show();
		});	


	    // console.log(search_query);
	    $.ajax({
	    	method: 'get',	
	    	url: '/group/inv-pri/search',
	    	dataType: 'json',
	    	data: {
	    		'_token': '{{ csrf_token() }}',
	    		search_query: search_query,
	    		group_id: group_id,
	    	},

	    	success: function(res){

				var tableRow = '';

				$('#dyn-users-row-private').html('');

				$.each(res, function(index, value){

					if(!value.sent){
						tableRow = '<tr><td><div class="card d-flex align-items-center px-4 py-2" style="border-radius: 2rem;"><img src="' + value.recipient_pi + '" width="50" height="50"><strong>' + value.recipient_name + '</strong><a href="/grp/send-inv/priv/'+ value.sender_uid +'/'+ value.recipient_uid +'/'+ value.group_id +'">Send invite</a></div></td></tr>';
					}
					
					$('#dyn-users-row-private').append(tableRow);
				});
	    	}
	    });
	});

	$(document).ready(function(){
	  $("#clearbtn3").click(function(){
	    location.reload();
	  });
	});

	// user search for private invite //






}
