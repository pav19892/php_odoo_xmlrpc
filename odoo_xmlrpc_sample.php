<?php
/*
 * For the PHP XMLRPC Connection,
 * Use this library to install,
 *
 * sudo apt-get install php-xmlrpc -y
 *
 */

/* Refer from the <https://github.com/poef/ripcord> */
require_once ('ripcord/ripcord.php');

/* GIVE YOUR CREDENTIAL BELOW */
$url = 'http://myodoo.com:8069';
$db = 'mint.com';
$username = 'admin';
$password = 'admin';

$common = ripcord::client("$url/xmlrpc/2/common");
$models = ripcord::client("$url/xmlrpc/2/object");
$common->version();
print_r($common->version());

$uid = $common->authenticate($db, $username, $password, array());

// ==============================
// Search Customer
// ==============================
$ids = $models->execute_kw($db, $uid, $password, 'res.partner', 'search', array(
    array(
        array(
            'is_company',
            '=',
            FALSE
        ),
        array(
            'customer',
            '=',
            true
        )
    )
));

$records = $models->execute_kw($db, $uid, $password, 'res.partner', 'read', array(
    $ids
));

// ==============================
// Create Customer or Company
// ==============================

$models->execute_kw($db, $uid, $password, 'res.partner', 'create', array(
    array(
        'name' => "Test company Pvt Ltd.",
        // FOR CREATE THE CUSTOMER CHANGE 'company_type' TO 'person'
        'company_type' => 'company',
        'mobile' => '+919898986688',
        'email' => 'test@testcompany.com',
        'dob' => '10/06/2015',
        'function' => 'IT techonology',
        'phone' => '+971-5566891'
    )
));

// ==============================
// Update Customer
// ==============================

$id_update = 7;

$update_id = $models->execute_kw($db, $uid, $password, 'res.partner', 'write', array(
    array(
        // $records.$id
        $id_update
    ),
    array(
        'gender' => '1',
        'dob' => '10/06/1992',
        'function' => 'Pre-sales',
        'phone' => '+971-5566891'
    )
));

// ==============================
// Delete Customer
// ==============================

$id_update = 7;

$delete_id = $models->execute_kw($db, $uid, $password, 'res.partner', 'unlink', array(
    array(
        $id_update
    )
));

// Print Record
print_r($delete_id);

?>