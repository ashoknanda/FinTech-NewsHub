<?php

class CMA_QuestionController extends CMA_BaseController {
	
	
	public static function initialize() {
		
		if (!CMA::isLicenseOk()) return;
		
		add_action('cma_index_question_form', array(__CLASS__, 'indexQuestionForm'), 1000, 3);
		add_filter('template_include', array(__CLASS__, 'overrideTemplate'), PHP_INT_MAX);
// 		add_filter('the_content', array(__CLASS__, 'the_content'), PHP_INT_MAX);
		
	}
	
	
	static function overrideTemplate($template) {
		if (get_query_var('CMA-question-add')) {
			$tempalte = self::prepareSinglePage(
				$title = CMA_Labels::getLocalized('ask_a_question'),
				$content = '',
				$newQuery = true
			);
		}
		
		return $template;
		
	}
	
	
	static function addHeader() {
		
		if (!CMA_Thread::canPostQuestions()) {
			self::addMessage(self::MESSAGE_ERROR, CMA_Labels::getLocalized('msg_cannot_post_question'));
// 			wp_redirect(CMA::getReferer());
// 			exit;
		}
		
		self::loadScripts();
		
	}
	
	
	static function addAction() {
		$content = '';
		if (CMA_Thread::canPostQuestions()) {
			$content = CMA_QuestionFormShortcode::shortcode(array(
				'cat' => CMA_BaseController::_getParam('category')
			));
		}
		else if (!is_user_logged_in()) {
			$content = self::_loadView('answer/widget/login');
		}
		return compact('content');
	}
	
	
	static function testHeader() {
		
	}
	
	
	static function testAction() {
		return array();
	}
	
	
	static function indexQuestionForm($catId, $place, $displayOptions = array()) {
		if (CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_FORM_BUTTON)) {
			$url = home_url('question/add/');
			if (!empty($displayOptions['formtags'])) {
				$url = add_query_arg('formtags', urlencode($displayOptions['formtags']), $url);
			}
			echo CMA_BaseController::_loadView('answer/widget/question-form-button', compact('url', 'displayOptions'));
		} else {
			echo CMA_BaseController::_loadView('answer/widget/question-form', compact('catId', 'displayOptions'));
		}
	}
	
	
}
