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

	// post search admin panel //

	$(document).ready(function(){
	  $("#clearbtn4").hide();
	});	

	$('body').on('keyup', '#search-post', function(){
	    var search_query = $(this).val();
		var group_id = $(this).attr("name");

		$(document).ready(function(){
		  $("#clearbtn4").show();
		});	


	    // console.log(search_query);
	    $.ajax({
	    	method: 'get',	
	    	url: '/group/group-post/search',
	    	dataType: 'json',
	    	data: {
	    		'_token': '{{ csrf_token() }}',
	    		search_query: search_query,
	    		group_id: group_id,
	    	},

	    	success: function(res){

				var tableRow = '';

				$('#dyn-row-posts').html('');

				$.each(res, function(index, value){

					tableRow = '<tr><td>' + value.id + '</td><td><a href="/group/view-post/' + value.id + '">' + value.content + '</a></td><td><a href="/profile/' + value.user_id + '">' + value.name + '</a></td>+<td>' + value.status + '</td><td>' + value.attachment + '</td><td>' + value.created_at + '</td><td>' + value.like_count + '</td><td>' + value.cmt_count + '</td><td><a onclick="return confirm(`Are you sure you want to delete this post?`)" href="/group/group-post/delete/' + value.id +'">Remove post</a></td></tr>'

					$('#dyn-row-posts').append(tableRow);
				});
	    	}
	    });
	});

	$(document).ready(function(){
	  $("#clearbtn4").click(function(){
	    location.reload();
	  });
	});


	// post search admin panel //

	// feed search admin panel //

	$(document).ready(function(){
	  $("#clearbtn5").hide();
	});	

	$('body').on('keyup', '#search-feed', function(){
	    var search_query = $(this).val();

		$(document).ready(function(){
		  $("#clearbtn5").show();
		});	


	    // console.log(search_query);
	    $.ajax({
	    	method: 'get',	
	    	url: '/feed/search',
	    	dataType: 'json',
	    	data: {
	    		'_token': '{{ csrf_token() }}',
	    		search_query: search_query,
	    	},

	    	success: function(res){

	    		// console.log(res);

	    		if(res.message != 'No search results')
	    		{
	    			var tableRow = '';

	    			$('#dyn-feed').html('');

	    			$.each(res, function(index, value){

	    				tableRow = '<tr><td><a href="/profile/' + value.id + '"><img src="' + value.image + '" width="50" height="50"></a></td><td><a href="/profile/' + value.id + '">' + value.name + '</a></td><td><strong>' + value.biography + '</strong></td></tr>'

	    				$('#dyn-feed').append(tableRow);
	    			});
	    		} else {	
	    			$('#dyn-feed').html('');
	    		}
	    	}
	    });
	});

	$(document).ready(function(){
	  $("#clearbtn5").click(function(){
	    location.reload();
	  });
	});


	// feed search admin panel //

	// feed search admin panel //

	$(document).ready(function(){
	  $("#clearbtn6").hide();
	});	

	$('body').on('keyup', '#search-group', function(){
	    var search_query = $(this).val();

		$(document).ready(function(){
		  $("#clearbtn6").show();
		});	


	    console.log(search_query);
	    $.ajax({
	    	method: 'get',	
	    	url: '/group/search',
	    	dataType: 'json',
	    	data: {
	    		'_token': '{{ csrf_token() }}',
	    		search_query: search_query,
	    	},

	    	success: function(res){

	    		console.log(res);

	    		if(res.message != 'No search results')
	    		{
	    			var tableRow = '';

	    			$('#dyn-grp-search').html('');

	    			$.each(res, function(index, value){

	    				tableRow = '<tr><td><a href="/group/home/' + value.id + '"><img src="' + value.image + '" width="50" height="50"></a></td><td><a href="/group/home/' + value.id + '">' + value.name + '</a></td><td><strong>' + value.description + '</strong></td></tr>'

	    				$('#dyn-grp-search').append(tableRow);
	    			});
	    		} else {	
	    			$('#dyn-grp-search').html('');
	    		}
	    	}
	    });
	});

	$(document).ready(function(){
	  $("#clearbtn6").click(function(){
	    location.reload();
	  });
	});


	// feed search admin panel //




}
