$(document).ready(function() {
	
	$(".list input[type='checkbox']").on('click', function() {
			//alert('hek');
//		var userId = this.id;
//		userId = userId.slice( (userId.indexOf('[')+1) , userId.indexOf(']') );
//		var userIdStr = ' '+userId+',';
//		var setIds = $("#archiveForm input[name='selectedUsers']").val();
//		if (setIds.indexOf(userIdStr) < 0 ) {
//			setIds += userIdStr;
//			$("#archiveForm input[name='selectedUsers']").val(setIds);
//		} else {
//			setIds = setIds.replace(userIdStr, '');
//			$("#archiveForm input[name='selectedUsers']").val(setIds);
//		}
	});



	$( "#archiveButton" ).click(function( event ) {
    $( "#archiveForm" ).submit();
	});



});
