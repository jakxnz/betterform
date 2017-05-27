<?php

/**
 * A controller for the betterform exercise
 *
 * @author Jackson Darlow jackson@codecraft.nz
 * @since May 2017
 */

class BetterFormController extends Controller {

	// Validate return codes
	const VALIDATION_SUCCESS = 0;
	const VALIDATION_ERROR = 1;
	const VALIDATION_ERROR_CSRF_TOKEN = 2;
	const VALIDATION_ERROR_UNKNOWN_FIELD = 3;
	const VALIDATION_ERROR_FIELD_EMPTY = 4;
	const VALIDATION_ERROR_FIELD_INVALID = 5;
	
    private static $allowed_actions = array(
        'check',
		'submit'
    );

	public function init() {

		parent::init();
		Requirements::set_write_js_to_body(false);
		Requirements::set_force_js_to_bottom(false);
	}
	
	/**
	 * Index page (Main form)
	 * @return HTMLText
	 */
	public function index() {

		return $this->renderWith('BetterForm');
	}

	/**
	 * @return String
	 */
	private function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	/**
	 * @return String
	 */
	public function Link() {
		return Director::BaseURL();
	}
	
	/**
	 * Build Betterform
	 * @return type
	 */
	public function BetterForm() {
		$nameField = TextField::create('name', 'Name')
				->setFieldHolderTemplate('BootstrapRequiredFieldHolder')
				->setAttribute('id', 'betterform-name')
				->addExtraClass('form-control');
		$emailField = EmailField::create('email', 'Email')	
				->setFieldHolderTemplate('BootstrapRequiredFieldHolder')
				->setAttribute('id', 'betterform-email')
				->addExtraClass('form-control');
		$websiteField = TextField::create('website', 'Website')
				->setFieldHolderTemplate('BootstrapRequiredFieldHolder')
				->setAttribute('id', 'betterform-website')
				->addExtraClass('form-control');
		$commentField = TextareaField::create('comment', 'Comment')
				->setFieldHolderTemplate('BootstrapFieldHolder')
				->setAttribute('id', 'betterform-comment')
				->addExtraClass('form-control');
		$genderField = OptionsetField::create('gender', 'Gender', array('female' => 'Female', 'male' => 'Male'))
				->setFieldHolderTemplate('BootstrapRequiredFieldHolder');

		$fields = new FieldList(
			$nameField,
			$emailField,
			$websiteField,
			$commentField,
			$genderField 
        );	

        $actions = new FieldList(
            FormAction::create("submit")
				->setTitle("Submit")
				->setAttribute('id', 'betterform-submit')
				->setDisabled(true)
				->addExtraClass('btn btn-primary')
        );

        $required = new RequiredFields('name', 'email', 'website', 'gender');

        $form = (new Form($this, null, $fields, $actions, $required))
				->setAttribute('id', 'betterform-mainform')
				->setAttribute('class', 'form-horizontal');
		
        return $form;
		
    }
	
	/**
	 * Validate name field
	 * @param type $name
	 * @return type
	 */
	function checkName($name) {
		
		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;
		
		if (empty($name)) {
			$errorMessage = "Name is required";
			$retCode = self::VALIDATION_ERROR_FIELD_EMPTY;
		} else if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			// check if name only contains letters and whitespace
			$errorMessage = "Only letters and white space allowed";
			$retCode = self::VALIDATION_ERROR_FIELD_INVALID;
		}

		return array($retCode, $errorMessage);
	}
	
	/**
	 * Validate email field
	 * @param type $email
	 * @return type
	 */
	function checkEmail($email) {
		
		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;

		if (empty($email)) {
			$errorMessage = "Email is required";
			$retCode = self::VALIDATION_ERROR_FIELD_EMPTY;
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// check if e-mail address is well-formed
			$errorMessage = "Invalid email format";
			$retCode = self::VALIDATION_ERROR_FIELD_INVALID;
		}

		return array($retCode, $errorMessage);
	}
	
	/**
	 * Validate website field
	 * @param type $email
	 * @return type
	 */
	function checkWebsite($website) {
		
		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;

		if (empty($website) 
				&& !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
			// check if URL address syntax is valid (this regular expression also allows dashes in the URL)
			$errorMessage = "Invalid URL";
			$retCode = self::VALIDATION_ERROR_FIELD_INVALID;
		}

		return array($retCode, $errorMessage);
	}
	
	/**
	 * 	 * Validate gender field
	 * @param type $email
	 * @return type
	 */
	function checkGender($gender) {
		
		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;

		if (empty($gender)) {
			$errorMessage = "Gender is required";
			$retCode = self::VALIDATION_ERROR_FIELD_EMPTY;
		}

		return array($retCode, $errorMessage);
	}
	
	/**
	 * Validate content field
	 * @param type $email
	 * @return type
	 */
	function checkComment($token) {

		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;
		return array($retCode, $errorMessage);
	}
	
	/**
	 * Validate CRSF token
	 * @param type $email
	 * @return type
	 */
	function checkToken($token) {
		
		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;

		if ($token != Session::get('SecurityID')) {
			$errorMessage = "Invalid CSRF token. Please reload the page.";
			$retCode = self::VALIDATION_ERROR_CSRF_TOKEN;
		}

		return array($retCode, $errorMessage);
	}
	
	/**
	 * Generic validation function
	 * @param type $email
	 * @return type
	 */
	protected function checkParam($parameterName = '', $parameterValue = null) {
		
		// Compute validation method name base on parameter received
		$methodName = 'check' . ucwords($parameterName);
		$retCode = self::VALIDATION_SUCCESS;
		$errorMessage = null;
		
		// Check if method exists and use id if found
		if (empty($parameterName) || !method_exists($this, $methodName)) {
			$retCode = self::VALIDATION_ERROR_UNKNOWN_FIELD;
			$errorMessage = "Parameter could not be checked.";
		} else {
			list($retCode, $errorMessage) = $this->$methodName($parameterValue);
		}
		$retArray = ['return_code' => $retCode];
		if (!empty($errorMessage)) {
			$retArray['error_message'] = $errorMessage;
		}
		
		return $retArray;
	}
	
	/**
	 * Validate all posted variables
	 * @return type
	 */
	protected function checkParams() {

		$retCode = self::VALIDATION_SUCCESS;
		$submissionResults = [];
		
		// First validate posted data
		foreach ($this->getRequest()->postVars() as $parameterName => $parameterValue) {
			$submissionResults[$parameterName] = $this->checkParam($parameterName, $parameterValue);
			if ($submissionResults[$parameterName]['return_code'] !== self::VALIDATION_SUCCESS) {
				$retCode = self::VALIDATION_ERROR;
			} 
		}
		$submissionResults['return_code'] = $retCode;
		
		return $submissionResults;
	}

	/**
	 * Handle validation AJAX calls
	 * @param type $email
	 * @return type
	 */
	public function check() {
		
		return json_encode($this->checkParams());
	}

	/**
	 * Handle validation AJAX calls
	 * @param type $email
	 * @return type
	 */
	public function submit() {
		
		$submissionResults = $this->checkParams();
		
		// If validation was successful, go through array once more and 'submits' value,
		// here we only return values received and validated but that's the point where 
		// we should store data or use it in any way.
		if ($submissionResults['return_code'] === self::VALIDATION_SUCCESS) {
			foreach ($this->getRequest()->postVars() as $parameterName => $parameterValue) {
				$submissionResults[$parameterName]['submitted_value'] = $this->test_input($parameterValue);
			}
		}
		
		return json_encode($submissionResults);
	}
}
