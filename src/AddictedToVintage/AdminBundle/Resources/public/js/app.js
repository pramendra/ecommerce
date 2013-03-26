$(document).ready(function() {
   
    $('select[name="first_image"]').change(function() { 
        $('.thumbnail img').attr('src', '/images/products/' + $('select[name="first_image"] option:selected').text());
    });
    
    $('#Subcategory_name').blur(function() { 
        $('#Subcategory_permalink').val(permalink($(this).val()));
    });
    
    $('#Category_name').blur(function() { 
        $('#Category_permalink').val(permalink($(this).val()));
    });
    
    
});

function removeAttribute(id) {
    
    var attribute = id;
    
    
    $.post('/admin/remove-attribute',
    {
        attribute: id
    },

    function(data)
    {
        $('tr#' + attribute).remove();
        return true;
    },

    'json'
    );    
}

function sendOrderMail(id) {
    
    $.post('/admin/send-order-mail/' + id,
    {
        order: id
    },

    function(data)
    {
        alert('Mail verstuurd');
        return true;
    },

    'json'
    );    
}

function permalink(str) {
    return str.replace(/[^a-z0-9]+/gi, '-').replace(/^-*|-*$/g, '').toLowerCase();
}