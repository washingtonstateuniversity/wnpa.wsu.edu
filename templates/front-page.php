<?php /* Template Name: WNPA Front Page */ ?>

<?php get_header(); ?>

	<main class="spine-single-template">

		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php get_template_part('parts/headers'); ?>

			<section class="row single gutter marginalize-ends">

				<div class="column one">

					<?php get_template_part('articles/article'); ?>

				</div><!--/column-->

			</section>

		<?php endwhile; endif; ?>

		<section class="row single gutter marginalize-ends recent-articles">
			<div class="column one">
				<article>
					<h2 class="article-title">Today's Featured Articles</h2>

				<?php
				$recent_articles = new WP_Query( array(
					'post_type' => 'wnpa_feed_item',
					'posts_per_page' => '8',
					'meta_query' => array(
						array(
							'key' => '_wnpa_featured_article',
							'value' => 'featured',
						),
					),
				));

				if ( $recent_articles->have_posts() ) : while( $recent_articles->have_posts() ) : $recent_articles->the_post();
					$link_url = get_post_meta( get_the_ID(), '_feed_item_link_url', true );
					$link_author = ucwords( strtolower( get_post_meta( get_the_ID(), '_feed_item_author', true ) ) );
					$source_id = get_post_meta( get_the_ID(), '_feed_item_source', true );
					if ( empty( $source_id ) ) {
						$source_title = get_post_meta( get_the_ID(), '_feed_item_source_manual', true );
						if ( empty( $source_title ) ) {
							$source_title = 'Manual Entry';
						}
						$link_url = get_the_permalink();
						$link_author = 'By ' . get_the_author();
					} else {
						$source = get_post( absint( $source_id ) );
						$source_title = $source->post_title;
					}
					?>

					<article class="recent-article">
					
						<h3 class="recent-article-title"><a href="<?php echo esc_url( $link_url ); ?>"><?php the_title(); ?></a></h3>
						<span class="recent-article-date"><?php echo get_the_date(); ?></span>
						<span class="recent-article-author"><?php echo esc_html( $link_author ); ?></span>
						<span class="recent-article-source"><?php echo $source_title; ?></span>
						<?php the_excerpt(); ?>
					</article>
				<?php
				endwhile; endif;
				wp_reset_postdata(); ?>

					<span class="link-all-feed-items"><a href="<?php echo esc_url( home_url( '/feed-items' ) ); ?>">View all recent articles.</a></span>
				</article>
			</div>
		</section>
	</main>

<?php

get_footer();