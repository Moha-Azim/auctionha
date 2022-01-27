$(function (){
    'use strict';

    // Switch between login  and  Signup

    $('.login-page h1 span').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);
    });

  /* #062 Calls the selectBoxIt method on your HTML select box and uses the default theme  the link :http://gregfranko.com/jquery.selectBoxIt.js/index.html  #062*/
  $("select").selectBoxIt({
      autoWidth: false
  });

    // Hide placeholder on form Focus
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder', '');

    }).blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // Add Asterisk On Required Field

    $('input').each(function(){
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // Convert Password Field To Text Field On hover
    var PassField = $('.password');
    $('.show-pass').hover(function (){

        PassField.attr('type', 'text');
    },function(){
        PassField.attr('type', 'password');
    });

    // Confirmation before Delete  When press on confirm btn

    $('.confirm').click(function(){
        return confirm('Are you sure About this Deleting')
    });



    $('.live').keyup(function()  {
        $($(this).data('class')).text($(this).val());
    });
});