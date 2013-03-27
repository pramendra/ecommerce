(function( $ ){

    // Initialize global settings
    var $settings = [];
    // Ajax object
    var $ajax_call = null;
    // options
    var $options = [];
    // Loading gif
    var $loadingImage = '<img src="/bundles/ecommerce/images/loading.gif" />';
    // Object methods
    var methods = {

        // set filter
        set_options : function() {

            if($ajax_call != null) { // kill current connnection
                $ajax_call.abort();
            }

            show_loading_icon();

            // Fetch
            $ajax_call = $.post(ROOT + 'set-product-filter', {

                attribute: $options.attribute,
                attribute_value: $options.attribute_value,
                action : $options.action,
                post_action : 'set_filter'

            }, function() {
                
                window.location = '';
                
            },'json' );
        },
        change : function() {
            
            if($(this).attr('checked') == 'checked') { // turn on
            
                $options =  {
                    'attribute' : $(this).attr('rel'),
                    'attribute_value' : $(this).val(),
                    'action' : 'add'
                } ;
                
            } else { // turn off
                
                $options =  {
                    'attribute' : $(this).attr('rel'),
                    'attribute_value' : $(this).val(),
                    'action' : 'remove'
                } ;
                
            }
                        
            methods.set_options();

        },
        changeSortBy : function() {
            
            if($ajax_call != null) { // kill current connnection
                $ajax_call.abort();
            }

            show_loading_icon();

            // Fetch
            $ajax_call = $.post(ROOT + 'set-product-filter', {

                sort_by: $(this).val(),
                post_action : 'set_sort_by'

            }, function() { 
            
                window.location = '';
                
            },'json' );

        },
        changeMaxResults : function() {
            
            if($ajax_call != null) { // kill current connnection
                $ajax_call.abort();
            }

            show_loading_icon();

            // Fetch
            $ajax_call = $.post(ROOT + 'set-product-filter', {

                max_results: $(this).val(),
                post_action : 'set_max_results'

            }, function() { 
            
                window.location = '';
                
            },'json' );

        },
        setSale : function() {
            
            if($ajax_call != null) { // kill current connnection
                $ajax_call.abort();
            }

            show_loading_icon();

            var $is_sale = '';
                
            if($(this).attr('checked') == 'checked') { // turn on
                $is_sale = true;
            } else { // turn off
                $is_sale = false;
            }


            // Fetch
            $ajax_call = $.post(ROOT + 'set-product-filter', {

                is_sale: $is_sale,
                post_action : 'set_sale_only'

            }, function() { 
            
                window.location = '';
                
            },'json' );

        },
        reset : function() {
            
            if($ajax_call != null) { // kill current connnection
                $ajax_call.abort();
            }

            show_loading_icon();
            
            // Fetch
            $ajax_call = $.post(ROOT + 'set-product-filter', {

                post_action : 'reset_filter'

            }, function() { 
            
                window.location = '';
                
            },'json' );

        },
        // init productfilter
        init : function() {
            
            $('select[name="sortby"]').bind('change', methods.changeSortBy);
            
            $('select[name="max_results"]').bind('change', methods.changeMaxResults);
            
            $('input[name="sale_only"]').bind('change', methods.setSale);
                        
            $('a#reset_filter').bind('click', methods.reset);
            
            // bind events to selected object
            return this.each(function(){
                $(this).bind('change', methods.change);
            });
        }
    };

    $.fn.productfilter = function( method ) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $('.error-log').append( '<p>Method ' +  method + ' does not exist on jQuery.productfilter</p>' );
        }

    };

})( jQuery );