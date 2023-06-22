<?php
the_post();

add_action('wp_head', 'QuadLayers_add_schema');
function QuadLayers_add_schema(){
	echo '<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "JobPosting",
			"title" : "' . get_the_title() . '",
			"datePosted" : "' . get_the_date() . '",
			"hiringOrganization": {
				"@type": "Organization",
				"name": "Health & Rehab Solutions (HRS)"
			}
		}
	</script>';
}

get_header();
$strukture_class = strukture_style();
?>

<style>
	.single-page-banner {
		margin-bottom: 0;
	}
	.single-page-banner .social-share {
		display: none;
	}

	@media screen and (max-width: 1199px) {
		.single-job .page-banner .row {
			padding-left: 0;
		}

		.single-post-content .columns-10 {
			padding: 0 28px;
		}
	}

	@media screen and (max-width: 767px) {
		.page-banner .content-container {
			align-items: start !important;
		}

		.single-post-content .columns-10 {
			padding: 0;
		}
	}


	@media screen and (max-width: 639px) {
		.single .strukture-wrapper {
			padding-top: 55px !important;
		}

		.single-post-content .columns-10 {
			padding: 0 38px;
		}
	}

	[data-bg="bg-6450a4552c6a2"] { background-image: url('https://healthrehabsolutions.local/wp-content/uploads/2020/03/Headers-01-1-768x380.jpg'); }
	@media screen and (min-width: 768px) { [data-bg="bg-6450a4552c6a2"] { background-image: url('https://healthrehabsolutions.local/wp-content/uploads/2020/03/Headers-01-1-980x485.jpg'); } }
	@media screen and (min-width: 980px) { [data-bg="bg-6450a4552c6a2"] { background-image: url('https://healthrehabsolutions.local/wp-content/uploads/2020/03/Headers-01-1-1200x594.jpg'); } }
	@media screen and (min-width: 1200px) { [data-bg="bg-6450a4552c6a2"] { background-image: url('https://healthrehabsolutions.local/wp-content/uploads/2020/03/Headers-01-1-1800x890.jpg'); } }

	.strukture-wrapper {
		padding-top: 20px;
	}
</style>

	<section class="">
		<div class="black page-banner single-page-banner" style="background-color: #232323;" data-bg="bg-6450a4552c6a2">
			<div class="row-bottom row-center row">

				<div class="content-container columns-11  content-column">
					<div class="banner-content-box">
						<div class="title-container">
							<?php echo stk_format_terms($terms); ?>
							<!-- heading -->
							<h1><?php the_title(); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="strukture-wrapper <?php echo $strukture_class;?>">

		<article class="row row-center single-post-content">

			<div class="columns-10">
				<iframe id="grnhse_iframe" width="100%" frameborder="0" scrolling="no" allow="geolocation" onload="window.scrollTo(0,0)" title="Greenhouse Job Board" src="https://boards.greenhouse.io/embed/job_app?for=healthrehabsolutions&amp;token=<?php the_field( 'greenhouse_job_id' ); ?>" height="1200"></iframe>
			</div>

		</article>

	</div>

	<script>
		let iframe = document.querySelector("#grnhse_iframe");

		window.addEventListener('message', function(e) {
			// message that was passed from iframe page
			let message = e.data;

			console.log('message - ' + message);

			iframe.style.height = message + 'px';
		} , false);
	</script>

<?php forge_template('components/content/content-background', ['field_name' => 'standard_pre_footer_cta', 'option' => true]);
get_footer(); ?>