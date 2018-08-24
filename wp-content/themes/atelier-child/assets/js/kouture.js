$(document).ready(function(){
	prisCount = 0;
	KundeserviceCount = 0;
	KundeopplevelseCount = 0;
	
	$('.eltdf-comment-list li .review-list span:contains("Pris")').prev('.review-star').find('.review-result').each(function(){
prisCount += parseFloat(this.style.width)/100;
})
	prisLength = $('.eltdf-comment-list li .review-list span:contains("Pris")').length;
	prisCount = (prisCount / prisLength)*100;
	$('.wp-review-star-type .review-list .review-result:first').width(prisCount+'%')
	console.log(prisCount)
	
	$('.eltdf-comment-list li .review-list span:contains("Kundeservice")').prev('.review-star').find('.review-result').each(function(){
KundeserviceCount += parseFloat(this.style.width)/100;
})
	KundeserviceLength = $('.eltdf-comment-list li .review-list span:contains("Kundeservice")').prev('.review-star').find('.review-result').length
	KundeserviceCount = (KundeserviceCount/KundeserviceLength)
 * 100;
	$('.wp-review-star-type .review-list .review-result').eq(1).width(KundeserviceCount+'%')
	
	
	$('.eltdf-comment-list li .review-list span:contains("Kundeopplevelse")').prev('.review-star').find('.review-result').each(function(){
KundeopplevelseCount += parseFloat(this.style.width)/100
})
	KundeopplevelseLength = $('.eltdf-comment-list li .review-list span:contains("Kundeopplevelse")').prev('.review-star').find('.review-result').length
	KundeopplevelseCount = (KundeopplevelseCount / KundeopplevelseLength) * 100
	$('.wp-review-star-type .review-list .review-result').eq(2).width(KundeopplevelseCount+'%')
	
  $('#frm_field_17_container label').removeClass("frm-radio-checked");
  $('#frm_field_17_container input:checked').parent("label").addClass("frm-radio-checked");
  
  $('#frm_field_17_container input:radio').click(function() {
    $('#frm_field_17_container label').removeClass("frm-radio-checked");
    $(this).parent('label').addClass('frm-radio-checked');
  });
  
  $('.frm_form_field.vertical_radio label').removeClass("frm-radio-checked");
  $('.frm_form_field.vertical_radio input:checked').parent("label").addClass("frm-radio-checked");
  
  $('.frm_form_field.vertical_radio input:radio').click(function() {
    $(this).parent('label').parent(".frm_radio.radio").siblings('.frm_radio.radio').find('label').removeClass("frm-radio-checked");
    $(this).parent('label').addClass('frm-radio-checked');
  });
  
   $("#privat-start-btn").click(function(ge) {
    $(".button-group div").removeClass("active");
    $(this).addClass("active");
    $(".privat-start").removeClass("hidden");
    $(".bedrift-start").addClass("hidden");
    console.log(ge);
  });
  
  $("#bedrift-start-btn").click(function(ef) {
    $(".button-group div").removeClass("active");
    $(this).addClass("active");
    $(".bedrift-start").removeClass("hidden");
    $(".privat-start").addClass("hidden");
    console.log(ef);
  });
  
  $('input[type=range]').on('input', function(e){
    var min = e.target.min,
        max = e.target.max,
        val = e.target.value,
        siblingRange = $(this).prev().find("span");

    siblingRange.css({
      'width': (val - min) * 100 / (max - min) + '%'
    });
  }).trigger('input');
  setTimeout(function() {
  $(".eltdf-title-holder.ui-accordion-header.ui-state-default.ui-accordion-header-active.ui-state-active.ui-corner-top").trigger('click');
  $("#sticky-nav-menu-item-4399 .second ul, #nav-menu-item-4399 .second ul").removeClass("right");
  },500);
  
  $("#avtale .wpb_column .wpb_wrapper .vc_row .wpb_column .vc_column-inner .wpb_wrapper .eltdf-icon-list-holder .eltdf-il-text, .omtale-avtale .wpb_column .wpb_wrapper .vc_row .wpb_column .vc_column-inner .wpb_wrapper .eltdf-icon-list-holder .eltdf-il-text").html(function(){
    var text= $(this).text().trim().split(" ");
    var first = text.shift();
    return (text.length > 0 ? "<span class='bold'>"+ first + "</span> " : first) + text.join(" ");
  });
  
  $(".omtale-side #reply-title").text("Del dine erfaringer, skriv en kundeomtale");
}); 


$('input[type=range]').before('<div class="lower-fill"><span></span></div>');

$(document).scroll(function() {
  var headerHeight = $("header.eltdf-page-header").height();
  var y = $(this).scrollTop();
  
  if (y >= headerHeight) {
    $('#stromavtaler_2_menu_sticky').addClass("scrolled");
  } else {
    $('#stromavtaler_2_menu_sticky').removeClass("scrolled");
  }
	
});

