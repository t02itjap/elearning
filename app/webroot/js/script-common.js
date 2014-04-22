
// on dom ready
$(document).ready(function(){
// class exists
//Khanh
$(".onlyNumber").keypress(function(e){
        return !(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46);
});
//end Khanh

if($('.confirm_report').length) {
        // add click handler
     //サーバにタイトル違反をレポートする
	$('.confirm_report').click(function(){
		// ask for confirmation
		var result = confirm('本当にタイトル違反を報告したい？?');

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
						alert('報告成功！!');
					}
					else
						alert('前にもう報告した！!');
					//alert(response.lesson_id);
				}
			});
		}
	
	return false;
	//return true;
	});
};

//サーバに授業削除をrequestする
if($('.confirm_delete').length) {
        // add click handler
	$('.confirm_delete').click(function(){
		// ask for confirmation
		var result = confirm('本当にこの授業を削除したい？?');

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
						alert('削除成功!');
					}
					else
						alert('削除できなかった！もう一度やってみてくだい！');
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

//if($('.confirm_accept').length) {
//       // add click handler
//	$('.confirm_accept').click(function(){
//		// ask for confirmation
//		var result = confirm('Are you sure you want to accept this?');
//
//		// do ajax request
//		if(result) {
//			//alert('in if result');
//			$.ajaxSetup({
//   			headers: { 'X-Requested-With': 'XMLHttpRequest' }
//			});
//			$.ajax({
//				type:"POST",
//				url:$(this).attr('href'),
//				//headers: { 'X-Requested-With': 'XMLHttpRequest' },
//				//data:"ajax=1",
//				dataType: "json",
//				success:function(response){
//					if(response.success == false) {
//						alert('Accept successed!');
//						window.location = 'http://localhost/elearning/Admins/getConfirmAccount';
//					}
//					else
//						alert('Accept failed! Try agian!');
//					window.location = 'http://localhost/elearning/Admins/getConfirmAccount';
//				}	
//			});
//		}
//	
//	return false;
//	//return true;
//	});
//};
//
//if($('.confirm_remove').length) {
//       // add click handler
//	$('.confirm_remove').click(function(){
//		// ask for confirmation
//		var result = confirm('Are you sure you want to remove this?');
//
//		// do ajax request
//		if(result) {
//			//alert('in if result');
//			$.ajaxSetup({
//   			headers: { 'X-Requested-With': 'XMLHttpRequest' }
//			});
//			$.ajax({
//				type:"POST",
//				url:$(this).attr('href'),
//				//headers: { 'X-Requested-With': 'XMLHttpRequest' },
//				//data:"ajax=1",
//				dataType: "json",
//				success:function(response){
//					if(response.success == false) {
//						alert('Remove successed!');
//					}
//					else
//						alert('Remove failed! Try agian!');
//					window.location = 'http://localhost/elearning/lessons/manage_lessons';
//				}
//			});
//		}
//	
//	return false;
//	//return true;
//	});
//};
});
