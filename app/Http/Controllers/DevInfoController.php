<?php

namespace App\Http\Controllers;

use App\Support\EnvironmentInfo;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * /devinfo: the server's environment details, for superusers only, in every environment.
 *
 * This checks is_superuser() directly instead of a gate, because Gate::before lets superusers
 * through every gate; a direct check means no role permission can ever open this page.
 */
class DevInfoController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()->is_superuser(), 403);

        return view('devinfo', [
            'server' => EnvironmentInfo::server(),
            'packages' => EnvironmentInfo::packages(),
            'extensions' => EnvironmentInfo::phpExtensions(),
        ]);
    }
}
