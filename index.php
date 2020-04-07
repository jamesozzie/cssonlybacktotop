<?php
/*
Plugin Name: CSS Only Back to Top Button
Plugin URI: http://jamesozz.ie
Description: A CSS only back to top button. AMP compatible & lightweight.
Author: James Osborne
Version: 1.0.0
Author URI: https://aztecdesign.ie
 */

define('JZ_PLUGIN_DIR', plugin_dir_path(__FILE__));

// include options file
include plugin_dir_path(__FILE__) . '/options.php';

// create custom plugin settings menu
add_action('admin_menu', 'sr_custom_settings');
function sr_custom_settings()
{
    $page_title = 'CSS Back to Top';
    $menu_title = 'CSS Back to Top';
    $capability = 'manage_options';
    $slug = 'jz-settings-cssbacktotop';
    $start = 'jz_custom_settings_start';
    add_options_page($page_title, $menu_title, $capability, $slug, $start);
}

// Create option settings
add_action('admin_init', 'jz_field');
function jz_field()
{
    register_setting('jz-settings', 'color');
    register_setting('jz-settings', 'viewoption');
}

// add WP colour picker
if (is_admin()) {
    add_action('admin_enqueue_scripts', 'jz_colors_script');
}
function jz_colors_script($hook_suffix)
{
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
}

//set the CSS defaults
add_action('wp_head', 'jz_cssdefaults');
function jz_cssdefaults()
{
    $color = esc_attr(get_option('color', '#314a5e')); ?>
<style>
.jz-scrolltop-wrap a svg path {
    fill: <?= $color ?>;
}
</style>
<?php
}

//set the rendering options
add_action('wp_head', 'jz_options');
function jz_options()
{
    $viewoption = esc_attr(get_option('viewoption', 'AMP & Canonical'));

    if ($viewoption == "AMP only") {
        add_action('wp_footer', function () {
            if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
                echo '
        <div class="jz-scrolltop-wrap"  >
        <a href="#" role="button" aria-label="Scroll to top">
        <svg viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" width="40px" height="40px" >

        <path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M383.188,302.75
                   c-1.646,3.979-5.542,6.583-9.854,6.583h-32c-2.833,0-5.542-1.125-7.542-3.125L256,228.417l-77.792,77.792
                   c-2,2-4.708,3.125-7.542,3.125h-32c-4.313,0-8.208-2.604-9.854-6.583c-1.604-3.979-0.729-8.583,2.313-11.625l117.333-117.333
                   c4.167-4.167,10.917-4.167,15.083,0l117.333,117.333c2.042,2.042,3.125,4.771,3.125,7.542
                   C384,300.042,383.729,301.438,383.188,302.75z"/>
        </svg>
        </a>
        </div>
        ';
            }
        });
    } elseif ($viewoption == "Canonical only") {
        add_action('wp_footer', function () {
            if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
                return;
            } else {
                echo '
        <div class="jz-scrolltop-wrap"  >
        <a href="#" role="button" aria-label="Scroll to top">
        <svg viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" width="40px" height="40px" >

        <path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M383.188,302.75
                   c-1.646,3.979-5.542,6.583-9.854,6.583h-32c-2.833,0-5.542-1.125-7.542-3.125L256,228.417l-77.792,77.792
                   c-2,2-4.708,3.125-7.542,3.125h-32c-4.313,0-8.208-2.604-9.854-6.583c-1.604-3.979-0.729-8.583,2.313-11.625l117.333-117.333
                   c4.167-4.167,10.917-4.167,15.083,0l117.333,117.333c2.042,2.042,3.125,4.771,3.125,7.542
                   C384,300.042,383.729,301.438,383.188,302.75z"/>
        </svg>
        </a>
        </div>
        ';
            }
        });
    } else {
        add_action('wp_footer', function () {
            echo '
        <div class="jz-scrolltop-wrap"  >
        <a href="#" role="button" aria-label="Scroll to top">
        <svg viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" width="40px" height="40px" >

        <path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M383.188,302.75
                   c-1.646,3.979-5.542,6.583-9.854,6.583h-32c-2.833,0-5.542-1.125-7.542-3.125L256,228.417l-77.792,77.792
                   c-2,2-4.708,3.125-7.542,3.125h-32c-4.313,0-8.208-2.604-9.854-6.583c-1.604-3.979-0.729-8.583,2.313-11.625l117.333-117.333
                   c4.167-4.167,10.917-4.167,15.083,0l117.333,117.333c2.042,2.042,3.125,4.771,3.125,7.542
                   C384,300.042,383.729,301.438,383.188,302.75z"/>
        </svg>
        </a>
        </div>
        ';
        });
    }
}

// Add the style
function jz_load_plugin_css()
{
    $plugin_url = plugin_dir_url(__FILE__);
    wp_enqueue_style('style1', $plugin_url . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'jz_load_plugin_css');

// create link to the settings page from plugins page
function my_plugin_settings_link($links)
{
    $settings_link =
        '<a href="options-general.php?page=jz-settings-cssbacktotop.php">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'my_plugin_settings_link');
