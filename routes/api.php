<?php

Route::group(['middleware' => ['auth:api']], function () {
    // Administrator routes
    Route::post('/admin/check', 'AdminController@isAdministrator'); // checked 
    Route::get('/admin/users', 'AdminController@indexUsers'); // checked 
    Route::get('/admin/comments', 'AdminController@indexComments'); // checked 
    Route::get('/admin/channels', 'AdminController@indexChannels'); // checked 
    Route::get('/admin/channels/inactive', 'AdminController@inactiveChannels'); // checked
    Route::get('/admin/submissions', 'AdminController@indexSubmissions'); // checked 
    Route::get('/admin/suggesteds', 'SuggestionController@adminIndex'); // checked 
    Route::post('/admin/suggesteds', 'SuggestionController@store'); // checked 
    Route::delete('/admin/suggesteds/{suggested}', 'SuggestionController@destroy'); // checked 
    Route::get('/admin/reports/comments', 'AdminController@reportedComments'); // checked 
    Route::get('/admin/reports/submissions', 'AdminController@reportedSubmissions'); // checked 
    Route::get('/admin/activities', 'AdminController@activities'); // checked 
    Route::get('/admin/echo', 'AdminController@echoServer'); // checked 
    Route::get('/admin/statistics', 'AdminController@statistics'); // checked 

    // feedback
    Route::get('/feedbacks/{feedback}', 'FeedbacksController@get')->middleware('voten-administrator'); // checked
    Route::get('/feedbacks', 'FeedbacksController@index')->middleware('voten-administrator'); // checked
    Route::post('/feedbacks', 'FeedbacksController@store')->middleware('shadow-ban'); // checked
    Route::delete('/feedbacks/{feedback}', 'FeedbacksController@destroy')->middleware('voten-administrator'); // checked

    // user
    Route::get('/users/store', 'StoreController@index'); // checked 
    Route::delete('/users', 'UserController@destroyAsAuth'); // checked 
    Route::delete('/admin/users', 'UserController@destroyAsVotenAdministrator')->middleware('voten-administrator'); // checked 
    Route::patch('/users/profile', 'UserSettingsController@profile'); // checked 
    Route::patch('/users/account', 'UserSettingsController@account'); // checked 
    Route::patch('/users/email', 'UserSettingsController@email'); // checked 
    Route::patch('/users/password', 'UserSettingsController@password'); // checked 
    Route::get('/users/submissions/likeds', 'UserController@likedSubmissions'); // checked 
    Route::post('/email/verify/resend', 'Auth\VerificationController@resendVerifyEmailAddress'); // checked 
    Route::post('/users/clientside-settings', 'ClientsideSettingsController@store'); // checked 
    Route::get('/users/clientside-settings', 'ClientsideSettingsController@get'); // checked 
    Route::post('/users/{user}/bookmark', 'BookmarksController@bookmarkUser'); // checked 
    Route::get('/users/bookmarked', 'BookmarksController@getBookmarkedUsers'); // checked 

    // submission
    Route::post('/submissions', 'SubmissionController@store')->middleware('shadow-ban'); // checked 
    Route::patch('/submissions/{submission}', 'SubmissionController@patchTextSubmission'); // checked 
    Route::delete('/submissions/{submission}', 'SubmissionController@destroy'); // checked 
    Route::post('/submissions/{submission}/hide', 'BlockSubmissionsController@store'); // checked 
    Route::delete('/submissions/{submission}/hide', 'BlockSubmissionsController@destroy'); // checked 
    Route::get('/links/title', 'SubmissionController@getTitleAPI'); // checked 
    Route::post('/submissions/{submission}/nsfw', 'NsfwController@store'); // checked 
    Route::delete('/submissions/{submission}/nsfw', 'NsfwController@destroy'); // checked 
    Route::delete('/submissions/{submission}/thumbnail', 'SubmissionController@removeThumbnail'); // checked 
    Route::post('/submissions/{submission}/like', 'SubmissionLikesController@like'); // checked
    Route::post('/submissions/{submission}/bookmark', 'BookmarksController@bookmarkSubmission'); // checked 
    Route::get('/submissions/bookmarked', 'BookmarksController@getBookmarkedSubmissions'); // checked 

    // Comment
    Route::post('/comments', 'CommentController@store')->middleware('shadow-ban'); // checked
    Route::patch('/comments/{comment}', 'CommentController@patch'); // checked
    Route::delete('/comments/{comment}', 'CommentController@destroy'); // checked
    Route::post('/comments/{comment}/like', 'CommentLikesController@like'); // checked
    Route::post('/comments/{comment}/bookmark', 'BookmarksController@bookmarkComment'); // checked
    Route::get('/comments/bookmarked', 'BookmarksController@getBookmarkedComments'); // checked  

    // channel
    Route::post('/channels', 'ChannelController@store')->middleware('shadow-ban'); // checked
    Route::patch('/channels/{channel}', 'ChannelController@patch')->middleware('administrator'); // checked 
    Route::post('/channels/{channel}/block', 'BlockChannelsController@block'); // checked 
    Route::post('/channels/{channel}/destroy', 'ChannelController@destroy')->middleware('voten-administrator'); // checked 
    Route::post('/channels/{channel}/bookmark', 'BookmarksController@bookmarkChannel'); // checked 
    Route::get('/channels/bookmarked', 'BookmarksController@getBookmarkedChannels'); // checked 
    Route::get('/channels/discover', 'SuggestionController@discover'); // checked 
    Route::post('/channels/{channel}/subscribe', 'SubscribeController@subscribe'); // checked
    Route::get('/channels/subscribed', 'SubscribeController@index'); // checked 

    // rule
    Route::post('/channels/{channel}/rules', 'RulesController@store')->middleware('administrator'); // checked 
    Route::patch('/channels/{channel}/rules/{rule}', 'RulesController@patch')->middleware('administrator'); // checked 
    Route::delete('/channels/{channel}/rules/{rule}', 'RulesController@destroy')->middleware('administrator'); // checked 

    // block domain
    Route::get('/channels/{channel}/blocked-domains', 'BlockDomainController@indexAsChannelModerator')->middleware('moderator'); // checked 
    Route::post('/channels/{channel}/blocked-domains', 'BlockDomainController@storeAsChannelModerator')->middleware('moderator'); // checked 
    Route::delete('/channels/{channel}/blocked-domains/{domain}', 'BlockDomainController@destroyAsChannelModerator')->middleware('moderator'); // checked 
    // (admin)
    Route::get('/admin/domains/block', 'BlockDomainController@indexAsVotenAdministrator')->middleware('voten-administrator');
    Route::post('/admin/domains/block', 'BlockDomainController@storeAsVotenAdministrator')->middleware('voten-administrator');
    Route::delete('/admin/domains/block', 'BlockDomainController@destroyAsVotenAdministrator')->middleware('voten-administrator');

    // ban user
    Route::post('/channels/{channel}/banned-users', 'BanController@storeAsChannelModerator')->middleware('moderator'); // checked 
    Route::get('/channels/{channel}/banned-users', 'BanController@indexAsChannelModerator')->middleware('moderator'); // checked 
    Route::delete('/channels/{channel}/banned-users/{user}', 'BanController@destroyAsChannelModerator')->middleware('moderator'); // checked 
    // (admin)
    Route::post('/admin/banned-users', 'BanController@storeAsVotenAdministrator')->middleware('voten-administrator'); // checked 
    Route::get('/admin/banned-users', 'BanController@indexAsVotenAdministrator')->middleware('voten-administrator'); // checked 
    Route::delete('/admin/banned-users/{user}', 'BanController@destroyAsVotenAdministrator')->middleware('voten-administrator'); // checked 

    // moderation
    Route::post('/channels/{channel}/moderators', 'ModeratorController@store')->middleware('administrator'); // checked 
    Route::delete('/channels/{channel}/moderators/{user}', 'ModeratorController@destroy')->middleware('administrator'); // checked
    Route::post('/approve-comment', 'ModeratorController@approveComment');
    Route::post('/approve-submission', 'ModeratorController@approveSubmission');
    Route::post('/disapprove-comment', 'ModeratorController@disapproveComment');
    Route::post('/disapprove-submission', 'ModeratorController@disapproveSubmission');

    // messages
    Route::post('/messages', 'MessagesController@store')->middleware('shadow-ban');
    Route::get('/messages', 'MessagesController@index');
    Route::delete('/messages', 'MessagesController@destroy');
    Route::post('/messages/read', 'MessagesController@markAsRead');

    // conversations
    Route::get('/conversations', 'ConversationsController@index');
    Route::delete('/conversations', 'ConversationsController@destroy');
    Route::post('/conversations/read', 'ConversationsController@broadcastConversaionAsRead');
    Route::post('/conversations/block', 'ConversationsController@block');
    Route::get('/conversations/search', 'SearchController@conversations');

    // Photo uploading
    Route::post('/channels/{channel}/avatar', 'PhotoController@channelAvatar')->middleware('administrator');
    Route::post('/users/avatar', 'PhotoController@userAvatar')->middleware('shadow-ban');
    Route::post('/photos', 'PhotoController@store')->middleware('shadow-ban');
    // Route::post('/gifs', 'GifController@store')->middleware('shadow-ban');

    // notification
    Route::get('/notifications', 'NotificationsController@index'); // checked 
    Route::post('/notifications', 'NotificationsController@markAsRead'); // checked 

    // report
    Route::post('/comments/reports', 'ReportCommentsController@store')->middleware('shadow-ban');
    Route::get('/comments/reports', 'ReportCommentsController@index');
    Route::post('/submissions/reports', 'ReportSubmissionsController@store')->middleware('shadow-ban');
    Route::get('/submissions/reports', 'ReportSubmissionsController@index');

    Route::post('/announcement/seen', 'AnnouncementController@seen');

    Route::get('/suggested-channel', 'SuggestionController@channel');

    ////////////////////////////////////////////////////////////////////////
    // Below routes have a twin route prefixed with "guest"
    ////////////////////////////////////////////////////////////////////////
    Route::get('/users', 'UserController@get');
    Route::get('/feed', 'HomeController@feed');
    Route::get('/channels/submissions', 'ChannelController@submissions');
    Route::get('/announcement', 'AnnouncementController@get');

    Route::get('/submissions', 'SubmissionController@get');
    Route::get('/submissions/{submission}/comments', 'CommentController@index');
    Route::get('/channels/{channel}/moderators', 'ModeratorController@index'); // checked 
    Route::get('/channels/rules', 'RulesController@index');
    Route::get('/emojis', 'EmojiController@index');
    Route::get('/submissions/photos', 'SubmissionController@getPhotos');
    Route::get('/search', 'SearchController@index');
    Route::get('/channels', 'ChannelController@get');
    Route::get('/users/submissions', 'UserController@submissions');
    Route::get('/users/comments', 'UserController@comments');
    Route::get('/submissions/comments', 'CommentController@index');
});

////////////////////////////////////////////////////////////////////////
// Below routes are the twin routes for guests
////////////////////////////////////////////////////////////////////////
Route::prefix('guest')->group(function () {
    Route::get('/users', 'UserController@get');
    Route::get('/feed', 'HomeController@feed');
    Route::get('/channels/submissions', 'ChannelController@submissions');
    Route::get('/announcement', 'AnnouncementController@get');

    Route::get('/submissions', 'SubmissionController@get');
    Route::get('/submissions/{submission}/comments', 'CommentController@index');
    Route::get('/channels/{channel}/moderators', 'ModeratorController@index'); // checked 
    Route::get('/channels/rules', 'RulesController@index');
    Route::get('/emojis', 'EmojiController@index');
    Route::get('/submissions/photos', 'SubmissionController@getPhotos');
    Route::get('/search', 'SearchController@index');
    Route::get('/channels', 'ChannelController@get');
    Route::get('/users/submissions', 'UserController@submissions');
    Route::get('/users/comments', 'UserController@comments');
    Route::get('/submissions/comments', 'CommentController@index');
});

Route::post('/token/login', 'Auth\LoginController@getAccessToken');
Route::post('/token/register', 'Auth\RegisterController@getAccessToken');