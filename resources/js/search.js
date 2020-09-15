{
	$('body').on('keyup', '#search-member', function(){
	    var search_query = $(this).val();

	    var group_id = $(this).attr("name");

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
					tableRow = '<tr><td>' + value.name + '</td><td>' + value.profession + '</td></tr>';

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
