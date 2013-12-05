<?php
/*
 * Embeds an edit link for the annotation
 */

$annotation = $vars['annotation'];

$owner = get_entity($annotation->owner_guid);
if (!$owner) {
	return true;
}
$icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = "<a href=\"{$owner->getURL()}\">$owner->name</a>";

$menu = elgg_view_menu('annotation', array(
	'annotation' => $annotation,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
));

$text = elgg_view("output/longtext", array("value" => $annotation->value));

$friendly_time = htmlspecialchars(elgg_get_friendly_time($annotation->time_created));
$timestamp = htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $annotation->time_created));

$date = "<acronym title=\"$friendly_time\">$timestamp</acronym>";

$body = <<<HTML
<div class="mbn">
	$menu
	$owner_link
	<span class="elgg-subtext">
		$date
	</span>
	$text
</div>
HTML;

echo elgg_view_image_block($icon, $body);

if ($annotation->canEdit()) {
	$form = elgg_view_form('discussion/reply/save', array(), array_merge(array(
			'entity' => get_entity($annotation->entity_guid),
			'annotation' => $annotation
		), $vars)
	);

	echo "<div class=\"hidden mbm\" id=\"edit-annotation-$annotation->id\">$form</div>";
}

