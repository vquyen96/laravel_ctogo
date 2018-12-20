<?php

namespace App\Http\Controllers\Pub;

use App\Events\NotiEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\HomeStay;
use App\Models\Comment;
use App\Models\Config;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function getIndex()
    {
        return redirect('home');
    }

    public function getHome(Config $config, HomeStay $homestay, Comment $comment)
    {
        $data['hot_homestay'] = $homestay->where('homestay_active', 2)->orderBy('homestay_id', 'desc')->take(9)->get();
        $data['comments'] = $comment->where('home',Comment::ACTIVE)->with('user')->with('homestay')->take(9)->get();
        $data['banners'] = $config->getBanner()->value;
        return view('public.index', $data);
    }

    public function getBlogs(Client $guzzle)
    {
        $res = $guzzle->get(env('BLOG_URL') . '/api/blogs',['verify' => false]);
        $blogs = json_decode($res->getBody(), true);
        return view('public.get-blog', compact('blogs'));
    }

    public function getContactUs()
    {
        return view('public.support.contact_us');
    }

    public function getCopyright(Config $config)
    {
        $policy = $config->getPolicy()->value;
        return view('public.support.copyright', compact('policy'));
    }

    public function getTermsConditions(Config $config)
    {
        $term = $config->getTerm()->value;
        return view('public.support.terms_conditions', compact('term'));
    }

    public function getSupport()
    {
        return view('public.support.support');
    }

    public function getSearch()
    {
        return view('public.search-result');
    }

    public function getDetail($id)
    {
        $data['data_search'] = Session::get('search_data');

        $data['homestay'] = HomeStay::findOrFail($id);
        $data['nearby_homestay'] = HomeStay::where('homestay_active', 1)->orderBy('homestay_id', 'desc')->take(9)->get();
        $data['comments'] = $data['homestay']->comment();
        return view('public.detail', $data);
    }

    public function getRegister()
    {
        return view('public.register');
    }

    public function getHostSignUp()
    {
        return view('public.host-signup');
    }

    public function getSignUp()
    {
        return view('public.signup');
    }
}
