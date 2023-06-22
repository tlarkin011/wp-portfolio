<style>
	.job-listings {
		margin-bottom: 80px;
	}

	.accordion-holder {
		padding-top: 0;
		padding-bottom: 0;
	}

	.accordion-holder .accordion-label {
		align-items: start !important;
		padding-right: 45px;
	}

	.accordion-holder .accordion-label p {
		margin-left: auto;
		padding-top: 3px;
	}

	.job-listings .accordion-entry .accordion-label h5 {
		width: 65%;
	}

	.filter-holder {
		padding-top: 0;
	}

	.filter-holder .filter {
		width: 92%;
	}

	.filter .facetwp-facet {
		margin-bottom: 24px !important;
	}

	.filter h5 {
		border-bottom: solid 1px #0FA6FF;
		cursor: pointer;
		display: flex;
		font-size: 16px;
		font-weight: 700;
		margin-bottom: 12px;
		padding: 8px 8px 10px 0;
	}

	.filter h5 i {
		display: flex;
		font-family: "Font Awesome 5 Free";
		font-style: normal;
		margin-left: auto;
	}

	.facetwp-facet .facetwp-input-wrap {
		width: 100%;
	}

	.facetwp-facet input.facetwp-search {
		min-width: 100% !important;
		padding-right: 46px !important;
	}

	.facetwp-icon:before {
		background-position: 50% 50% !important;
		width: 46px !important;
	}

	.facetwp-reset, .facetwp-load-more {
		background: #0FA6FF;
		border-width: 0;
		cursor: pointer;
		color: white;
		font-size: 12px;
		font-weight: 700;
		letter-spacing: 2px;
		line-height: 24px;
		padding: 12px 25px;
		text-transform: uppercase;
	}

	.facetwp-reset:hover, .facetwp-load-more:hover {
		background: #EEF9FF !important;
		color: #0FA6FF;
		transition-duration: 250ms;
	}

	.facetwp-checkbox {
		background-image: none !important;
		background-color: #EEF9FF !important;
		border: solid 1px #0FA6FF;
		display: inline-block;
		font-weight: 700;
		font-size: 14px;
		margin: 0 6px 6px 0;
		padding: 8px 16px !important;
	}

	.facetwp-checkbox:hover {
		background-color: #0FA6FF !important;
		color: white;
	}

	.facetwp-checkbox .facetwp-counter {

	}

	@media screen and (max-width: 979px) {
		.filter .facetwp-facet {
			margin-bottom: 16px !important;
		}

		.facetwp-checkbox {
			font-size: 12px;
			padding: 6px 12px !important;
		}

		.accordion-holder {
			-ms-flex-preferred-size: calc(11 / 12 * 100%);
			flex-basis: calc(11 / 12 * 100%);
			max-width: calc(11 / 12 * 100%);
		}
	}

</style>

<section class="faq-postings job-listings">

	<div class="row row-center">
		<div class="filter-holder columns-4">
			<div class="filter">
				<?php echo do_shortcode( '[facetwp facet="job_search"]' ); ?>
			</div>
			<div class="filter" data-toggle-filter="location">
				<h5>Location <i class="fa-solid fa-chevron-down"></i></h5>
				<?php echo do_shortcode( '[facetwp facet="location"]' ); ?>
			</div>

			<div class="filter" data-toggle-filter="company">
				<h5>Company <i class="fa-solid fa-chevron-down"></i></h5>
				<?php echo do_shortcode( '[facetwp facet="company"]' ); ?>
			</div>

			<div class="filter" data-toggle-filter="job_type">
				<h5>Job Type <i class="fa-solid fa-chevron-down"></i></h5>
				<?php echo do_shortcode( '[facetwp facet="job_type"]' ); ?>
			</div>

			<div class="filter" data-toggle-filter="position_type">
				<h5>Position Type <i class="fa-solid fa-chevron-down"></i></h5>
				<?php echo do_shortcode( '[facetwp facet="position_type"]' ); ?>
			</div>

			<div class="filter">
				<?php echo do_shortcode( '[facetwp facet="clear_filters"]' ); ?>
			</div>
		</div>

		<div class="columns-8">
			<?php echo do_shortcode( '[facetwp template="jobs_listing"]' ); ?>

			<?php echo do_shortcode( '[facetwp facet="pager_jobs"]' ); ?>
		</div>
	</div>

</section>

<script type="text/javascript">
	(function() {
		$('.filter > h5').click(function(e){
			e.preventDefault();

			let f = $(this).parent().attr('data-toggle-filter');

			$('.filter .facetwp-facet[data-name="' + f + '"]').slideToggle('fast');
			$('> i', this).toggleClass( 'fa-chevron-up fa-chevron-down' );
		});
	}());
</script>
