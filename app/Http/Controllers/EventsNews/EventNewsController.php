<?php

namespace App\Http\Controllers\EventsNews;

use App\Event;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventNewsController extends Controller
{
    public function index()
    {
        $newsQ = News::query();
        
        $news = $newsQ->filteredNews()->limit(4)->latest()->get();
        
        $eventsQ = Event::query();
        
        $today = Carbon::now()->format("Y-m-d");


        $events = $eventsQ->filteredEvents()->where('is_approved',1)->where('start_date','>', $today)->limit(6)->orderBy('start_date', 'asc')->get();
        
        $approvedEvents = $eventsQ->filteredEvents()->where('is_approved',1)->where('start_date','>', $today)->limit(6)->orderBy('start_date', 'asc')->get();

        return view('events-news.index')->with('news', $news)
            ->with('events', $events)->with('approvedEvents', $approvedEvents);
    }
}
