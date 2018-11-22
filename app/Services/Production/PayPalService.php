<?php
namespace App\Services\Production;

use App\Repositories\PaymentLogRepositoryInterface;
use App\Services\PayPalServiceInterface;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPalService extends BaseService implements PayPalServiceInterface
{
    /** @var PaymentLogRepositoryInterface $paymentLogRepository */
    protected $paymentLogRepository;

    public function __construct(
        PaymentLogRepositoryInterface $paymentLogRepository
    ) {
        $this->paymentLogRepository = $paymentLogRepository;
    }

    public function getApprovalUrlUrl($redirectUrl, $amount, $currencyCode, $name, $sku, $invoiceCode)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $transaction = $this->createTransaction($amount, $currencyCode, $name, $sku)->setInvoiceNumber($invoiceCode);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($redirectUrl.'?success=true&invoice_code='.$invoiceCode)->setCancelUrl($redirectUrl.'?success=false');

        $payment = new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);

        try {
            $payment->create($this->getAPIContext());
            $approvalUrl = $payment->getApprovalLink();

            return $approvalUrl;
        } catch (\Exception $ex) {
            return '';
        }
    }

    public function executeTransaction($amount, $currencyCode, $name, $sku, $user, $paymentId, $payerId, $invoiceCode)
    {
        $apiContext = $this->getAPIContext();
        $payment    = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $transaction = $this->createTransaction($amount, $currencyCode, $name, $sku);
        $execution->addTransaction($transaction);
        try {
            $result = $payment->execute($execution, $apiContext);

            return $result->toArray();
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function createInvoiceCode()
    {
        return uniqid();
    }

    /**
     * @return ApiContext
     */
    private function getAPIContext()
    {
        $apiContext = new ApiContext(new OAuthTokenCredential(config('paypal.clientId'), config('paypal.secret')));
        $apiContext->setConfig([
            'mode'           => config('paypal.mode', 'sandbox'),
            'log.LogEnabled' => true,
            'log.FileName'   => storage_path('logs/paypal.log'),
            'log.LogLevel'   => 'DEBUG',
            // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
            'cache.enabled'  => true,
            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
            //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
        ]);

        return $apiContext;
    }

    /**
     * @param int    $amount
     * @param string $currencyCode
     * @param string $name
     * @param string $sku
     *
     * @return Transaction
     */
    private function createTransaction($amount, $currencyCode, $name, $sku)
    {
        $item = new Item();
        $item->setName($name)->setCurrency($currencyCode)->setQuantity(1)->setSku($sku)->setPrice($amount);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setShipping(0)->setTax(0)->setSubtotal($amount);

        $amountObj = new Amount();
        $amountObj->setCurrency($currencyCode)->setTotal($amount)->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amountObj)->setItemList($itemList)->setDescription('Payment description');

        return $transaction;
    }
}
