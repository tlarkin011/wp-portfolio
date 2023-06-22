	</section>


	<footer class="site-footer" role="contentinfo">

		<div class="row row-center">
			<div class="columns-12 multi-address-menu-wrap flex">

			<div class="columns-2 footer-logo-column">
				 <?php anvil_site_logo(); ?>
				

			</div>

			<div class="columns-2 footer-menu right-1">
				<p>Footer Heading</p>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'	 => false,
					'menu_class'     => 'nav-menu footer-menu',
				]);
				?>
			</div>

				<div class="columns-2 footer-menu">
				<p>Footer Heading</p>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'	 => false,
					'menu_class'     => 'nav-menu footer-menu',
				]);
				?>
			</div>

				<div class="columns-2 footer-menu">
				<p>Footer Heading</p>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'	 => false,
					'menu_class'     => 'nav-menu footer-menu',
				]);
				?>
			</div>

				<div class="columns-2 footer-menu social-column left-1">
					<p>Footer Heading</p>
				
					 <?php if( have_rows('footer_social_media', 'option') ) : ?>

					<ul class="social-list">

						<?php while ( have_rows('footer_social_media', 'option') ) : the_row();
							$socialMediaIcon = get_sub_field('platform','option');
							$socialMediaLink = get_sub_field('link','option'); ?>

							<li>
								<a href="<?php echo $socialMediaLink; ?>" target="_blank" rel="noopener">
									<i class="fa fa-<?php echo $socialMediaIcon; ?>" aria-hidden="true"></i>
								</a>
							</li>
						<?php endwhile; ?>

					</ul>

				<?php endif;  ?>
				</div>
					
			</div>

			<div class="columns-10 multi-address-wrap flex">
				<div class="columns-2 footer-menu address-column ">
					<p>Footer Heading</p>
				
					<p class="address"><?php the_field('footer_address', 'option');?></p>
					<a href="tel:<?php echo the_field('footer_phone_number', 'option');?>"><?php echo the_field('footer_phone_number', 'option');?></a>
					<a href="mailto:<?php echo the_field('footer_email_address', 'option');?>"><?php echo the_field('footer_email_address', 'option');?></a>
				</div>
				<div class="columns-2 footer-menu address-column ">
					<p>Footer Heading</p>
				
					<p class="address"><?php the_field('footer_address', 'option');?></p>
					<a href="tel:<?php echo the_field('footer_phone_number', 'option');?>"><?php echo the_field('footer_phone_number', 'option');?></a>
					<a href="mailto:<?php echo the_field('footer_email_address', 'option');?>"><?php echo the_field('footer_email_address', 'option');?></a>
				</div>
				<div class="columns-2 footer-menu address-column ">
					<p>Footer Heading</p>
				
					<p class="address"><?php the_field('footer_address', 'option');?></p>
					<a href="tel:<?php echo the_field('footer_phone_number', 'option');?>"><?php echo the_field('footer_phone_number', 'option');?></a>
					<a href="mailto:<?php echo the_field('footer_email_address', 'option');?>"><?php echo the_field('footer_email_address', 'option');?></a>
				</div>
				<div class="columns-2 footer-menu address-column">
					<p>Footer Heading</p>
				
					<p class="address"><?php the_field('footer_address', 'option');?></p>
					<a href="tel:<?php echo the_field('footer_phone_number', 'option');?>"><?php echo the_field('footer_phone_number', 'option');?></a>
					<a href="mailto:<?php echo the_field('footer_email_address', 'option');?>"><?php echo the_field('footer_email_address', 'option');?></a>
				</div>

			</div>


		</div>
		</div>	
	</footer>



	<footer class="footer-copyright">
		<div class="row">
			<div class="columns-6 copyright-column">
				<p class="site-copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>

				<?php
				wp_nav_menu([
					'theme_location' => 'privacy',
					'container'      => false,
					'fallback_cb'	 => false,
					'menu_class'     => 'nav-menu privacy-menu',
				]);
				?>
			</div>

			<div class="columns-6 designby-column">
				<p class="site-credit">Crafted with love by <a href="http://forgeandsmith.com/" target="_blank">Forge and Smith</a>.</p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>