var $ = require('jquery');
require('slick-carousel');
require('slick-lightbox');
var autocomplete = require( "jquery-ui/ui/widgets/autocomplete" );

$('.slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    cssEase: 'linear'
});

$('.left').click(function(){
    $('.slider').slick('slickPrev');
})

$('.right').click(function(){
    $('.slider').slick('slickNext');
})

$('.karusele').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    dots: false,
    arrows: false,
    responsive: [
    {
        breakpoint: 1024,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: false
        }
    },
    {
        breakpoint: 600,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    },
    {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
        ],
        autoplaySpeed: 2000
    });

$('.prev').click(function(){
    $('.karusele').slick('slickPrev');
})

$('.next').click(function(){
    $('.karusele').slick('slickNext');
})


$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    arrows: true,
    centerMode: true,
    variableWidth: true,
    focusOnSelect: true
});

//// Suggestion Autocomplete
$( function() {

    $( "#productsSearch" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: '/suggest',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response(data );
                },
                error: function (err) {
                    console.log('klaida')
                }
            } );
        },
        minLength: 2,

    } );
} );
// End of Suggestion Autocomplete

$('#gll').slickLightbox();

function addAutocomplete(input)
{
    input = $(input);
    var autocomplete = input.attr('data-autocomplete');

    autocomplete = JSON.parse(autocomplete);

    activeList = []

    $.each( autocomplete, function( key, value ) {
        activeList.push(value['name']);
    });

    input.autocomplete({
        source: activeList
    });
}

$( function() {
    var inputs = $('.autocomplete');

    inputs.each(function(key, input) {

        addAutocomplete(input);
    });
});

$('.add-into-cart').click(function(){
	var element = $('#' + $(this).closest('td').prev().find('span')[0]['id']);
	var token = $('meta[name="csrf-token"]').attr('content');
	var quantity = $(this).closest('td').prev().find('input').val();
	var button = $(this);
	button.css('display', 'none');
	$(this).parent().append('<span class="loader"></span>');
    element.css({'display':'none'});
    $.ajax({
      type: "post",
      url: $(this).data('url'),
      data: {quantity: quantity,_token: token},
      dataType: "json",
      success:function (data)
      {
          button.css('display', 'inline-block');
          $('.loader').remove();
          $('.totalQuantityTop').html('Items: ' + data['totalQuantity']);
          $('.totalPriceTop').html('  € '+data['totalPrice'].toFixed(2));
          setTimeout(function () { element.css({'display':'none'});
      }, 3000);
      },
      error:function (error)
      {
        button.css('display', 'inline-block');
        $('.loader').remove();
        element.html(error['responseJSON']['errors']['quantity'][0]);
        element.css({'color':'red','display':'block'});
        setTimeout(function () { element.css({'display':'none'});
    }, 3000);
    }
})
});

$(document).ready(function() {

if (localStorage.show_packshots == 'checked') {
    $('#show_packshots').prop('checked', true);
}

if ($('#show_packshots').is(':checked')) {
    $('.packshots').addClass( "packshotsImgDisplay" );
    $('.packshots').removeClass( "packshotsImgDisplayNone" );
}

    $('#show_packshots').click(function () {

if ($('#show_packshots').is(':checked')) {
    $('.packshots').addClass( "packshotsImgDisplay" );
    $('.packshots').removeClass( "packshotsImgDisplayNone" );
    localStorage.setItem("show_packshots", "checked");
} else {
    $('.packshots').removeClass( "packshotsImgDisplay" );
    $('.packshots').addClass( "packshotsImgDisplayNone" );
    localStorage.setItem("show_packshots", "unchecked");
}

    });
});

$('.add-into-cart-single').click(function(){
    var element = $(".add-to-cart-span");
    var token = $('meta[name="csrf-token"]').attr('content');
    var quantity = $(".counter-inputas").val();
    var button = $(this);
    button.css('display', 'none');
    $(this).parent().append('<span class="loader"></span>');
    $.ajax({
        type: "post",
        url: $(this).data('url'),
        data: {quantity: quantity,_token: token},
        dataType: "json",
        success:function (data)
        {
            button.css('display', 'inline-block');
            $('.loader').remove();
            $('.totalQuantityTop').html('Items: ' + data['totalQuantity']);
            $('.totalPriceTop').html('  € '+data['totalPrice'].toFixed(2));
            $('.add-to-cart-span').show();
        },
        error:function (error)
        {
            button.css('display', 'inline-block');
            $('.loader').remove();
            element.html(error['responseJSON']['errors']['quantity'][0]);
            element.css({'color':'red','display':'block'});
            setTimeout(function () { element.css({'display':'none'});
        }, 3000);
        }
    })
});

function showHideOrders (orderName) {
    var url_delete = document.location.href;
    urlObject = new URL(url_delete);
    urlObject.searchParams.delete(orderName);

    var fieldId = "#"+"show_"+orderName+"s";


    if($(fieldId).is(':checked')) {
        if(urlObject.href.indexOf('?') > -1) {
            var url = urlObject.href+"&"+orderName+"=hide";
        } else {
            var url = urlObject.href+"?"+orderName+"=hide";
        }
    } else {
        var url = urlObject.href;
    } 
    document.location = url; 
}

$(document).ready(function() {
    $('#show_preorders').click(function () {
        showHideOrders("preorder");
    });


    $('#show_backorders').click(function () {
          showHideOrders("backorder");  
  });
});

var timer = null;
$('.setquantity').keyup(function() {
    var quantity = $(this).val();
    var url = $(this).data('url');
    var messageId = $(this).parent().find('span')[0]['id'];
    var input = $(this);
    $(this).parent().prev().html('<span class="loader"></span>');
    $('#' + messageId).css({'display':'none'});
    clearTimeout(timer);
    timer = setTimeout(function() {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "post",
            url: url,
            data: {quantity: quantity,from: 'order',_token: token},
            dataType: "json",
            success:function (data)
            {
                if(data['true'])
                {
                    var element = $('#message' + data['id']);
                    element.html('Stock limit '+ data['singleQuantity']);
                    element.css({'color':'red','display':'block'});
                    input.val(data['singleQuantity']);
                    input.parent().prev().html(data['singlePrice'].toFixed(2) + ' €');
                    setTimeout(function () { element.css({'display':'none'});
                }, 3000);
                }else{
                    var element = $('#message' + data['id']);
                    $('.totalQuantityTop').html('Item: '+data['totalQuantity']);
                    $('.totalQuantity').html(data['totalQuantity']);
                    $('#singlePrice' + data['id']).html(data['singleProductPrice'].toFixed(2) + ' €');
                    $('.totalPrice').html(data['totalPrice'].toFixed(2) + ' €');
                    $('.totalPriceTop').html('  € '+data['totalPrice'].toFixed(2));
                    element.html('updated');
                    element.css({'color':'green','display':'block'});
                    setTimeout(function () { element.css({'display':'none'});
                }, 3000);
                }
            },
            error:function (error)
            {
                var message = $('#' + messageId);
                message.html(error['responseJSON']['errors']['quantity'][0]);
                message.css({'color':'red','display':'block'});
                setTimeout(function () { message.css({'display':'none'});
            }, 3000);
            }
        });
    }, 0)
});

$('.setquantity_BP').keyup(function() {

    var quantity = $(this).val();
    var url = $(this).data('url');
    var messageId = $(this).parent().find('span')[0]['id'];
    $('#' + messageId).css({'display':'none'});
    $(this).parent().prev().html('<span class="loader"></span>');
    var index = $(this).data('index');
    clearTimeout(timer);
    timer = setTimeout(function() {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "post",
            url: url,
            data: {quantity: quantity,from: 'backorder',_token: token},
            dataType: "json",
            success:function (data)
            {
                var element = $('#message' + data['id']);
                $('#totalPrice_' + index).html(data['totalPrice'].toFixed(2) + ' €');
                $('#singlePrice_' + index + data['id']).html(data['singleProductPrice'].toFixed(2) + ' €');
                $('#totalQuantity_' + index).html(data['totalQuantity']);
                element.html('updated');
                element.css({'color':'green','display':'block'});
                setTimeout(function () { element.css({'display':'none'});
            }, 3000);
            },
            error:function (error)
            {
                var message = $('#' + messageId);
                message.html(error['responseJSON']['errors']['quantity'][0]);
                message.css({'color':'red','display':'block'});
                setTimeout(function () { message.css({'display':'none'});
            }, 3000);
            }
        });
    }, 0)
});

var timer = null;
$('.updateQ').keyup(function() {
    var url = $(this).data('url');
    var quantity = $(this).val();
    var messageId = $(this).parent().find('span')[0]['id'];
    $(this).parent().prev().html('<span class="loader"></span>');
    clearTimeout(timer);
    timer = setTimeout(function() {

        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "post",
            url: url,
            data: {quantity: quantity,_token: token},
            dataType: "json",
            success:function (data)
            {
                $('#totalQuantity').html(data['totalQuantity']);
                $('#singlePrice' + data['id']).html(data['singleProductPrice'].toFixed(2) + ' €');
                $('#totalPrice').html(data['totalPrice'].toFixed(2) + ' €');
            },
            error:function (error)
            {
                $('#' + messageId).html(error['responseJSON']['errors']['quantity'][0]);
                $('#' + messageId).css({'color':'red', 'display':'block'});
            }
        });
    }, 1000)
});

$('.updateP').keyup(function() {
    var url = $(this).data('url');
    var price = $(this).val();
    var messageId = $(this).parent().find('span')[0]['id'];
    $(this).parent().next().html('<span class="loader"></span>');
    clearTimeout(timer);
    timer = setTimeout(function() {

        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "post",
            url: url,
            data: {price: price,_token: token},
            dataType: "json",
            success:function (data)
            {
                console.log(data);
                $('#singlePrice' + data['id']).html(data['singleProductPrice'].toFixed(2) + ' €');
                $('#totalPrice').html(data['totalPrice'].toFixed(2) + ' €');
            },
            error:function (error)
            {
                $('#' + messageId).html(error['responseJSON']['errors']['price'][0]);
                $('#' + messageId).css({'color':'red', 'display':'block'});
            }
        });
    }, 1000)
});

$(document).ready(function() {
    $(".select-all-products-special-offers").change(function() {
        if (this.checked) {
            $(".gamescheckall").each(function() {
                this.checked=true;
            });
        } else {
            $(".gamescheckall").each(function() {
                this.checked=false;
            });
        }
    });
});

$(document).ready(function() {
    $(".selectAll").click(function() {
        if (this.checked) {
            $("." + $(this).val()).each(function() {
                this.checked=true;
            });
        } else {
            $("." + $(this).val()).each(function() {
                this.checked=false;
            });
        }
    });
});

$(document).ready(function() {
    $('.no').on("click", function () {
        $('.deadline').prop("disabled", true);
        return;
    });
});

$(document).ready(function() {
    $('.yes').on("click", function () {
        $('.deadline').prop("disabled", false);
        return;
    });
});

$(document).ready(function() {
    $('.add_cat').on("click", function () {
        var categories = $('.input_cat input').attr('data-autocomplete').replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");;
        var div = $('.input_cat').append('<input data-autocomplete="'+categories+'" class="form-control autocomplete" type="text" name="category_name[]" value="">');
        addAutocomplete(div.children().last()); 
        return;
    });
});

$('.delete').click(function(){
    var row = $(this);
    var url = row.data('url');
    var token = $('meta[name="csrf-token"]').attr('content');
    var pageUrl = row.data('html');
    $.ajax({
        type: "DELETE",
        url: url,
        data: {
            _token: token,
        },
        datatype: 'json',
        success: function(data){
            if (data === 'emptyOrder')
            {
                window.location.replace(pageUrl);
            }
            row.closest('tr').remove();
        }
    });
});

$(document).ready(function() {
    var input = document.getElementById( 'file-upload' );
    var infoArea = document.getElementById( 'file-upload-filename' );

    input.addEventListener( 'change', showFileName );

    function showFileName( event ) {

      var input = event.srcElement;
      
      var fileName = input.files[0].name;
      
      console.log(fileName);

      document.getElementById( 'file-upload-filename' ).innerHTML = fileName;
  }
});
