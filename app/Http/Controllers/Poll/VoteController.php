<?php

namespace App\Http\Controllers\Poll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Poll;
use App\Option;
use App\Vote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index($id)
    {
        $userId = Auth::id();

        $polls = Poll::with('options')->find($id);
        $maxCheck = $polls->max_checkable;

        $allVotes = Vote::with('option')->where('user_id', $userId)->get();

        return view('polls.vote.index')->with('polls', $polls)->with('maxCheck', $maxCheck)->with('allVotes', $allVotes);
    }

    public function vote(Request $request, $id)
    {
        if($request->has('checkbox_type')) {
            if(!$request->options || count($request->options) <= 0) {
                return redirect()->back()->with("error", "Please select at least one option");
            }
        }

        if($request->has('radio_type')) {
            if(!$request->options) {
                return redirect()->back()->with("error", "Please select at least one option");
            }
        }

        $userId = Auth::id();

        $voteData = [];

        if ($request->has('checkbox_type')) {
            $countVotes = count($request->options);

            if ($countVotes < 1) {

                return redirect()->back()->with("error", "Please select at least one option");

            }

            $polls = Poll::with('options')->find($id);
            $maxCheck = $polls->max_checkable;

            if ($countVotes > $maxCheck) {

                return redirect()->back()->with("error", "You can vote maximum " . $maxCheck . " options");

            }

            if (count($request->options)) {
                $now = Carbon::now()->toDateTimeString();

                for ($i = 0; $i < $countVotes; $i++) {
                    $voteData[$i]['user_id'] = $userId;
                    $voteData[$i]['option_id'] = $request->options[$i];
                    $voteData[$i]['created_at'] = $now;
                    $voteData[$i]['updated_at'] = $now;
                }

                Vote::insert($voteData);
            }

            $optionIds = $request->options;

            Option::whereIn('id', $optionIds)->increment('votes');
        } elseif ($request->has('radio_type')) {

            $option = $request->options;

            if (!$option) {

                return redirect()->back()->with("error", "Please select at least one option");

            }

            $checkUserVote = Vote::where('option_id', $option)->where('user_id', $userId)->first();

            if ($checkUserVote) {
                return redirect()->back()->with("error", "You have already voted. Thank You");
            }

            $now = Carbon::now()->toDateTimeString();

            $voteData['user_id'] = $userId;
            $voteData['option_id'] = $option;
            $voteData['created_at'] = $now;
            $voteData['updated_at'] = $now;

            Vote::insert($voteData);

            Option::where('id', $option)->increment('votes');
        }
        $isVoted = "active";
        return redirect()->back()->with('success', "Your vote has been submitted successfully")->with('isVoted', $isVoted);
    }

    public function voteResult($id)
    {

        $totalVotes = Option::where('poll_id', $id)->get();

        if (count($totalVotes)) {
            $sum = 0;
            foreach ($totalVotes as $totalVote) {
                $sum = $sum + $totalVote->votes;
            }
        } else {
            $sum = 0;
        }

        $voteResults = Option::with('poll')->where('poll_id', $id)->get();
        $pollStatus = Poll::find($id);

        return view('polls.vote.result')->with('voteResults', $voteResults)->with('sum', $sum)
            ->with('pollStatus', $pollStatus);
    }

    public function userVoteDetails($id)
    {

        $user = Auth::id();

        $votedOptions = Vote::with('option')->where('user_id', $user)->get();

        $options = [];

        foreach ($votedOptions as $votedOption) {
            $options[] = $votedOption->option_id;
        }


        $userVoteDetails = Option::with('poll')
            ->whereIn('id', $options)->where('poll_id', $id)->get();


        return view('polls.vote.user-vote-details')->with('userVoteDetails', $userVoteDetails);
    }

}
