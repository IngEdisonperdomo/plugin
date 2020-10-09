<?php

/*

Plugin Name: Gestion de Reportes

Plugin URI: 

Description: Sistema de gestion para generar reporte de usuarios

Version: 1.0

Author: Edison perdomo

Author URI: 

License: GPLv2

*/

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

$prefix_plugin_gn = "gestion_reporte_";

define('PREFIX', 'gn_');

define( 'GN_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

define( 'GN_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

define('PLUGIN_BASE_DIR', dirname(__FILE__));


define('PLUGIN_NAME',"Sistema de Reportes");

//Creacion nombre de las tablas de la base de datos
define('TABLA_EMPLEADOS' , $wpdb->prefix . $prefix_plugin_gn . 'perfil_empleado');


function admin_style(){

  //Bootstrap
  wp_enqueue_style( 'css-bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', false );
  wp_enqueue_script( 'jquery','https://code.jquery.com/jquery-3.5.1.slim.min.js', array('jquery'), null, true );
  wp_enqueue_script( 'bootstrap-popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', array('jquery'), null, true );

  wp_enqueue_script( 'bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true );

  wp_enqueue_style( 'css-admin-plugin', GN_PLUGIN_DIR_URL .'assets/css/estilos_admin.css', false );

  //Datatable
  wp_enqueue_style( 'datatablecss','https://cdn.datatables.net/v/bs4/dt-1.10.22/r-2.2.6/datatables.min.css', false );
  wp_enqueue_script( 'datatablejs','https://cdn.datatables.net/v/bs4/dt-1.10.22/r-2.2.6/datatables.min.js', array('jquery'), null, true );

  wp_enqueue_script( 'sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@10' , array( 'jquery' ), '1.0.0' , true );

  wp_enqueue_script( 'script-busqueda', GN_PLUGIN_DIR_URL . 'assets/js/busqueda.js' , array( 'jquery' ), '1.0.0' , true );
wp_localize_script('script-busqueda','busqueda_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);

}
add_action('admin_enqueue_scripts', 'admin_style');


function front_styles(){

  wp_enqueue_script( 'sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@10' , array( 'jquery' ), '1.0.0' , true );

  wp_enqueue_style( 'css-front-plugin', GN_PLUGIN_DIR_URL .'assets/css/estilos_front.css', false );

  wp_enqueue_script( 'script-front', GN_PLUGIN_DIR_URL . 'assets/js/front.js' , array( 'jquery' ), '1.0.0' , true );
wp_localize_script('script-front','busqueda_var',['ajaxurl'=>admin_url('admin-ajax.php')]);

}
add_action('wp_enqueue_scripts', 'front_styles');





//directorio de archivos
include GN_PLUGIN_DIR_PATH. "lib/functions.php";
include GN_PLUGIN_DIR_PATH . "models/index.php";
include GN_PLUGIN_DIR_PATH . "controllers/index.php";
include GN_PLUGIN_DIR_PATH . "admin/index.php";
include GN_PLUGIN_DIR_PATH . "views/index.php";

include GN_PLUGIN_DIR_PATH . "reportes/index.php";

/* CREAR lOS MENUS */
function admin_menus() {
  add_menu_page(PLUGIN_NAME,PLUGIN_NAME,'manage_options', 'reportes-usuarios','listado_usuarios', 'dashicons-admin-users', 6);
 
}
add_action('admin_menu', 'admin_menus');


//Devolver datos a archivo js
add_action('wp_ajax_nopriv_ajax_busqueda','busqueda_ajax');
add_action('wp_ajax_ajax_busqueda','busqueda_ajax');

//Devolver datos a archivo Front js
add_action('wp_ajax_nopriv_ajax_buscar','busqueda');
add_action('wp_ajax_ajax_buscar','busqueda');


//ajax funcion
function busqueda_ajax(){
  require_once(ABSPATH . 'wp-includes/pluggable.php');
  
include "ajax/busqueda.ajax.php";
}


function busqueda(){
  require_once(ABSPATH . 'wp-includes/pluggable.php');
  
include "ajax/buscar.ajax.php";
}