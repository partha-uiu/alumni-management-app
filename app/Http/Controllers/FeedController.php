<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
		if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {

		
			$userActivities = UserActivity::with('relatable')
				->whereIn('activity_type', ['event_approved','event_created', 'job_approved', 'job_created','donation_approved','donation_created','news_created','poll_created'])
				->latest()
				->take(20)
				->get();
		}
		elseif(Auth::user()->hasAnyRole('alumni|student')) {

			$userActivities = UserActivity::with('relatable')
				->whereIn('activity_type', ['event_approved', 'job_approved','donation_approved','news_created','poll_created'])
				->latest()
				->take(20)
				->get();	
		}
		
		return view('feed.index')->with('userActivities', $userActivities);						
    }

    public function getFeeds(Request $request)
    { 
    	$type = $request->data;

    	$q = UserActivity::with('relatable');

			if ($type == "more") {
				if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
		       	   $offsetFromPageCount = $request->pageCount;
		       	   
		       	   $limit = 20;
		       	   $offset = $offsetFromPageCount*$limit;

		       	   $feedType = $request->type;

		       	    if($feedType=='event'){
		           		$q->whereIn('activity_type', ['event_approved','event_created']);

		       	    }
		       	    elseif ($feedType == "job") {

		        		$q->whereIn('activity_type', ['job_approved','job_created']);

		       		}
		       		elseif ($feedType == "donation") {
		       	
		        		$q->whereIn('activity_type', ['donation_approved','donation_created']);

		       		}
		       		elseif ($feedType == "news") {
		       	
		        		$q->whereIn('activity_type', ['news_created']);

					   }
					elseif ($feedType == "poll") {
			
						$q->whereIn('activity_type', ['poll_created']);

					}
				}
				elseif(Auth::user()->hasAnyRole('alumni|student')) {
					$offsetFromPageCount = $request->pageCount;
		       	   
					$limit = 20;
					$offset = $offsetFromPageCount*$limit;

					$feedType = $request->type;

					 if($feedType=='event'){
						 $q->whereIn('activity_type', ['event_approved']);

					 }
					 elseif ($feedType == "job") {

					  $q->whereIn('activity_type', ['job_approved']);

					 }
					 elseif ($feedType == "donation") {
				 
					  $q->whereIn('activity_type', ['donation_approved']);

					 }
					 elseif ($feedType == "news") {
				 
					  $q->whereIn('activity_type', ['news_created']);

					}
				  	elseif ($feedType == "poll") {
		  
					  $q->whereIn('activity_type', ['poll_created']);

					}
					elseif ($feedType == "all") {
		  
						$q->whereIn('activity_type', ['poll_created','news_created','donation_approved','job_approved','event_approved']);
  
					}

				}
		       	
				$getFeeds= $q->skip($offset)->take($limit)->latest()->get();


				return json_encode($getFeeds);
			}
		   

		   else {
				if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
					if($type == "event" )
					{

						$q->whereIn('activity_type', ['event_approved','event_created']);

					}
					elseif ($type == "job") {

						$q->whereIn('activity_type', ['job_approved','job_created']);

					}
					elseif ($type == "donation") {
						
						$q->whereIn('activity_type', ['donation_approved','donation_created']);

					}
					elseif ($type == "news") {
						
						$q->whereIn('activity_type', ['news_created']);

					}
					elseif ($type == "poll") {
					
						$q->whereIn('activity_type', ['poll_created']);

					}
				}
				elseif(Auth::user()->hasAnyRole('alumni|student')) {
					if($type == "event" )
					{

						$q->whereIn('activity_type', ['event_approved']);

					}
					elseif ($type == "job") {

						$q->whereIn('activity_type', ['job_approved']);

					}
					elseif ($type == "donation") {
						
						$q->whereIn('activity_type', ['donation_approved']);

					}
					elseif ($type == "news") {
						
						$q->whereIn('activity_type', ['news_created']);

					}
					elseif ($type == "poll") {
					
						$q->whereIn('activity_type', ['poll_created']);

					}
					elseif ($type == "all") {
		  
						$q->whereIn('activity_type', ['poll_created','news_created','donation_approved','job_approved','event_approved']);
  
					}
				}
		      
			 
			   
		    $getFeeds = $q->latest()
	  		    ->take(20)
	            ->get();

         	return json_encode($getFeeds);
	    }

    }

}
