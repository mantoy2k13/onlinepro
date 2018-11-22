<?php
namespace app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\User\UserProfileUpdateRequest;
use App\Repositories\EmailLogRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;
use App\Services\MailServiceInterface;
use App\Services\UserNotificationServiceInterface;
use App\Services\UserServiceInterface;

class ProfileController extends Controller
{
    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;

    /** @var ImageServiceInterface $imageService */
    protected $imageService;

    /** @var UserNotificationRepositoryInterface $userNotificationRepository */
    protected $userNotificationRepository;

    /** @var UserNotificationServiceInterface $userNotificationService */
    protected $userNotificationService;

    /** @var EmailLogRepositoryInterface $emailLogRepository */
    protected $emailLogRepository;

    /** @var MailServiceInterface $mailService */
    protected $mailService;

    public function __construct(
        UserServiceInterface $userService,
        UserRepositoryInterface $userRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        ImageServiceInterface $imageService,
        UserNotificationRepositoryInterface $userNotificationRepository,
        UserNotificationServiceInterface $userNotificationService,
        EmailLogRepositoryInterface $emailLogRepository,
        MailServiceInterface $mailService
    ) {
        $this->userService                = $userService;
        $this->userRepository             = $userRepository;
        $this->fileUploadService          = $fileUploadService;
        $this->imageRepository            = $imageRepository;
        $this->imageService               = $imageService;
        $this->userNotificationRepository = $userNotificationRepository;
        $this->userNotificationService    = $userNotificationService;
        $this->emailLogRepository         = $emailLogRepository;
        $this->mailService                = $mailService;
    }

    public function index(PaginationRequest $request)
    {
        $user   = $this->userService->getUser();
        $offset = $request->offset();
        $limit  = $request->limit();
        $count  = $this->userNotificationRepository->countEnabledWithConditions('', '', $user, '');
        $models = $this->userNotificationRepository->getEnabledWithConditions('', '', $user, '', 'updated_at', 'desc', $offset, $limit);

        return view('pages.user.mypage', [
            'offset'  => $offset,
            'limit'   => $limit,
            'models'  => $models,
            'count'   => $count,
            'params'  => [],
            'baseUrl' => action('User\ProfileController@index'),
        ]);
    }

    public function showNotification($id)
    {
        $user       = $this->userService->getUser();
        $notice     = $this->userNotificationRepository->findByIdAndUserId($id, $user->id);
        $nextNotice = $this->userNotificationRepository->nextNotice($notice->id, $user->id, $user->created_at);
        $preNotice  = $this->userNotificationRepository->preNotice($notice->id, $user->id, $user->created_at);

        return view('pages.user.notice.view', [
            'notice'     => $notice,
            'nextNotice' => $nextNotice,
            'preNotice'  => $preNotice,
        ]);
    }

    public function show()
    {
        $user  = $this->userService->getUser();
        $model = $this->userRepository->find($user->id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.user.profile.edit', [
            'isNew' => false,
            'user'  => $model,
        ]);
    }

    public function updateProfile(UserProfileUpdateRequest $request)
    {
        $user  = $this->userService->getUser();
        $model = $this->userRepository->find($user->id);
        if (empty($model)) {
            \App::abort(404);
        }

        $input = $request->only([
            'name',
            'skype_id',
            'year_of_birth',
            ]);

        if ($password = $request->get('password')) {
            $input['password'] = $password;
        }
        $this->userRepository->update($model, $input);
        if ($request->hasFile('profile_image')) {
            $file      = $request->file('profile_image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('user-profile-image', $path, $mediaType, [
                'entityType' => 'user-profile',
                'entityId'   => $model->id,
                'title'      => $request->input('name', ''),
            ]);

            if (!empty($image)) {
                $imageOld = $model->profileImage;
                if (!empty($imageOld)) {
                    $this->fileUploadService->delete($imageOld);
                    $this->imageRepository->delete($imageOld);
                }
                $this->userRepository->update($model, ['profile_image_id' => $image->id]);
            }
        }
        $messageSuccess = trans('user.messages.general.update_success');

        return redirect()->action('User\ProfileController@show')
            ->with('message-success', $messageSuccess);
    }
}
