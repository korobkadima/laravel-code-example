<?php

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileLoginRequest;

use App\Services\AuthService;
use App\Services\ProfileService;

use App\Services\InstanceService;
use App\Services\LoggerService;
use App\Services\SearchService;
use Illuminate\Http\Request;

use Validator;
use Input;

class OnlineController extends Controller
{
    /**
     * @var SearchService
     */
    protected $search;

    /**
     * @var LoggerService
     */
    protected $logger;

    /**
     * @var InstanceService
     */
    protected $instance;

    /**
     * @var ProfileService
     */
    protected $profile;
   
    /**
     * @var AuthService
     */
    protected $auth;

    /**
     * OnlineController constructor.
     *
     * @param SearchService $search
     * @param LoggerService $logger
     * @param InstanceService $instance
     * @param ProfileService $profile
     * @param AuthService $auth
     */
    public function __construct(

        SearchService $search,
        LoggerService $logger,
        InstanceService $instance,
        ProfileService $profile,
        AuthService $auth
        )
    {
        $this->search = $search;
        $this->auth = $auth;
        $this->profile = $profile;
        $this->instance = $instance;
        $this->logger = $logger;
    }

    /**
     * Get Profile online list view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function onlineShow(Request $request)
    {
        if ($request->online)
        {
            $profileList = $this->search->search(auth()->user()->profile, $request->all());

            /** Add all $_GET values */
            $profileList->appends(Input::except('page'));
        }
        else
        {
            $profileList = $this->profile->isOnline()->paginate(15);
        }

        return view('instance.online.list',[

            'loggers'       => $this->logger->findLastActivity()->limit(20)->get(),
            
            'profiles'      => $profileList,
            'onlineMale'    => $this->profile->isOnlineMale()->get()->count(),
            'onlineFemale'  => $this->profile->isOnlineFemale()->get()->count(),
            'vipFemale'     => $this->profile->isVipFemale()->limit(5)->get(),

        ]);
    }

}
