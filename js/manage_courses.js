$(document).ready(function() {

	//Initiate list.js List
	var courseList = new List('test-list', {
		valueNames: ['courseName', 'courseStart', 'courseEnd', 'schoolProgram'],
		page: 40,
		plugins: [ ListPagination({}), ListFuzzySearch() ]
			// [ ListFuzzySearch() ],
	});

	//Wrapper for list.js filter function
	function filterCourseList() {
		var programSelectorValue = $('.programSelector').val();
		courseList.filter(function(item){
			if ( programSelectorValue === "Alla..." || programSelectorValue === item.values().schoolProgram ) {
				return true;
			} else {
				return false;
			}
		});
	}

	//Saves checkbox id to hidden input field
	function setOrUnsetSelectedCourses() {
		var courseId = this.id;
		courseId = courseId.slice( (courseId.indexOf('[')+1) , courseId.indexOf(']') );
		var courseIdStr = ' '+courseId+',';
		var setIds = $("#archiveForm input[name='selectedCourses']").val();
		if (setIds.indexOf(courseIdStr) < 0 ) {
			setIds += courseIdStr;
			$("#archiveForm input[name='selectedCourses']").val(setIds);
		} else {
			setIds = setIds.replace(courseIdStr, '');
			$("#archiveForm input[name='selectedCourses']").val(setIds);
		}
	}

	//Bind filter function to selectors
	$('.filterSelector').on('change', function(){
		filterCourseList();
	});

	//Bind checkbox click through list.js iteration.
	var listArray = courseList.items;
	for (var i = 0; i < listArray.length; i++) {
		var trElement = listArray[i].elm;
		var checkbox = trElement.querySelector('input[type="checkbox"]');
		checkbox.addEventListener('click', setOrUnsetSelectedCourses, true);
	}

	//Bind archive button to form around table
	$( "#archiveButton" ).click(function( event ) {
    $( "#archiveForm" ).submit();
	});

	//Filter on page load
	filterCourseList();

});