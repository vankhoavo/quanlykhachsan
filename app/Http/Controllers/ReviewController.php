<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.page.review.index');
    }

    public function store(CreateReviewRequest $request)
    {
        $data = $request->all();

        Review::create($data);

        return response()->json([
            'status'  => true,
        ]);
    }

    public function data()
    {
        $data = Review::all();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function update(UpdateReviewRequest $request)
    {
        $data = Review::where('id', $request->id)->first();

        $data->update($request->all());

        return response()->json([
            'status'  => true,
        ]);
    }

    public function destroy(Request $request)
    {
        Review::where('id', $request->id)->first()->delete();

        return response()->json(['status' => true]);
    }
}
