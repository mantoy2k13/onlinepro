<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactRequest;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\InquiryRepositoryInterface;
use App\Services\MailServiceInterface;
use App\Services\UserServiceInterface;

class ContactController extends Controller
{
    /** @var \App\Services\UserServiceInterface UserService */
    protected $userService;

    /** @var InquiryRepositoryInterface $inquiryRepository */
    protected $inquiryRepository;

    /** @var MailServiceInterface $mailService */
    protected $mailService;

    /** @var \App\Repositories\CountryRepositoryInterface */
    protected $countryRepository;

    public function __construct(
        UserServiceInterface $userService,
        InquiryRepositoryInterface $inquiryRepository,
        MailServiceInterface $mailService,
        CountryRepositoryInterface $countryRepository
    ) {
        $this->userService       = $userService;
        $this->inquiryRepository = $inquiryRepository;
        $this->mailService       = $mailService;
        $this->countryRepository = $countryRepository;
    }

    public function contactUs()
    {
        return view('pages.user.contact.contact', [
            'countries' => $this->countryRepository->all('order', 'asc'),
        ]);
    }

    public function confirmContact(ContactRequest $request)
    {
        $country = $this->countryRepository->allByCode($request->get('living_country_code', ''));
        if (count($country) > 0) {
            $data = [
                'name'         => $request->get('name', ''),
                'country'      => $country[0],
                'email'        => $request->get('email', ''),
                'type'         => $request->get('type', ''),
                'content'      => $request->get('content', ''),
            ];

            return view('pages.user.contact.confirm', $data);
        } else {
            redirect()->action('User\ContactController@contactUs');
        }
    }

    public function postContact(ContactRequest $request)
    {
        $user = $this->userService->getUser();
        $data = [
            'name'                     => $request->get('name', ''),
            'email'                    => $request->get('email', ''),
            'type'                     => $request->get('type', ''),
            'content'                  => $request->get('content', ''),
            'living_country_code'      => $request->get('living_country_code', ''),
            'user_id'                  => empty($user) ? 0 : $user->id,
        ];

        $inquiry = $this->inquiryRepository->create($data);
        $this->mailService->sendInquiryMailToSekaihe($inquiry);

        return redirect()->action('User\ContactController@completeContact');
    }

    public function completeContact()
    {
        return view('pages.user.contact.complete');
    }
}
