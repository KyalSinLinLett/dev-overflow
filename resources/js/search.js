{

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
}
