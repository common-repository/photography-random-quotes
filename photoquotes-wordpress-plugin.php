<?php
/*
Plugin Name: Photography Random Quotes Plugin
Plugin URI: http://www.photoquotes.com/
Description: Random photography quotes plugin that will display quotations about photography on your wordpress blog.
Version: 1.0
Author: Hakon Agustsson
Author URI: http://www.PhotoQuotes.com
*/
/*  Copyright 2010 Hakon Agustsson (email : info@PhotoQuotes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

error_reporting(E_ALL);

if (!class_exists("photoquotes_widget")) {

   class photoquotes_widget {
      public function photoquotes_widget() { //constructor
      }

      public function control(){
         echo 'photoquotes.com widget control panel';
      }

      public function widget($args){
         echo $args['before_widget'];
         echo $args['before_title'] . 'photoquotes.com widget' . $args['after_title'];
         echo '<noscript>Your browser needs to support javascript to view Photoquotes</noscript><div id=\'photoquotes_quote\'>?</div><div id=\'photoquotes_author\'>?</div>';
         echo $args['after_widget'];
      }

      public function photoquotesjs ( ) {
/*          wp_enqueue_script( 'photoquotesjs', path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/js/photoquotes.js") );*/
        echo  '
<script type="text/javascript">
    function fnc(obj) {
       eval(\'var v=\'+obj.d);

       if (!v.Quote) 
          v.Quote = "?";

       if (!v.Author)
          v.Author = "?";

       document.getElementById(\'photoquotes_quote\').innerHTML = v.Quote;
       document.getElementById(\'photoquotes_author\').innerHTML = v.Author;

       document.getElementById(\'photoquotes_author\').innerHTML = "<a href=\"http://www.photoquotes.com/showquotes.aspx?id=" + v.Id + "\">- " + v.Author + "</a>"

    }
 </script>  
 <script type="text/javascript" src="http://api.photoquotes.com/photoquotes.asmx/PhotoQuoteGetJson?callback=fnc"></script>';
      }

      public function register(){
         register_sidebar_widget('photoquotes_widget', array(&$this, 'widget'));
         // callback is photoquotes_widget::widget
         register_widget_control('photoquotes_widget', array(&$this, 'control'));
         // callback is photoquotes_widget::control
      }

   } // end class

}

function add_jquery() {
   wp_enqueue_script('jquery' ); 
}

if (class_exists("photoquotes_widget")) {
   $photoquotes_plugin = new photoquotes_widget();
}

if (isset($photoquotes_plugin)) {
   // Actions
   add_action('widgets_init', array(&$photoquotes_plugin, 'register'));
   add_action('wp_footer', array(&$photoquotes_plugin, 'photoquotesjs'));

}

?>