$(document).ready(function() {

	//Initiate list.js List
	var userList = new List('test-list', {
		valueNames: ['name', 'email', 'telephone', 'schoolClass', 'schoolProgram', 'userType'],
		page: 40,
		plugins: [ ListPagination({}), ListFuzzySearch() ]
			// [ ListFuzzySearch() ],
	});

	//Wrapper for list.js filter function
	function filterUserList() {
		var classSelectorValue = $('.classSelector').val();
		var accessSelectorValue = $('.accessSelector').val();
		var programSelectorValue = $('.programSelector').val();
		console.dir({one: classSelectorValue, two: accessSelectorValue, three: programSelectorValue});
		userList.filter(function(item){
			if ( (programSelectorValue === "Alla..." || programSelectorValue === item.values().schoolProgram) && (classSelectorValue === "Alla..." || classSelectorValue === item.values().schoolClass) && (accessSelectorValue === "Alla..." || accessSelectorValue === item.values().userType ) ) {
				return true;
			} else {
				return false;
			}
		});
	}

	//Saves checkbox id to hidden input field
	function setOrUnsetSelectedUsers() {
		var userId = this.id;
		userId = userId.slice( (userId.indexOf('[')+1) , userId.indexOf(']') );
		var userIdStr = ' '+userId+',';
		var setIds = $("#archiveForm input[name='selectedUsers']").val();
		if (setIds.indexOf(userIdStr) < 0 ) {
			setIds += userIdStr;
			$("#archiveForm input[name='selectedUsers']").val(setIds);
		} else {
			setIds = setIds.replace(userIdStr, '');
			$("#archiveForm input[name='selectedUsers']").val(setIds);
		}
	}

	//Bind filter function to selectors
	$('.filterSelector').on('change', function(){
		filterUserList();
	});

	//Bind checkbox click through list.js iteration.
	var listArray = userList.items;
	for (var i = 0; i < listArray.length; i++) {
		var trElement = listArray[i].elm;
		var checkbox = trElement.querySelector('input[type="checkbox"]');
		checkbox.addEventListener('click', setOrUnsetSelectedUsers, true);
	}

	//Bind archive button to form around table
	$( "#archiveButton" ).click(function( event ) {
    $( "#archiveForm" ).submit();
	});

	//Filter on page load
	filterUserList();

});