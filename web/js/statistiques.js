function postStat(campagne, id_element, description){
	id_element = (id_element == null)?'':id_element;
	description = (description == null)?'':description;
	$.ajax({
		type: 'POST',
		url: statistiques_href + "?robot=false",
		data: { 
			referrer:		document.referrer,
			url: 			document.URL,
			campagne: 		campagne,
			id_element: 	id_element,
			description: 	description
		},
		success: function(data) {
		   if(typeof(data.statut) != 'undefined' && data.statut){
		   }else{
		   }
		},
		async:false
	});
}
$(document).ready(function() {	
	postStat('Page Visits', '', 'Visite sur le site');
	$('.stats-click').click(function(){
		postStat($(this).attr('cp'), $(this).attr('id-element'), $(this).attr('dsc'));
	});
});