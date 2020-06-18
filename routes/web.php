<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/about', 'AboutController@index')->name('about');
Route::get('/', 'HomeController@index')->name('cse-connect.home');
Route::get('/committee', 'CommitteeController@index')->name('committee');


Route::middleware('guest')->group(function () {

    Route::get('register/verify/{token}', 'Auth\RegisterController@verify');
    Route::get('/register/home', 'Auth\RegisterController@index')->name('register.index');
    Route::get('/register/step-1', 'Auth\RegisterController@firstStep')->name('register.step-1');
    Route::get('/register/step-2', 'Auth\RegisterController@secondStep')->name('register.step-2');
    Route::post('/register/step-2', 'Auth\RegisterController@secondStep')->name('register.step-2');
    Route::get('/register/step-3', 'Auth\RegisterController@thirdStep')->name('register.step-3');
    Route::post('/register/step-3', 'Auth\RegisterController@thirdStep')->name('register.step-3');
    Route::get('/register/success', 'Auth\RegisterController@success')->name('register.success');
    Route::get('/register/verified', 'Auth\RegisterController@verified')->name('register.verified');
    Route::get('/register/{id}/confirmation', 'Auth\RegisterController@confirmation')->name('register.confirm');

    //social login routes
    Route::get('auth/{driver}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
    Route::get('auth/{driver}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');

});

Auth::routes();


Route::group(['middleware' => ['auth', 'checkStatus']], function () {

    Route::get('/user/dashboard', 'DashboardController@index')->name('user.home');

    Route::get('/not-approved', 'HomeController@notApproved')->name('not-approved');

    Route::get('/profile/{id}/index', 'ProfileController@index')->name('profile');

    //    Alumni-directory route
    Route::get('/directory', 'AlumniDirectoryController@index')->name('alumni-directory');
    Route::get('/directory/create', 'AlumniDirectoryController@create')->name('alumni-directory.create');
    Route::post('/directory', 'AlumniDirectoryController@store')->name('alumni-directory.store');


    //    jobs route
    Route::get('/jobs', 'JobController@index')->name('jobs');
    Route::get('/jobs/create', 'JobController@create')->name('jobs.create');
    Route::post('/jobs', 'JobController@store')->name('jobs.store');


    //    donations route
    Route::get('/donations', 'DonationController@index')->name('donations');
    Route::get('/donation/create', 'DonationController@create')->name('donations.create');
    Route::post('/donations', 'DonationController@store')->name('donations.store');


    //    news/events route
    Route::get('/events-news', 'EventsNews\EventNewsController@index')->name('events-news');

    //events route
    Route::get('/events', 'EventsNews\EventController@index')->name('events');
    Route::get('/events/create', 'EventsNews\EventController@create')->name('events.create');
    Route::post('/events', 'EventsNews\EventController@store')->name('events.store');

    //news route
    Route::get('/news', 'EventsNews\NewsController@index')->name('news');

    Route::get('/user/{id}', 'ProfileController@index')->name('profile');
    Route::get('/user/{id}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('/user/{id}/edit', 'ProfileController@update')->name('profile.edit');


    Route::get('settings/password-update', 'SettingsController@passwordSettings')->name('settings.password');
    Route::post('settings/password-update', 'SettingsController@updatePasswordSettings')->name('settings.password.update');

    Route::get('settings/password-create', 'SettingsController@createPassword')->name('settings.password-create');
    Route::post('settings/password-create', 'SettingsController@storeNewPassword')->name('settings.password.create');
    Route::get('invite', 'InvitationController@index')->name('invite');

    Route::get('user/{id}/settings', 'SettingsController@editUserSettings')->name('settings.user');
    Route::post('user/{id}/settings', 'SettingsController@updateUserSettings')->name('settings.user-update');

    Route::group(['middleware' => ['role:super-admin|admin']], function () {

        Route::get('/admin/dashboard', 'DashboardController@index')->name('admin.home');

        Route::post('/about/update', 'AboutController@update')->name('about.update');
        Route::post('/home/update', 'HomeController@update')->name('home.update');
        Route::post('/committee/update', 'CommitteeController@update')->name('committee.update');

        Route::get('/news/create', 'EventsNews\NewsController@create')->name('news.create');
        Route::post('/news', 'EventsNews\NewsController@store')->name('news.store');
        Route::get('/news/batch-action', 'EventsNews\NewsController@batchAction')->name('news.batch-action');
        Route::get('/news/{id}/delete', 'EventsNews\NewsController@destroy')->name('news.destroy');
        Route::get('/news/{id}/edit', 'EventsNews\NewsController@edit')->name('news.edit');
        Route::post('/news/{id}/edit', 'EventsNews\NewsController@update')->name('news.update');

        Route::get('/donations/{id}/approve', 'DonationController@approve')->name('donations.approve');
        Route::get('/donations/{id}/edit', 'DonationController@edit')->name('donations.edit');
        Route::post('/donations/{id}/edit', 'DonationController@update')->name('donations.update');

        Route::get('/donations/{id}/delete', 'DonationController@destroy')->name('donations.destroy');
        Route::get('/donation/batch-action', 'DonationController@batchAction')->name('donations.batch-action');


        Route::get('/events/{id}/approve', 'EventsNews\EventController@approve')->name('events.approve');
        Route::get('/events/batch-action', 'EventsNews\EventController@batchAction')->name('events.batch-action');
        Route::get('/events/{id}/edit', 'EventsNews\EventController@edit')->name('events.edit');
        Route::post('/events/{id}/edit', 'EventsNews\EventController@update')->name('events.update');
        Route::get('/events/{id}/delete', 'EventsNews\EventController@destroy')->name('events.destroy');

        Route::get('/pages', 'PagesController@index')->name('pages');
        Route::get('/directory/batch-action', 'AlumniDirectoryController@batchAction')->name('alumni-directory.batchAction');

        Route::get('/directory/{id}/delete', 'AlumniDirectoryController@destroy')->name('alumni-directory.destroy');
        Route::get('/directory/{id}/confirm', 'AlumniDirectoryController@confirm')->name('alumni-directory.approve');

        Route::get('/directory/{id}/edit', 'AlumniDirectoryController@edit')->name('alumni-directory.edit');
        Route::post('/directory/{id}/edit', 'AlumniDirectoryController@update')->name('alumni-directory.update');
        Route::post('/admin/{id}/edit', 'SettingsController@update')->name('alumni-directory.update');

        Route::post('/mentorship-topics', 'MentorshipTopicController@store')->name('mentorship-topic.store');
        Route::get('/mentorship-topics/{id}/edit', 'MentorshipTopicController@edit')->name('mentorship-topic.edit');
        Route::post('/mentorship-topics/{id}/edit', 'MentorshipTopicController@update')->name('mentorship-topic.update');

        Route::get('/mentorship-topics/{id}/delete', 'MentorshipTopicController@destroy')->name('mentorship-topic.destroy');

        Route::get('/committee-member/{id}/edit', 'CommitteeController@editMember')->name('committee-member.edit');
        Route::post('/committee-member/{id}/edit', 'CommitteeController@updateMember')->name('committee-member.update');
        Route::get('/committee-member/{id}/delete', 'CommitteeController@destroyMember')->name('committee-member.destroy');
        Route::get('/home-logo/delete', 'HomeController@destroyLogo')->name('home-logo.destroy');
        Route::get('/home-background/delete', 'HomeController@destroyBackgroundImage')->name('home-background.destroy');

        Route::get('/jobs/{id}/edit', 'JobController@edit')->name('jobs.edit');
        Route::post('/jobs/{id}/edit', 'JobController@update')->name('jobs.edit');
        Route::get('/jobs/{id}/delete', 'JobController@destroy')->name('jobs.destroy');
        Route::get('/jobs/{id}/approve', 'JobController@approve')->name('jobs.approve');

        Route::get('/jobs/batch-action', 'JobController@batchAction')->name('jobs.batch-action');

        Route::get('/registered-event/batch-action', 'EventsNews\EventRegistrationController@batchAction')->name('re.batch-action');
        Route::post('/approve-registered-event', 'EventsNews\EventRegistrationController@approve')->name('re.approve');
        Route::post('/delete-registered-event', 'EventsNews\EventRegistrationController@destroy')->name('re.delete');


        Route::post('/session', 'SessionController@store')->name('session.store');
        Route::get('/session/{id}/edit', 'SessionController@edit')->name('session.edit');
        Route::post('/session/{id}/edit', 'SessionController@update')->name('session.update');
        Route::get('/session/{id}/delete', 'SessionController@destroy')->name('session.destroy');

        Route::post('/degree', 'DegreeController@store')->name('degree.store');
        Route::get('/degree/{id}/edit', 'DegreeController@edit')->name('degree.edit');
        Route::post('/degree/{id}/edit', 'DegreeController@update')->name('degree.update');
        Route::get('/degree/{id}/delete', 'DegreeController@destroy')->name('degree.destroy');


        //
    });

    Route::get('/news/{id}', 'EventsNews\NewsController@show')->name('news.show');
    Route::get('/directory/{id}', 'AlumniDirectoryController@show')->name('alumni-directory.show');
    Route::get('/events/{id}', 'EventsNews\EventController@show')->name('events.show');
    Route::get('/jobs/{id}', 'JobController@show')->name('jobs.show');
    Route::get('/donations/{id}', 'DonationController@show')->name('donations.show');

    Route::get('/feed', 'FeedController@index')->name('feed');
    Route::post('/getFeeds', 'FeedController@getFeeds')->name('feed.list');
    Route::get('/register-event/{id}', 'EventsNews\EventController@registerEvent')->name('event.register');


    // poll routes
    
    Route::get('/polls', 'Poll\PollController@index')->name('poll.home');
    
    Route::get('/polls/create', 'Poll\PollController@create')->name('poll.create');

    Route::post('/polls/store', 'Poll\PollController@store')->name('poll.store');
    
    Route::get('/polls/{id}/edit', 'Poll\PollController@edit')->name('poll.edit');

    Route::post('/polls/{id}/edit', 'Poll\PollController@update')->name('poll.update');

    Route::get('/polls/{id}/delete', 'Poll\PollController@destroy')->name('poll.destroy');

    Route::get('/polls/{id}/{status}/change-status', 'Poll\PollController@changeStatus')->name('poll.change-status');

    Route::get('/polls/{id}/vote', 'Poll\VoteController@index')->name('poll.vote');

    Route::post('/polls/{id}/vote', 'Poll\VoteController@vote')->name('poll.vote');

    Route::get('/polls/{id}/result', 'Poll\VoteController@voteResult')->name('poll.result');

    Route::get('/polls/{id}/user-vote-details', 'Poll\VoteController@userVoteDetails')->name('poll.user-vote-details');

});
