
// on dom ready
$(document).ready(function(){
// class exists


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

//サーバにユーザ確認をrequestする
if($('.confirm_accept').length) {
        // add click handler
	$('.confirm_accept').click(function(){
		// ask for confirmation
		var result = confirm('確認したい？');

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
						alert('確認成功！!');
					}
					else
						alert('確認失敗！もう一度やってみてください！');
					window.location = 'http://localhost/elearning/lessons/manage_lessons';
				}
			});
		}
	
	return false;
	//return true;
	});
};

//サーバにユーザ拒否をrequestする
if($('.confirm_remove').length) {
        // add click handler
	$('.confirm_remove').click(function(){
		// ask for confirmation
		var result = confirm('拒否したい？');

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
						alert('登録情報を削除した！!');
					}
					else
						alert('削除失敗！もう一度やってみてください！');
					window.location = 'http://localhost/elearning/lessons/manage_lessons';
				}
			});
		}
	
	return false;
	//return true;
	});
};
});
