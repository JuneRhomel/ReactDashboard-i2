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
$return_value = ['success' => 0];
try {
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

            if ($post['property_type'] === 'Commercial') {
                if (isset($post['company_name'])) {
                    $extraFields = [
                        'company_name' => $post['company_name'],
                    ];
                }
                $allFields = array_merge($commonFields, $extraFields);
                $sth = $db->prepare("INSERT INTO {$account_db}.occupant_reg SET " . implode('=?, ', array_keys($allFields)) . "=?");
                $sth->execute(array_values($allFields));
                $return_value = ['success' => 1, 'title' => "You're almost there!", "description" => 'Please wait for the approval of your registration in your email. We will notify you via email once the approval is done.'];
            } elseif ($post['ownership'] === 'HOA') {
                if ($post['type'] === 'Owner') {
                    if (isset($post['company_name'])) {
                        $extraFields = [
                            'company_name' => $post['company_name'],
                        ];
                    }
                    if (isset($post['created_by'])) {
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
                    if (isset($post['created_by'])) {
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
            } else {
                $allFields = array_merge($commonFields);
                $sth = $db->prepare("INSERT INTO {$account_db}.occupant_reg SET " . implode('=?, ', array_keys($allFields)) . "=?");
                $sth->execute(array_values($allFields));
                $return_value = ['success' => 1, 'title' => "You're almost there!", "description" => 'Please wait for the approval of your registration in your email. We will notify you via email once the approval is done.'];
            }
        }
    }
} catch (PDOException $e) {
    //$return_value = ['success' => 0, 'title' => "Error", "description" => "An error occurred while processing your request."];
    $return_value = ['success' => 0, 'title' => "Error", "description" => $e->getMessage()];

    if ($e->getCode() === '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
        $return_value = ['success' => 0, 'title' => "Error", "description" => "Email address already exists."];
    }
}

echo json_encode($return_value);
