<?php

/**
 * A controller for the betterform exercise
 *
 * @author Jackson Darlow jackson@codecraft.nz
 * @since May 2017
 */

class BetterFormController extends Controller {

	/**
	 * A basic form, with validation, based on the W3C schools PHP5 Complete
	 * Form Example @see https://www.w3schools.com/php/php_form_complete.asp
	 *
	 * @return HTMLText
	 */
	public function index() {

		$nameErr = $emailErr = $genderErr = $websiteErr = "";
		$name = $email = $gender = $comment = $website = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (empty($_POST["name"])) {
				$nameErr = "Name is required";
			} else {
				$name = $this->test_input($_POST["name"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
					$nameErr = "Only letters and white space allowed";
				}
			}

			if (empty($_POST["email"])) {
				$emailErr = "Email is required";
			} else {
				$email = $this->test_input($_POST["email"]);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$emailErr = "Invalid email format";
				}
			}

			if (empty($_POST["website"])) {
				$website = "";
			} else {
				$website = $this->test_input($_POST["website"]);
				// check if URL address syntax is valid (this regular expression also allows dashes in the URL)
				if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
					$websiteErr = "Invalid URL";
				}
			}

			if (empty($_POST["comment"])) {
				$comment = "";
			} else {
				$comment = $this->test_input($_POST["comment"]);
			}

			if (empty($_POST["gender"])) {
				$genderErr = "Gender is required";
			} else {
				$gender = $this->test_input($_POST["gender"]);
			}
		}

		return $this->customise(array(
			'Name' => $name,
			'NameErr' => $nameErr,
			'Email' => $email,
			'EmailErr' => $emailErr,
			'Website' => $website,
			'WebsiteErr' => $websiteErr,
			'Comment' => $comment,
			'Gender' => $gender,
			'GenderErr' => $genderErr,
		))->renderWith('BetterForm');
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

}
