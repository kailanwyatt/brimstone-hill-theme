<?php
/**
 * Elementor accordion widget.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BH_Elementor_Accordion.
 */
class BH_Elementor_Accordion extends \Elementor\Widget_Base {

	/**
	 * @return string
	 */
	public function get_name() {
		return 'bh_accordion';
	}

	/**
	 * @return string
	 */
	public function get_title() {
		return __( 'Plan Your Visit Accordion', 'brimstone-hill' );
	}

	/**
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-accordion';
	}

	/**
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Register controls.
	 */
	protected function register_controls() {
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'brimstone-hill' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Accordion item', 'brimstone-hill' ),
			)
		);
		$repeater->add_control(
			'content',
			array(
				'label'   => __( 'Content', 'brimstone-hill' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
			)
		);
		$repeater->add_control(
			'title_url',
			array(
				'label' => __( 'Title link URL', 'brimstone-hill' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$repeater->add_control(
			'link_text',
			array(
				'label' => __( 'Link text', 'brimstone-hill' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->start_controls_section(
			'section_items',
			array(
				'label' => __( 'Items', 'brimstone-hill' ),
			)
		);
		$this->add_control(
			'items',
			array(
				'label'       => __( 'Accordion items', 'brimstone-hill' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		if ( ! class_exists( 'BHFP_Accordion' ) ) {
			return;
		}
		$settings = $this->get_settings_for_display();
		$items    = array();
		if ( ! empty( $settings['items'] ) && is_array( $settings['items'] ) ) {
			foreach ( $settings['items'] as $item ) {
				$url = '';
				if ( ! empty( $item['title_url']['url'] ) ) {
					$url = (string) $item['title_url']['url'];
				}
				$items[] = array(
					'title'     => (string) ( $item['title'] ?? '' ),
					'content'   => (string) ( $item['content'] ?? '' ),
					'title_url' => $url,
					'link_text' => (string) ( $item['link_text'] ?? '' ),
				);
			}
		}
		echo BHFP_Accordion::render( $items ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
