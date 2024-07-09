<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

class LoginController extends Controller
{
    public function loginRedirect() {
        return Socialite::driver('github')->scopes(['repo', 'gist', 'user:email'])->redirect();
    }

    public function loginCallback(Request $req) {
        $requestAccessToken = HTTP::post('https://github.com/login/oauth/access_token?client_id='.env('GITHUB_CLIENT_ID').'&client_secret='.env('GITHUB_CLIENT_SECRET').'&code='.$req->code);
        $accessToken = $requestAccessToken->body();
        
        return redirect()->route('userSave', $accessToken);
    }

    public function getAndSaveUser(Request $req) {
        $githubUser = Socialite::driver('github')->userFromToken($req->access_token);

        $githubUserName = $githubUser->name !== null ? $githubUser->name : $githubUser->nickname;

        $user = User::UpdateorCreate([
            'github_id' => $githubUser->id
        ], [
            'nickname' => $githubUser->nickname,
            'name' => $githubUserName,
            'email' => $githubUser->email,
            'avatar_url' => $githubUser->user['avatar_url'],
            'github_profile_url' => $githubUser->user['html_url'],
            'github_orgs_url' => $githubUser->user['organizations_url'],
            'github_repos_url' => $githubUser->user['repos_url'],
            'github_token' => $req->access_token
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logOutUser() {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }
}
