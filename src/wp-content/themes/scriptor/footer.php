<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>
</div><!-- .container -->
<div class="footer">
</div>
<?php get_template_part('templates/template', 'search-result') ?>
<?php get_template_part('templates/template', 'gallery-popup') ?>
<?php wp_footer(); ?>
</body>
</html>