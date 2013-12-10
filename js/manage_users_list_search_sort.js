$(document).ready(function() {

	var userList = new List('test-list', {
		valueNames: ['name', 'email', 'telephone', 'schoolClass', 'schoolProgram', 'access'],
		page: 40,
		plugins: [ ListPagination({}), ListFuzzySearch() ]
			// [ ListFuzzySearch() ],
	});

	function filterUserList() {

		userList.filter(function(item){

			if ( (programSelectorValue === "Alla..." || programSelectorValue === item.values().schoolProgram) && (classSelectorValue === "Alla..." || classSelectorValue === item.values().schoolClass) && (accessSelectorValue === "Alla..." || accessSelectorValue === item.values().access ) ) {
				return true;
			} else {
				return false;
			}

		});
	}

	function getSelectorValues() {
		classSelectorValue = $('.classSelector').val();
		accessSelectorValue = $('.accessSelector').val();
		programSelectorValue = $('.programSelector').val();
	}

	//Bind to selectors
	$('.filterSelector').on('change', function(){
		getSelectorValues();
		filterUserList();
	});

	//Run on page load
	getSelectorValues();
	filterUserList();

});