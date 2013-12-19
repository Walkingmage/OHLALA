$(document).ready(function() {

	//Initiate list.js List
	var userList = new List('test-list', {
		valueNames: ['dateRange', 'timeRange', 'room', 'weekday', 'schoolClass', 'access'],
		page: 40,
		plugins: [ ListPagination({}), ListFuzzySearch() ]
			// [ ListFuzzySearch() ],
	});

	// //Wrapper for list.js filter function
	// function filterUserList() {
	// //	var classSelectorValue = $('.classSelector').val();
	// //	var accessSelectorValue = $('.accessSelector').val();
	// //	var programSelectorValue = $('.programSelector').val();
	// //	userList.filter(function(item){
	// //		if ( (programSelectorValue === "Alla..." || programSelectorValue === item.values().schoolProgram) && (classSelectorValue === "Alla..." || classSelectorValue === item.values().schoolClass) && (accessSelectorValue === "Alla..." || accessSelectorValue === item.values().access ) ) {
	// //			return true;
	// //		} else {
	// //			return false;
	// //		}
	// //	});
	// }

	//Saves checkbox id to hidden input field
	function setOrUnsetSelectedUsers() {
		var userId = this.id;
		userId = userId.slice( (userId.indexOf('[')+1) , userId.indexOf(']') );
		var userIdStr = ' '+userId+',';
		var setIds = $("#unbookForm input[name='selectedBookings']").val();
		if (setIds.indexOf(userIdStr) < 0 ) {
			setIds += userIdStr;
			$("#unbookForm input[name='selectedBookings']").val(setIds);
		} else {
			setIds = setIds.replace(userIdStr, '');
			$("#unbookForm input[name='selectedBookings']").val(setIds);
		}
	}

	//Bind filter function to selectors
	// $('.filterSelector').on('change', function(){
	// 	filterUserList();
	// });

	//Bind checkbox click through list.js iteration.
	var listArray = userList.items;
	for (var i = 0; i < listArray.length; i++) {
		var trElement = listArray[i].elm;
		var checkbox = trElement.querySelector('input[type="checkbox"]');
		checkbox.addEventListener('click', setOrUnsetSelectedUsers, true);
	}

	//Bind archive button to form around table
	$( "#unbookButton" ).click(function( event ) {
    $( "#unbookForm" ).submit();
	});

	//Filter on page load
	//filterUserList();

});