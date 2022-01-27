$(function (){
    'use strict';

    // Dashboard

    $('.toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
        if($(this).hasClass('selected')){
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }else{
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }
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

    //Category View Option

    $('.cat h3').click(function(){
        $(this).next('.full-view').fadeToggle(200);
    });
    
    $('.option span').click(function (){
        $(this).addClass('activate').siblings('span').removeClass('activate');
        if($(this).data('view')==='full'){
            $('.cat .full-view').fadeIn(200);
        }else{
            $('.cat .full-view').fadeOut(200);
        }
    });


    // Show delete button on child Cats

    $('.child-link').hover(function(){
        $(this).find('.show-delete').fadeIn(400);

    },function(){
        $(this).find('.show-delete').fadeOut(400);
    });



});


