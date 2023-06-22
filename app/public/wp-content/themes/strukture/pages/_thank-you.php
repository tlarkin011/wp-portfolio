<?php
/*
 *  Template Name: Thank you Page
 */
get_header(); the_post();
?>


<?php

if($_GET['form'] && !empty($_GET['form'])) {
	$form = $_GET['form'];
}

?>




<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<?php if( $form == 'get-in-touch' ) : ?>

	<?php forge_template('components/content', ['field_name' => 'get_in_touch']); ?>

	<?php elseif( $form == 'subscribe') : ?>

		<?php forge_template('components/content', ['field_name' => 'subscribe']); ?>

		<?php else : ?>

			<a class="button one" href="<?php esc_url(home_url( '/' )) ?>">Back Home</a>

		<?php endif; ?>

		<?php get_footer();?>
