<?php
    /*
      Plugin Name: CSS3 Tables
      Plugin URI: http://codecanyon.net/user/Code125
      Description: Plugin for adding tables to a WordPress theme and edit them in a very easy way
      Author: Creiden
      Version: 1.0
      Author URI: http://www.code125.com
     */

    function css3_tables_create() {
        include('css3_tables_create.php');
    }

    function css3_tables_list() {
        include('css3_tables_table.php');
    }

    function css3_tables_admin_actions() {
        add_menu_page('CSS3 Tables', 'CSS3 Tables', 8, __FILE__);
        add_submenu_page(__FILE__, 'Create Table', 'Create Table', 8, __FILE__, "css3_tables_create");
        add_submenu_page(__FILE__, 'Tables list', 'Tables list', 8, "tables_list", "css3_tables_list");
    }

    function wpct_activate() {
        global $wpdb;

        //*** Table Properties table creation***//
        $table_name = $wpdb->prefix . 'wpct_tables';

        if ($wpdb->get_var('SHOW TABLES LIKE ' . $table_name) != $table_name) {
            $sql = 'CREATE TABLE ' . $table_name . '( 
				table_id INTEGER(10) UNSIGNED AUTO_INCREMENT,
				table_type VARCHAR (255),
				table_name VARCHAR (255),
				theme_name VARCHAR (255),
				table_width INTEGER(10),
				col_count INTEGER(10),
				col_width INTEGER(10),
				col_left_width INTEGER(10),
				row_count INTEGER(10),
				PRIMARY KEY  (table_id) )';

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            add_option('wpct_tables_database_version', '1.0');
        }
    }

    function wpct_css_add() {
        $myStyleUrl = plugins_url('style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
        $myStyleFile = WP_PLUGIN_DIR . '/wpct_css3_tables/style.css';
        if (file_exists($myStyleFile)) {
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style('myStyleSheets');
        }
    }

    function wpct_css_admin_add() {
        echo '<link rel="stylesheet" type="text/css" href="' . plugins_url('style-admin.css', __FILE__) . '">';
    }

    function wpct_js_admin_add() {
        echo '<script src="http://code.jquery.com/jquery-latest.js"></script>';

        echo '<script type="text/javascript" src="' . plugins_url('script.js', __FILE__) . '"></script>';
    }

    function wpct_show_table($atts, $content=null) {

        shortcode_atts(array('id' => ''), $atts);

        global $wpdb;

        $table_name = $wpdb->prefix . 'wpct_tables';

        $table_id_query = $atts['id'];

        $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_id` = ' . $table_id_query;

        $data_general = $wpdb->get_row($query, ARRAY_A);

        $query2 = 'SELECT * FROM `wp_wpct_table_' . $atts['id'] . '`';

        $data_contents = $wpdb->get_results($wpdb->prepare($query2));

        $counter = 0;

        foreach ($data_contents as $data_content_one) {
            $data_content[$counter] = (array) $data_content_one;
            $counter++;
        }




        $tag_count = 3;
        $data = '<table class="table_01">';
        $data = $data . '<tr class="col_title">';
        if ($data_general['table_type'] == "left_col") {
            $data = $data . '<td style="width:' . $data_general['col_left_width'] . 'px"></td>';
        }

        for ($i = 1; $i <= $data_general['col_count']; $i++) {
            $data = $data . '<td class="' . $data_content[3]['col' . $i] . '"><hgroup>';
            for ($j = 1; $j <= $tag_count; $j++) {
                $data = $data . '<h' . $j . '>' . $data_content[$j - 1]['col' . $i] . '</h' . $j . '>';
            }
            $data = $data . '</hgroup><p>99</p> </td>';
        }

        $data = $data . '</tr>';

        if ($data_general['table_type'] == "left_col") {

            for ($i = 1; $i <= $data_general['row_count']; $i++) {
                $class_odd_even = ($i % 2 ) ? 'odd' : 'even';
                $data = $data . '<tr class="' . $class_odd_even . '" >';
                $data = $data . '<td class="' . $data_content[6]['name'] . '">' . $data_content[$i + 6]['name'] . '</td>';
                for ($j = 1; $j <= $data_general['col_count']; $j++) {
                    if ($data_content[$i + 3]['type'] == "true_false") {
                        if ($data_content[$i + 3]['col' . $j] == "yes") {
                            $cell_content = '<img src="' . plugins_url('images/included.png', __FILE__) . '" alt="included"/>';
                        } elseif ($data_content[$i + 3]['col' . $j] == "no") {
                            $cell_content = '<img src="' . plugins_url('images/not_included.png', __FILE__) . '" alt="included"/>';
                        }
                    } else {
                        $cell_content = $data_content[$i + 3]['col' . $j];
                    }
                    $data = $data . '<td class="' . $data_content[3]['col' . $j] . '">' . $cell_content . '</td>';
                }
                $data = $data . '</tr>';
            }
            if ($data_content[$data_general['row_count'] + 5]['name'] == "yes") {
                $data = $data . '<tr class="table_button" ><td></td>';
                for ($j = 1; $j <= $data_general['col_count']; $j++) {
                    $data = $data . '<td class="' . $data_content[3]['col' . $j] . '"><a href="' . $data_content[$data_general['row_count'] + 5]['col' . $j] . '" >' . $data_content[$data_general['row_count'] + 4]['col' . $j] . '</a></td> ';
                }
                $data = $data . '</tr>';
            }
        } else {

            for ($i = 1; $i <= $data_general['row_count']; $i++) {
                $class_odd_even = ($i % 2 ) ? 'odd' : 'even';
                $data = $data . '<tr class="' . $class_odd_even . '" >';
                for ($j = 1; $j <= $data_general['col_count']; $j++) {
                    if ($data_content[$i + 3]['col' . $j] == "X") {
                        $cell_content = '<img src="' . plugins_url('images/not_included.png', __FILE__) . '" alt="included"/>';
                    } else {
                        $cell_content = $data_content[$i + 3]['col' . $j];
                    }
                    $data = $data . '<td class="' . $data_content[3]['col' . $j] . '">' . $cell_content . '</td>';
                }
                $data = $data . '</tr>';
            }
            if ($data_content[$data_general['row_count'] + 5]['name'] == "yes") {
                $data = $data . '<tr class="table_button" >';
                for ($j = 1; $j <= $data_general['col_count']; $j++) {
                    $data = $data . '<td class="' . $data_content[3]['col' . $j] . '"><a href="' . $data_content[$data_general['row_count'] + 5]['col' . $j] . '" >' . $data_content[$data_general['row_count'] + 4]['col' . $j] . '</a></td> ';
                }
                $data = $data . '</tr>';
            }
        }
        $data = $data . '</table>';

        return $data;
    }

    function wpct_js_add() {
        // register your script location, dependencies and version

        $myScriptUrl = plugins_url('script_plugin.js', __FILE__);
        wp_register_script('custom_script', $myScriptUrl, array('jquery'), '1.0');
        // enqueue the script
        wp_enqueue_script('custom_script');
    }

    add_shortcode('wpct_show_table', 'wpct_show_table');

    add_action('admin_menu', 'css3_tables_admin_actions');
    add_action('wp_print_styles', 'wpct_css_add');
    add_action('wp_enqueue_scripts', 'wpct_js_add');
    add_action('admin_head', 'wpct_css_admin_add');
    add_action('admin_head', 'wpct_js_admin_add');



    register_activation_hook(__FILE__, "wpct_activate");
?>