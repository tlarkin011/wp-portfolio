<section class="post-loop">


	<div class="row row-center">
		
		<div class="blog-grid">

			<div class="block-grid-3">
				<?php
				$post_query = (new ForgeQuery)->query('post', 9, $args);
				$post_query->loop('templates/loop/post');
				?>

			</div>

		</div>

	</div>

	<?php forge_template('components/pagination', ['query' => $post_query]); ?>
</section>