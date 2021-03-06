<?php
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('auth.login');
})->middleware(['guest']);

Route::get('/dashboard', 'HomeController@index')->name('home')->middleware(['auth', 'checkProfile']);

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('/profile', 'Account\ProfileController');
    Route::post('/meta-data/{user}', 'Account\MetaDataController@store')->name('meta.store');
    Route::resource('/skills', 'Applicant\SkillsController');
});

Route::middleware(['auth', 'checkProfile'])->group(function () {
    Route::resource('/jobs', 'Employer\JobsController');

    Route::post('/jobs/{job}/create/job-board', 'Employer\JobBoardController@store')->name('job.board.store');

    Route::post('/application/{applicant}/update-status', 'Employer\ApplicantController@updateStatus')->name('applicants.update.status');

    Route::get('/applicants/{job}/{board}', 'Employer\ApplicantController@index')->name('applicants.index');

    Route::get('/manage-applicants/{job}', 'Employer\ApplicantController@manage')->name('applicants.manage');

    Route::resource('applicants', 'Employer\ApplicantController')->except(
        'index', 'store'
    );

    Route::get('/credit/buy-credit', 'Employer\CreditController@create')->name('credit.create');
    Route::post('/credit/buy-credit', 'Employer\CreditController@store')->name('credit.store');

    Route::resource('/talents', 'Employer\TalentsController');

});

Route::middleware(['auth', 'checkProfile'])->group(function () {
    Route::resource('/conversation', 'Account\ConversationController')->except(
        'create', 'show', 'edit', 'update'
    );

    Route::post('/conversation/{conversation}/reply', 'Account\ConversationController@reply')->name('conversation.reply');

    Route::get('/conversation/{conversation}/read', 'Account\ConversationController@read')->name('conversation.read');
});

Route::middleware(['auth', 'checkProfile'])->prefix('app')->group(function () {
    Route::resource('/jobs', 'Applicant\JobsController', [
        'as' => 'app'
    ]);

    Route::post('/jobs/apply/{job}', 'Applicant\ApplicantController@store')->name('application.store');

    Route::resource('application', 'Applicant\ApplicantController')->except(
        'store'
    );
});
