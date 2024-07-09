<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index() {
        if(Auth::check()) {
            $userAccessToken = Auth::User()->github_token;

            $reposArray = Http::withHeaders([
                'Authorization' => 'Bearer '.$userAccessToken
            ])->get('https://api.github.com/user/repos')->json();
            $sortRepos = collect($reposArray)->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
            $repos = json_encode($sortRepos);

            $orgsArray = Http::withHeaders([
                'Authorization' => 'Bearer '.$userAccessToken
            ])->get('https://api.github.com/user/orgs')->json();
            $sortOrgs = collect($orgsArray)->sortBy('login', SORT_NATURAL|SORT_FLAG_CASE);
            $orgs = json_encode($sortOrgs);

            
            
            return view('pages.home-page', compact('repos', 'orgs', 'userAccessToken'));
        } else {
            return view('pages.login-page');
        }
    }
}
