<?php
namespace App\Services;

interface PayPalServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $redirectUrl
     * @param int    $amount
     * @param string $currencyCode
     * @param string $name
     * @param string $sku
     * @param string $invoiceCode
     *
     * @return string
     */
    public function getApprovalUrlUrl($redirectUrl, $amount, $currencyCode, $name, $sku, $invoiceCode);

    /**
     * @param int              $amount
     * @param string           $currencyCode
     * @param string           $name
     * @param string           $sku
     * @param \App\Models\User $user
     * @param string           $paymentId
     * @param string           $payerId
     * @param string           $invoiceCode
     *
     * @return array|null
     */
    public function executeTransaction($amount, $currencyCode, $name, $sku, $user, $paymentId, $payerId, $invoiceCode);

    /**
     * @return string
     */
    public function createInvoiceCode();
}
