<?php

namespace App\Http\Controllers\EventsNews;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateNewsRequest;
use App\News;
use App\Session;
use App\Institution;
use App\Department;
use App\UserActivity;
use App\Http\Requests\StoreNewsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {

        $q = News::query();

        if ($request->filled('q')) {

            $searchKeyword = $request->q;

            $q->where(function ($query) use ($searchKeyword) {
                $query->where('heading', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('description', 'like', '%' . $searchKeyword . '%');
            });
        }

        if ($request->filled('news_date')) {

            $date = Carbon::createFromFormat('d-m-Y', $request->news_date)->format('Y-m-d');

            $q->where('created_at', 'like', $date . '%');
        }


        $allNews = $q->filteredNews($q)->latest()->paginate(12);

        return view('news.index')->with('allNews', $allNews);
    }

    public function create()
    {
        $latestNews = News::latest()->take(5)->get();

        $sessions = Session::all();
        $department = Department::first();
        $institution = Institution::first();

        return view('news.create')->with('latestNews', $latestNews)
                                  ->with('sessions',  $sessions)
                                  ->with('department', $department)
                                  ->with('institution', $institution);
    }

    public function store(StoreNewsRequest $request)
    {
        $userId = Auth::id();

        $news = new News;
        $news->user_id = $userId;
        $news->heading = $request->heading;
        $news->description = $request->description;


        if( $request->session_id =='all')
            
             {
               $news->session_id = null;
             }
            else
             {
               $news->session_id = $request->session_id;

             }
        
        $news->department_id = $request->department_id;
        $news->institution_id = $request->institution_id;


        if ($request->hasFile('image_url')) {
            $newsImage = $request->file('image_url');
            $newsImageSaveAsName = time() . Auth::id() . "-news." . $newsImage->getClientOriginalExtension();
            $newsImage->storeAs('public/news', $newsImageSaveAsName);
            $news->image_url = "news/" . $newsImageSaveAsName;
        }

        $news->link = $request->link;

        $news->save();
         
        UserActivity::logActivity(Auth::user()->id, 'news_created', ['relatable_type' => 'App\News','relatable_id'=> $news->id]);

        return redirect()->back()->with('success', 'News has been successfully added');
    }

    public function edit($id)
    {
        $news = News::find($id);
        $latestNews = News::latest()->take(5)->get();

        return view('news.edit')
            ->with('news', $news)
            ->with('latestNews', $latestNews);
    }

    public function update($id, UpdateNewsRequest $request)
    {
        $news = News::find($id);
        $news->heading = $request->heading;
        $news->description = $request->description;

        if ($request->hasFile('image_url')) {
            $newsImage = $request->file('image_url');
            $newsImageSaveAsName = time() . Auth::id() . "-news." . $newsImage->getClientOriginalExtension();
            $newsImage->storeAs('public/news', $newsImageSaveAsName);
            $news->image_url = "news/" . $newsImageSaveAsName;
        }

        $news->link = $request->link;
        $news->save();

        return redirect()->back()->with('success', 'News has been successfully updated!');
    }

    public function show($id)
    {
        $news = News::find($id);

        $latestNews = News::latest()->take(5)->get();

        return view('news.show')
            ->with('news', $news)->with('latestNews', $latestNews);
    }

    public function destroy($id)
    {
        News::find($id)->delete();

        return redirect()->back()->with('success', 'News has been successfully deleted!');
    }

    public function batchAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        $arrayIds = explode(",", $ids);

        if ($action == 'delete') {
            News::whereIn('id', $arrayIds)->delete();
        }

        return redirect()->back()->with('success', 'Action Successfully Done !');
    }

     public function activities()
    {
        return $this->morphMany('App\UserActivity', 'activities');
    }




   

}
