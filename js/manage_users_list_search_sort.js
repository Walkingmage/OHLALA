$(document).ready(function() {

	//Initiate list.js List
	var userList = new List('test-list', {
		valueNames: ['name', 'email', 'telephone', 'schoolClass', 'schoolProgram', 'access'],
		page: 40,
		plugins: [ ListPagination({}), ListFuzzySearch() ]
			// [ ListFuzzySearch() ],
	});

	//Wrapper for list.js filter function
	function filterUserList() {
		var classSelectorValue = $('.classSelector').val();
		var accessSelectorValue = $('.accessSelector').val();
		var programSelectorValue = $('.programSelector').val();
		userList.filter(function(item){
			if ( (programSelectorValue === "Alla..." || programSelectorValue === item.values().schoolProgram) && (classSelectorValue === "Alla..." || classSelectorValue === item.values().schoolClass) && (accessSelectorValue === "Alla..." || accessSelectorValue === item.values().access ) ) {
				return true;
			} else {
				return false;
			}
		});
	}

	//Bind filter function to selectors
	$('.filterSelector').on('change', function(){
		filterUserList();
	});

	//On page load
	filterUserList();

});