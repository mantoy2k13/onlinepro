<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Models\PurchaseLog;
use App\Repositories\PointLogRepositoryInterface;
use App\Services\PayPalServiceInterface;
use App\Services\PointServiceInterface;
use App\Services\UserServiceInterface;

class PointController extends Controller
{
    /** @var \App\Services\PayPalServiceInterface */
    protected $payPalService;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var \App\Repositories\PointLogRepositoryInterface */
    protected $pointLogRepository;

    /** @var \App\Services\PointServiceInterface */
    protected $pointService;

    protected $redirectUrl;

    public function __construct(
        PayPalServiceInterface          $payPalService,
        UserServiceInterface            $userService,
        PointLogRepositoryInterface     $pointLogRepository,
        PointServiceInterface           $pointService
    ) {
        $this->payPalService      = $payPalService;
        $this->userService        = $userService;
        $this->redirectUrl        = action('User\PointController@purchaseSuccessful');
        $this->pointLogRepository = $pointLogRepository;
        $this->pointService       = $pointService;
    }

    public function index()
    {
        return view('pages.user.point.index', [
            'titlePage' => trans('user.pages.title.point_index'),
        ]);
    }

    public function confirmPurchase(BaseRequest $request)
    {
        $user         = $this->userService->getUser();
        $packageInput = $request->get('package', 'basic');
        $package      = config('point.package.'.$packageInput);
        if (array_key_exists('value', $package) && array_key_exists('amount', $package['value'])) {
            $amount = intval($package['value']['amount']);
        } else {
            $amount = config('point.default_amount');
        }

        $currencyCode = config('point.currency_code');
        $name         = $user->name;
        $sku          = $user->id;
        $redirectUrl  = $this->redirectUrl;
        $invoiceCode  = $this->payPalService->createInvoiceCode();
        $pointInvoice = ['amount'=> $amount, 'currencyCode'=>$currencyCode,
            'name'               => $name,
            'sku'                => $sku,
            'user'               => $user,
            'invoiceCode'        => $invoiceCode,
        ];
        \Session::put('pointInvoice-'.$user->id, $pointInvoice);
        $redirectUrl = $this->payPalService->getApprovalUrlUrl($redirectUrl, $amount, $currencyCode, $name, $sku, $invoiceCode);
        if (empty($redirectUrl)) {
            return redirect()->back()->withErrors('Something Wrong');
        }

        return redirect($redirectUrl);
    }

    public function purchaseSuccessful(BaseRequest $request)
    {
        $user         = $this->userService->getUser();
        $pointInvoice = \Session::get('pointInvoice-'.$user->id);
        if ($pointInvoice['invoiceCode'] == $request->get('invoice_code')) {
            $amount           = $pointInvoice['amount'];
            $currencyCode     = $pointInvoice['currencyCode'];
            $name             = $pointInvoice['name'];
            $sku              = $pointInvoice['sku'];
            $user             = $pointInvoice['user'];
            $paymentId        = $request->get('paymentId');
            $payerId          = $request->get('PayerID');
            $invoiceCode      = $request->get('invoiceCode');
            $paypalFinishData = $this->payPalService->executeTransaction($amount, $currencyCode, $name, $sku, $user, $paymentId, $payerId, $invoiceCode);
            if (!empty($paypalFinishData) && $paypalFinishData['state'] == 'approved') {
                $totalAmount = $paypalFinishData['transactions'][0]['amount']['total'];
                $package     = $this->pointService->getPackageFromAmount($totalAmount);
                $this->pointService->purchasePoints($user->id, $package['value']['point'], PurchaseLog::PURCHASE_TYPE_PAYPAL, $paypalFinishData);
                $redirectUrl = \Session::get('booking-'.$user->id);
                if (!empty($redirectUrl)) {
                    \Session::forget('pointInvoice-'.$user->id);
                    \Session::forget('booking-'.$user->id);

                    return redirect($redirectUrl);
                }

                return redirect(action('User\PointController@completePurchase'));
            }
        }

        abort(404);
    }

    public function completePurchase()
    {
        $user         = $this->userService->getUser();
        $pointInvoice = \Session::get('pointInvoice-'.$user->id);
        $package      = $this->pointService->getPackageFromAmount($pointInvoice['amount']);
        \Session::forget('pointInvoice-'.$user->id);
        \Session::forget('booking-'.$user->id);

        return view('pages.user.point.purchase_point_successful', [
            'points' => $package['value']['point'],
        ]);
    }
}
