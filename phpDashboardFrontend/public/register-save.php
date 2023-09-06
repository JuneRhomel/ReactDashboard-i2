<?php
session_start();

include('../../../vhosts/apii2-sandbox.inventiproptech.com/config.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/db.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/shared.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/mailer/mailer.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$post = $_POST;

// GET OTS DB NAME
$sth = $db->prepare("select concat('otsi2_',id) as account_db from otsi2.accounts where account_code=?");
$sth->execute([decryptData($_POST['acctcode'])]);
$account_db = $sth->fetch()['account_db'];

// CREATE NEW ACCOUNT
$return_value = ['success' => 0, 'title' => "Error", "description" => "An error occurred while processing your request."];

try {
    // $sth = $db->prepare("select email,status from {$account_db}.resident where email=? status IN  ('Active', 'Inactive')");
    // $sth->execute([$post['email']]);
    // $ocupant_account = $sth->fetch();

    // if (!$ocupant_account) {
    //     $email = $post['email'];
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $return_value = ['success' => 0, 'title' => 'Invalid Email', 'description' => 'Please enter a valid email address.'];
    //     } else {
    //         // Check if the email is already registered as 'approved', 'disapproved', or 'pending'
    //         $sth = $db->prepare("SELECT email, status FROM {$account_db}.occupant_reg WHERE email=? AND status IN ('Approved', 'Pending')");
    //         $sth->execute([$email]);
    //         $existing_email = $sth->fetch();

    //         if ($existing_email) {
    //             if ($existing_email['status'] === "approved") {
    //                 $return_value = [
    //                     'success' => 0,
    //                     'title' => 'Sorry, your account cannot be created',
    //                     'description' => 'The email address you provided is already registered'
    //                 ];
    //             } else {
    //                 $return_value = [
    //                     'success' => 0,
    //                     'title' => 'Email Already Registered',
    //                     'description' => 'The email address you provided is already registered, and the account is currently pending for approval. Please wait for the approval process to complete or contact our support team if you have any questions.'
    //                 ];
    //             }
    //         } else {
    //             // Check if the email already exists in the 'resident' table
    //             $sth = $db->prepare("SELECT email FROM {$account_db}.resident WHERE email=?");
    //             $sth->execute([$email]);
    //             $existing_resident_email = $sth->fetch();

    //             if ($existing_resident_email) {
    //                 $return_value = ['success' => 0, 'title' => 'Email Already Exists', 'description' => 'Your email is already registered as a occupant.'];
    //             } else {
    //                 // If email is valid and not registered, insert the data into the database
    //                 $sth = $db->prepare("INSERT INTO {$account_db}.occupant_reg SET first_name=?, last_name=?, address=?, email=?, contact_no=?, company_name=?, created_on=?, status='pending'");
    //                 $sth->execute([
    //                     $post['first_name'],
    //                     $post['last_name'],
    //                     $post['address'],
    //                     $email,
    //                     $post['contact_no'],
    //                     $post['company_name'],
    //                     time(),
    //                 ]);

    //                 $return_value = ['success' => 1, 'title' => "You're almost there!", 'description' => 'Please wait for the approval of your registration.'];
    //             }
    //         }
    //     }
    // } else {
    //     if ($ocupant_account['status'] === 'Active') {
    //         $return_value = ['success' => 1, 'title' => "You're almost there!", 'description' => 'The email address you provided is already registered'];
    //     } else {
    //         $return_value = ['success' => 1, 'title' => "You're almost there!", 'description' => 'The email address you provided is already registered whithe the status of inactive'];
    //     }
    // }



    // Old Code


    $sth = $db->prepare("select email from {$account_db}.occupant_reg where email=? and status='approved' ");
    $sth->execute([$post['email']]);
    $ocupant_reg = $sth->fetch();

    $sth = $db->prepare("select email from {$account_db}.occupant_reg where email=? and status='Pending' ");
    $sth->execute([$post['email']]);
    $pending = $sth->fetch();

    $sth = $db->prepare("select email from {$account_db}.occupant_reg where email=? and status='Approved' ");
    $sth->execute([$post['email']]);
    $ocupant_reg = $sth->fetch();

    $sth = $db->prepare("select email,status from {$account_db}.resident where email=? ");
    $sth->execute([$post['email']]);
    $ocupant_account = $sth->fetch();


    if ($pending) {
        $return_value = ['success' => 0, 'title' => "Email Already Registered", "description" => "'The email address you provided is already registered, and the account is currently pending for approval. Please wait for the approval process to complete or contact our support team if you have any questions.'"];
    } else {
        if ($ocupant_account) {
            if ($ocupant_account['status'] === 'Active') {
                $return_value = ['success' => 0, 'title' => "Email Already Registered", "description" => "The email address you provided is already registered"];
            } elseif ($ocupant_account['status'] === 'Inactive') {
                $return_value = ['success' => 0, 'title' => "Email Already Registered", "description" => "Sorry. The email address you provided is already registered with the status of " . $ocupant_account['status']];
            } else {
                $return_value = ['success' => 0, 'title' => "Unknown Email Status", "description" => "Sorry. The email address you provided is already registered with an unknown status: " . $ocupant_account['status']];
            }
        } else {
            $commonFields = [
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'address' => $post['address'],
                'email' => $post['email'],
                'contact_no' => $post['contact_no'],
                'created_on' => time(),
            ];
            
            if ($post['ownership'] === 'SO') {
                $extraFields = [
                    'company_name' => $post['company_name'],
                ];
                $allFields = array_merge($commonFields, $extraFields);
                $sth = $db->prepare("INSERT INTO {$account_db}.occupant_reg SET " . implode('=?, ', array_keys($allFields)) . "=?");
                $sth->execute(array_values($allFields));
                $return_value = ['success' => 1, 'title' => "You're almost there!", "description" => 'Please wait for the approval of your registration in your email. We will notify you via email once the approval is done.'];
            } elseif ($post['ownership'] === 'HOA') {
                if($post['type'] === 'Owner') {
                   if(isset($post['created_by'])) {
                       $extraFields = [
                           'type' => $post['type'],
                           'created_by' => $post['created_by'],
                       ];
                    } else {
                       $extraFields = [
                           'type' => $post['type'],
                       ];
                   }
                    $allFields = array_merge($commonFields, $extraFields);
                    $sth = $db->prepare("INSERT INTO {$account_db}.occupant_reg SET " . implode('=?, ', array_keys($allFields)) . "=?");
                    $sth->execute(array_values($allFields));
                    $return_value = ['success' => 1, 'title' => "You're almost there!", "description" => 'Please wait for the approval of your registration in your email. We will notify you via email once the approval is done.'];
                    
                } else {
                    if(isset($post['created_by'])) {
                        $extraFields = [
                            'type' => $post['type'],
                            'created_by' => $post['created_by'],
                            'unit_id' => $post['unit_id'],
                            'def_unit_id' => $post['unit_id'],
                        ];
                     } else {
                        $extraFields = [
                            'type' => $post['type'],
                        ];
                    }
                    $allFields = array_merge($commonFields, $extraFields);
                    
                    $sth = $db->prepare("INSERT INTO {$account_db}.occupant_reg SET " . implode('=?, ', array_keys($allFields)) . "=?");
                    $sth->execute(array_values($allFields));
                    $return_value = ['success' => 1, 'title' => "You're almost there!", "description" => 'Please wait for the approval of your registration in your email. We will notify you via email once the approval is done.'];

                }
            }
        }
    }
} catch (PDOException $e) {
    if ($e->getCode() === '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
        $return_value = ['success' => 0, 'title' => "Error", "description" => "Email address already exists."];
    }
}

echo json_encode($return_value);
