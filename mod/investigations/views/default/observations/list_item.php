<?php
/**
 * Group entity view
 *
 * @package ElggGroups
 */

$obs = $vars['entity'];
$advisor = 'None Yet';
$e = $obs->getEntitiesFromRelationship('advisor', true);
if (count($e) > 0) {
	$advisor = $e[0]->get('name');
}
?>
<li class="obs">
    <div class="obs_container">
        <a href="<?php echo elgg_get_site_url(); ?>observation/<?php echo $obs->get("agg_id"); ?>">
            <img class="obs_image" src='<?php echo elgg_get_site_url(); ?>_graphics/wb-small-data-icons.png'>
            <p class="obs_owner">By <?php print $obs->getOwnerEntity()->get('name'); ?></p>
            <p class="obs_date">On <?php echo date('F jS, Y g:i:s A', $obs->get('time_created') + (3600 * (1 - date('I', $comment->time_created)))); ?></p>
        </a>
    </div>
</li>
