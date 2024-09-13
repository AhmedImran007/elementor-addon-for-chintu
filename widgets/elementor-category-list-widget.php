<?php

class Elementor_Category_List_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'category_list_widget';
    }

    public function get_title() {
        return esc_html__('Category List', 'elementor-addon-for-chintu');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['basic'];
    }

    public function get_keywords() {
        return ['category', 'list', 'post', 'menu'];
    }

    protected function _register_controls() {
        $categories = get_categories(['hide_empty' => false]);

        $category_options = [];
        foreach ($categories as $category) {
            $category_options[$category->term_id] = $category->name;
        }

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'elementor-addon-for-chintu'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add control for vertical or horizontal layout
        $this->add_control(
            'menu_layout',
            [
                'label' => esc_html__('Menu Layout', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'vertical' => esc_html__('Vertical', 'elementor-addon-for-chintu'),
                    'horizontal' => esc_html__('Horizontal', 'elementor-addon-for-chintu'),
                ],
                'default' => 'vertical',
            ]
        );

        $repeater = new \Elementor\Repeater();

        // Add control to select one category
        $repeater->add_control(
            'category_id',
            [
                'label' => esc_html__('Select Category', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $category_options,
            ]
        );

        // Background Color
        $repeater->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .category-item-{{category_id}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border Color
        $repeater->add_control(
            'border_color',
            [
                'label' => esc_html__('Border Color', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .category-item-{{category_id}}' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Font Color
        $repeater->add_control(
            'font_color',
            [
                'label' => esc_html__('Font Color', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .category-item-{{category_id}} > a' => 'color: {{VALUE}};', // This makes sure the color only applies to the specific category's link
                ],
            ]
        );
        
        // Enable Image Toggle Control
        $repeater->add_control(
            'enable_image',
            [
                'label' => esc_html__('Enable Image', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-addon-for-chintu'),
                'label_off' => esc_html__('No', 'elementor-addon-for-chintu'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        // Image Control (Disabled by default)
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'enable_image' => 'yes',
                ],
            ]
        );

        // Add control to toggle categories per row grid system
        $this->add_control(
            'enable_grid',
            [
                'label'        => esc_html__('Enable Grid System', 'elementor-addon-for-chintu'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'elementor-addon-for-chintu'),
                'label_off'    => esc_html__('No', 'elementor-addon-for-chintu'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // Add control for the number of categories per row (only if grid is enabled)
        $this->add_control(
            'categories_per_row',
            [
                'label'     => esc_html__('Categories Per Row', 'elementor-addon-for-chintu'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'min'       => 1,
                'max'       => 12,
                'default'   => 4, // Default to 4 categories per row
                'condition' => [
                    'enable_grid' => 'yes',  // Show only if the grid system is enabled
                ],
            ]
        );

        $this->add_control(
            'category_list',
            [
                'label' => esc_html__('Category List', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ category_id }}}',
            ]
        );

        // Add toggle to show or hide search box
        $this->add_control(
            'show_search_box',
            [
                'label' => esc_html__('Show Search Box', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-addon-for-chintu'),
                'label_off' => esc_html__('No', 'elementor-addon-for-chintu'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'elementor-addon-for-chintu'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Add control for border shape (global for all categories)
        $this->add_control(
            'border_shape',
            [
                'label' => esc_html__('Border Shape', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'normal' => esc_html__('Normal', 'elementor-addon-for-chintu'),
                    'rounded' => esc_html__('Rounded', 'elementor-addon-for-chintu'),
                ],
                'default' => 'normal',
            ]
        );

        // Border Radius Control: Only shown when "rounded" is selected
        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'border_shape' => 'rounded',  // Only show if "rounded" is selected
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-list li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Add Alignment Control
        $this->add_control(
            'content_alignment',
            [
                'label' => esc_html__('Content Alignment', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'elementor-addon-for-chintu'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-addon-for-chintu'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'elementor-addon-for-chintu'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .category-list li' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Add padding control (global for all category items)
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .category-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Add margin control (global for all category items)
        $this->add_responsive_control(
            'margin',
            [
                'label' => esc_html__('Margin', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .category-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Typography (Font Size and Font Weight)
        $this->start_controls_section(
            'style_typography_section',
            [
                'label' => esc_html__('Typography', 'elementor-addon-for-chintu'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Font Size Control
        $this->add_responsive_control(
            'font_size',
            [
                'label'      => esc_html__('Font Size', 'elementor-addon-for-chintu'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .category-list li a' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 16,
                ],
            ]
        );

        // Font Weight Control
        $this->add_control(
            'font_weight',
            [
                'label'   => esc_html__('Font Weight', 'elementor-addon-for-chintu'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '100' => '100 (Thin)',
                    '200' => '200 (Extra Light)',
                    '300' => '300 (Light)',
                    '400' => '400 (Normal)',
                    '500' => '500 (Medium)',
                    '600' => '600 (Semi Bold)',
                    '700' => '700 (Bold)',
                    '800' => '800 (Extra Bold)',
                    '900' => '900 (Black)',
                ],
                'default' => '400', // Normal weight by default
                'selectors' => [
                    '{{WRAPPER}} .category-list li a' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Settings Control
        $this->start_controls_section(
            'style_image_section',
            [
                'label' => esc_html__('Image Settings', 'elementor-addon-for-chintu'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Global Image Position Control
        $this->add_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left', 'elementor-addon-for-chintu'),
                    'right' => esc_html__('Right', 'elementor-addon-for-chintu'),
                    'top' => esc_html__('Top', 'elementor-addon-for-chintu'),
                    'bottom' => esc_html__('Bottom', 'elementor-addon-for-chintu'),
                ],
            ]
        );

        // Image Size Control in the Style Tab
        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Image Size', 'elementor-addon-for-chintu'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 128,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 32, // Default size
                ],
                'selectors' => [
                    '{{WRAPPER}} img.category-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $category_list = $settings['category_list'];
        $menu_layout = $settings['menu_layout']; // Horizontal or vertical layout
        $border_shape = $settings['border_shape'];
        $image_position = $settings['image_position'];
        $show_search_box = $settings['show_search_box'];
        $enable_grid = $settings['enable_grid'];  // Grid system toggle
        $categories_per_row = $settings['categories_per_row']; // Categories per row for grid

        // Determine class based on layout selection
        $layout_class = $menu_layout === 'horizontal' ? 'horizontal-menu' : 'vertical-menu';

        // Determine class for border shape
        $border_class = $border_shape === 'rounded' ? 'rounded-border' : 'normal-border';

        echo '<div class="category-search-wrapper">';

        if (!empty($category_list)) {
            if ($enable_grid === 'yes') {
                // If grid system is enabled: use CSS Grid and set number of columns
                echo '<ul class="category-list ' . esc_attr($layout_class) . ' ' . esc_attr($border_class) . '" style="display: grid; grid-template-columns: repeat(' . esc_attr($categories_per_row) . ', 1fr); gap: 0px;">';
            } else {
                // If grid system is disabled: use flexbox for horizontal, block for vertical
                $flex_style = $menu_layout === 'horizontal' ? 'display: flex; flex-wrap: wrap; gap: 0px;' : 'display: block;'; // Flex for horizontal, block for vertical
                echo '<ul class="category-list ' . esc_attr($layout_class) . ' ' . esc_attr($border_class) . '" style="' . esc_attr($flex_style) . '">';
            }

            foreach ($category_list as $item) {
                $category_link = get_category_link($item['category_id']);
                $category_name = get_cat_name($item['category_id']);
                $bg_color = isset($item['bg_color']) ? 'background-color:' . esc_attr($item['bg_color']) . ';' : '';
                $border_color = isset($item['border_color']) ? 'border-color:' . esc_attr($item['border_color']) . ';' : '';
                $font_color = isset($item['font_color']) ? 'color:' . esc_attr($item['font_color']) . ';' : '';
                $image_html = '';

                // Handle image rendering if enabled
                if (isset($item['enable_image']) && $item['enable_image'] === 'yes' && isset($item['image']['url']) && !empty($item['image']['url'])) {
                    $image_html = '<a href="' . esc_url($category_link) . '"><img src="' . esc_url($item['image']['url']) . '" class="category-image" alt="' . esc_attr($category_name) . '"></a>';
                }

                echo '<div class="category-content-wrapper">';
                echo '<li class="category-item-' . esc_attr($item['category_id']) . '" style="' . $bg_color . $border_color . '">';
                switch ($image_position) {
                    case 'top':
                        echo $image_html . '<br><a href="' . esc_url($category_link) . '" style="' . $font_color . '">' . esc_html($category_name) . '</a>';
                        break;
                    case 'bottom':
                        echo '<a href="' . esc_url($category_link) . '" style="' . $font_color . '">' . esc_html($category_name) . '</a><br>' . $image_html;
                        break;
                    case 'left':
                        echo $image_html . '<a href="' . esc_url($category_link) . '" style="' . $font_color . '">' . esc_html($category_name) . '</a>';
                        break;
                    case 'right':
                        echo '<a href="' . esc_url($category_link) . '" style="' . $font_color . '">' . esc_html($category_name) . '</a>' . $image_html;
                        break;
                    default:
                        echo '<a href="' . esc_url($category_link) . '" style="' . $font_color . '">' . esc_html($category_name) . '</a>';
                        break;
                }

                echo '</div>';
                echo '</li>';
            }

            echo '</ul>';
        } else {
            echo '<p>' . esc_html__('No categories selected.', 'elementor-addon-for-chintu') . '</p>';
        }

        // Display the search box if enabled
        if ($show_search_box === 'yes') {
            echo '<div class="search-box">';
            echo '<form role="search" method="get" action="' . esc_url(home_url('/')) . '">';
            echo '<input type="search" class="search-field" placeholder="' . esc_attr__('', 'elementor-addon-for-chintu') . '" value="' . get_search_query() . '" name="s" />';
            echo '<button type="submit"><i class="eicon-search"></i></button>';
            echo '</form>';
            echo '</div>';
        }

        echo '</div>';
    }

}
