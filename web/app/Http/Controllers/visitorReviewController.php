<?php

namespace App\Http\Controllers;

use App\Models\visitorReview;
use Illuminate\Http\Request;

class visitorReviewController extends Controller
{
    public function index()
    {
        $visitors = visitorReview::get();
        return view('admin.visitors.index', compact('visitors'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        visitorReview::create($data);
        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
