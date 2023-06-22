<?php
/*
 *  Template Name: About Page
 */
get_header();
the_post();
$strukture_class = strukture_style();
$background_variables = background_variables();

?>

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner', 'class' => 'homepage-banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php forge_template('components/content/content-image', ['field_name' => 'mission_and_vision']); ?>
	<?php forge_template('components/content/content-intro', ['field_name' => 'meet_our_team_headline']); ?>
	<?php forge_template('components/loop-slideout', ['post-type' => 'team_member', 'block-grid' => 4, 'hidden' => 'components/slideout/team-slideout-hidden', 'content' => 'components/slideout/team-slideout-content']); ?>

<div class="blue-background">
	<?php forge_template('components/content/content-image', ['field_name' => 'our_story']); ?>
</div>


	<?php forge_template('components/content/content-intro', ['field_name' => 'our_partners_intro']); ?>
	<?php forge_template('components/logo-grid', ['field_name' => 'partners']); ?>

</div>

<?php get_footer(); ?>
