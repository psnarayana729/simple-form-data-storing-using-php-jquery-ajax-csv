<?php

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
// if any of these variables don't exist, add an error to our $errors array

if (empty($_POST['name']))
    $errors['name'] = 'Name is required.';

if (empty($_POST['email']))
    $errors['email'] = 'Email is required.';
else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    $errors['email'] = "Invalid email format";

if (empty($_POST['superheroAlias']))
    $errors['superheroAlias'] = 'Superhero alias is required.';

// return a response ===========================================================

// if there are any errors in our errors array, return a success boolean of false
if ( ! empty($errors)) {

    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors']  = $errors;
} else {

    // if there are no errors process our form, then return a message

    // DO ALL YOUR FORM PROCESSING HERE
    // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

    //CSV storing process
    $file_open = fopen("contact_data.csv", "a");
    $no_rows = count(file("contact_data.csv"));
    if($no_rows > 1)
    {
        $no_rows = ($no_rows - 1) + 1;
    }
    $form_data = array(
                    'sr_no' => $no_rows,
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'superheroAlias' => $_POST['superheroAlias']
                );
    fputcsv($file_open, $form_data);


    // show a message of success and provide a true success variable
    $data['success'] = true;
    $data['message'] = 'Success!';
}

// return all our data to an AJAX call
echo json_encode($data);