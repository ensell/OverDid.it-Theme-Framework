jQuery(document).ready(function($) {

    var thisDiv;

	formfield = '';

	$('input[rel="overdid-image-upload"]').click(function() {
		formfield = $(this).attr('class');
	 	tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 	return false;

	});

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html) {
		if (formfield != '') {
			imgurl = $('img',html).attr('src');
	 		$('#' + formfield).val(imgurl);
	 		tb_remove();

			//Insert preview image
			if ($('img.' + formfield).attr('src')) {
				$('img.' + formfield).attr('src', imgurl);
			} else {
				$('#' + formfield).before("<img class='odit-thumb-preview " + formfield + "' src='" + imgurl + "' />");
			}
			formfield = '';

		} else {
			window.original_send_to_editor(html);

		}

	}

    /*
     * Add options through Ajax to the options screen
     */
    $('.opt-addition').live('click', function() {
        var id = $('.opt-addition').prev('fieldset').attr('id');
        if (id == null) {
            id = 0;
        }

        options_ajax(id);
    });
    $('.monitor select').each(function() {
       if ($(this).val()  == 'Site') {
           var trig = $(this).attr('rel');
           $('span.' + trig).hide();
           $('select.' + trig).show();
           $('em.' + trig).show();
       }
   });
   $('.monitor select').live('change', function() {
       if ($(this).val()  == 'Site') {
           var trig = $(this).attr('rel');
           $('span.' + trig).hide();
           $('select.' + trig).show();
           $('em.' + trig).show();
       } else {
           var trig = $(this).attr('rel');
           $('span.' + trig).show();
           $('select.' + trig).hide();
           $('em.' + trig).hide();
       }
   });

    /*
     * Show and hide additional options in Theme Options
     */
    $('.odit-adjustment').click(function() {
        var field = $(this).nextAll(".sub-fields:first");
        if (field.is(':visible')) {
           $(this).text('( + )');

        } else {
            $(this).text('( - )');

        }

        field.slideToggle();


    });

});

function options_ajax(id) {
	jQuery.post(
		overdidAjax.ajaxurl,
		{
			action 	: 'overdidAjax-options',
			ID		: id,
			// send the nonce along with the request
			NonceRequest : overdidAjax.NonceRequest
		}, function(response) {
            jQuery('.opt-addition').before(response.content);
		}

	);

}
