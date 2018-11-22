<?php
/**
 * Created by PhpStorm.
 * User: ironh
 * Date: 1/8/2017
 * Time: 10:26 PM.
 */
namespace app\Http\Controllers\User;

use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function beginner()
    {
        return view('pages.user.static-pages.beginner', [
        ]);
    }

    public function faq()
    {
        return view('pages.user.static-pages.faq', [
        ]);
    }

    public function terms()
    {
        return view('pages.user.static-pages.terms', [
        ]);
    }

    public function privacy()
    {
        return view('pages.user.static-pages.privacy', [
        ]);
    }
}
