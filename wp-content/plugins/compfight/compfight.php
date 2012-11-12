<?php
/*
Plugin Name: Compfight
Plugin URI: http://www.compfight.com/
Description: Quickly find the perfect Creative Commons licensed photo every time. Add them to your blog posts with the proper attribution every time with just one click!
Author: Compfight
Version: 1.3
Author URI: http://www.compfight.com/
*/


define('CF_CORE_VERSION', '1.2');
define('CF_OPTIONS_KEY', 'cf_options');
define('CF_WP_MIN', 3.2);
define('CF_FLICKR_API_KEY', '3c6fc5866de4606b58d4cfb06357060b');
define('CF_FLICKR_SECRET', '16094ca47d0ba84d');
define('CF_IMG_PP', 100);
define('CF_IMG_LIMIT', 1000);
define('CF_PAGES_LIMIT', 10);
define('CF_DEFAULT_LAYOUT', '<a title="{title}" href="{url}" target="_blank"><img title="{title}" alt="{title}" src="{src}" /></a><small>{copyright} {credits}</small>');

require 'phpFlickr/phpFlickr.php';


class compfight {
  function init() {
    if (is_admin()) {
      self::check_wp_version(CF_WP_MIN);

      // add menu item
      add_action('admin_menu', array(__CLASS__, 'admin_menu'));

      // aditional links in plugin description
      add_filter('plugin_action_links_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__),
                          array(__CLASS__, 'plugin_action_links'));

      // set default options
      self::default_settings(false);

      // settings registration
      add_action('admin_init', array(__CLASS__, 'register_settings'));

      // add media button
      add_action('media_buttons', array(__CLASS__, 'media_button'), 999);

      // add jquery
      add_action('admin_head', array(__CLASS__, 'admin_enqueues'));

      // ajax endpoints
      add_action('wp_ajax_get_photo_info', array(__CLASS__, 'ajax_callback_get_photo_info'));
      add_action('wp_ajax_set_featured_image', array(__CLASS__, 'ajax_callback_set_featured_image'));
      
      // add theme support
      add_theme_support('post-thumbnails');
    }
  } // init

  // add settings link to plugins page
  function plugin_action_links($links) {
    $settings_link = '<a href="options-general.php?page=cf-options" title="Configure Compfight settings">Settings</a>';
    array_unshift($links, $settings_link);

    return $links;
  } // plugin_action_links


  // add media button
  function media_button() {
    echo '<a href="' . plugins_url('compfight-search.php', __FILE__) . '?TB_iframe=1&inline=1" id="add_compfight" class="thickbox" title="Compfight"><img src="' . plugins_url('images/camera.png', __FILE__) . '" alt="Compfight" width="16" height="16" /></a>';
  } // media_button


  // helper function for creating dropdowns
  function create_select_options($options, $selected = null, $output = true) {
    $out = "\n";

    foreach ($options as $tmp) {
      if ($selected == $tmp['val']) {
        $out .= "<option selected=\"selected\" value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      } else {
        $out .= "<option value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      }
    } // foreach

    if ($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_select_options


  // admin enqueue
  function admin_enqueues() {
    $screen = get_current_screen();

    if ($screen->base == 'post'
        || $screen->base == 'page'
        || $screen->base == 'settings_page_cf-options'
        || strpos($_SERVER['REQUEST_URI'], 'compfight-search.php') !== false) {
      wp_enqueue_script('cf-jquery', plugins_url('js/cf-jquery.js', __FILE__), array('jquery'), '1.0', true);
      wp_enqueue_style('cf-css', plugins_url('css/cf-style.css', __FILE__), array(), '1.0');
    }

    if (strpos($_SERVER['REQUEST_URI'], 'compfight-search.php') !== false) {
      echo '<script type="text/javascript"> var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
    }
  } // admin_enqueues


  // complete options page markup
  function options_page() {
    if (!current_user_can('manage_options'))  {
      wp_die('You do not have sufficient permissions to access this page.');
    }

    $options = get_option(CF_OPTIONS_KEY);

    $search   = array();
    $search[] = array('val' => 'tags-only', 'label' => 'Tags (keywords) only');
    $search[] = array('val' => 'all-text', 'label' => 'All text');

    $license   = array();
    $license[] = array('val' => 'any', 'label' => 'Any');
    $license[] = array('val' => 'cc', 'label' => 'Creative Commons');
    $license[] = array('val' => 'commercial', 'label' => 'Commercial');

    $safe_search   = array();
    $safe_search[] = array('val' => '1', 'label' => 'On');
    $safe_search[] = array('val' => '0', 'label' => 'Off');

    $original_images   = array();
    $original_images[] = array('val' => 'all', 'label' => 'Show all images');
    $original_images[] = array('val' => 'only-originals', 'label' => 'Show only images that have originals');

    $thumb_size   = array();
    $thumb_size[] = array('val' => '_s', 'label' => 'Small square');
    $thumb_size[] = array('val' => '_t', 'label' => 'Thumbnail');

    $small_image_size   = array();
    $small_image_size[] = array('val' => '_s', 'label' => 'Small square 75x75');
    $small_image_size[] = array('val' => '_t', 'label' => 'Thumbnail - 100 on the longest side');
    $small_image_size[] = array('val' => '_m', 'label' => 'Thumbnail - 240 on the longest side');

    $medium_image_size   = array();
    $medium_image_size[] = array('val' => '', 'label' => 'Medium - 500 on longest side');
    $medium_image_size[] = array('val' => '_z', 'label' => 'Medium - 640 on longest side');

    $large_image_size   = array();
    $large_image_size[] = array('val' => '_b', 'label' => 'Large - 1024 on longest side');
    $large_image_size[] = array('val' => '_o', 'label' => 'Original size');
    

    $featured_image_size   = array();
    $featured_image_size[] = array('val' => '_s', 'label' => 'Small square 75x75');
    $featured_image_size[] = array('val' => '_t', 'label' => 'Thumbnail - 100 on the longest side');
    $featured_image_size[] = array('val' => '_m', 'label' => 'Thumbnail - 240 on the longest side');
    $featured_image_size[] = array('val' => '',   'label' => 'Medium - 500 on longest side');
    $featured_image_size[] = array('val' => '_z', 'label' => 'Medium - 640 on longest side');
    $featured_image_size[] = array('val' => '_b', 'label' => 'Large - 1024 on longest side');
    $featured_image_size[] = array('val' => '_o', 'label' => 'Original size');


    echo '<div class="wrap">
          <div class="icon32-new icon-cf"><br /></div>
          <h2>Compfight</h2>';

    echo '<form action="options.php" method="post">';
    settings_fields(CF_OPTIONS_KEY);

    echo '<table class="form-table"><tbody>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-search">Search images under</label></th>
          <td><select id="compfight-search" name="' . CF_OPTIONS_KEY . '[search]">';
          self::create_select_options($search, $options['search']);
    echo '</select>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-license">Image license</label></th>
          <td><select id="compfight-license" name="' . CF_OPTIONS_KEY . '[license]">';
          self::create_select_options($license, $options['license']);
    echo '</select>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-safe-search">Safe search</label></th>
          <td><select id="compfight-safe-search" name="' . CF_OPTIONS_KEY . '[safe-search]">';
          self::create_select_options($safe_search, $options['safe-search']);
    echo '</select>';
    echo '<span class="description">If enabled hides 99% of innapropriate images.</span>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-original-images">Original images</label></th>
          <td><select id="compfight-original-images" name="' . CF_OPTIONS_KEY . '[original-images]">';
          self::create_select_options($original_images, $options['original-images']);
    echo '</select>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-small-image-size">Small image size when inserted into the post</label></th>
          <td><select id="compfight-small-image-size" name="' . CF_OPTIONS_KEY . '[small-image-size]">';
          self::create_select_options($small_image_size, $options['small-image-size']);
    echo '</select>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-medium-image-size">Medium image size when inserted into the post</label></th>
          <td><select id="compfight-medium-image-size" name="' . CF_OPTIONS_KEY . '[medium-image-size]">';
          self::create_select_options($medium_image_size, $options['medium-image-size']);
    echo '</select>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-large-image-size">Large image size when inserted into the post</label></th>
          <td><select id="compfight-large-image-size" name="' . CF_OPTIONS_KEY . '[large-image-size]">';
          self::create_select_options($large_image_size, $options['large-image-size']);
    echo '</select>';
    echo '</td></tr>';
    
    echo '<tr valign="top">
          <th scope="row"><label for="compfight-featured-image-size">Featured image size when attached to the post</label></th>
          <td><select id="compfight-featured-image-size" name="' . CF_OPTIONS_KEY . '[featured-image-size]">';
          self::create_select_options($featured_image_size, $options['featured-image-size']);
    echo '</select>';
    echo '<span class="description">The image will be resized according to the size specified in <a href="options-media.php">Settings-Media</a>. In order to save disk space you can choose the minimum size that fits your needs.</span>';
    echo '</td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="compfight-layout">Image layout template</label></th>
          <td><textarea id="compfight-layout" name="' . CF_OPTIONS_KEY . '[layout]" rows="8" cols="60">' . $options['layout'] . '</textarea> <input type="button" value="Load default layout" id="load-default-layout" /><br/>';
    echo '<span class="description">Making changes to the template will not change your old posts. It\'ll only be used on newly inserted images.<br>Available variables;</span>';
    echo '<ul id="tags">
            <li>{url} - full link to image\'s Flickr page</li>
            <li>{src} - full image source URL, should be used in &lt;img&gt; src attribute</li>
            <li>{img} - complete &lt;img&gt; tag, includes alt, title and src attributes</li>
            <li>{title} - image title from Flickr</li>
            <li>{author} - image author name</li>
            <li>{credits} - author\'s name and link to the image on Flickr along with Compfight link</li>
            <li>{copyright} - small CC logo with link to the license; if image is not CC licensed this variable will be empty</li>

            <li>{img_size} - depends on the size you choose when inserting an image; values: small, medium, large</li>
         </ul>';
    echo '</td></tr>';

    echo '</tbody></table>';

    echo '<script type="text/javascript"> cf_default_layout = \'' . CF_DEFAULT_LAYOUT . '\'; </script>';

    echo '<p class="submit"><input type="submit" value="Save Settings" class="button-primary" name="Submit" /></p>';

    echo '</form>';
    echo '</div>';
  } // options_page


  // set default settings
  function default_settings($force = false) {
    $defaults = array('search' => 'tags-only',
                      'license' => 'cc',
                      'safe-search' => '1',
                      'original-images' => 'all',
                      'small-image-size' => '_s',
                      'medium-image-size' => '',
                      'large-image-size' => '_b',
                      'featured-image-size' => '_z',
                      'layout' => CF_DEFAULT_LAYOUT);

    $options = get_option(CF_OPTIONS_KEY);

    if ($force || !$options || !$options['search']) {
      update_option(CF_OPTIONS_KEY, $defaults);
    }

    $options = get_option(CF_OPTIONS_KEY);
    if(empty($options['layout'])) {
      $options['layout'] = CF_DEFAULT_LAYOUT;
      update_option(CF_OPTIONS_KEY, $options);
    }
    
    $options = get_option(CF_OPTIONS_KEY);
    if(empty($options['featured-image-size'])) {
      $options['featured-image-size'] = '_z';
      update_option(CF_OPTIONS_KEY, $options);
    }
  } // default_settings


  // all settings are saved in one option key
  function register_settings() {
    register_setting(CF_OPTIONS_KEY, CF_OPTIONS_KEY, array(__CLASS__, 'sanitize_settings'));
  } // register_settings


  // sanitize settings on save
  function sanitize_settings($values) {
    $old_options = get_option(CF_OPTIONS_KEY);

    foreach ($values as $key => $value) {
      switch ($key) {
        case 'search':
        case 'license':
        case 'safe-search':
        case 'original-images':
        case 'small-image-size':
        case 'medium-image-size':
        case 'large-image-size':
        case 'featured-image-size':
          $values[$key] = trim($value);
        break;
        case 'layout':
          if (empty($values[$key])) {
            $values[$key] = CF_DEFAULT_LAYOUT;
          }
        break;
      } // switch
    } // foreach

    return array_merge($old_options, $values);
  } // sanitize_settings


  // min version error
  function min_version_error() {
    echo '<div class="error"><p>Compfight<b> requires WordPress version ' . CF_WP_MIN . '</b> or higher to function properly. You\'re using WordPress version ' . get_bloginfo('version') . '. Please <a href="update-core.php">update it</a>.</p></div>';
  } // min_version_error



  // helper function for $_POST checkbox handling
  function check_var_isset(&$values, $variables) {
    foreach ($variables as $key => $value) {
      if (!isset($values[$key])) {
        $values[$key] = $value;
      }
    }
  } // check_var_isset


  // check if user has the minimal WP version required by the plugin
  function check_wp_version($min_version) {
    if (!version_compare(get_bloginfo('version'), $min_version,  '>=')) {
        add_action('admin_notices', array(__CLASS__, 'min_version_error'));
    }
  } // check_wp_version


  // create the admin menu item under appearance
  function admin_menu() {
    add_options_page('Compfight', 'Compfight', 'manage_options', 'cf-options', array(__CLASS__, 'options_page'));
  } // admin_menu


  // uninstall plugin
  function uninstall() {
    global $current_user;

    delete_option(CF_OPTIONS_KEY);
    delete_transient('cf_' . $current_user->user_login . '_search_value');
  } // uninstall


  // get photo info via API
  function ajax_callback_get_photo_info() {
    // Fetch plugin options
    $options = get_option(CF_OPTIONS_KEY);

    // Photo ID and Photo Secret
    $photo_id     = trim($_POST['photo_id']);
    $photo_secret = trim($_POST['photo_secret']);
    $photo_size   = trim($_POST['img_size']);
    if ($photo_size == '_s') {
      $photo_size2 = 'small';
    } elseif ($photo_size == '') {
      $photo_size2 = 'medium';
    } elseif ($photo_size == '_b') {
      $photo_size2 = 'large';
    }

    // Flickr API Call
    $f = new phpFlickr(CF_FLICKR_API_KEY, CF_FLICKR_SECRET, true);
    $f->enableCache('ts', '');
    $info = $f->photos_getInfo($photo_id, $photo_secret);

    // License Checking
    $not_cc_license = explode(',', '4,5,6');
    if (in_array($info['photo']['license'], $not_cc_license)) {
      $setup['cc'] = 0;
    } else {
      $setup['cc'] = 1;
    }

    // Photo Id, Photo Owner
    $setup['photo_id']   = $info['photo']['id'];
    $setup['owner_nsid'] = $info['photo']['owner']['nsid'];

    if ($info['photo']['owner']['realname'] != '') {
      $setup['owner']  = $info['photo']['owner']['realname'];
    } else {
      $setup['owner']  = $info['photo']['owner']['username'];
    }

    // Copyright
    $setup['credit'] = plugins_url('images/cc.png', __FILE__);

    // Layout setup
    if (!$setup['cc']) {
      $cc  = '<a title="Attribution License" href="http://creativecommons.org/licenses/by/2.0/" target="_blank">';
      $cc .= '<img src="' . $setup['credit'] . '" alt="Creative Commons License" title="Creative Commons License" width="16" height="16" style="margin:0; padding:0;" border="0">';
      $cc .= '</a>';
    } else {
      $cc = '';
    }

    // Layout vars
    $layout_vars = array('{url}', '{src}', '{img}', '{credits}', '{copyright}', '{title}', '{img_size}', '{author}');
    $layout_rplv = array('http://www.flickr.com/photos/' . $setup['owner_nsid'] . '/' . $setup['photo_id'] . '/',
                         'http://farm' . $info['photo']['farm'] . '.staticflickr.com/' . $info['photo']['server'] . '/' . $setup['photo_id'] . '_' . $photo_secret . '' . $photo_size . '.jpg',
                         '<img src="http://farm' . $info['photo']['farm'] . '.staticflickr.com/' . $info['photo']['server'] . '/' . $setup['photo_id'] . '_' . $photo_secret . '' . $photo_size . '.jpg" title="' . htmlspecialchars($info['photo']['title']) . '" alt="' . htmlspecialchars($info['photo']['title']) . '" />',
                         '<a title="' . $setup['owner'] . '" href="http://www.flickr.com/photos/' . $setup['owner_nsid'] .  '/' . $setup['photo_id'] . '/" target="_blank">' . $setup['owner'] . '</a> via <a href="http://www.compfight.com/" title="Compfight">Compfight</a>',
                         $cc,
                         htmlspecialchars($info['photo']['title']),
                         $photo_size2,
                         $setup['owner']);
    $return = str_replace($layout_vars, $layout_rplv, $options['layout']);

    echo $return;
    die();
  } // get_photo_info
  
  
  // Set selected photo as featured image for post/page
  function ajax_callback_set_featured_image() {
    $photo_url = trim($_POST['photo_url']);
    $title     = trim($_POST['photo_title']);
    $post_id   = trim($_POST['post_id']);
    
    $response = wp_remote_get($photo_url);
    if ($response['headers']['content-length'] == '10274') {
      die('file-error');
    }
    
    $tmp = download_url($photo_url);
    if (is_wp_error($tmp)) {
      die('file-error');
    }
    
    $desc = $title;

    // Set variables for storage
    preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $photo_url, $matches);
    
    if (!isset($matches[0])) {
      // Extension not supported
      die('0');
    }
    
    $file_array['name'] = basename($matches[0]);
    $file_array['tmp_name'] = $tmp;
    
    // If error storing temporarily, unlink
    if (is_wp_error($tmp)) {
      @unlink($file_array['tmp_name']);
      $file_array['tmp_name'] = '';
      die();
    }

    // do the validation and storage stuff
    $id = media_handle_sideload($file_array, $post_id, $desc);
    $img_url = wp_get_attachment_image_src($id, 'thumbnail');
    // If error storing permanently, unlink
    if ( is_wp_error($id) ) {
      @unlink($file_array['tmp_name']);
      die();
    }
    
    echo '<img class="attachment-post-thumbnail" src="' . $img_url[0] . '" />';
    update_post_meta($post_id, '_thumbnail_id', $id);
    die();
  } // set_featured_image
} // class compfight

add_action('init', array('compfight', 'init'));
register_deactivation_hook(__FILE__, array('compfight', 'uninstall'));
?>