<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://kobkob.org
 * @since      1.0.0
 *
 * @package    Map_List_Search
 * @subpackage Map_List_Search/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="map-list-search-admin-dashboard">
<div class="mls-menu">
<li>About Kobkob's Map List Search</li>
<li>Add record</li>
<li>Search record</li>
<li>Settings</li>
<li><a href="/wp-admin/edit.php?post_type=map_list&page=import-csv">Import list from CSV file</a></li>
<li>Help</li>
</div>
<div class="mls-logo">
</div>
<span class="mls-sign">This plugin was made for you by <a href="mailto:monsenhor@cpan.org">monsenhor</a> www.kobkob.org</span>
</div>
<?php
//echo plugin_basename( __FILE__ );
?>
