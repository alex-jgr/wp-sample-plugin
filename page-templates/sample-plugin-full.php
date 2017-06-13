<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage 
 * @since 1.0
 * @version 1.0
 */
require_once ABSPATH . 'wp-admin/includes/bookmark.php'  ;
get_header(); ?>

<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div id="sample-plugin-main">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="sample-plugin-entry-header">
                            <?php // the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header><!-- .entry-header -->
                        <div class="sample-plugin-entry-content">
                            <?php the_content(); ?>
                        </div><!-- .entry-content -->
                        <br />
                        <br />
                        <?php edit_post_link(sprintf(__( 'Edit <i class="fa fa-pencil-square-o"></i> <span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title()), '<span class="edit-link">', '</span>'); ?> 
                    </article><!-- #post-## -->
                <?php endwhile; // End of the loop. ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();