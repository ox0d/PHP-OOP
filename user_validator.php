<?php
namespace Validator;

class UserValidator {
  private $errors = [];

  public function __construct(string $name, string $email, string $gender) {
    // Validate the provided name, email, and gender
    $this->validateName($name);
    $this->validateEmail($email);
    $this->validateGender($gender);
  }

  private function validateName($name) {
    // Validate the name field for emptiness and allowed characters
    if (empty(trim($name))) {
      $this->addError('name', "Name can not be empty.");
      return;
    }

    if(!preg_match("/^[a-zA-Z\s]+$/u", $name)) {
      $this->addError('name', "Name can only contain letters and spaces.");
      return;
    }
  }

  private function validateEmail($email) {
    // Validate the email field for emptiness and valid email format
    if (empty(trim($email))) {
      $this->addError('email', "Email can not be empty!");
      return;
    }

    if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/u", $email)) {
      $this->addError('email', "Please enter a valid email address.");
      return;
    }
  }

  private function validateGender($gender) {
    // Validate the gender field for emptiness and allowed values (case-insensitive)
    if (empty(trim($gender))) {
      $this->addError('gender', "Gender can not be empty!");
      return;
    }

    if(!preg_match("/^(male|female)$/i", $gender)) {
      $this->addError('gender', "Please select a valid gender.");
      return;
    }
  }

  private function addError(string $key, string $value) {
    // Add an error message to the errors array for the given key
    $this->errors[$key] = $value;
  }

  public function getErrors() {
    // Get the array of errors, if any
    return $this->errors;
  }
}
?>
