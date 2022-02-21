<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class ACUI_Doc{
	public static function message(){
	?>
	<h3><?php _e( 'Documentation', 'import-users-from-csv-with-meta' ); ?></h3>
		<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e( 'Columns position', 'import-users-from-csv-with-meta' ); ?></th>
				<td><small><em><?php _e( '(Documents should look like the one presented into screenshot. Remember you should fill the first two columns with the next values)', 'import-users-from-csv-with-meta' ); ?></em></small>
					<ol>
						<li><?php _e( 'Username', 'import-users-from-csv-with-meta' ); ?></li>
						<li><?php _e( 'Email', 'import-users-from-csv-with-meta' ); ?></li>
					</ol>						
					<small><em><?php _e( '(The next columns are totally customizable and you can use whatever you want. All rows must contains same columns)', 'import-users-from-csv-with-meta' ); ?></em></small>
					<small><em><?php _e( '(User profile will be adapted to the kind of data you have selected)', 'import-users-from-csv-with-meta' ); ?></em></small>
					<small><em><?php _e( '(If you want to disable the extra profile information, please deactivate this plugin after make the import)', 'import-users-from-csv-with-meta' ); ?></em></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'id (column id)', 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( 'You can use a column called id in order to make inserts or updates of an user using the ID used by WordPress in the wp_users table. We have two different cases:', 'import-users-from-csv-with-meta' ); ?>
					<ul style="list-style:disc outside none; margin-left:2em;">
						<li><?php _e( "If id <strong>doesn't exist in your users table</strong>: WordPress core does not allow us insert it, so it will throw an error of kind: invalid_user_id", 'import-users-from-csv-with-meta' ); ?></li>
						<li><?php _e( "If id <strong>exists</strong>: plugin check if username is the same, if yes, it will update the data, if not, it ignores the cell to avoid problems", 'import-users-from-csv-with-meta' ); ?></li>
					</ul>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( "Passwords (column password)", 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( "A string that contains user passwords. We have different options for this case:", 'import-users-from-csv-with-meta' ); ?>
					<ul style="list-style:disc outside none; margin-left:2em;">
						<li><?php _e( "If you <strong>don't create a column for passwords</strong>: passwords will be generated automatically", 'import-users-from-csv-with-meta' ); ?></li>
						<li><?php _e( "If you <strong>create a column for passwords</strong>: if cell is empty, password won't be updated; if cell has a value, it will be used", 'import-users-from-csv-with-meta' ); ?></li>
					</ul>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( "Roles (column role)", 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( "Plugin can import roles from the CSV. This is how it works:", 'import-users-from-csv-with-meta' ); ?>
					<ul style="list-style:disc outside none; margin-left:2em;">
						<li><?php _e( "If you <strong>don't create a column for roles</strong>: roles would be chosen from the 'Default role' field in import screen.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><?php _e( "If you <strong>create a column called 'role'</strong>: if cell is empty, roles would be chosen from 'Default role' field in import screen; if cell has a value, it will be used as role, if this role doesn't exist the default one would be used", 'import-users-from-csv-with-meta' ); ?></li>
						<li><?php _e( "Multiple roles can be imported creating <strong>a list of roles</strong> using commas to separate values.", 'import-users-from-csv-with-meta' ); ?></li>
					</ul>
					<em><?php _e( "Notice: If the default new role is administrator in WordPress settings, role will not be set during a CSV file import with this plugin. Check it if all users are being imported as administrators and you have set another role in this plugin.", 'import-users-from-csv-with-meta' ); ?></em>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( "Serialized data", 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( "Plugin can now import serialized data. You have to use the serialized string directly in the CSV cell in order the plugin will be able to understand it as an serialized data instead as any other string.", 'import-users-from-csv-with-meta' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( "Lists", 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( "Plugin can now import lists an array. Use this separator:", 'import-users-from-csv-with-meta'); ?> <strong>::</strong> <?php _e("two colons, inside the cell in order to split the string in a list of items.", 'import-users-from-csv-with-meta' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'WordPress default profile data', 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( "You can use those labels if you want to set data adapted to the WordPress default user columns (the ones who use the function", 'import-users-from-csv-with-meta' ); ?> <a href="http://codex.wordpress.org/Function_Reference/wp_update_user">wp_update_user</a>)
					<ol>
						<li><strong>user_nicename</strong>: <?php _e( "A string that contains a URL-friendly name for the user. The default is the user's username.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>user_url</strong>: <?php _e( "A string containing the user's URL for the user's web site.", 'import-users-from-csv-with-meta' ); ?>	</li>
						<li><strong>display_name</strong>: <?php _e( "A string that will be shown on the site. Defaults to user's username. It is likely that you will want to change this, for both appearance and security through obscurity (that is if you don't use and delete the default admin user).", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>nickname</strong>: <?php _e( "The user's nickname, defaults to the user's username.", 'import-users-from-csv-with-meta' ); ?>	</li>
						<li><strong>first_name</strong>: <?php _e( "The user's first name.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>last_name</strong>: <?php _e("The user's last name.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>description</strong>: <?php _e("A string containing content about the user.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>jabber</strong>: <?php _e("User's Jabber account.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>aim</strong>: <?php _e("User's AOL IM account.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>yim</strong>: <?php _e("User's Yahoo IM account.", 'import-users-from-csv-with-meta' ); ?></li>
						<li><strong>user_registered</strong>: <?php _e( "Using the WordPress format for this kind of data Y-m-d H:i:s.", "import-users-from-csv-with-meta "); ?></li>
					</ol>
				</td>
			</tr>

			<?php if( is_plugin_active( 'woocommerce/woocommerce.php' ) ): ?>

				<tr valign="top">
					<th scope="row"><?php _e( "WooCommerce is activated", 'import-users-from-csv-with-meta' ); ?></th>
					<td><?php _e( "You can use those labels if you want to set data adapted to the WooCommerce default user columns", 'import-users-from-csv-with-meta' ); ?>
					<ol>
						<li>billing_first_name</li>
						<li>billing_last_name</li>
						<li>billing_company</li>
						<li>billing_address_1</li>
						<li>billing_address_2</li>
						<li>billing_city</li>
						<li>billing_postcode</li>
						<li>billing_country</li>
						<li>billing_state</li>
						<li>billing_phone</li>
						<li>billing_email</li>
						<li>shipping_first_name</li>
						<li>shipping_last_name</li>
						<li>shipping_company</li>
						<li>shipping_address_1</li>
						<li>shipping_address_2</li>
						<li>shipping_city</li>
						<li>shipping_postcode</li>
						<li>shipping_country</li>
						<li>shipping_state</li>
					</ol>
				</td>
				</tr>
			<?php endif; ?>

			<?php do_action( 'acui_documentation_after_plugins_activated' ); ?>

			<tr valign="top">
				<th scope="row"><?php _e( "Important notice", 'import-users-from-csv-with-meta' ); ?></th>
				<td><?php _e( "You can upload as many files as you want, but all must have the same columns. If you upload another file, the columns will change to the form of last file uploaded.", 'import-users-from-csv-with-meta' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( "Any question about it", 'import-users-from-csv-with-meta' ); ?></th>
				<td>
					<ul style="list-style:disc outside none; margin-left:2em;">
						<li><?php _e( 'Free support (in WordPress forums):', 'import-users-from-csv-with-meta' ); ?> <a href="https://wordpress.org/support/plugin/import-users-from-csv-with-meta">https://wordpress.org/support/plugin/import-users-from-csv-with-meta</a>.</li>
						<li><?php _e( 'Premium support (with a quote):', 'import-users-from-csv-with-meta' ); ?> <a href="mailto:contacto@codection.com">contacto@codection.com</a>.</li>
					</ul>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Hooks', 'import-users-from-csv-with-meta' ); ?></th>
			<td><?php _e( 'If you are a developer you can extend or use this plugin with all the hooks we provide, you have <a href="https://codection.com/import-users-csv-meta/listado-de-hooks-de-import-and-exports-users-and-customers/">a list of them here</a>','import-users-from-csv-with-meta'); ?></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Example', 'import-users-from-csv-with-meta' ); ?></th>
			<td><?php _e( 'Download this', 'import-users-from-csv-with-meta' ); ?> <a href="<?php echo esc_url( plugins_url( 'test.csv', dirname( __FILE__ ) ) ); ?>">.csv <?php _e('file','import-users-from-csv-with-meta'); ?></a> <?php _e( 'to test', 'import-users-from-csv-with-meta' ); ?></td>
			</tr>
		</tbody>
		</table>
		<br/>
		<div style="width:775px;margin:0 auto"><img src="<?php echo esc_url( plugins_url( 'csv_example.png', dirname( __FILE__ ) ) ); ?>"/></div>
	<?php
	}
}