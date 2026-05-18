<?php
/**
 * The header for our theme
 *
 * @package Brimstone_Hill
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="skip-link">Skip to main content</a>

<?php get_template_part( 'template-parts/announcement-bar' ); ?>

<header class="site-header">
	<div class="site-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo">
			Brimstone Hill
		</a>

		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_id'         => 'primary-menu',
				'container'       => 'nav',
				'container_class' => 'nav nav--desktop',
				'menu_class'      => 'nav__list',
				'fallback_cb'     => false,
				'walker'          => new BH_Primary_Walker_Nav_Menu(),
			)
		);
		?>

		<a href="<?php echo esc_url( bh_book_tickets_url() ); ?>" class="site-header__book-btn btn btn--primary">
			<?php echo esc_html( bh_book_tickets_label() ); ?>
		</a>

		<button type="button" class="site-header__menu-btn" aria-label="Open menu" aria-expanded="false">
			<span class="site-header__menu-icon"></span>
		</button>
	</div>
</header>
