<?php
/**
 * Template Name: Membership
 * 
 * @package Brimstone_Hill
 */

get_header();

$membership_categories = array(
    'captain' => array(
        'name' => 'Captain (Ordinary Member)',
        'price_display' => 'XCD$100.00',
        'benefits' => array(
            'Free entry for yourself and 2 guests.',
            '10% discount at the restaurant.',
            '10% discount at the Gift Shop.'
        )
    ),
    'governor' => array(
        'name' => 'Governor',
        'price_display' => 'XCD$1,000.00',
        'benefits' => array(
            'Free entry for yourself and 5 guests.',
            'Free entry for yourself and 1 guest to paid events held by Brimstone Hill.',
            '10% discount at the restaurant.',
            '10% discount at the Gift Shop.'
        )
    ),
    'corporate' => array(
        'name' => 'Corporate General',
        'price_display' => 'XCD$3,000.00',
        'benefits' => array(
            'Free entry for CEO and 10 guests.',
            '10% discount at restaurant.',
            '10% discount at the Gift Shop.',
            'Hosting of two free events at Brimstone Hill Fortress.',
            'Acknowledgement in each issue of Cannonball.',
            'Placement of company logo on BHFNPS website.',
            'Company website link placed on BHFNPS website.'
        )
    ),
    'lieutenant' => array(
        'name' => 'Lieutenant (University students & Professors)',
        'price_display' => 'XCD$60.00',
        'benefits' => array(
            'Free entry for yourself and 1 guest.',
            '10% discount at the restaurant.',
            '10% discount at the Gift Shop.',
            '*Must present valid Student ID'
        )
    ),
    'non-nationals' => array(
        'name' => 'Non-Nationals',
        'price_display' => 'USD$100.00',
        'benefits' => array(
            'Free entry for yourself and 2 guests.',
            '10% discount at the restaurant.',
            '10% discount at the Gift Shop.'
        )
    )
);

$membership_benefits = array(
    'Support the maintenance and restoration of this national treasure',
    'Help promote a better understanding of our history and culture',
    'You enjoy free admission for yourself and guests',
    '10% discount from the Restaurant and Bar',
    '10% discount from the Gift Shop',
    'You are entitled to vote for a member of your choice to serve on the Council of Management and even to become an Officer of the Society'
);

?>

<main id="primary" class="site-main page-membership">
    <div class="page-banner page-banner--fallback">
        <div class="page-banner__overlay" aria-hidden="true"></div>
        <div class="page-banner__inner container">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="container section-padding">
        <section class="membership-intro text-center">
            <h2 class="membership-intro__headline">Support the preservation of our national treasure and enjoy</h2>
            <p class="membership-intro__blurb lead-text">
                The Brimstone Hill Fortress National Park Society is a non-profit voluntary organisation entrusted with the important responsibility of managing one of the outstanding cultural heritage sites of the Americas.
            </p>
        </section>

        <section class="membership-benefits-section mt-section">
            <h3 class="text-center">By being a member you:</h3>
            <ul class="membership-benefits-list">
                <?php foreach ($membership_benefits as $benefit) : ?>
                    <li>
                        <span class="benefit-icon" aria-hidden="true">✓</span>
                        <?php echo esc_html($benefit); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="membership-categories-section mt-section">
            <h3 class="text-center">Membership Categories</h3>
            <div class="membership-grid">
                <?php foreach ($membership_categories as $id => $cat) : ?>
                    <div class="membership-card">
                        <div class="membership-card__header">
                            <h4 class="membership-card__name"><?php echo esc_html($cat['name']); ?></h4>
                            <p class="membership-card__price"><?php echo esc_html($cat['price_display']); ?></p>
                        </div>
                        <ul class="membership-card__benefits">
                            <?php foreach ($cat['benefits'] as $b) : ?>
                                <li><?php echo esc_html($b); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="membership-join-section mt-section">
            <div class="membership-join-layout">
                <div class="membership-form-wrapper">
                    <h3>Become a Member Now!</h3>
                    <form id="bhfp-membership-form" method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" class="membership-form">
                        <input type="hidden" name="action" value="bhfp_process_membership_form">
                        <?php wp_nonce_field('bhfp_membership_form', 'bhfp_membership_nonce'); ?>

                        <div class="form-group">
                            <label for="member_full_name">Full Name <span aria-hidden="true">*</span></label>
                            <input type="text" id="member_full_name" name="full_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="member_address">Address</label>
                            <input type="text" id="member_address" name="address" class="form-control">
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="member_email">Email <span aria-hidden="true">*</span></label>
                                <input type="email" id="member_email" name="email" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="member_phone">Phone <span aria-hidden="true">*</span></label>
                                <input type="tel" id="member_phone" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="member_category">Membership Category <span aria-hidden="true">*</span></label>
                            <select id="member_category" name="category" class="form-control" required>
                                <option value="">Select category</option>
                                <?php foreach ($membership_categories as $id => $cat) : ?>
                                    <option value="<?php echo esc_attr($id); ?>"><?php echo esc_html($cat['name']); ?> — <?php echo esc_html($cat['price_display']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <p class="description form-note">This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.</p>

                        <button type="submit" class="btn btn--primary btn--block">Register & Proceed to Payment</button>
                    </form>
                </div>

                <div class="membership-contact-wrapper">
                    <div class="contact-box">
                        <h4>Brimstone Hill Fortress National Park</h4>
                        <p>P.O. Box 588 Taylor's Range<br>Basseterre<br>St. Kitts, West Indies</p>
                        <p class="phone"><a href="tel:869-465-2609">869-465-2609</a></p>
                        <hr>
                        <p class="corporate-note">Contact our office for additional offerings on Corporate packages.</p>
                        <a href="<?php echo esc_url(site_url('/about/contact')); ?>" class="btn btn--secondary btn--outline mt-sm">Contact Us</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
