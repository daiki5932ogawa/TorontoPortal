<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->

		<!--投稿者一覧を表示-->
			<?php $users =get_users( array('orderby'=>'post_count','order'=>DESC) );
			echo '<div class="writers">';
			foreach($users as $user):
					$uid = $user->ID;
					$userData = get_userdata($uid);
					echo '<div class="writer-profile">';
							echo '<figure class="eyecatch">';
									echo get_avatar( $uid ,300 );
							echo '</figure>';
							echo '<div class="profiletxt">';
									echo '<p class="name">'.$user->display_name.'</p>';
									echo '<div class="description">'.$userData->user_description.'</div>';
									// echo '<div class="button"><a href="'.get_bloginfo(url).'/?author='.$uid.'">'.$user->display_name.'の記事一覧</a></div>';
									 echo '<div class="shikiri"><a href=""><br><hr><br></a></div>';
							echo '</div>';
					echo '</div>';
			endforeach;
			echo '</div>'; ?>
		<!--投稿者一覧を表示-->

	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
