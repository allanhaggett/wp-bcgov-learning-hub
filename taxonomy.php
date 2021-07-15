<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$parent = get_term($term->parent, get_query_var('taxonomy') ); // get parent term
?>

<?php if ( have_posts() ) : ?>

	<header class="entry-header alignfull" style="background: #FFF; padding: 2em 2em 3em 2em;">
		<div class="alignwide">
	
	<div>
		<a href="/portal/course/">
			All Courses
		</a> 
		<?php if(!empty($parent->slug)): ?>
		/ 
		<a href="/portal/course_category/<?php echo $parent->slug ?>">
			<?php echo $parent->name ?>
		</a>
		<?php endif ?>
	</div>
	
	<h1><?php echo $term->name ?></h1>
		<?php //the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
<div class="" style="margin: 1em 0 0 0;">
<?php 
// Get a list of all sub-categories and output them as simple links
$catlist = get_categories(
						array(
							'taxonomy' => 'course_category',
							'child_of' => $term->term_id,
							'orderby' => 'id',
							'order' => 'DESC',
							'hide_empty' => '0'
						));

foreach($catlist as $childcat) {
	echo '<a href="/portal/course_category/'. $childcat->slug . '">' . $childcat->name . '</a> | ';
}

//print_r($catlist);
?>
</div>
</div>
</div>
	</header><!-- .page-header -->
<div class="alignwide">
<div class="entry-content">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<div class="course">
                <div style="background: #28537d; height: 6px; margin-top: 1em; width: 100%;"></div> 
                <div class="coursename">
                <a  href="<?php echo get_permalink(); ?>">
                    <?= the_title(); ?>
                </a>
                <!-- <a href="#course-<?= $post->ID ?>" class="showdeets">#</a> -->
                </div>
                <div class="details" id="course-<?= $post->ID ?>">
                    <div class="learningpartner">
                        <?php the_terms( $post->ID, 'learning_partner', 'Offered by: ', ', ', ' ' ); ?>
                    </div>
                    <div class="coursedesc">
                        <?php the_content(); ?>
                    </div>
                    <div class="coursecats">
                        <?php the_terms( $post->ID, 'course_category', 'Categories: ', ', ', ' ' ); ?>
                    </div>
                    <div class="courseregister">
                    <a style="background: #28537d; color: #F2F2F2; font-size: 1.2rem; padding: .5em 1em; text-align: center; text-decoration: none;" 
                        href="<?= $post->course_link ?>" 
                        target="_blank" 
                        rel="noopener">
                            Register Here +
                    </a>
                    </div>
                </div>
           </div> <!-- /.course -->
	<?php endwhile; ?>
</div>
</div>
<div style="clear: both">
	<?php twenty_twenty_one_the_posts_navigation(); ?>
</div>
<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
