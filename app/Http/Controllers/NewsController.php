<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\DeleteNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function viewNews($str)
    {
        $viTri = 0;
        for($i = strlen($str) - 1; $i >= 0; $i--) {
            if($str[$i] == '-') {
                $viTri = $i;
                break;
            }
        }

        $id     = Str::substr($str, $viTri + 1, strlen($str) - $viTri);
        $news   = News::where('id', $id)->first();

        if($news) {
            return view('client.page.news_detail', compact('news'));
        } else {
            return redirect('/');
        }
    }

    public function index()
    {
        return view('admin.page.tin_tuc.index');
    }

    public function getData()
    {
        $data   = News::all();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function store(CreateNewsRequest $request)
    {
        News::create($request->all());

        return response()->json(['status' => true]);
    }

    public function changeStatus(Request $request)
    {
        $news = News::find($request->id);
        if($news) {
            $news->is_open = !$news->is_open;
            $news->save();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function update(UpdateNewsRequest $request)
    {
        $news = News::where('id', $request->id)->first();

        $news->update($request->all());

        return response()->json(['status' => true]);
    }

    public function destroy_1(Request $request)
    {
        $news = News::where('id', $request->id)->first();
        if($news) {
            $news->delete();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function destroy(DeleteNewsRequest $request)
    {
        News::where('id', $request->id)->first()->delete();

        return response()->json(['status' => true]);
    }
}
