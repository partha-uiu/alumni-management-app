<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorshipTopic;
use Illuminate\Http\Request;
use App\MentorshipTopic;

class MentorshipTopicController extends Controller
{
    public function index()
    {
        $mentorshipTopics = MentorshipTopic::all();

        return view('mentorship-topics.index')->with('mentorshipTopics', $mentorshipTopics);
    }

    public function create()
    {
        return view('mentorship-topics.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:mentorship_topics',
        ]);

        $mentorshipTopic = new MentorshipTopic;
        $mentorshipTopic->title = $request->title;
        $mentorshipTopic->save();

        $mentoringTab = "active";

        return redirect()->back()->with('success', 'Topic has been added')->with('mentoringTab', $mentoringTab);
    }

    public function edit($id)
    {
        $mentorshipTopic = MentorshipTopic::find($id);

        return view('mentorship-topic.edit')
            ->with('mentorshipTopic', $mentorshipTopic);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:mentorship_topics',
        ]);

        $mentorshipTopic = MentorshipTopic::find($id);
        $mentorshipTopic->title = $request->title;
        $mentorshipTopic->save();

        $mentoringTab = "active";

        return redirect()->route('settings.user',['id'=>$id])->with('success', 'Mentorship Topic has been updated!')
                                                             ->with('mentoringTab', $mentoringTab);
    }

    public function destroy($id)
    {
        MentorshipTopic::find($id)->delete();

        $mentoringTab = "active";

        return redirect()->back()->with('success', 'Mentorship Topic has been deleted!')->with('mentoringTab', $mentoringTab);
    }

}
