/*
  Compfight v1.3
*/

jQuery(document).ready(function($){
  jQuery("[name='cf_small'], [name='cf_medium'], [name='cf_large']").live('click',function(){
    var img_size     = $(this).attr("data-imgsize");
    var img_server   = $(this).attr("data-server");
    var img_src      = $(this).attr("data-url");
    var photo_id     = $(this).attr("data-photoid");
    var photo_secret = $(this).attr("data-photosecret");
    var img_title    = $(this).attr("title");
    var info         = '';

    var win = window.dialogArguments || opener || parent || top;

    var data = {action:'get_photo_info', photo_id: photo_id, photo_secret: photo_secret, img_size: img_size, img_server: img_server};
    var output = '';

    jQuery.post(ajaxurl, data, function(response){
      if(!response) {
        info = '';
      } else {
        win.send_to_editor(response);
      }
    });
  });
  
  
  jQuery("[name='cf_featured']").live('click', function(){
    var img_url   = $(this).attr('data-url');
    var img_title = $(this).attr('data-title');
    var wpwrap    = $('div#wpwrap', window.parent.document);
    var form      = $('form#post', wpwrap);
    var post_id   = $('input#post_ID', form).val();
    
    var win = window.dialogArguments || opener || parent || top;
    var data = {action:'set_featured_image', photo_url:img_url, photo_title:img_title, post_id:post_id};
    
    if (post_id == '') {
      alert('The post has to be auto-saved or published before a featured image can be atached!');
    } // if post_id == ''
    
    // Hide result list and load loading gif
    $('ul.compfight-resultlist, ul.compfight-pagination').hide();
    $('div.cf-loading').show();
    
    $.post(ajaxurl, data, function(response){
      if (!response) {
        alert('An undocumented error has occurred. Please reload the page.');
      } else {
        if (response == '0') {
          alert('This image/file type is not supported.');
        } else if (response == 'file-error') {
          alert('The image you\'re trying to use is currently unavailable. Please try again later.');
        } else {
          alert('Featured image is attached. Please don\'t forget to publish/save the post.');
          $('a#set-post-thumbnail', wpwrap).empty().html(response);
          win.send_to_editor('');
        }
        $('ul.compfight-resultlist, ul.compfight-pagination').show();
        $('div.cf-loading').hide();
      }
    }); // $.post
  }); // jQuery name='cf_featured'.click

  
  $('#load-default-layout').click(function() {
    $('#compfight-layout').val(cf_default_layout);
  });
});