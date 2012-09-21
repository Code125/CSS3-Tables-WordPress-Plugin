<?php
global $wpdb;

$table_name = $wpdb->get_var($wpdb->prepare("SELECT table_name FROM wp_wpct_tables WHERE table_id = %d", $table_id));

if ($_POST['wpct_action_type'] == "create") {

    global $wpdb;
    $table_name = $wpdb->prefix . 'wpct_tables';

    $table_width = ( $_POST['wpct_table_number_cols'] * $_POST['wpct_table_column_width'] ) + $_POST['wpct_table_left_column_width'];

    $wpdb->insert($table_name, array('table_type' => $_POST['wpct_table_type'],
        'table_name' => $_POST['wpct_table_name'],
        'theme_name' => $_POST['wpct_table_theme'],
        'table_width' => $table_width,
        'col_count' => $_POST['wpct_table_number_cols'],
        'col_width' => $_POST['wpct_table_column_width'],
        'col_left_width' => $_POST['wpct_table_left_column_width'],
        'row_count' => $_POST['wpct_table_number_rows']
            ), array('%s'));

    $table_name_query = $_POST['wpct_table_name'];

    $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_name` = "' . $table_name_query . '"';

    $data_temp = $wpdb->get_row($query, ARRAY_A);

    $table_data_name = $wpdb->prefix . 'wpct_table_' . $data_temp['table_id'];

    $sql = 'CREATE TABLE ' . $table_data_name . '( 
					id INTEGER(10) UNSIGNED AUTO_INCREMENT,
					name VARCHAR (255),
					type VARCHAR (255),';

    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
        $sql = $sql . ' col' . $i . ' VARCHAR (255),';
    }
    $sql = $sql . 'PRIMARY KEY  (id) )';


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);


    $table_name = $wpdb->prefix . 'wpct_table_' . $data_temp['table_id'];

    //tag 1-6
    for ($j = 1; $j <= 3; $j++) {
        //tag j
        unset($table_data);
        $table_data['name'] = "";
        $table_data['type'] = "";

        for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
            $table_data['col' . $i] = "";
        }

        $wpdb->insert($table_name, $table_data, array('%s'));
    }
    $col_odd = '';
    $col_even = '';
    $col_last = '';

    switch ($_POST['wpct_table_theme']) {

        case "wpct_table_theme_01":

            $col_odd = 'red';
            $col_even = 'black';
            break;
        case "wpct_table_theme_02":
            $col_odd = 'beige';
            $col_even = 'black';
            break;
        case "wpct_table_theme_03":
            $col_odd = 'green';
            $col_even = 'black';
            break;
        case "wpct_table_theme_04":

            $col_odd = 'blue';
            $col_even = 'black';
            break;
        case "wpct_table_theme_05":

            $col_odd = 'yellow';
            $col_even = 'black';
            break;
        case "wpct_table_theme_06":

            $col_odd = 'violet';
            $col_even = 'black';
            break;
        case "wpct_table_theme_07":

            $col_odd = 'pink';
            $col_even = 'black';
            break;
        case "wpct_table_theme_08":

            $col_odd = 'blue';
            $col_even = 'red';
            break;
        case "wpct_table_theme_09":

            $col_odd = 'yellow';
            $col_even = 'red';
            break;
        case "wpct_table_theme_10":

            $col_odd = 'orange';
            $col_even = 'red';
            break;
        case "wpct_table_theme_11":

            $col_odd = 'yellow';
            $col_even = 'blue';
            break;
        case "wpct_table_theme_12":

            $col_odd = 'yellow';
            $col_even = 'green';
            break;
        case "wpct_table_theme_13":

            $col_odd = 'yellow';
            $col_even = 'beige';
            break;
        case "wpct_table_theme_14":

            $col_odd = 'violet';
            $col_even = 'pink';
            break;
        case "wpct_table_theme_15":

            $col_odd = 'pink';
            $col_even = 'red';
            break;
        case "wpct_table_theme_16":

            $col_odd = 'violet';
            $col_even = 'red';
            break;
        case "wpct_table_theme_17":

            $col_odd = 'red';
            $col_even = 'red';
            break;
        case "wpct_table_theme_18":

            $col_odd = 'blue';
            $col_even = 'blue';
            break;
        case "wpct_table_theme_19":

            $col_odd = 'green';
            $col_even = 'green';
            break;
        case "wpct_table_theme_20":

            $col_odd = 'beige';
            $col_even = 'beige';
            break;
        case "wpct_table_theme_21":

            $col_odd = 'yellow';
            $col_even = 'yellow';
            break;
        case "wpct_table_theme_22":

            $col_odd = 'orange';
            $col_even = 'orange';
            break;
        case "wpct_table_theme_23":

            $col_odd = 'pink';
            $col_even = 'pink';
            break;
        case "wpct_table_theme_24":

            $col_odd = 'violet';
            $col_even = 'violet';
            break;
        case "wpct_table_theme_25":

            $col_odd = 'black';
            $col_even = 'black';
            break;
        case "wpct_table_theme_26":

            $col_last = 'red';
            break;
        case "wpct_table_theme_27":

            $col_last = 'yellow';
            break;
        case "wpct_table_theme_28":

            $col_last = 'orange';
            break;
        case "wpct_table_theme_29":

            $col_last = 'green';
            break;
        case "wpct_table_theme_30":

            $col_last = 'blue';
            break;
        case "wpct_table_theme_31":

            $col_last = 'violet';
            break;
        case "wpct_table_theme_32":

            $col_last = 'pink';
            break;
    }

    //column color

    unset($table_data);
    if ($col_last) {
        $table_data['name'] = 'black';
    } else {
        $table_data['name'] = $col_odd;
    }
    $table_data['type'] = "";

    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
        if ($col_last) {
            if ($i == $_POST['wpct_table_number_cols']) {
                $table_data['col' . $i] = $col_last;
            } else {
                $table_data['col' . $i] = 'black';
            }
        } else {
            if ($i % 2) {
                $table_data['col' . $i] = $col_even;
            } else {
                $table_data['col' . $i] = $col_odd;
            }
        }
    }

    $wpdb->insert($table_name, $table_data, array('%s'));


    //rows 
    for ($j = 1; $j <= $_POST['wpct_table_number_rows']; $j++) {
        //tag j
        unset($table_data);
        $table_data['name'] = '';
        $table_data['type'] = 'value';

        for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
            $table_data['col' . $i] = '';
        }

        $wpdb->insert($table_name, $table_data, array('%s'));
    }

    //Button

    unset($table_data);
    $table_data['name'] = "yes";
    $table_data['type'] = "button";

    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
        $table_data['col' . $i] = '';
    }

    $wpdb->insert($table_name, $table_data, array('%s'));


    //link

    unset($table_data);
    $table_data['name'] = "yes";
    $table_data['type'] = "link";

    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
        $table_data['col' . $i] = '';
    }

    $wpdb->insert($table_name, $table_data, array('%s'));
} elseif ($_POST['wpct_action_type'] == "update") {

    $table_name = $wpdb->prefix . 'wpct_tables';

    $table_width = ( $_POST['wpct_table_number_cols'] * $_POST['wpct_table_column_width'] ) + $_POST['wpct_table_left_column_width'];

    $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_id` = "' . $_POST['wpct_table_id'] . '"';

    $data_old = $wpdb->get_row($query, ARRAY_A);

    $wpdb->update(
            $table_name, array(
        'table_type' => $_POST['wpct_table_type'],
        'table_name' => $_POST['wpct_table_name'],
        'theme_name' => $_POST['wpct_table_theme'],
        'table_width' => $table_width,
        'col_count' => $_POST['wpct_table_number_cols'],
        'col_width' => $_POST['wpct_table_column_width'],
        'col_left_width' => $_POST['wpct_table_left_column_width'],
        'row_count' => $_POST['wpct_table_number_rows']
            ), array('table_id' => $_POST['wpct_table_id']), array(
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%d',
        '%d',
        '%d'
            ), array('%s')
    );

    $query = 'SELECT * FROM `wp_wpct_table_' . $_POST['wpct_table_id'] . '`';

    $data_temp = $wpdb->get_results($wpdb->prepare($query));

    $clear = 'TRUNCATE TABLE `wp_wpct_table_' . $_POST['wpct_table_id'] . '`';
    $wpdb->query($clear);

    if ($_POST['wpct_table_number_cols'] != $data_old['col_count']) {
        $delete = 'DROP TABLE `wp_wpct_table_' . $_POST['wpct_table_id'] . '`';
        $wpdb->query($delete);

        $table_data_name = $wpdb->prefix . 'wpct_table_' . $_POST['wpct_table_id'];

        $sql = 'CREATE TABLE ' . $table_data_name . '( 
					id INTEGER(10) UNSIGNED AUTO_INCREMENT,
					name VARCHAR (255),
					type VARCHAR (255),';

        for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
            $sql = $sql . ' col' . $i . ' VARCHAR (255),';
        }
        $sql = $sql . 'PRIMARY KEY  (id) )';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    $table_name = 'wp_wpct_table_' . $_POST['wpct_table_id'];

    $counter = 1;
    foreach ($data_temp as $row) {
        $row = (array) $row;
        if ($_POST['wpct_table_number_rows'] > $data_old['row_count']) {
            if ($counter < 4 + $data_old['row_count'] && $counter != 4) {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {
                    for ($i = 1; $i <= $data_old['col_count']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = '';
                    }
                } else {
                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;
            } elseif ($counter == 4) {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {

                    $col_odd = '';
                    $col_even = '';
                    $col_last = '';

                    switch ($_POST['wpct_table_theme']) {

                        case "wpct_table_theme_01":

                            $col_odd = 'red';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_02":
                            $col_odd = 'beige';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_03":
                            $col_odd = 'green';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_04":

                            $col_odd = 'blue';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_05":

                            $col_odd = 'yellow';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_06":

                            $col_odd = 'violet';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_07":

                            $col_odd = 'pink';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_08":

                            $col_odd = 'blue';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_09":

                            $col_odd = 'yellow';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_10":

                            $col_odd = 'orange';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_11":

                            $col_odd = 'yellow';
                            $col_even = 'blue';
                            break;
                        case "wpct_table_theme_12":

                            $col_odd = 'yellow';
                            $col_even = 'green';
                            break;
                        case "wpct_table_theme_13":

                            $col_odd = 'yellow';
                            $col_even = 'beige';
                            break;
                        case "wpct_table_theme_14":

                            $col_odd = 'violet';
                            $col_even = 'pink';
                            break;
                        case "wpct_table_theme_15":

                            $col_odd = 'pink';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_16":

                            $col_odd = 'violet';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_17":

                            $col_odd = 'red';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_18":

                            $col_odd = 'blue';
                            $col_even = 'blue';
                            break;
                        case "wpct_table_theme_19":

                            $col_odd = 'green';
                            $col_even = 'green';
                            break;
                        case "wpct_table_theme_20":

                            $col_odd = 'beige';
                            $col_even = 'beige';
                            break;
                        case "wpct_table_theme_21":

                            $col_odd = 'yellow';
                            $col_even = 'yellow';
                            break;
                        case "wpct_table_theme_22":

                            $col_odd = 'orange';
                            $col_even = 'orange';
                            break;
                        case "wpct_table_theme_23":

                            $col_odd = 'pink';
                            $col_even = 'pink';
                            break;
                        case "wpct_table_theme_24":

                            $col_odd = 'violet';
                            $col_even = 'violet';
                            break;
                        case "wpct_table_theme_25":

                            $col_odd = 'black';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_26":

                            $col_last = 'red';
                            break;
                        case "wpct_table_theme_27":

                            $col_last = 'yellow';
                            break;
                        case "wpct_table_theme_28":

                            $col_last = 'orange';
                            break;
                        case "wpct_table_theme_29":

                            $col_last = 'green';
                            break;
                        case "wpct_table_theme_30":

                            $col_last = 'blue';
                            break;
                        case "wpct_table_theme_31":

                            $col_last = 'violet';
                            break;
                        case "wpct_table_theme_32":

                            $col_last = 'pink';
                            break;
                    }
                    if ($_POST['wpct_table_theme'] == $data_old['theme_name']) {
                        for ($i = 1; $i <= $data_old['col_count']; $i++) {
                            $table_data['col' . $i] = $row['col' . $i];
                        }
                    } else {
                        for ($i = 1; $i <= $data_old['col_count']; $i++) {
                            if ($col_last) {
                                if ($i == $_POST['wpct_table_number_cols']) {
                                    $table_data['col' . $i] = $col_last;
                                } else {
                                    $table_data['col' . $i] = 'black';
                                }
                                if ($i == $data_old['col_count'] + 1) {
                                    $jj = $i - 1;
                                    $table_data['col' . $jj] = 'black';
                                }
                            } else {
                                if ($i % 2) {
                                    $table_data['col' . $i] = $col_even;
                                } else {
                                    $table_data['col' . $i] = $col_odd;
                                }
                            }
                        }
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        if ($col_last) {
                            if ($i == $_POST['wpct_table_number_cols']) {
                                $table_data['col' . $i] = $col_last;
                            } else {
                                $table_data['col' . $i] = 'black';
                            }
                            if ($i == $data_old['col_count'] + 1) {
                                $jj = $i - 1;
                                $table_data['col' . $jj] = 'black';
                            }
                        } else {
                            if ($i % 2) {
                                $table_data['col' . $i] = $col_even;
                            } else {
                                $table_data['col' . $i] = $col_odd;
                            }
                        }
                    }
                } else {
                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;
            } elseif ($counter == 4 + $data_old['row_count']) {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {
                    for ($i = 1; $i <= $data_old['col_count']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = '';
                    }
                } else {
                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;

                for ($i = 1; $i <= ( $_POST['wpct_table_number_rows'] - $data_old['row_count'] ); $i++) {
                    unset($table_data);
                    $table_data['name'] = "";
                    $table_data['type'] = "";

                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = '';
                    }

                    $wpdb->insert($table_name, $table_data, array('%s'));
                }
            } else {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {
                    for ($i = 1; $i <= $data_old['col_count']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = '';
                    }
                } else {
                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;
            }
        } else {
            if ($counter <= 4 + $_POST['wpct_table_number_rows'] && $counter != 4) {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {
                    for ($i = 1; $i <= $data_old['col_count']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = '';
                    }
                } else {
                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;
            } elseif ($counter == 4) {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {

                    $col_odd = '';
                    $col_even = '';
                    $col_last = '';

                    switch ($_POST['wpct_table_theme']) {

                        case "wpct_table_theme_01":

                            $col_odd = 'red';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_02":
                            $col_odd = 'beige';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_03":
                            $col_odd = 'green';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_04":

                            $col_odd = 'blue';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_05":

                            $col_odd = 'yellow';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_06":

                            $col_odd = 'violet';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_07":

                            $col_odd = 'pink';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_08":

                            $col_odd = 'blue';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_09":

                            $col_odd = 'yellow';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_10":

                            $col_odd = 'orange';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_11":

                            $col_odd = 'yellow';
                            $col_even = 'blue';
                            break;
                        case "wpct_table_theme_12":

                            $col_odd = 'yellow';
                            $col_even = 'green';
                            break;
                        case "wpct_table_theme_13":

                            $col_odd = 'yellow';
                            $col_even = 'beige';
                            break;
                        case "wpct_table_theme_14":

                            $col_odd = 'violet';
                            $col_even = 'pink';
                            break;
                        case "wpct_table_theme_15":

                            $col_odd = 'pink';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_16":

                            $col_odd = 'violet';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_17":

                            $col_odd = 'red';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_18":

                            $col_odd = 'blue';
                            $col_even = 'blue';
                            break;
                        case "wpct_table_theme_19":

                            $col_odd = 'green';
                            $col_even = 'green';
                            break;
                        case "wpct_table_theme_20":

                            $col_odd = 'beige';
                            $col_even = 'beige';
                            break;
                        case "wpct_table_theme_21":

                            $col_odd = 'yellow';
                            $col_even = 'yellow';
                            break;
                        case "wpct_table_theme_22":

                            $col_odd = 'orange';
                            $col_even = 'orange';
                            break;
                        case "wpct_table_theme_23":

                            $col_odd = 'pink';
                            $col_even = 'pink';
                            break;
                        case "wpct_table_theme_24":

                            $col_odd = 'violet';
                            $col_even = 'violet';
                            break;
                        case "wpct_table_theme_25":

                            $col_odd = 'black';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_26":

                            $col_last = 'red';
                            break;
                        case "wpct_table_theme_27":

                            $col_last = 'yellow';
                            break;
                        case "wpct_table_theme_28":

                            $col_last = 'orange';
                            break;
                        case "wpct_table_theme_29":

                            $col_last = 'green';
                            break;
                        case "wpct_table_theme_30":

                            $col_last = 'blue';
                            break;
                        case "wpct_table_theme_31":

                            $col_last = 'violet';
                            break;
                        case "wpct_table_theme_32":

                            $col_last = 'pink';
                            break;
                    }
                    if ($_POST['wpct_tablee_theme'] == $data_old['theme_name']) {
                        for ($i = 1; $i <= $data_old['col_count']; $i++) {
                            $table_data['col' . $i] = $row['col' . $i];
                        }
                    } else {
                        for ($i = 1; $i <= $data_old['col_count']; $i++) {
                            if ($col_last) {
                                $table_data['name']='black';
                                if ($i == $_POST['wpct_table_number_cols']) {
                                    $table_data['col' . $i] = $col_last;
                                } else {
                                    $table_data['col' . $i] = 'black';
                                }
                                if ($i == $data_old['col_count'] + 1) {
                                    $jj = $i - 1;
                                    $table_data['col' . $jj] = 'black';
                                }
                            } else {
                            $table_data['name']=$col_odd;
                                if ($i % 2) {
                                    $table_data['col' . $i] = $col_even;
                                } else {
                                    $table_data['col' . $i] = $col_odd;
                                }
                            }
                        }
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        if ($col_last) {
                            if ($i == $_POST['wpct_table_number_cols']) {
                                $table_data['col' . $i] = $col_last;
                            } else {
                                $table_data['col' . $i] = 'black';
                            }
                            if ($i == $data_old['col_count'] + 1) {
                                $jj = $i - 1;
                                $table_data['col' . $jj] = 'black';
                            }
                        } else {
                            if ($i % 2) {
                                $table_data['col' . $i] = $col_even;
                            } else {
                                $table_data['col' . $i] = $col_odd;
                            }
                        }
                    }
                } else {


                    $col_odd = '';
                    $col_even = '';
                    $col_last = '';

                    switch ($_POST['wpct_table_theme']) {

                        case "wpct_table_theme_01":

                            $col_odd = 'red';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_02":
                            $col_odd = 'beige';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_03":
                            $col_odd = 'green';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_04":

                            $col_odd = 'blue';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_05":

                            $col_odd = 'yellow';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_06":

                            $col_odd = 'violet';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_07":

                            $col_odd = 'pink';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_08":

                            $col_odd = 'blue';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_09":

                            $col_odd = 'yellow';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_10":

                            $col_odd = 'orange';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_11":

                            $col_odd = 'yellow';
                            $col_even = 'blue';
                            break;
                        case "wpct_table_theme_12":

                            $col_odd = 'yellow';
                            $col_even = 'green';
                            break;
                        case "wpct_table_theme_13":

                            $col_odd = 'yellow';
                            $col_even = 'beige';
                            break;
                        case "wpct_table_theme_14":

                            $col_odd = 'violet';
                            $col_even = 'pink';
                            break;
                        case "wpct_table_theme_15":

                            $col_odd = 'pink';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_16":

                            $col_odd = 'violet';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_17":

                            $col_odd = 'red';
                            $col_even = 'red';
                            break;
                        case "wpct_table_theme_18":

                            $col_odd = 'blue';
                            $col_even = 'blue';
                            break;
                        case "wpct_table_theme_19":

                            $col_odd = 'green';
                            $col_even = 'green';
                            break;
                        case "wpct_table_theme_20":

                            $col_odd = 'beige';
                            $col_even = 'beige';
                            break;
                        case "wpct_table_theme_21":

                            $col_odd = 'yellow';
                            $col_even = 'yellow';
                            break;
                        case "wpct_table_theme_22":

                            $col_odd = 'orange';
                            $col_even = 'orange';
                            break;
                        case "wpct_table_theme_23":

                            $col_odd = 'pink';
                            $col_even = 'pink';
                            break;
                        case "wpct_table_theme_24":

                            $col_odd = 'violet';
                            $col_even = 'violet';
                            break;
                        case "wpct_table_theme_25":

                            $col_odd = 'black';
                            $col_even = 'black';
                            break;
                        case "wpct_table_theme_26":

                            $col_last = 'red';
                            break;
                        case "wpct_table_theme_27":

                            $col_last = 'yellow';
                            break;
                        case "wpct_table_theme_28":

                            $col_last = 'orange';
                            break;
                        case "wpct_table_theme_29":

                            $col_last = 'green';
                            break;
                        case "wpct_table_theme_30":

                            $col_last = 'blue';
                            break;
                        case "wpct_table_theme_31":

                            $col_last = 'violet';
                            break;
                        case "wpct_table_theme_32":

                            $col_last = 'pink';
                            break;
                    }
                    if ($_POST['wpct_tablee_theme'] == $data_old['theme_name']) {
                        for ($i = 1; $i <= $data_old['col_count']; $i++) {
                            $table_data['col' . $i] = $row['col' . $i];
                        }
                    } else {
                        for ($i = 1; $i <= $data_old['col_count']; $i++) {
                            if ($col_last) {
                                $table_data['name']='black';
                                if ($i == $_POST['wpct_table_number_cols']) {
                                    $table_data['col' . $i] = $col_last;
                                } else {
                                    $table_data['col' . $i] = 'black';
                                }
                                if ($i == $data_old['col_count'] + 1) {
                                    $jj = $i - 1;
                                    $table_data['col' . $jj] = 'black';
                                }
                            } else {
                            $table_data['name']=$col_odd;
                                if ($i % 2) {
                                    $table_data['col' . $i] = $col_even;
                                } else {
                                    $table_data['col' . $i] = $col_odd;
                                }
                            }
                        }
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;
            } else {
                unset($table_data);
                $table_data['name'] = $row['name'];
                $table_data['type'] = $row['type'];

                if ($_POST['wpct_table_number_cols'] > $data_old['col_count']) {
                    for ($i = 1; $i <= $data_old['col_count']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                    for ($i = $data_old['col_count'] + 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = '';
                    }
                } else {
                    for ($i = 1; $i <= $_POST['wpct_table_number_cols']; $i++) {
                        $table_data['col' . $i] = $row['col' . $i];
                    }
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
                $counter++;
            }
        }
    }
}

if ($_GET['table_id']) {
    $table_name = $wpdb->prefix . 'wpct_tables';

    $table_id_query = $_GET['table_id'];

    $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_id` = ' . $table_id_query;

    $data = $wpdb->get_row($query, ARRAY_A);


    $query = 'SELECT * FROM `wp_wpct_table_' . $_GET['table_id'] . '`';

    $data_temp = $wpdb->get_results($wpdb->prepare($query));
    ?>
    <div class="wpct_wrap">
        <div id="wpct_message" class="updated">Table <?php
    echo $data['table_name'];
    if ($_POST['wpct_action_type'] == "update")
        echo " Updated"; else
        echo " Loaded"
        ?>  , <a href="?page=tables_list&table_id=<?php echo $data['table_id']; ?>">Click Here<a/> To Edit.</div>
        <!--Create-->
        <div class="wpct_create" id="wpct_create">
            <form id="wpct_create_form" method="post" action="">

                <table class="wpct_create_csstable">
                    <tr>
                        <td>
                            <label for="wpct_table_name" class="wpct_label">Name: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_name" id="wpct_table_name" class="wpct_input" value="<?php echo $data['table_name'] ?>" />
                        </td>
                        <td>
                            <label for="wpct_table_type" class="wpct_label" >Table type</label>
                        </td>
                        <td>
                            <select name="wpct_table_type" id="wpct_table_type" class="wpct_input" >
                                <?php
                                if ($data['table_type'] == "left_col") {
                                    $seleced = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                                ?>
                                <option value="left_col" <?php echo $seleced ?>>With left column</option>
                                <?php
                                if ($data['table_type'] == "no_left_col") {
                                    $seleced = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                                ?>
                                <option value="no_left_col" <?php echo $seleced ?>>Without left column</option>
                            </select>
                        </td>
                        <td>
                            <label for="wpct_table_theme" class="wpct_label">Table theme</label>
                        </td>
                        <td>
                            <select name="wpct_table_theme" class="wpct_input" id="wpct_table_theme"> 
                                <?php
                                $arr = array(
                                    'Color Template 01' => 'wpct_table_theme_01',
                                    'Color Template 02' => 'wpct_table_theme_02',
                                    'Color Template 03' => 'wpct_table_theme_03',
                                    'Color Template 04' => 'wpct_table_theme_04',
                                    'Color Template 05' => 'wpct_table_theme_05',
                                    'Color Template 06' => 'wpct_table_theme_06',
                                    'Color Template 07' => 'wpct_table_theme_07',
                                    'Color Template 08' => 'wpct_table_theme_08',
                                    'Color Template 09' => 'wpct_table_theme_09',
                                    'Color Template 10' => 'wpct_table_theme_10',
                                    'Color Template 11' => 'wpct_table_theme_11',
                                    'Color Template 12' => 'wpct_table_theme_12',
                                    'Color Template 13' => 'wpct_table_theme_13',
                                    'Color Template 14' => 'wpct_table_theme_14',
                                    'Color Template 15' => 'wpct_table_theme_15',
                                    'Color Template 16' => 'wpct_table_theme_16',
                                    'Color Template 17' => 'wpct_table_theme_17',
                                    'Color Template 18' => 'wpct_table_theme_18',
                                    'Color Template 19' => 'wpct_table_theme_19',
                                    'Color Template 20' => 'wpct_table_theme_20',
                                    'Color Template 21' => 'wpct_table_theme_21',
                                    'Color Template 22' => 'wpct_table_theme_22',
                                    'Color Template 23' => 'wpct_table_theme_23',
                                    'Color Template 24' => 'wpct_table_theme_24',
                                    'Color Template 25' => 'wpct_table_theme_25',
                                    'Color Template 26' => 'wpct_table_theme_26',
                                    'Color Template 27' => 'wpct_table_theme_27',
                                    'Color Template 28' => 'wpct_table_theme_28',
                                    'Color Template 29' => 'wpct_table_theme_29',
                                    'Color Template 30' => 'wpct_table_theme_30',
                                    'Color Template 31' => 'wpct_table_theme_31',
                                    'Color Template 32' => 'wpct_table_theme_32',
                                );
                                foreach ($arr as $sf => $ff) {
                                    if ($data['theme_name'] == $ff) {
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    ?>
                                    <option value="<?php echo $ff ?>" <?php echo $selected ?>><?php echo $sf ?></option>
                                <?php }
                                ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="wpct_table_number_cols" class="wpct_label">Number of columns: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_number_cols" id="wpct_table_number_cols" value="<?php echo $data['col_count'] ?>" class="wpct_input" />
                        </td>
                        <td>
                            <label for="wpct_table_column_width" class="wpct_label">Column width: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_column_width" id="wpct_table_column_width" value="<?php echo $data['col_width'] ?>" class="wpct_input" />
                        </td>
                        <td>
                            <?php if ($data['table_type'] == "left_col") { ?>
                                <label for="wpct_table_left_column_width" class="wpct_label" id="wpct_table_type_name">Left column width: </label>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($data['table_type'] == "left_col") { ?>
                                <input type="text" name="wpct_table_left_column_width" id="wpct_table_left_column_width" value="<?php echo $data['col_left_width'] ?>" class="wpct_input"  />
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td><td></td>
                        <td>
                            <label for="wpct_table_number_rows" class="wpct_label" id="wpct_table_type_name">Number of Rows: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_number_rows" id="wpct_table_number_rows" value="<?php echo $data['row_count'] ?>" class="wpct_input"  />
                            <input type="hidden" name="wpct_table_id" id="wpct_table_id" value="<?php echo $_GET['table_id'] ?>"  />
                            <input type="hidden" name="wpct_action_type" id="wpct_action_type" value="update"  />
                        </td>
                        <td></td><td></td>
                    </tr>
                </table>
                <input style="float:right;" type="submit" class="button-primary" name="wpct_create_table" id="wpct_create_table" value="Update" />


            </form>
        </div>

    </div>
    <?php
} else {
    ?>
    <div class="wpct_wrap">
        <?php if ($_POST['wpct_table_name']) { ?>
            <div id="wpct_message" class="updated">Table <?php echo $_POST['wpct_table_name']; ?> Created, <a href="?page=tables_list&table_id=<?php echo $data_temp['table_id']; ?>">Click Here<a/> To Edit.</div>
        <?php } else { ?>
            <div id="wpct_message" class="updated">Create a table, or Edit created one <a href="?page=tables_list">Here</a></div>

        <?php } ?>
        <!--Create-->
        <div class="wpct_create" id="wpct_create">
            <form id="wpct_create_form" method="post" action="">

                <table class="wpct_create_csstable">
                    <tr>
                        <td>
                            <label for="wpct_table_name" class="wpct_label">Name: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_name" id="wpct_table_name" class="wpct_input" value="<?php
    $tables_ids = $wpdb->get_col($wpdb->prepare("SELECT table_id FROM wp_wpct_tables"));
    if ($tables_ids) {
        $counter = count($tables_ids);
    } else {
        $counter = 0;
    }
    $counter++;
    echo "table_" . $counter
        ?>" />
                        </td>
                        <td>
                            <label for="wpct_table_type" class="wpct_label" >Table type</label>
                        </td>
                        <td>
                            <select name="wpct_table_type" id="wpct_table_type" class="wpct_input" > 
                                <option value="left_col" selected="selected">With left column</option>
                                <option value="no_left_col">Without left column</option>
                            </select>
                        </td>
                        <td>
                            <label for="wpct_table_theme" class="wpct_label">Table theme</label>
                        </td>
                        <td>
                            <select name="wpct_table_theme" class="wpct_input" id="wpct_table_theme"> 
                                <option value="wpct_table_theme_01" selected="selected">Color Template 01</option>
                                <option value="wpct_table_theme_02">Color Template 02</option>
                                <option value="wpct_table_theme_03">Color Template 03</option>
                                <option value="wpct_table_theme_04">Color Template 04</option>
                                <option value="wpct_table_theme_05">Color Template 05</option>
                                <option value="wpct_table_theme_06">Color Template 06</option>
                                <option value="wpct_table_theme_07">Color Template 07</option>
                                <option value="wpct_table_theme_08">Color Template 08</option>
                                <option value="wpct_table_theme_09">Color Template 09</option>
                                <option value="wpct_table_theme_10">Color Template 10</option>
                                <option value="wpct_table_theme_11">Color Template 11</option>
                                <option value="wpct_table_theme_12">Color Template 12</option>
                                <option value="wpct_table_theme_13">Color Template 13</option>
                                <option value="wpct_table_theme_14">Color Template 14</option>
                                <option value="wpct_table_theme_15">Color Template 15</option>
                                <option value="wpct_table_theme_16">Color Template 16</option>
                                <option value="wpct_table_theme_17">Color Template 17</option>
                                <option value="wpct_table_theme_18">Color Template 18</option>
                                <option value="wpct_table_theme_19">Color Template 19</option>
                                <option value="wpct_table_theme_20">Color Template 20</option>
                                <option value="wpct_table_theme_21">Color Template 21</option>
                                <option value="wpct_table_theme_22">Color Template 22</option>
                                <option value="wpct_table_theme_23">Color Template 23</option>
                                <option value="wpct_table_theme_24">Color Template 24</option>
                                <option value="wpct_table_theme_25">Color Template 25</option>
                                <option value="wpct_table_theme_26">Color Template 26</option>
                                <option value="wpct_table_theme_27">Color Template 27</option>
                                <option value="wpct_table_theme_28">Color Template 28</option>
                                <option value="wpct_table_theme_29">Color Template 29</option>
                                <option value="wpct_table_theme_30">Color Template 30</option>
                                <option value="wpct_table_theme_31">Color Template 31</option>
                                <option value="wpct_table_theme_32">Color Template 32</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="wpct_table_number_cols" class="wpct_label">Number of columns: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_number_cols" id="wpct_table_number_cols" value="2" class="wpct_input" />
                        </td>
                        <td>
                            <label for="wpct_table_column_width" class="wpct_label">Column width: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_column_width" id="wpct_table_column_width" value="180" class="wpct_input" />
                        </td>
                        <td>
                            <label for="wpct_table_left_column_width" class="wpct_label" id="wpct_table_type_name">Left column width: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_left_column_width" id="wpct_table_left_column_width" value="150" class="wpct_input"  />
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td><td></td>
                        <td>
                            <label for="wpct_table_number_rows" class="wpct_label" id="wpct_table_type_name">Number of Rows: </label>
                        </td>
                        <td>
                            <input type="text" name="wpct_table_number_rows" id="wpct_table_number_rows" value="5" class="wpct_input"  />
                            <input type="hidden" name="wpct_table_id" id="wpct_table_id" value=""  />
                            <input type="hidden" name="wpct_action_type" id="wpct_action_type" value="create"  />
                        </td>
                        <td></td><td></td>
                    </tr>
                </table>

                <input style="float:right;" type="submit" class="button-primary" name="wpct_create_table" id="wpct_create_table" value="Create" />


            </form>
        </div>

    </div>
    <?php
}?>