<?php // VALIDATION FUNCTIONS

  $errors = array();

  function field_name_as_text($fieldname) {
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
  }

  // * Presence
  function has_presence($value) {
    return isset($value) && !empty($value);
  }

  function validate_precences($required_fields) {
    global $errors;
    // Expects an assoc array
    foreach ($required_fields as $field) {
      $value = trim($_POST[$field]);
      if (!has_presence($value)) {
        $errors[$field] = field_name_as_text($field) . " can't be blank";
      }
    }
  }

  // * String Length

  // Less than max length
  function under_max($value, $max_length) {
    return strlen($value) < $max_length;
  }

  function validate_max_lengths($fields_with_max_lengths) {
    global $errors;
    // Expects an assoc array
    foreach ($fields_with_max_lengths as $field => $max) {
      $value = trim($_POST[$field]);
      if (!under_max($value, $max)) {
        $errors[$field] = field_name_as_text($field) . " is too long";
      }
    }
  }

  // More than min length
  function over_min($value, $min_length) {
    return strlen($value) > $min_length;
  }

  // * Inclusion in a set
  function is_in_set($value, $set) {
    return in_array($value, $set);
  }

  // * Format

  // Use regex on a string
  // preg_match($regex, $subject)
  function has_format($regex, $value) {
    return preg_match($regex, $value);
  }

?>
