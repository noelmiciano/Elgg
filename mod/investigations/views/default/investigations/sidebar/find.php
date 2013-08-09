<?php
/**
 * Group search
 *
 * @package ElggGroups
 */
$url = elgg_get_site_url() . 'groups/search';
$body = elgg_view_form('investigations/find', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true,
));

?>
<div class="inv-search">
<?php echo $body; ?>
</div>
