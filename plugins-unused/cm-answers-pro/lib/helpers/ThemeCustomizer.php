<?php

class CMA_ThemeCustomizer {
	
	const PANEL_ID = 'cm_answers';
	
	protected $supportedSubcategories;
	protected $getConfigCallable;
	protected $getCategoriesCallable;
	protected $getSubcategoriesCallable;
	
	
	static function initialize($supportedSubcategories, $getConfigCallable, $getCategoriesCallable, $getSubcategoriesCallable) {
		return new static($supportedSubcategories, $getConfigCallable, $getCategoriesCallable, $getSubcategoriesCallable);
	}
	
	
	function __construct($supportedSubcategories, $getConfigCallable, $getCategoriesCallable, $getSubcategoriesCallable) {
		
		$this->supportedSubcategories = $supportedSubcategories;
		$this->getConfigCallable = $getConfigCallable;
		$this->getCategoriesCallable = $getCategoriesCallable;
		$this->getSubcategoriesCallable = $getSubcategoriesCallable;
		
		add_action('customize_register', array($this, 'customize_register'), 10, 1);
	}
	
	
	
	function getConfig() {
		return call_user_func($this->getConfigCallable);
	}
	
	
	
	function getCategories() {
		return call_user_func($this->getCategoriesCallable);
	}
	
	
	function getSubcategories() {
		return call_user_func($this->getSubcategoriesCallable);
	}
	
	
	function getCategoryName($category) {
		return \CMA_Settings::$categories[$category];
	}
	
	
	function getSubcategoryName($category, $subcategory) {
		return \CMA_Settings::$subcategories[$category][$subcategory];
	}
	
	
	function customize_register($wp_customize) {
		
		$wp_customize->add_panel(static::PANEL_ID, array(
			'title' => 'CMA Settings',
			'priority' => 160,
		));
		
		foreach ($this->supportedSubcategories as $category => $subcategories) {
			foreach ($subcategories as $subcategory) {
				$wp_customize->add_section( 'cma_' . $category . '_' . $subcategory, array(
					'title' => $this->getCategoryName($category) .': '. $this->getSubcategoryName($category, $subcategory),
					'panel' => static::PANEL_ID, // Not typically needed.
					'priority' => 160,
					'capability' => 'edit_theme_options',
					'theme_supports' => '', // Rarely needed.
				) );
			}
		}
				
		$supportedTypes = array(
			\CMA_Settings::TYPE_BOOL,
			\CMA_Settings::TYPE_INT,
			\CMA_Settings::TYPE_RADIO,
			\CMA_Settings::TYPE_SELECT,
			\CMA_Settings::TYPE_STRING,
			\CMA_Settings::TYPE_TEXTAREA
		);
		
		
		$optionsConfig = $this->getConfig();
		$supportedCategories = array_keys($this->supportedSubcategories);
		foreach ($optionsConfig as $name => $config) {
			if (in_array($config['category'], $supportedCategories) AND in_array($config['subcategory'], $this->supportedSubcategories[$config['category']])) {
				if (in_array($config['type'], $supportedTypes)) {
					static::addCustomizerOption($wp_customize, $name, $config);
				}
			}
		}
	}
	
	
	static function addCustomizerOption($wp_customize, $name, $config) {
		
		$typeMap = array(
			\CMA_Settings::TYPE_BOOL => 'radio',
			\CMA_Settings::TYPE_INT => 'number',
			\CMA_Settings::TYPE_RADIO => 'select',
			\CMA_Settings::TYPE_SELECT => 'select',
			\CMA_Settings::TYPE_STRING => 'text',
			\CMA_Settings::TYPE_TEXTAREA => 'textarea',
		);
		
		$settingArgs = array(
			'type' => 'option', // or 'option'
			'capability' => 'edit_theme_options',
			'theme_supports' => '', // Rarely needed.
			'default' => (isset($config['default']) ? $config['default'] : ''),
			'transport' => 'refresh', // or postMessage
			'sanitize_callback' => '',
			'sanitize_js_callback' => '', // Basically to_json.
		);
		
		$controlArgs = array(
			'label'        => $config['title'],
			'section'    => 'cma_' . $config['category'] . '_' . $config['subcategory'],
			'settings'   => $name,
			'type' => $typeMap[$config['type']],
			'description' => (isset($config['desc']) ? $config['desc'] : ''),
		);
		
		switch ($config['type']) {
			case \CMA_Settings::TYPE_BOOL:
				$controlArgs['choices'] = array('1' => 'yes', '0' => 'no');
				$settingArgs['default'] = intval($settingArgs['default']);
				break;
			case \CMA_Settings::TYPE_RADIO:
			case \CMA_Settings::TYPE_SELECT:
				$controlArgs['choices'] = (is_callable($config['options']) ? call_user_func($config['options'], $name) : $config['options']);
				break;
		}
		
		$wp_customize->add_setting( $name, $settingArgs );
		
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, $name, $controlArgs ) );
		
	}
	
}
