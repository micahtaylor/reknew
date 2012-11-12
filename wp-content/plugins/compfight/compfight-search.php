<?php
/*
 Compfight
 Version: 1.3
*/

if (!isset($_GET['inline']))
  define( 'IFRAME_REQUEST' , true );

// load WP bootstrap
require_once('../../../wp-admin/admin.php');

$hook_suffix = $GLOBALS['hook_suffix'];

do_action('admin_enqueue_scripts', $hook_suffix);
do_action("admin_print_styles-$hook_suffix");
do_action('admin_print_styles');
do_action("admin_print_scripts-$hook_suffix");
do_action('admin_print_scripts');
do_action("admin_head-$hook_suffix");
do_action('admin_head');

require_once('../../../wp-load.php' );
$cf_track = 0;

class cf_search {
  var $track = 0;

  function cf_search() {
    global $current_user;
    $past_search = get_transient('cf_' . $current_user->user_login . '_search_value');

    if (!@$_GET['search-value']) {
      if ($past_search != '') {
        echo self::search_results($past_search);
      } else {
        echo self::search_form();
        // if query is an empty string
        if (!empty($_GET) && $_GET['search-value'] == '') {
          echo '<h4 class="cf_search_title">Please input keyword(s) you wish to search</h4>';
        }
      }
    } else {
      $page = @$_GET['page_no'];
      if (!$page) {
        $page = 1;
      }
      echo "<script type=\"text/javascript\">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-18298160-1']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
      _gaq.push(['_trackEvent', 'WP Plugin Search', '" . $_GET['search-value'] . "', 'page-" . $page . "']);
  </script>";

      echo self::search_results($_GET['search-value']);

    }
  } // cf_search


  // Search form
  function search_form($show_title = true) {
    global $current_user;
    $output = '';

    $search_value = trim($_GET['search-value']);
    if (!$search_value) {
      $search_value = get_transient('cf_' . $current_user->user_login . '_search_value');
    }

    if (!$search_value) {
      $input_text = 'Enter Keyword(s)';
    } else {
      $input_text = $search_value;
    }

    if ($show_title) {
      $output .= '<h3 class="cf_search_title">Compfight</h3>';
      $output .= '<p class="cf_search_subtitle">Locate the visual inspiration<br/>you need. Super fast!</p>';
    }

    $output .= '<form method="GET" action="" id="cf-form">';
    $output .= '<input type="text" name="search-value" id="search-value" value="' . $input_text . '" onClick="javascript:if(this.value==\'Enter Keyword(s)\') { this.value = \'\'; };" />';
    $output .= '<input type="submit" name="search" id="search" value="Search" class="button" />';
    $output .= '</form>';


    if (!$show_title) {
      $output .= '<p><p class="yellowmessage">Locate the visual inspiration you need. Super fast!</p></p>';
    }

    return $output;
  } // search_form


  // Search results
  function search_results($search_value) {
    global $current_user;
    $output = '';

    if ($search_value == '' || $search_value == 'Enter Keyword(s)') {
      set_transient('cf_' . $current_user->user_login . '_search_value', '', 60*10);
      $output .= self::search_form();
      $output .= '<h4 class="cf_search_title">Please input keyword(s) you wish to search</h4>';
      return $output;
    }

    $output .= self::search_form(false);

    $options = get_option(CF_OPTIONS_KEY);

    $search = trim($search_value);
    set_transient('cf_' . $current_user->user_login . '_search_value', $search, 60*10);

    $page = $_GET['page_no'];
    if ($page == '') {
      $page = '0';
    }

    // Init phpFlickr
    $f = new phpFlickr(CF_FLICKR_API_KEY, CF_FLICKR_SECRET, true);
    $f->enableCache('ts', '');

    $search_query = array();
    $search_query['sort'] = 'interestingness-desc';
    // Search by tags or everything?
    if ($options['search'] == 'tags-only') {
      $search = str_replace(' ', ',', $search);
      $search_query['tags'] = $search;
      $search_query['tag_mode'] = 'any';
    } elseif ($options['search'] == 'all-text') {
      $search_query['text'] = $search;
      $search_query['tag_mode'] = 'all';
    }

    // License: http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
    if ($options['license'] == 'any') {
      $search_query['license'] = '1,2,3,4,5,6,7';
    } elseif ($options['license'] == 'cc') {
      $search_query['license'] = '1,2,3,4,5,6';
    } elseif ($options['license'] == 'commercial') {
      $search_query['license'] = '4,5,6';
    }

    // Safe search?
    if ($options['safe-search'] != '0') {
      $search_query['safe_search'] = '1';
    }

    $search_query['extras'] = 'original_format, o_dims';
    $search_query['per_page'] = CF_IMG_PP;
    $search_query['page'] = $page;

    $flickrResponse = $f->photos_search($search_query);
    $photos = $flickrResponse['photo'];

    $output .= '';

    // Loading animation
    $output .= '<div class="cf-loading" style="display:none;">Loading ...</div>';

    if (!$photos || count($photos) <= 0) {
      $output .= '<p class="no-items"><p colspan="2" class="colspanchange"><b>No images found. Try a different keyword.</b></p></p>';
    } else {
      $output .= '<ul class="compfight-resultlist">';
      foreach ($photos as $index => $photo) {

        if ($options['original-images'] == 'only-originals' && !@$photo['originalformat']) {
          continue;
        }

        $output .= '<li class="" style="padding:8px;">
                     <div class="column-thumb">
                     <img id="' . $photo['id'] . '" src="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_s.jpg" alt="' . htmlspecialchars($photo['title']) . '" /></div>';
        $output .= '<div class="column-img-title">' . htmlspecialchars($photo['title']) . '</div>';
        $output .= '<div class="column-actions">';
        $output .= '<input type="button" class="button smallimage" name="cf_small" title="Insert small image in post" data-url="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '' . $options['small-image-size'] . '.jpg" data-photoid="' . $photo['id'] . '" data-photosecret="' . $photo['secret'] . '" data-imgsize="' . $options['small-image-size'] . '" data-server="' . $photo['server'] . '" value="S" />';
        $output .= '<input type="button" class="button mediumimage" name="cf_medium" title="Insert medium image in post" data-url="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '' . $options['medium-image-size'] . '.jpg" data-server="' . $photo['server'] . '" data-imgsize="' . $options['medium-image-size'] . '" data-photoid="' . $photo['id'] . '" data-photosecret="' . $photo['secret'] . '" value="M" />';
        $output .= '<input type="button" class="button bigimage" name="cf_large" title="Insert large image in post" data-url="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '' . $options['large-image-size'] . '.jpg" data-server="' . $photo['server'] . '" data-imgsize="' . $options['large-image-size'] . '" data-photoid="' . $photo['id'] . '" data-photosecret="' . $photo['secret'] . '" value="L" />';
        $output .= '<input type="button" class="button bigimage" name="cf_featured" title="Attach as featured image to the post" data-title="' . htmlspecialchars($photo['title']) . '" data-url="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '' . $options['featured-image-size'] . '.jpg" data-server="' . $photo['server'] . '" data-imgsize="' . $options['featured-image-size'] . '" data-photoid="' . $photo['id'] . '" data-photosecret="' . $photo['secret'] . '" value="F" />';
        $output .= '</div>';
        $output .= '</li>';
      }
      $output .= '</ul>';

      $output .= '<ul class="compfight-pagination">';
      for ($i = 1; $i<= CF_PAGES_LIMIT; $i++) {
        $output .= '<li>';
        $output .= '<a href="' . plugins_url('compfight-search.php', __FILE__) . '?search-value=' . $search . '&page_no=' . $i . '">' . $i . '</a>';
        $output .= '</li>';
      }
      $output .= '</ul>';
    } // if (!$photos)

    return $output;
  } // search_results
} // cf_search

$cf = new cf_search();

do_action('admin_footer', '');
do_action('admin_print_footer_scripts');
do_action("admin_footer-" . $GLOBALS['hook_suffix']);
?>