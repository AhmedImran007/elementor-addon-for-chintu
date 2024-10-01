<?php

class Elementor_Banner_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'chintu_banner_slider';
    }

    public function get_title() {
        return esc_html__( 'Chintu Banner Slider', 'elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {
        // Content section for the slider items
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Slider Content', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater for multiple slides
        $repeater = new \Elementor\Repeater();

        // Slide background image
        $repeater->add_control(
            'background_image',
            [
                'label'   => esc_html__( 'Background Image', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Slide title
        $repeater->add_control(
            'title',
            [
                'label'   => esc_html__( 'Title', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Slide Title', 'elementor-addon' ),
            ]
        );

        // Text Input Fields (Top of the Banner)
        $repeater->add_control(
            'top_text_1',
            [
                'label'   => esc_html__( 'Top Text 1', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Top Text 1', 'elementor-addon' ),
            ]
        );

        $repeater->add_control(
            'top_text_2',
            [
                'label'   => esc_html__( 'Top Text 2', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Top Text 2', 'elementor-addon' ),
            ]
        );

        $repeater->add_control(
            'top_text_3',
            [
                'label'   => esc_html__( 'Top Text 3', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Top Text 3', 'elementor-addon' ),
            ]
        );

        // Button Heading Text (Bottom of the Banner)
        $repeater->add_control(
            'button_heading_text',
            [
                'label'   => esc_html__( 'Button Heading Text', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Button Heading', 'elementor-addon' ),
            ]
        );

        // Button 1 (First Button) Controls
        $repeater->add_control(
            'button_1_enabled',
            [
                'label'        => esc_html__( 'Enable First Button', 'elementor-addon' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // Button 1 Text
        $repeater->add_control(
            'button_1_text',
            [
                'label'     => esc_html__( 'First Button Text', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( 'Click Here', 'elementor-addon' ),
                'condition' => [
                    'button_1_enabled' => 'yes',
                ],
            ]
        );

        // Button 1 Image
        $repeater->add_control(
            'button_1_image',
            [
                'label'     => esc_html__( 'First Button Image', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'button_1_enabled' => 'yes',
                ],
            ]
        );

        // Button 1 Link
        $repeater->add_control(
            'button_1_link',
            [
                'label'       => esc_html__( 'First Button Link', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-addon' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    'button_1_enabled' => 'yes',
                ],
            ]
        );

        // Button 2 (Second Button) Controls
        $repeater->add_control(
            'button_2_enabled',
            [
                'label'        => esc_html__( 'Enable Second Button', 'elementor-addon' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // Button 2 Text
        $repeater->add_control(
            'button_2_text',
            [
                'label'     => esc_html__( 'Second Button Text', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( 'Learn More', 'elementor-addon' ),
                'condition' => [
                    'button_2_enabled' => 'yes',
                ],
            ]
        );

        // Button 2 Image
        $repeater->add_control(
            'button_2_image',
            [
                'label'     => esc_html__( 'Second Button Image', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'button_2_enabled' => 'yes',
                ],
            ]
        );

        // Button 2 Link
        $repeater->add_control(
            'button_2_link',
            [
                'label'       => esc_html__( 'Second Button Link', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-addon' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    'button_2_enabled' => 'yes',
                ],
            ]
        );

        // Add the repeater control for slides
        $this->add_control(
            'slides',
            [
                'label'       => esc_html__( 'Slides', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $unique_id = 'chintu-banner-slider-' . $this->get_id(); // Unique ID for each widget instance

        if ( !empty( $settings['slides'] ) ) {
            echo '<div id="' . esc_attr( $unique_id ) . '" class="swiper-container chintu-banner-slider">';
            echo '<div class="swiper-wrapper">';

            // Loop through each slide
            foreach ( $settings['slides'] as $slide ) {
                echo '<div class="swiper-slide" style="background-image: url(' . esc_url( $slide['background_image']['url'] ) . ');">';

                // Display the top three text fields
                echo '<div class="chintu-top-texts">';
                echo '<h3>' . esc_html( $slide['top_text_1'] ) . '</h3>';
                echo '<h3>' . esc_html( $slide['top_text_2'] ) . '</h3>';
                echo '<h3>' . esc_html( $slide['top_text_3'] ) . '</h3>';
                echo '</div>';


                echo '<div class="chintu-banner-text">' . esc_html( $slide['title'] ) . '</div>';

                // Display the button heading text (at the bottom)
                echo '<div class="chintu-button-heading-text">';
                echo '<h4>' . esc_html( $slide['button_heading_text'] ) . '</h4>';
                echo '</div>';

                // Render the first button as an image if provided, otherwise as text
                if ( $slide['button_1_enabled'] === 'yes' || $slide['button_2_enabled'] === 'yes' ) {
                    echo '<div class="chintu-banner-buttons">';

                    // First button
                    if ( $slide['button_1_enabled'] === 'yes' ) {
                        if ( !empty( $slide['button_1_image']['url'] ) ) {
                            echo '<a href="' . esc_url( $slide['button_1_link']['url'] ) . '"><img src="' . esc_url( $slide['button_1_image']['url'] ) . '" class="chintu-button-image" alt="' . esc_attr( $slide['title'] ) . '" /></a>';
                        } else {
                            echo '<a href="' . esc_url( $slide['button_1_link']['url'] ) . '" class="chintu-banner-button">' . esc_html( $slide['button_1_text'] ) . '</a>';
                        }
                    }

                    // Second button
                    if ( $slide['button_2_enabled'] === 'yes' ) {
                        if ( !empty( $slide['button_2_image']['url'] ) ) {
                            echo '<a href="' . esc_url( $slide['button_2_link']['url'] ) . '"><img src="' . esc_url( $slide['button_2_image']['url'] ) . '" class="chintu-button-image" alt="' . esc_attr( $slide['title'] ) . '" /></a>';
                        } else {
                            echo '<a href="' . esc_url( $slide['button_2_link']['url'] ) . '" class="chintu-banner-button">' . esc_html( $slide['button_2_text'] ) . '</a>';
                        }
                    }

                    echo '</div>';
                }

                echo '</div>'; // .swiper-slide
            }

            echo '</div>'; // .swiper-wrapper

            // Navigation arrows
            echo '<div class="swiper-button-next"></div>';
            echo '<div class="swiper-button-prev"></div>';

            // Pagination
            echo '<div class="swiper-pagination"></div>';

            echo '</div>'; // .swiper-container

            // Swiper initialization script
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    new Swiper("#' . esc_js( $unique_id ) . '", {
                        spaceBetween: 30,
                        effect: "fade",
                        loop: true,
                        navigation: {
                            nextEl: "#' . esc_js( $unique_id ) . ' .swiper-button-next",
                            prevEl: "#' . esc_js( $unique_id ) . ' .swiper-button-prev",
                        },
                        pagination: {
                            el: "#' . esc_js( $unique_id ) . ' .swiper-pagination",
                            clickable: true,
                        },
                    });
                });
            </script>';
        }
    }

    // Enqueue Swiper JS and CSS
    public function get_script_depends() {
        return ['swiper-js'];
    }

    public function get_style_depends() {
        return ['swiper-css'];
    }
}
