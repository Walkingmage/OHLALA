$(document).ready(function() {

	$(".day").popover({
		trigger: 'hover',
		placement: 'bottom',
		title: getDate,
		html: true,
		content: getBookedInfo
	});

	function getDate(){
		var thisDate = this.id;
		return thisDate;
	}

	function getBookedInfo() {
		var dates = $(this).children('span').attr('class');
		var startDate = dates.substr(0,10);
		var endDate = dates.substr(11,10);
		var userName = "";
		var courseName = "";

		if (dates.indexOf('#') > 0) {
			userName = "bokning, det finns ett kursnamn";
			userName = dates.substr(21,(dates.indexOf('#')-21));
			courseName = dates.substr(dates.indexOf('#')+1);
		} else if (dates.length > 4) {
			userName = "bokning utan kursnamn";
			userName = dates.substr(21);
			courseName = "Ingen";
		}	else {
			//do nothing
		}
		//courseName.length === 0 ? courseName = "Ingen" : courseName = courseName;
		var contentText = "<p>Start: "+startDate+"</p>"+"<p>Slut: "+endDate+"</p>"+"<p>Bokad av: "+userName+"</p>"+"<p>Kurs: "+courseName+"</p>";
		return contentText;
	}

});