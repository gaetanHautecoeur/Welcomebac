function hideAll(el){
$('.submenu').slideUp();
$(".lien-menu").removeClass('active');
}
$(function() {
if(serie == 'false'){
	serie=false;
}
var type = false;
$('.submenu').hide();
$('.retour-submenu-serie-annale').click(function(){
	serie = false;
	$(this).parent().fadeOut(function(){
		$('#submenu-series').fadeIn();
		type = 'annale';
	});
});
$('.retour-submenu-serie-fiche').click(function(){
	serie = false;
	$(this).parent().fadeOut(function(){
		$('#submenu-series').fadeIn();
		type = 'fiche';
	});
});
$('#submenu-lien-s').click(function(){
	serie = 'S';
	$(".serie-en-cours").html(serie);
	$('#submenu-series').fadeOut(function(){
		$('#submenu-serieS-' + type + 's').fadeIn();
	});
});
$('#submenu-lien-es').click(function(){
	serie = 'ES';
	$(".serie-en-cours").html(serie);
	$('#submenu-series').fadeOut(function(){
		$('#submenu-serieES-' + type + 's').fadeIn();
	});
});
$('#submenu-lien-l').click(function(){
	serie = 'L';
	$(".serie-en-cours").html(serie);
	$('#submenu-series').fadeOut(function(){
		$('#submenu-serieL-' + type + 's').fadeIn();
	});
});
$("#menu-lien-annales").click(function(){
	type = 'annale';
	if($(this).is('.active')){
		hideAll();
		return true;
	}
	if($("#menu-lien-fiches").is('.active') && !serie){
		$("#menu-lien-fiches").removeClass('active');
		$(this).addClass('active');
		return true;
	}
	hideAll();
	if(serie){
		$(".serie-en-cours").html(serie);
		$('#submenu-serie'+serie+'-annales').slideDown();
	}else{
		$('#submenu-series').slideDown();
	}
	$(this).addClass('active');
});
$("#menu-lien-fiches").click(function(){
	type = 'fiche';
	if($(this).is('.active')){
		hideAll();
		return true;
	}
	if($("#menu-lien-annales").is('.active') && !serie){
		$("#menu-lien-annales").removeClass('active');
		$(this).addClass('active');
		return true;
	}
	hideAll();
	if(serie){
		$(".serie-en-cours").html(serie);
		$('#submenu-serie'+serie+'-fiches').slideDown();
	}else{
		$('#submenu-series').slideDown();
	}
	$(this).addClass('active');
});
});
