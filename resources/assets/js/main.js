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
    autoplay: true,
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

$( function() {
    var inputs = $('.autocomplete');

    inputs.each(function(key, input) {
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
    });
});

$('.add-into-cart').click(function(){
	var element = $('#' + $(this).parent().prev().find('span')[0]['id']);
	var token = $('meta[name="csrf-token"]').attr('content');
	var quantity = $(this).parent().prev().find('input').val();
    element.css({'display':'none'});
	$.ajax({
		type: "post",
		url: $(this).data('url'),
		data: {quantity: quantity,_token: token},
		dataType: "json",
		success:function (data)
		{
			$('.totalQuantityTop').html('Items: ' + data['totalQuantity']);
			$('.totalPriceTop').html('  € '+data['totalPrice'].toFixed(2));
			element.html('Added to cart');
			element.css({'color':'green','display':'block'});
            setTimeout(function () { element.css({'display':'none'});
            }, 3000);
		},
		error:function (error)
		{
			element.html(error['responseJSON']['errors']['quantity'][0]);
			element.css({'color':'red','display':'block'});
            setTimeout(function () { element.css({'display':'none'});
            }, 3000);
		}
	})
});

$('#show_packshots').click(function () {
    $('.packshots').toggle();
    return;
});

$('#show_preorders').click(function () {
    $('.preorders').toggle();
    return;
});

var timer = null;
$('.setquantity').keyup(function() {
    var quantity = $(this).val();
    var url = $(this).data('url');
    var messageId = $(this).parent().find('span')[0]['id'];
    var input = $(this);
    $('#' + messageId).css({'display':'none'});
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
                if(data['true'])
                {
                    var element = $('#message' + data['id']);
                    element.html('Stock limit '+ data['singleQuantity']);
                    element.css({'color':'red','display':'block'});
                    input.val(data['singleQuantity']);
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

$('.setquantity_BP').change(function() {
    var quantity = $(this).val();
    var url = $(this).data('url');
    var messageId = $(this).parent().find('span')[0]['id'];
    $('#' + messageId).css({'display':'none'});
    var totalQuantity = $(this).parent().parent().next().children()[1]['id'];
    var totalPrice = $(this).parent().parent().next().children()[2]['id'];
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
                var element = $('#message' + data['id']);
                $('#' + totalPrice).html(data['totalQuantity']);
                $('#singlePrice' + data['id']).html(data['singleProductPrice'].toFixed(2) + ' €');
                $('#' + totalQuantity).html(data['totalPrice'].toFixed(2) + ' €');
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


$( ".table-tr" ).hover(
    function() {
        $( this ).css("background-color","white").css("opacity", "0.7");
    }, function() {
        $( this ).css("background-color","").css("opacity", "1");
    }
    );

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