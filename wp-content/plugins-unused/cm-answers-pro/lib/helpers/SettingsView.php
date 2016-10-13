<?php

require_once CMA_PATH . '/lib/helpers/SettingsViewAbstract.php';

class CMA_SettingsView extends CMA_SettingsViewAbstract {
	
	
	
	
	protected function getSubcategoryTitle($category, $subcategory) {
		$subcategories = $this->getSubcategories();
		if (isset($subcategories[$category]) AND isset($subcategories[$category][$subcategory])) {
			return CMA_Settings::__($subcategories[$category][$subcategory]);
		} else {
			return CMA_Settings::__($subcategory);
		}
	}
	
	
	protected function getCategories() {
		return CMA_Settings::getCategories();
	}
	
	
	protected function getSubcategories() {
		return CMA_Settings::getSubcategories();
	}
	
	
}