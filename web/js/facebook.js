var status = -1;

function goLogIn(token){
	$.ajax({
		type: "GET",
		url: facebookConnect_href + "?token="+token,
		dataType: "html",
		async: false,
		statusCode: {
				404: function() {
					alert("Page non trouvée. La connexion a Welcomebac a échoué");
			},
				200: function() {
					changeConnected();
			}
		}
	});
}
function changeIsFavori(){
	$('a.favori').hide();
	$('span.favori').show();
}
function addEventAjouterFavori(){
	$(this).removeClass('thickbox');
	$('.favori').each(function(){
		if(typeof(href_ajouterFavori) != 'undefined'){
			$(this).click(function(){
				$.ajax({
					type: "GET",
					url: href_ajouterFavori,
					dataType: "html",
					statusCode: {
							404: function() {
								alert("Page not found");
						},
							200: function() {
								changeIsFavori();
						}
					}
				});
			});
		}

	});
}
function changeIsNotFavori(){
	$('span.favori').hide();
	$('a.favori').show();
	if(status == 1){
		addEventAjouterFavori();
	}else{
		$('.favori').each(function(){
			$(this).addClass('thickbox');
			$(this).click(function(){
				FB.login(function(response) {
				   if (response.authResponse) {
						goLogIn(response.authResponse.accessToken);
						$.ajax({
							type: "GET",
							async: false,
							url: href_ajouterFavori,
							dataType: "html"
						});
				   }
				},{scope: 'email,publish_stream'});
			});
		});
	}
}
function changeConnected(){
	status = 1;
	$('#lien-favoris').show();
	if(typeof(href_isFavori) != 'undefined'){
		$.ajax({
			type: "GET",
			url: href_isFavori,
			dataType: "json",
			success: function(data){
				if(data.estFavori){
					changeIsFavori();
				}else{
					changeIsNotFavori();
				}
			}
		});
	}
	$('.is_not_connected').hide();
	$('.is_connected').show();
}
function changeNotConnected(){
	status=-1;
	changeIsNotFavori();
	$('.is_connected').hide();
	$('.is_not_connected').show();
	$('#lien-favoris').hide();
	
	$.ajax({
		type: "GET",
		url: facebookDeconnect_href,
		dataType: "html",
		statusCode: {
				404: function() {
					alert("Page non trouvée. La deconnexion a Welcomebac a échoué");
			},
				200: function() {
			}
		}
	});
}
function changeNotAuthorized(){
	status = 0;
	changeIsNotFavori();
	$('.is_connected').hide();
	$('.is_not_connected').show();
	$('#lien-favoris').hide();
	
	$.ajax({
		type: "GET",
		url: facebookDeconnect_href,
		dataType: "html",
		statusCode: {
				404: function() {
					alert("Page non trouvée. La deconnexion a Welcomebac a échoué");
			},
				200: function() {
			}
		}
	});
}

function goLogOut(){
	$.ajax({
		type: "GET",
		url: facebookDeconnect_href,
		dataType: "html",
		statusCode: {
				404: function() {
					alert("Page non trouvée. La deconnexion a Welcomebac a échoué");
			},
				200: function() {
					window.location.reload();
			}
		}
	});
}
function onFbInit() {
	setTimeout(function(){
		if (typeof(FB) != 'undefined' && FB != null ) {
			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {
					goLogIn(response.authResponse.accessToken);
				} else if (response.status === 'not_authorized') {
					changeNotAuthorized();
				} else {
					changeNotConnected();
				}
			});
			FB.Event.subscribe('auth.logout', function(response) {
				goLogOut();
			});
			FB.Event.subscribe('auth.login', function(response) {
				goLogIn(response.authResponse.accessToken);
			});

			FB.Event.subscribe('edge.create', function(targetUrl) {	
			  _gaq.push(['_trackSocial', 'facebook', 'like', targetUrl]);
			});

			FB.Event.subscribe('edge.remove', function(targetUrl) {
			  _gaq.push(['_trackSocial', 'facebook', 'unlike', targetUrl]);
			});

			FB.Event.subscribe('message.send', function(targetUrl) {
				_gaq.push(['_trackSocial', 'facebook', 'send', targetUrl]);
			});

			$('a.deconnexion').click(function(){
				FB.logout(function(response) {
					goLogOut();
				});
			});

			$('a.connexion').click(function(){
				FB.login(function(response) {
				   if (response.authResponse) {
					goLogIn(response.authResponse.accessToken);
				   }
				},{scope: 'email,publish_stream'});
			});
		}
	},500);
}
