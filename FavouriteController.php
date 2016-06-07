<?php

namespace App\Http\Controllers\Instance;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ProfileFavouriteService;
use App\Services\ProfileService;
use App\Repositories\ProfileRepository;
use App\Services\UserService;
use App\Services\LoggerService;

class FavouriteController extends Controller
{
    /**
     * @var ProfileFavouriteService
     */
    protected $favourite;

    /**
     * @var UserService
     */
    protected $user;

    /**
     * @var ProfileService
     */
    protected $profile;

    /**
     * @var ProfileRepository
     */
    protected $pofilerepo;

    /**
     * @var LoggerService
     */
    protected $logger;

    /**
     * FavouriteController constructor.
     * @param ProfileFavouriteService $favourite
     * @param UserService $user
     * @param ProfileService $profile
     * @param LoggerService $logger
     * @param ProfileRepository $profilerepo
     */
    public function __construct(
        ProfileFavouriteService $favourite, 
        UserService $user, 
        ProfileService $profile,
        LoggerService $logger,
        ProfileRepository $profilerepo
    )
    {
        $this->favourite = $favourite;
        $this->user = $user;
        $this->profile = $profile;
        $this->profilerepo = $profilerepo;
        $this->logger = $logger;
    }

    /**
     * Add profile to favourite list
     *
     * @param $user_id
     * @param $profile_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($user_id, $profile_id)
    {
        $this->favourite->add($this->user->find($user_id), $this->profile->find($profile_id));

        flash()->success(stdMessage()->success);
        return redirect()->back();
    }

    /**
     * Remove profile from favourite list
     *
     * @param $user_id
     * @param $profile_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($user_id, $profile_id)
    {
        $this->favourite->remove($this->user->find($user_id), $this->profile->find($profile_id));

        flash()->success(stdMessage()->success);
        return redirect()->back();
    }

    /**
     * Find who mark given profile as favourite
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function whoLikeMe($user_id)
    {
        $whoLikeMe = $this->favourite->whoLikeMe($this->user->find($user_id));
        return response()->json($whoLikeMe, 200);
    }
    
    public function show()
    {
        $favorite_female = $this->favourite->whoILikeFemale(auth()->user());

        $favorite_male = $this->favourite->whoILikeMale(auth()->user());

        return view('instance.favorite.list',[

            'favorite_female' => $favorite_female,

            'favorite_male' => $favorite_male,

            'loggers'       => $this->logger->findLastActivity()->limit(10)->get(),

            'profiles'      => $this->favourite->belongsTo(auth()->user()),
          
            'vipFemale'     => $this->profile->isVipFemale()->limit(5)->get(),

        ]);
    }
}
