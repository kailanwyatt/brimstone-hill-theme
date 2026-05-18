<?php
/**
 * Template Name: Book Tickets
 * 
 * @package Brimstone_Hill
 */

get_header();

// Fetch events for the dropdown
$events_query = new WP_Query(array(
    'post_type'      => 'bhfp_event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
));

// Define default ticket types and prices
$ticket_types = array(
    'adult' => array(
        'label' => __('Adult (13+)', 'brimstone-hill'),
        'price' => 15,
        'desc'  => __('Standard admission', 'brimstone-hill'),
    ),
    'child' => array(
        'label' => __('Child (Under 13)', 'brimstone-hill'),
        'price' => 5,
        'desc'  => __('Must be accompanied by an adult', 'brimstone-hill'),
    ),
    'local' => array(
        'label' => __('Local Resident', 'brimstone-hill'),
        'price' => 0,
        'desc'  => __('Valid ID required at gate', 'brimstone-hill'),
    )
);

?>

<main id="primary" class="site-main page-book-tickets">
    <div class="page-banner page-banner--fallback">
        <div class="page-banner__overlay" aria-hidden="true"></div>
        <div class="page-banner__inner container">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="container section-padding">
        <?php
        if ( function_exists( 'bhfp_admission_product_id' ) && function_exists( 'bhfp_validate_wc_product_type' ) ) {
            $admission_id = bhfp_admission_product_id();
            if ( ! $admission_id || ! bhfp_validate_wc_product_type( $admission_id, 'bhfp_booking' ) ) {
                echo '<p class="book-tickets-notice notice">' . esc_html__( 'Online ticket booking is not fully configured. An administrator must set the Admission product ID under Settings → Brimstone Hill → Commerce.', 'brimstone-hill' ) . '</p>';
            }
        }
        ?>
        <div class="book-tickets-layout">
            <div class="book-tickets-form-wrapper">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="book-tickets-content">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>

                <form id="bhfp-book-tickets-form" method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" class="book-tickets-form">
                    <input type="hidden" name="action" value="bhfp_process_booking_form">
                    <?php wp_nonce_field('bhfp_booking_form', 'bhfp_booking_nonce'); ?>

                    <div class="form-section">
                        <h2><?php esc_html_e('1. Select an Event (Optional)', 'brimstone-hill'); ?></h2>
                        <div class="form-group">
                            <label for="booking_event"><?php esc_html_e('Event', 'brimstone-hill'); ?></label>
                            <select name="event_id" id="booking_event" class="form-control">
                                <option value=""><?php esc_html_e('General Admission (No Event)', 'brimstone-hill'); ?></option>
                                <?php if ( $events_query->have_posts() ) : ?>
                                    <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>
                                        <option value="<?php echo esc_attr( get_the_ID() ); ?>"><?php the_title(); ?></option>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2><?php esc_html_e('2. Choose Date (Optional)', 'brimstone-hill'); ?></h2>
                        <div class="form-group">
                            <label for="booking_date"><?php esc_html_e('Visit Date', 'brimstone-hill'); ?></label>
                            <input type="date" name="visit_date" id="booking_date" class="form-control" min="<?php echo esc_attr( date('Y-m-d') ); ?>">
                            <p class="description"><?php esc_html_e('Tickets are valid for any day if no date is selected.', 'brimstone-hill'); ?></p>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2><?php esc_html_e('3. Select Tickets', 'brimstone-hill'); ?></h2>
                        <div class="ticket-selectors">
                            <?php foreach ($ticket_types as $key => $type) : ?>
                                <div class="ticket-type-row" data-price="<?php echo esc_attr($type['price']); ?>" data-key="<?php echo esc_attr($key); ?>">
                                    <div class="ticket-info">
                                        <h3><?php echo esc_html($type['label']); ?></h3>
                                        <p><?php echo esc_html($type['desc']); ?></p>
                                        <div class="ticket-price"><?php echo $type['price'] > 0 ? '$' . number_format($type['price'], 2) : __('Free', 'brimstone-hill'); ?></div>
                                    </div>
                                    <div class="ticket-controls">
                                        <button type="button" class="btn-qty btn-minus" aria-label="<?php esc_attr_e('Decrease quantity', 'brimstone-hill'); ?>">-</button>
                                        <input type="number" name="tickets[<?php echo esc_attr($key); ?>]" value="0" min="0" max="20" class="qty-input" readonly>
                                        <button type="button" class="btn-qty btn-plus" aria-label="<?php esc_attr_e('Increase quantity', 'brimstone-hill'); ?>">+</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="booking-summary-sticky">
                        <div class="booking-total">
                            <span><?php esc_html_e('Total:', 'brimstone-hill'); ?></span>
                            <span id="booking-total-price">$0.00</span>
                        </div>
                        <button type="submit" id="btn-submit-booking" class="btn btn--primary" disabled>
                            <?php esc_html_e('Continue to Checkout', 'brimstone-hill'); ?>
                        </button>
                    </div>
                </form>
            </div>

            <div class="book-tickets-sidebar">
                <?php echo do_shortcode('[bhfp_context_sidebar section="visit"]'); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
