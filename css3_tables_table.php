<div class="wpct_wrap">
    <?php
    if ($_GET['table_id']) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wpct_tables';

        $table_id_query = $_GET['table_id'];

        $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_id` = ' . $table_id_query;

        $data = $wpdb->get_row($query, ARRAY_A);

        if ($_POST['wpct_column_color_left']) {
            $table_name = $wpdb->prefix . 'wpct_table_' . $_GET['table_id'];

            $clear = 'TRUNCATE TABLE `' . $table_name . '`';

            $wpdb->query($clear);


            //tag 1-3
            for ($j = 1; $j <= 3; $j++) {
                //tag j
                unset($table_data);
                $table_data['name'] = "";
                $table_data['type'] = "";

                for ($i = 1; $i <= $data['col_count']; $i++) {
                    $table_data['col' . $i] = $_POST['wpct_column_h' . $j . '_' . $i];
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
            }

            //column color

            unset($table_data);
            $table_data['name'] = $_POST['wpct_column_color_left'];
            $table_data['type'] = "";

            for ($i = 1; $i <= $data['col_count']; $i++) {
                $table_data['col' . $i] = $_POST['wpct_column_color_' . $i];
            }

            $wpdb->insert($table_name, $table_data, array('%s'));


            //rows 
            for ($j = 1; $j <= $data['row_count']; $j++) {
                //tag j
                unset($table_data);
                $table_data['name'] = $_POST['wpct_row_name_' . $j];
                $table_data['type'] = $_POST['wpct_row_type_' . $j];

                for ($i = 1; $i <= $data['col_count']; $i++) {
                    $table_data['col' . $i] = $_POST['wpct_cell_' . $j . '_' . $i];
                }

                $wpdb->insert($table_name, $table_data, array('%s'));
            }

            //Button

            unset($table_data);
            if ($_POST['wpct_button_name'] == 'yes') {
                $table_data['name'] = "yes";
            } else {
                $table_data['name'] = "no";
            }
            $table_data['type'] = "button";

            for ($i = 1; $i <= $data['col_count']; $i++) {
                $table_data['col' . $i] = $_POST['wpct_button_label_' . $i];
            }

            $wpdb->insert($table_name, $table_data, array('%s'));


            //link

            unset($table_data);
            if ($_POST['wpct_button_name'] == 'yes') {
                $table_data['name'] = "yes";
            } else {
                $table_data['name'] = "no";
            }
            $table_data['type'] = "link";

            for ($i = 1; $i <= $data['col_count']; $i++) {
                $table_data['col' . $i] = $_POST['wpct_button_link_' . $i];
            }

            $wpdb->insert($table_name, $table_data, array('%s'));
            ?>
            <div id="wpct_message" class="updated">Table <?php echo $data['table_name']; ?> Updated ... Edit Table info <a href="?page=wpct_css3_tables/css3_tables.php&table_id=<?php echo $data['table_id'] ?>">Here</a></div>
            <?php
        } else {
            ?>
            <div id="wpct_message" class="updated">Table <?php echo $data['table_name']; ?> Loaded ... Edit Table info <a href="?page=wpct_css3_tables/css3_tables.php&table_id=<?php echo $data['table_id'] ?>">Here</a></div>
            <?php
        }



        $query = 'SELECT * FROM `wp_wpct_table_' . $_GET['table_id'] . '`';

        $data_temp = $wpdb->get_results($wpdb->prepare($query));
        $counter = 0;
        foreach ($data_temp as $row) {
            $data_arr[$counter] = (array) $row;
            $counter++;
        }
        ?>

        <div class="wpct_table_edit" style="display: block; ">
            <form id="wpct_edit" method="post" action="">
                <div id="wpct_table_cells">
                    <table class="wpct_table_css_edit">
                        <tbody>
                            <tr>
                                <td id="wpct_image_preview" style=" background: url('http://demos.code125.com/envato/wp-content/plugins/css3_tables/images/theme_01.png') top center no-repeat; height: 200px; border-top: none; border-left: none;">
                                </td>
                                <?php for ($i = 1; $i <= $data['col_count']; $i++) { ?>
                                    <td>
                                        <h1>Column <?php echo $i ?></h1>
                                        <input type="text" name="wpct_column_h1_<?php echo $i ?>" id="wpct_column_h1_<?php echo $i ?>" class="wpct_column_tag" placeholder="tag 1" value="<?php echo $data_arr[0]['col' . $i] ?>">
                                        <input type="text" name="wpct_column_h2_<?php echo $i ?>" id="wpct_column_h2_<?php echo $i ?>" class="wpct_column_tag" placeholder="tag 2" value="<?php echo $data_arr[1]['col' . $i] ?>">
                                        <input type="text" name="wpct_column_h3_<?php echo $i ?>" id="wpct_column_h3_<?php echo $i ?>" class="wpct_column_tag" placeholder="tag 3" value="<?php echo $data_arr[2]['col' . $i] ?>">
                                        <br><br><br>

                                        <select name="wpct_column_color_<?php echo $i ?>" class="wpct_column_tag">
                                            <?php
                                            if ($data_arr[3]['col' . $i] == "red") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>		
                                            <option value="red" <?php echo $selected ?>>Red</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "blue") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="blue" <?php echo $selected ?>>Blue</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "green") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="green" <?php echo $selected ?>>Green</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "orange") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="orange" <?php echo $selected ?>>Orange</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "yellow") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="yellow" <?php echo $selected ?>>Yellow</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "black") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="black" <?php echo $selected ?>>Black</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "beige") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="beige" <?php echo $selected ?>>Beige</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "violet") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="violet" <?php echo $selected ?>>Violet</option>

                                            <?php
                                            if ($data_arr[3]['col' . $i] == "pink") {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="pink" <?php echo $selected ?>>Pink</option>
                                            <?php $selected = '' ?>
                                        </select>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php for ($i = 1; $i <= $data['row_count']; $i++) { ?>
                                <tr>
                                    <td style="width: 220px;">
                                        <?php if ($data['table_type'] == "left_col") { ?>
                                            <label for="wpct_row_name_<?php echo $i; ?>" class="wpct_row_name">Row name: </label>
                                            <input type="text" name="wpct_row_name_<?php echo $i; ?>" id="wpct_row_name_<?php echo $i; ?>" class="wpct_row_name_input" value="<?php echo $data_arr[3 + $i]['name']; ?>">

                                            <select name="wpct_row_type_<?php echo $i; ?>" class="wpct_row_select">
                                                <?php
                                                if ($data_arr[3 + $i]['type'] == "value") {
                                                    $selected = 'selected="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="value" <?php echo $selected ?> >Value</option>
                                                <?php
                                                if ($data_arr[3 + $i]['type'] == "true_false") {
                                                    $selected = 'selected="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="true_false" <?php echo $selected ?> >True/False</option>
                                            </select>
                                        <?php } ?>
                                    </td>
                                    <?php for ($j = 1; $j <= $data['col_count']; $j++) { ?>
                                        <td>
                                            <input type="text" name="wpct_cell_<?php echo $i; ?>_<?php echo $j ?>" id="wpct_cell_<?php echo $i; ?>_<?php echo $j ?>" class="wpct_edit_cell" value="<?php echo $data_arr[3 + $i]['col' . $j]; ?>">
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <label for="wpct_button_name" class="wpct_row_name">Button data, include it? </label>
                                    <select name="wpct_button_name" style="width: 100px;">
                                        <?php
                                        if ($data_arr[4 + $data['row_count']]['name'] == "yes") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="yes" <?php echo $selected; ?>>Yes</option>
                                        <?php
                                        if ($data_arr[4 + $data['row_count']]['name'] == "no") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="no" <?php echo $selected; ?>>No</option>
                                    </select>
                                    <br><br><br>
                                    <select name="wpct_column_color_left" class="wpct_column_tag">
                                        <?php
                                        if ($data_arr[3]['name'] == "red") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>		
                                        <option value="red" <?php echo $selected ?>>Red</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "blue") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="blue" <?php echo $selected ?>>Blue</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "green") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="green" <?php echo $selected ?>>Green</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "orange") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="orange" <?php echo $selected ?>>Orange</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "yellow") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="yellow" <?php echo $selected ?>>Yellow</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "black") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="black" <?php echo $selected ?>>Black</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "beige") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="beige" <?php echo $selected ?>>Beige</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "violet") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="violet" <?php echo $selected ?>>Violet</option>

                                        <?php
                                        if ($data_arr[3]['name'] == "pink") {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="pink" <?php echo $selected ?>>Pink</option>
                                        <?php $selected = '' ?>
                                    </select>
                                </td>
                                <?php for ($j = 1; $j <= $data['col_count']; $j++) { ?>
                                    <td>
                                        <input type="text" name="wpct_button_label_<?php echo $j ?>" id="wpct_cell_button_label_<?php echo $j ?>" class="wpct_edit_cell" placeholder="Button Label" value="<?php echo $data_arr[4 + $data['row_count']]['col' . $j]; ?>">
                                        <br>
                                        <input type="text" name="wpct_button_link_<?php echo $j ?>" id="wpct_cell_button_link_<?php echo $j ?>" class="wpct_edit_cell" placeholder="Button link" value="<?php echo $data_arr[5 + $data['row_count']]['col' . $j]; ?>">
                                    </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <input style="float:right; margin-top: 20px;" type="submit" class="button-primary" name="wpct_save_table" id="wpct_save_table" value="Save Changes"><p style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <p style="float: right;"><a href="?page=tables_list&detele_table_id=<?php echo $data['table_id'] ?> " style="float:right; margin-top: 20px;" class="button-primary">Delete Table</a>
                </p>
            </form>
        </div>
        <?php
    } elseif ($_GET['detele_table_id']) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wpct_tables';
        $query = 'DROP TABLE `wp_wpct_table_' . $_GET['detele_table_id'] . '`';
        $wpdb->query($query);
        $query = 'DELETE FROM `' . $table_name . '` WHERE `table_id` = ' . $_GET['detele_table_id'];
        $wpdb->query($query);

        $query = 'SELECT * FROM `' . $table_name . '`';

        $data_temp = $wpdb->get_results($wpdb->prepare($query));
        $counter = 0;
        foreach ($data_temp as $row) {
            $data_arr[$counter] = (array) $row;
            $counter++;
        }
        ?>
        <div id="wpct_message" class="updated"> Choose the table you want to edit:</div>
        <table class="wpct_table_css_edit">
                     <?php for ($i = 0; $i < $counter; $i++) { ?>
                    <tr>
                        <td>
                            <?php echo $i + 1 . '- ' . $data_arr[$i]['table_name'] ?>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=wpct_css3_tables/css3_tables.php&table_id=<?php echo $data_arr[$i]['table_id'] ?>">Edit Info</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&table_id=<?php echo $data_arr[$i]['table_id'] ?>">Edit Data</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&detele_table_id=<?php echo $data_arr[$i]['table_id'] ?>">Delete</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&t_copy_id=<?php echo $data_arr[$i]['table_id'] ?>">Dublicate</a>
                        </td>
                         <td>
                        	<input type="button"  name="wpct_get_code" class="button-primary wpct_get_code" value="Get Code" title="<?php echo $data_arr[$i]['table_id'] ?>" />
                        </td>
                     </tr>
                      <?php } ?>
        </table>
        <?php
    } elseif ($_GET['t_copy_id']) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wpct_tables';

        $table_id_query = $_GET['t_copy_id'];

        $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_id` = ' . $table_id_query;

        $data = $wpdb->get_row($query, ARRAY_A);

        $wpdb->insert($table_name, array('table_type' => $data['table_type'],
            'table_name' => $data['table_name'],
            'theme_name' => $data['theme_name'],
            'table_width' => $data['table_width'],
            'col_count' => $data['col_count'],
            'col_width' => $data['col_width'],
            'col_left_width' => $data['col_left_width'],
            'row_count' => $data['row_count']
                ), array('%s'));

		$query = 'SELECT LAST_INSERT_ID();';
		$new_id = mysql_insert_id();
		
       // $query = 'SELECT * FROM `' . $table_name . '` WHERE `table_name` = "' . $data['table_name'] . '"';

       // $data_temp = $wpdb->get_row($query, ARRAY_A);

        $table_data_name = $wpdb->prefix . 'wpct_table_' . $new_id;

        $sql = 'CREATE TABLE ' . $table_data_name . '( 
					id INTEGER(10) UNSIGNED AUTO_INCREMENT,
					name VARCHAR (255),
					type VARCHAR (255),';

        for ($i = 1; $i <= $data['col_count']; $i++) {
            $sql = $sql . ' col' . $i . ' VARCHAR (255),';
        }
        $sql = $sql . 'PRIMARY KEY  (id) )';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $query = 'SELECT * FROM `wp_wpct_table_' . $_GET['t_copy_id'] . '`';

        $data_temp = $wpdb->get_results($wpdb->prepare($query));

        $table_name = 'wp_wpct_table_' . $new_id;

        foreach ($data_temp as $row) {
            $row = (array) $row;
            unset($table_data);
            $table_data['name'] = $row['name'];
            $table_data['type'] = $row['type'];

            for ($i = 1; $i <= $data['col_count']; $i++) {
                $table_data['col' . $i] = $row['col' . $i];
            }

            $wpdb->insert($table_name, $table_data, array('%s'));
        }
        ?>

        <?php
        $table_name = $wpdb->prefix . 'wpct_tables';
        $query = 'SELECT * FROM `' . $table_name . '`';

        $data_temp = $wpdb->get_results($wpdb->prepare($query));
        $counter = 0;
        foreach ($data_temp as $row) {
            $data_arr[$counter] = (array) $row;
            $counter++;
        }
        ?>
        <div id="wpct_message" class="updated">Table <?php echo $data['table_name']; ?> Created ... Edit Table info <a href="?page=wpct_css3_tables/css3_tables.php&table_id=<?php echo $new_id ?>">Here</a></div><ul>
           <table class="wpct_table_css_edit">
                     <?php for ($i = 0; $i < $counter; $i++) { ?>
                    <tr>
                        <td>
                            <?php echo $i + 1 . '- ' . $data_arr[$i]['table_name'] ?>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=wpct_css3_tables/css3_tables.php&table_id=<?php echo $data_arr[$i]['table_id'] ?>">Edit Info</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&table_id=<?php echo $data_arr[$i]['table_id'] ?>">Edit Data</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&detele_table_id=<?php echo $data_arr[$i]['table_id'] ?>">Delete</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&t_copy_id=<?php echo $data_arr[$i]['table_id'] ?>">Dublicate</a>
                        </td>
                         <td>
                        	<input type="button" class="wpct_get_code" name="wpct_get_code" class="button-primary wpct_get_code" value="Get Code" title="<?php echo $data_arr[$i]['table_id'] ?>" />
                        </td>
                     </tr>
                      <?php } ?>
        </table>
        </ul>
        <?php
    } else {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wpct_tables';
        $query = 'SELECT * FROM `' . $table_name . '`';

        $data_temp = $wpdb->get_results($wpdb->prepare($query));
        $counter = 0;
        foreach ($data_temp as $row) {
            $data_arr[$counter] = (array) $row;
            $counter++;
        }
        ?>
        <div id="wpct_message" class="updated"> Choose the table you want to edit or <a href="?page=wpct_css3_tables/css3_tables.php">Create new one</a></div>
        <table class="wpct_table_css_edit">
                     <?php for ($i = 0; $i < $counter; $i++) { ?>
                    <tr>
                        <td>
                            <?php echo $i + 1 . '- ' . $data_arr[$i]['table_name'] ?>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=wpct_css3_tables/css3_tables.php&table_id=<?php echo $data_arr[$i]['table_id'] ?>">Edit Info</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&table_id=<?php echo $data_arr[$i]['table_id'] ?>">Edit Data</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&detele_table_id=<?php echo $data_arr[$i]['table_id'] ?>">Delete</a>
                        </td>
                        <td>
                        	<a class="button-primary" href="?page=tables_list&t_copy_id=<?php echo $data_arr[$i]['table_id'] ?>">Dublicate</a>
                        </td>
                        <td>
                        	<input type="button" class="wpct_get_code" name="wpct_get_code"  class="button-primary wpct_get_code"  value="Get Code" title="<?php echo $data_arr[$i]['table_id'] ?>" />
                        </td>
                     </tr>
                      <?php } ?>
        </table>

    <?php } ?>

</div>