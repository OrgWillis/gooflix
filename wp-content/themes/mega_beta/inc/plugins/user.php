<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

function new_modify_user_table($column) {
	$column['movies']  = __('Movies','mega');
	$column['tvshows'] = __('TV Shows','mega');
	unset($column['posts']);
	return $column;
}
add_filter('manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row($val, $column_name, $user_id) {
	switch ($column_name) {
		case 'movies' :
		return count_user_posts($user_id, 'movies', false);
		case 'tvshows' :
		return count_user_posts($user_id, 'tvshows', false);
	}
	return $val;
}
add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );

function profile_css(){
    echo '<style>tr.user-url-wrap,tr.user-comment-shortcuts-wrap,tr.user-comment-shortcuts-wrap,tr.user-last-name-wrap,tr.user-profile-picture,tr.user-description-wrap{ display: none; }</style>';
}
add_action('admin_head-user-edit.php', 'profile_css');
add_action('admin_head-profile.php',   'profile_css');

function custom_user_profile_fields($user) {
    ?>
    <table id="script_user_field_table" class="form-table">
        <tr id="script_user_field_row">
            <th>
                <label for="script_field"><?php _e('Code Script', 'mega'); ?></label>
            </th>
            <td>
            	<textarea rows="10" cols="100" name="script_field" id="script_field"><?php echo esc_attr( get_the_author_meta( 'script_field', $user->ID ) ); ?></textarea>
                <br>
                <span class="description"><?php _e('place your ad script', 'mega'); ?></span>
            </td>
        </tr>
    </table>
<?php 
}
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');

function script_field_placement_js() {
    $screen = get_current_screen();
    if ( $screen->id != "profile" && $screen->id != "user-edit" ) 
    return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            field = $('#script_user_field_row').remove();
            parent = $('#description').closest('tr');
            field.insertBefore(parent);
        });
    </script>
<?php
}
add_action('admin_head', 'script_field_placement_js');

function save_custom_user_profile_fields($user_id) {
    if ( !current_user_can( 'edit_user', $user_id) )
        return FALSE;

    update_user_meta( $user_id, 'script_field', $_POST['script_field']);
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');