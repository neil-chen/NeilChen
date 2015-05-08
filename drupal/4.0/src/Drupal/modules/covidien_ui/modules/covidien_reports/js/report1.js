$(document).ready(function() {
	//add different css for table rows
	$('table.report1_noborder table').each(function(){
	    $('tr:odd', this).addClass('odd');
	    $('tr:even', this).addClass('even');
	});

});