<?php

/**
 * Automatically Accept Order when invoice is Paid
 *
 * @package     WHMCS
 * @copyright   RtRasel
 * @link        https://rtrasel.com
 * @author      Md Rasel Islam <rtrasel.com>
 */

use WHMCS\Database\Capsule;

add_hook('InvoicePaid', 1, function ($vars) {

    $orderID = Capsule::table('tblorders')->where('invoiceid', '=', $vars['invoiceid'])->pluck('id')[0];
    if (!$orderID) {
        return;
    }
    $adminUsername = '';
    localAPI('AcceptOrder', ['orderid' => $orderID], $adminUsername);
});

add_hook('AfterProductUpgrade', 1, function ($vars) {

    $orderID = Capsule::table('tblupgrades')->where('id', '=', $vars['upgradeid'])->pluck('orderid')[0];
    if (!$orderID) {
        return;
    }
    $adminUsername = '';
    localAPI('AcceptOrder', ['orderid' => $orderID], $adminUsername);
});
