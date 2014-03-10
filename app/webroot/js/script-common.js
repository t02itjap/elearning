
// on dom ready
$(document).ready(function(){
// class exists
if($('.confirm_report').length) {
        // add click handler
	$('.confirm_report').click(function(){
		// ask for confirmation
		var result = confirm('Are you sure you want to report this?');

		// do ajax request
		if(result) {
			//alert('in if result');
			$.ajaxSetup({
    			headers: { 'X-Requested-With': 'XMLHttpRequest' }
			});
			$.ajax({
				type:"POST",
				url:$(this).attr('href'),
				//headers: { 'X-Requested-With': 'XMLHttpRequest' },
				//data:"ajax=1",
				dataType: "json",
				success:function(response){
					if(response.success == false) {
						alert('Report successed!');
					}
					else
						alert('Have reported before!');
					//alert(response.lesson_id);
				}
			});
		}
	
	return false;
	//return true;
	});
};

if($('.confirm_delete').length) {
        // add click handler
	$('.confirm_delete').click(function(){
		// ask for confirmation
		var result = confirm('Are you sure you want to delete this?');

		// do ajax request
		if(result) {
			//alert('in if result');
			$.ajaxSetup({
    			headers: { 'X-Requested-With': 'XMLHttpRequest' }
			});
			$.ajax({
				type:"POST",
				url:$(this).attr('href'),
				//headers: { 'X-Requested-With': 'XMLHttpRequest' },
				//data:"ajax=1",
				dataType: "json",
				success:function(response){
					if(response.success == false) {
						alert('Delete successed!');
					}
					else
						alert('Delete failed! Try agian!');
					//alert(response.lesson_id);
					var div='#'+response.lesson_id;
					$(div).remove();
				}
			});
		}
	
	return false;
	//return true;
	});
};

if($('.confirm_accept').length) {
        // add click handler
	$('.confirm_accept').click(function(){
		// ask for confirmation
		var result = confirm('Are you sure you want to accept this?');

		// do ajax request
		if(result) {
			//alert('in if result');
			$.ajaxSetup({
    			headers: { 'X-Requested-With': 'XMLHttpRequest' }
			});
			$.ajax({
				type:"POST",
				url:$(this).attr('href'),
				//headers: { 'X-Requested-With': 'XMLHttpRequest' },
				//data:"ajax=1",
				dataType: "json",
				success:function(response){
					if(response.success == false) {
						alert('Accept successed!');
					}
					else
						alert('Accept failed! Try agian!');
					window.location = 'http://localhost/elearning/lessons/manage_lessons';
				}
			});
		}
	
	return false;
	//return true;
	});
};

if($('.confirm_remove').length) {
        // add click handler
	$('.confirm_remove').click(function(){
		// ask for confirmation
		var result = confirm('Are you sure you want to remove this?');

		// do ajax request
		if(result) {
			//alert('in if result');
			$.ajaxSetup({
    			headers: { 'X-Requested-With': 'XMLHttpRequest' }
			});
			$.ajax({
				type:"POST",
				url:$(this).attr('href'),
				//headers: { 'X-Requested-With': 'XMLHttpRequest' },
				//data:"ajax=1",
				dataType: "json",
				success:function(response){
					if(response.success == false) {
						alert('Remove successed!');
					}
					else
						alert('Remove failed! Try agian!');
					window.location = 'http://localhost/elearning/lessons/manage_lessons';
				}
			});
		}
	
	return false;
	//return true;
	});
};
});