<?php

namespace Modules\Cargo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Acl\Repositories\AclRepository;
use Modules\Cargo\Http\Controllers\ClientController;
use Modules\Cargo\Http\Requests\RegisterRequest;
use Auth;
use Carbon\Carbon;

class SupportController extends Controller
{
    private $aclRepo;

    public function __construct(AclRepository $aclRepository)
    {
        $this->aclRepo = $aclRepository;
        // check on permissions
        $this->middleware('user_role:1|0|3|4')->only('index', 'shipmentsReport' ,'create');
        $this->middleware('user_role:4')->only('ShipmentApis');
    }

    public function index(){
        
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return view('cargo::'.$adminTheme.'.pages.support.index');
    }

}