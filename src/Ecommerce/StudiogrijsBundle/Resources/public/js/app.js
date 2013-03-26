$(document).ready(function() {

    $('.carousel').carousel({
        interval: 5000
    });

    if($('.btn-facebook').length > 0) { 

        $(this).social();

        $('.btn-facebook').click(function() { 
            $(this).social('facebookLogin');
        });
    
    }
    
    $(".typeahead").typeahead({
        source: function(query, process) {
            $.post(ROOT + 'json-search', {
                q: query, 
                limit: 4
            }, function(data) {
                process(data);
            });
        }
    });
    
    $('a[rel="tooltip"]').tooltip();
    
    $(window).resize(function() {
		make_responsive();
	});
    
    make_responsive();
    
    $('select[name="max_results"]').bind('change', function() { 
        $(this).productfilter('changeMaxResults');
    });
    
    $('select[name="sortby"]').bind('change', function() { 
        $(this).productfilter('changeSortBy');
    });
    
    $('#sidebar input[type="checkbox"]').bind('change', function() { 
        $(this).productfilter('change');
    });

    $('input#client_zipcode').bind('blur', function() { 
        clientAddressLookup();
    });
    

    $('input#client_housenumber').bind('blur', function() { 
        $('.address').empty();
        $('.address').append($('input#client_address').val() + ' ' + $('input#client_housenumber').val() + ' <br /> ' + $('input#client_location').val());
    });
    
    $('a.thumbnail img').bind('click', function() { 
        
        var $thumb = $(this).attr('src');
        
        $thumb = $thumb.replace('thumbs/','');        
        
        $('.product_image img').attr('src', $thumb);
    });
    
    $('.main-menu li').bind('mouseenter', function() { 
    
        var $sub = $(this).find('.sub-menu');
    
        if($sub.length > 0) { 
            $($sub).css('display', 'block');
        }
    
    });
    
    $('.main-menu li').bind('mouseleave', function() { 
    
        var $sub = $(this).find('.sub-menu');
    
        if($sub.length > 0) { 
            $($sub).css('display', 'none');
        }
        
    });
    /*
    $('.menu-cart .cart').bind('mouseenter', function() { 
    
        $(this).find('.cart-content').removeClass('hide');
        $(this).find('.innercart').addClass('hover');
        
        $('.cart-background').remove();
        $('body').append('<div class="cart-background"></div>');
        
    });
    
    $('.menu-cart .cart').bind('mouseleave', function() { 
    
        $(this).find('.cart-content').addClass('hide');
        $(this).find('.innercart').removeClass('hover');
        
        $('.cart-background').remove();
    
    });
    */
});

function make_responsive() { 
    
    if($(window).width() < 1180 && $(window).width() > 920) { 

        $('.container').addClass('container-fluid');
        $('.container').removeClass('container');
        $('.container-fluid').css('padding', '0px 10px');

    } else { 
         $('.container-fluid').addClass('container');
         $('.container-fluid').removeClass('container-fluid');
    }
    
    if($(window).width() < 920) { 

        $('.top-nav').parent().addClass('hide');
        $('.search').addClass('hide');

    } else { 
        $('.top-nav').parent().removeClass('hide');
	$('.search').removeClass('hide');
    }

}

function validate_contact() {

	$('.help-inline').remove();

	var valid = true;

	var required_fields = ["name", "email", "bericht"];
		
	$.each(required_fields, function(v,k) {

		$('#' + k).parent().parent().removeClass('error');

		if($('#' + k).val() > '') {

			switch(k) {

				default:
					$('#' + k).parent().parent().addClass('success');
					$('#' + k).parent().append('<span class="help-inline"><span class="btn btn-success"><i class="icon-white icon-ok"></i></span></span>');
					break;
			}
		} else {
			valid = false;

			$('#' + k).parent().parent().addClass('error');
			$('#' + k).parent().append('<span class="help-inline"><span class="btn btn-danger"><i class="icon-white icon-remove"></i></span></span>');
		}

	});

	if(valid) {
		$('#contact-form').submit();
	} else {
		return false;
	}
}

function check_filter_box(obj) { 

    if($(obj).parent().find('input').attr('checked') == 'checked') { 
        $(obj).parent().find('input').removeAttr('checked');
    } else { 
        $(obj).parent().find('input').attr('checked', 'checked');
    }
    
    $(obj).parent().find('input').change();
}

function reset_filter() { 
    
    $(this).productfilter('reset');
}

function show_loading_icon() { 
    $('body').append('<div class="loading-screen"><img src="/bundles/ecommerce/img/loading.gif" /></div>');
}
function remove_loading_icon() { 
    $('.loading-screen').remove();
}

function display_bottom_error(error, delay) { 
	$('body').append('<div class="bottom_validate_error"><strong><i class="icon-exclamation-sign"></i></strong> ' + error + '</div>');
    
    if(delay > 0) { 
        setTimeout(function() { 
            
            $('.bottom_validate_error').fadeOut('slow', function() {
                $('.bottom_validate_error').remove();
            });
        }, delay);
    }
}

function show_foreign() { 

    $('.foreign_payments_btn').addClass('hide');
    $('.foreign_payments').removeClass('hide');

}

function add_to_list(id) { 

    $.post(ROOT + 'ajax',
    {
        post_action: 'add_to_list',
        product: id
    },
    function(data)
    {
//        console.info(data);
        return true;
    },
    'json'
    );
}

function add_to_cart(id) { 

    $.post(ROOT + 'ajax',
    {
        post_action: 'add_to_cart',
        product: id,
        amount: $('select[name="stock"]').val()
    },

    function(data)
    {        
        
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        
        
        var $totalIncShipping = (data.cart.shipping.costs + data.cart.totalPriceInc);
        
        $('.product_price').find('.btn').addClass('disabled');
        $('.product_price').find('.btn').removeClass('btn-primary');
        $('.product_price').find('.btn').html('<i class="icon-check"></i> In Winkelmandje');
        
        $('#cartModal').find('.modal-body').html('<h3>' + data.product.name + ' toegevoegd!</h3><p>Totaalbedrag in je winkelmandje: € ' + number_format(parseFloat($totalIncShipping), 2, ',', '.') + ' inclusief verzendkosten</p>');
        
        $('#cartModal').modal('show');
        
        $('.product_count').html(data.cart.numProducts + ' producten');
        $('.total_price').html('&euro; ' + number_format(parseFloat($totalIncShipping), 2, ',', '.'));
        
        return true;

    },

    'json'
    );


}

function set_shipping_date() { 
    var shipping_date = $('select[name="shipping_date_select"]').val();
    $('input[name="shipping_date"]').val(shipping_date);
}

function validate_paymethod() { 
    
    $('.alert').remove();
    
    if(!$('input.payment:checked').val()) { 
        $('.checkout_payments').before('<div class="alert alert-error"><i class="icon-exclamation-sign"></i> Je hebt geen betaalmethode geselecteerd, kies een betaalmethode</div>');
        
        return false
    }
    
    document.checkout_form.submit();
}

function validate_personal_information() { 

    $('.error').removeClass('error');
    $('.bottom_validate_error').remove();

    var $client_name = $('input#client_name');
    var $client_email = $('input#client_email');
    var $client_zipcode = $('input#client_zipcode');
    var $client_housenumber = $('input#client_housenumber');
    var $client_address = $('input#client_address');
    var $client_location = $('input#client_location');
    
    if($($client_name).val() == '') { 
        display_bottom_error('Je hebt geen naam ingevuld', 8000);
        $client_name.parent().parent().addClass('error');
        $client_name.parent().find('.help-inline').html('<i class="icon-remove"></i>');
        
        return false;
    } else { 
        $client_name.parent().parent().addClass('success');
        $client_name.parent().find('.help-inline').html('<i class="icon-ok"></i>');
    }
    
    if($($client_email).val() == '') { 
        display_bottom_error('Je hebt geen e-mailadres ingevuld', 8000);
        $client_email.parent().parent().addClass('error');
        $client_email.parent().find('.help-inline').html('<i class="icon-remove"></i>');
        
        return false;
    } else { 
        $client_email.parent().parent().addClass('success');
        $client_email.parent().find('.help-inline').html('<i class="icon-ok"></i>');
    }
    
    if($($client_zipcode).val() == '') { 
        display_bottom_error('Je hebt geen postcode ingevuld', 8000);
        $client_zipcode.parent().parent().addClass('error');
        $client_zipcode.parent().find('.help-inline').html('<i class="icon-remove"></i>');
        
        return false;
    } else { 
        $client_zipcode.parent().parent().addClass('success');
        $client_zipcode.parent().find('.help-inline').html('<i class="icon-ok"></i>');
    }
    
    if($($client_housenumber).val() == '') { 
        display_bottom_error('Je hebt geen huisnummer ingevuld', 8000);
        $client_housenumber.parent().parent().addClass('error');
        $client_housenumber.parent().find('.help-inline').html('<i class="icon-remove"></i>');
        
        return false;
    } else { 
        $client_housenumber.parent().parent().addClass('success');
        $client_housenumber.parent().find('.help-inline').html('<i class="icon-ok"></i>');
    }
    
    if($($client_address).val() == '') { 
        display_bottom_error('Je hebt geen adres ingevuld', 8000);
        $client_address.parent().parent().addClass('error');
        $client_address.parent().find('.help-inline').html('<i class="icon-remove"></i>');
        
        return false;
    } else { 
        $client_address.parent().parent().addClass('success');
        $client_address.parent().find('.help-inline').html('<i class="icon-ok"></i>');
    }
    
    if($($client_location).val() == '') { 
        display_bottom_error('Je hebt geen woonplaats ingevuld', 8000);
        $client_location.parent().parent().addClass('error');
        $client_location.parent().find('.help-inline').html('<i class="icon-remove"></i>');
        
        return false;
    } else { 
        $client_location.parent().parent().addClass('success');
        $client_location.parent().find('.help-inline').html('<i class="icon-ok"></i>');
    }

    return true;
}

function setShippingMethod(id) { 
    
    $.post(ROOT + 'ajax',
    {
        post_action: 'set_shipping_method',
        shipping: id
    },

    function(data)
    {
        window.location = PATH_CART;
        return true;
    },

    'json'
    );
}

function remove_from_cart(id) { 

    show_loading_icon();

    $.post(ROOT + 'ajax',
    {
        post_action: 'remove_from_cart',
        product: id
    },

    function(data)
    {
        window.location = PATH_CART;
        return true;
    },

    'json'
    );


}


function add_coupon() { 

    show_loading_icon();

    var code = $('#coupon_code').val();

    $.post(ROOT + 'ajax',
    {
        post_action: 'add_coupon',
        code: code
    },

    function(data)
    {
        
        if(parseFloat(data.discount) > 0) { 
            window.location = PATH_CART;
        } else { 
            remove_loading_icon();
            display_bottom_error('Kortingscode <strong>"' + $('#coupon_code').val() + '"</strong> bestaat niet', 10000);
        }
        
        return true;
    },

    'json'
    );


}

function clear_coupon() { 

    show_loading_icon();
    
    $.post(ROOT + 'ajax',
    {
        post_action: 'clear_coupon'
    },

    function(data)
    {
        window.location = PATH_CART;
        return true;
    },

    'json'
    );
}

function validateCheckout() { 

    $('.alert').remove();
    
    if(!$('input[name="conditions"]:checked').val()) { 
        
        $('input[name="conditions"]').parent().before('<div class="alert alert-error"><i class="icon-exclamation-sign"></i> Je dient akkoord te gaan met de algemene voorwaarden</div>');
        
        return false
    }
    
    $('#checkout_form').submit();
}

function number_format( number, decimals, dec_point, thousands_sep ) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
     
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function clientAddressLookup() {

    var zipcode = $('input#client_zipcode').val();
    var housenumber = $('input#client_housenumber').val();

    $('.zipcode-warning').remove();

    $.post(ROOT + 'client-address-lookup',
    {
        zipcode: zipcode,
        housenumber: housenumber
    },

    function(data)
    {

        if (data.succes == false)
        {
            $('.alert-message p').html(data.message);
            $('.alert-message').removeClass('hide');

            return false;
        }

        if(data.result.length > 0) {

            $('input#client_address').val(data.result[0].street);
            $('input#client_location').val(data.result[0].city);
            $('input#client_province').val(data.result[0].province);

            //$('input#client_address').parent().parent().removeClass('hide');
            //$('input#client_location').parent().parent().removeClass('hide');
            //$('select#client_country').parent().parent().removeClass('hide');

            $('input#client_address').parent().parent().addClass('success');

            $('input#client_location').parent().parent().addClass('success');

            $('select#client_country').parent().parent().addClass('success');
						
            $('select#client_country').find('option:first').attr('selected', 'selected');
            
            $('.address').empty();
            
            $('.address').append($('input#client_address').val() + ' ' + $('input#client_housenumber').val() + ' <br /> ' + $('input#client_location').val());
            $('.address').parent().parent().removeClass('hide');

        } else {

            var alertbox = '<div class="clearfix"></div><div class="alert alert-block zipcode-warning clearfix">'
            + '<a class="close" data-dismiss="alert">×</a>'
            + '<h4 class="alert-heading">Let op!</h4>'
            + '<p>De postcode <strong>' + $('input#client_zipcode').val() + '</strong> is geen Nederlandse postcode of is niet gevonden in onze database. Controleer of u de juiste postcode heeft ingevuld of vul uw gegevens handmatig in.</p>'
            + '</div>';

            $('.form-inline').after(alertbox);
						
            $('input#client_address').parent().parent().removeClass('hide');
            $('input#client_location').parent().parent().removeClass('hide');
            $('select#client_country').parent().parent().removeClass('hide');
						
            $('input#client_address').focus();
        }

        $('.loading-input').remove();

        return false;
    },

    'json'
    );
}

