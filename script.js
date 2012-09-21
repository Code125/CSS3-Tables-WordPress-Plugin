jQuery(document).ready( function($) {
    $('#wpct_table_type').change( function table_type_change() {
        if($('#wpct_table_type').val()=='no_left_col'){
            $("#wpct_table_left_column_width").css('display','none');
            $("#wpct_table_type_name").css('display','none');
        }else {
            $("#wpct_table_left_column_width").css('display','block');
            $("#wpct_table_type_name").css('display','block');
        }
    });
    
    $('.wpct_get_code').click( function (){
    	id = $(this).attr('title');
    	alert('Add this code into the post in html section, [wpct_show_table id=' + id + ']');
    });
	
 });

