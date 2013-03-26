(function($) {

    // is Facebook alive?
    var $FBinit = false;
    var $APPId = '455090604538684';

    // Object methods
    var methods = {
	facebookLogin: function() {

	    FB.login(function(response) {
		if (response.authResponse) {
		    methods.clientFacebookForm();
		}
	    }, {
		scope: 'email'
	    });
	},
	facebookLogout: function() {
	    $('.facebook-data').addClass('hide');
	    $('fieldset#client').removeClass('hide');
	},
	facebookShareLink: function() {

	    FB.init({
		appId: $APPId, // App ID
		channelUrl: '//www.addictedtovintage.nl', // Channel File
		status: true, // check login status
		cookie: true, // enable cookies to allow the server to access the session
		xfbml: true  // parse XFBML
	    });

	    FB.ui({
		method: 'feed',
		link: 'http://www.addictedtovintage.nl',
		picture: 'http://addictedtovintage.nl/bundles/ecommerce/images/logo.png',
		name: 'Online vintage Tassen, Sieraden & Woonaccessoires!',
		caption: 'Addictedtovintage.nl',
		description: 'Addictedtovintage.nl - De online vintage webshop!'
	    }, function(response) {
		//console.log(response);
	    });

	},
	fetchInformation: function() {
	    if ($FBinit) {
		FB.api('/' + $APPId, function(response) {

		    // set likes 
		    $('.num_likes').html(response.likes);

		});
	    } else {
		setTimeout(function() {
		    methods.fetchInformation()
		}, 500);
	    }

	},
	fetchProfile: function() {

	    if ($FBinit) {

		FB.getLoginStatus(function(response) {
		    if (response.status === 'connected') {

			var uid = response.authResponse.userID;

			FB.api('/me', function(response) {
			    methods.log('Found user ' + response.name);
			});

		    } else if (response.status === 'not_authorized') {
			methods.log('Found user but no rights');
		    } else {
			methods.log('No Facebook user found');
		    }
		});

	    } else {
		setTimeout(function() {
		    methods.fetchProfile()
		}, 500);
	    }

	},
	clientFacebookForm: function() {

	    FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {

		    var uid = response.authResponse.userID;

		    FB.api('/me', function(response) {

			console.log(response);

			$('input[name="client_name"]').val(response.name);
			$('input[name="client_email"]').val(response.email);

			/*
			 $.post(ROOT + 'client-facebook-login', {
			 email: response.email
			 }, function(data) { }, 'json' );
			 */

			$('.facebook-data').find('strong').html(response.name);
			$('.facebook-data').find('img').attr('src', 'https://graph.facebook.com/' + response.id + '/picture');
			$('.facebook-data').find('p').html(response.email);
			$('.facebook-data').removeClass('hide');
			//$('.btn-facebook').addClass('hide');

		    });

		} else if (response.status === 'not_authorized') {
		    methods.log('not_authorized');
		} else {
		    methods.log('niet ingelogd');
		}
	    });

	},
	log: function(msg) {
	    
	},
	// init
	init: function() {

	    methods.log('Init social plugin');

	    window.fbAsyncInit = function() {
		FB.init({
		    appId: $APPId, // App ID
		    channelUrl: '//localhost/', // Channel File
		    status: true, // check login status
		    cookie: true, // enable cookies to allow the server to access the session
		    xfbml: true  // parse XFBML
		});

		$FBinit = true;

		methods.log('Facebook is initialized...');

		methods.clientFacebookForm();

	    };


	    // bind events to selected object
	    return this.each(function() {

	    });
	}
    };

    $.fn.social = function(method) {
	if (methods[method]) {
	    return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
	} else if (typeof method === 'object' || !method) {
	    return methods.init.apply(this, arguments);
	} else {
	    $('.error-log').append('<p>Method ' + method + ' does not exist on jQuery.social</p>');
	}

    };

})(jQuery);