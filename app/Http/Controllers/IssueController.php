<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index($org, $repo, $issueNumber) {

        return view('pages.issue-details-page', compact('org', 'repo', 'issueNumber'));
    }
}
