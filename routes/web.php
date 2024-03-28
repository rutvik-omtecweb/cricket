<?php

use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\UserController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TournamentController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Amin\EmailTemplateController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\HomePageContentController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\NewJoinMemberController;
use App\Http\Controllers\Admin\PaymentConfigController;
use App\Http\Controllers\Admin\PhotosController;
use App\Http\Controllers\FrontEnd\ContactUsController as FrontEndContactUsController;
use App\Http\Controllers\FrontEnd\EventPaymentController;
use App\Http\Controllers\FrontEnd\PlayerController;
use App\Http\Controllers\LiveScoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//home-page routes
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about-us', [HomeController::class, 'aboutUS'])->name('about.us');

//front-end register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/user-register', [RegisterController::class, 'registerStore'])->name('register.store');
Route::get('member-terms-condition', [HomeController::class, 'memberTermsCondition'])->name('member.terms.condition');

Auth::routes();

//admin-login routes
Route::get('admin', [LoginController::class, 'showAdminLoginForm'])->name('admin.login-view');
Route::post('admin', [LoginController::class, 'adminLogin'])->name('admin.login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//user login routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'userLogin'])->name('user.login');
Route::get('resend-user-verification', [LoginController::class, 'resentVerification'])->name('user.resend.verification');
Route::post('resend-user-verification-send', [LoginController::class, 'resentVerificationSend'])->name('user.resent.verification.send');

Route::get('user/verify/{token}', [RegisterController::class, 'verifyUserAccount'])->name('user.verify');

//contact-us route
Route::get('contact-us', [FrontEndContactUsController::class, 'contactUs'])->name('contact.us');
Route::post('contact-us', [FrontEndContactUsController::class, 'contactUsRequest'])->name('contact.us.request');

//cms-frontend route
Route::get('by-laws', [HomeController::class, 'byLaws'])->name('by.laws');
Route::get('league-rules', [HomeController::class, 'leagueRules'])->name('league.rules');

//photo-gallery route
Route::get('photo-gallery', [HomeController::class, 'photoGallery'])->name('photo.gallery');

//news-detail route
Route::get('news-list', [HomeController::class, 'newsList'])->name('news.list');
Route::get('news-detail/{id}', [HomeController::class, 'newsDetail'])->name('news.detail');

//cms page route:-
Route::get('terms-of-user', [HomeController::class, 'cmsTerm'])->name('cms.term');
Route::get('cms-pages/{id}', [HomeController::class, 'cmsPages'])->name('cms.page');
Route::get('privacy-policy', [HomeController::class, 'cmsPrivacy'])->name('cms.privacy');

//team-list route
Route::get('team-list', [HomeController::class, 'teamList'])->name('team.list');
Route::get('team-details/{id}', [HomeController::class, 'teamDetails'])->name('team.teamDetails');

//member-list route
Route::get('member-list', [HomeController::class, 'memberList'])->name('member.list');

//stripe for register member routes
Route::get('stripe/checkout/success/{id}', [RegisterController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
Route::get('stripe/checkout/cancel/{id}', [RegisterController::class, 'stripeCheckoutCancel'])->name('stripe.checkout.cancel');

//stripe for player fees routes
Route::get('stripe/checkout/success/player/{id}', [PlayerController::class, 'playerStripeCheckoutSuccess'])->name('stripe.checkout.success.player');
Route::get('stripe/checkout/cancel/player/{id}', [PlayerController::class, 'playerStripeCheckoutCancel'])->name('stripe.checkout.cancel.player');

//event-payment-stripe routes
Route::get('event-purchase-team-stripe/success/{id}', [EventPaymentController::class, 'stripePurchaseTeamSuccess'])->name('stripe.event.purchase.team.success');
Route::get('event-purchase-team-stripe/cancel/{id}', [EventPaymentController::class, 'stripeEventPaymentCancel'])->name('stripe.event.payment.cancel');

Route::get('event-join-participant-stripe/success/{id}', [EventPaymentController::class, 'stripeJoinParticipantSuccess'])->name('stripe.event.join.participant.success');

//global-search
Route::get('/search/{keyword}', [HomeController::class, 'search'])->name('search');

//event-;ist routes
Route::get('event-list', [HomeController::class, 'eventList'])->name('event.list');
Route::get('event-detail/{id}', [HomeController::class, 'eventDetail'])->name('event.detail');
Route::get('become-player', [HomeController::class, 'becomePlayer'])->name('become.player');
Route::get('player-list', [HomeController::class, 'PlayerList'])->name('player.list');


Route::group(['middleware' => ['auth', 'role:super admin|admin', 'prevent-back-history'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    //dashboard route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //profile routes
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('profile-update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('password-update', [ProfileController::class, 'updatePassword'])->name('password.update');

    //banner routes
    Route::resource('banners', BannerController::class);
    Route::get('get-banner', [BannerController::class, 'getBanner'])->name('get.banner');
    Route::get('toggle-banner/{id}', [BannerController::class, 'toggleBanner'])->name('toggle.banner');

    //home-page-content routes
    Route::resource('home-content', HomePageContentController::class);
    Route::get('get-home-page-content', [HomePageContentController::class, 'getHomePageContent'])->name('get.home.content');

    //news routes
    Route::resource('news', NewsController::class);
    Route::get('get-news', [NewsController::class, 'getNews'])->name('get.news');
    Route::get('toggle-news/{id}', [NewsController::class, 'toggleNews'])->name('toggle.news');
    Route::post('update-outer-news', [NewsController::class, 'updateOuterNews'])->name('update.outer.news');

    //tournaments routes
    Route::resource('tournaments', TournamentController::class);
    Route::get('get-tournaments', [TournamentController::class, 'getTournaments'])->name('get.tournaments');
    Route::get('toggle-tournaments/{id}', [TournamentController::class, 'toggleTournament']);

    Route::resource('photos', PhotosController::class);
    Route::get('get-photos', [PhotosController::class, 'getPhotos'])->name('get.photos');
    Route::get('toggle-photos/{id}', [PhotosController::class, 'togglePhotos'])->name('toggle.photos');

    //sponsors routes
    Route::resource('sponsors', SponsorController::class);
    Route::get('get-sponsors', [SponsorController::class, 'getSponsors'])->name('get.sponsors');
    Route::get('toggle-sponsors/{id}', [SponsorController::class, 'toggleSponsors']);
    Route::post('update-sponsors/{id}', [SponsorController::class, 'updateSponsor'])->name('update.sponsor');

    //cms routes
    Route::resource('cms', CMSController::class);
    Route::get('get-cms', [CMSController::class, 'getCMS'])->name('get.cms');
    Route::get('toggle-cms/{id}', [CMSController::class, 'toggleCMS']);

    //about-us route
    Route::get('about-us', [AboutUsController::class, 'index'])->name('about.us');
    Route::post('about-us', [AboutUsController::class, 'storeAboutUS'])->name('about.us.store');

    //contact-us controller
    Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact.us');
    Route::get('get-contact-us', [ContactUsController::class, 'getContactUs'])->name('get.contact.us');
    Route::delete('contact-us/{id}', [ContactUsController::class, 'delete']);

    //email-template route[setting]
    Route::resource('email-template', EmailTemplateController::class);
    Route::get('get-email-template/{id}', [EmailTemplateController::class, 'getEmailTemplate'])->name('get.email.template');

    Route::resource('testimonials', TestimonialController::class);

    //team route
    Route::resource('teams', TeamController::class);
    Route::get('get-teams', [TeamController::class, 'getTeams'])->name('get.teams');
    Route::get('toggle-teams/{id}', [TeamController::class, 'toggleTeam'])->name('toggle.teams');

    //general setting route
    Route::get('general-setting', [GeneralSettingController::class, 'index'])->name('general.setting');
    Route::put('general-update/{id}', [GeneralSettingController::class, 'settingUpdate'])->name('general.setting.update');

    //member list route
    Route::resource('members', MemberController::class);
    Route::get('get-member', [MemberController::class, 'getMember'])->name('get.member');
    Route::get('toggle-member/{id}', [MemberController::class, 'toggleMember'])->name('toggle.member');
    Route::post('members/import', [MemberController::class, 'import'])->name('members.import');

    //new-join-member that approve route
    Route::resource('new-join-member', NewJoinMemberController::class);
    Route::get('get-new-member', [NewJoinMemberController::class, 'getNewMember'])->name('get.new.member');
    Route::get('toggle-new-member/{id}', [NewJoinMemberController::class, 'toggleNewMember'])->name('toggle.new.member');

    //events route
    Route::resource('events', EventController::class);
    Route::get('get-events', [EventController::class, 'getEvents'])->name('get.events');
    Route::get('toggle-event/{id}', [EventController::class, 'toggleEvent']);

    //events route
    Route::resource('payment', PaymentConfigController::class);

    // Purchase team routes
    Route::get('purchase-team-view/{id}', [EventController::class, 'purchaseTeamView'])->name('purchase.team.view');
    Route::get('purchase-team-list', [EventController::class, 'purchaseTeamList'])->name('purchase.team.list');

    // Participant team routes
    Route::get('event-participant-payment-view/{id}', [EventController::class, 'ParticipantView'])->name('event.participant.payment.view');
    Route::get('event-participant-payment-list/', [EventController::class, 'ParticipantList'])->name('participant.payment.list');

    //live-score
    Route::resource('live-score', LiveScoreController::class);

    //admin-user
    Route::resource('admin-user', AdminUserController::class);
    Route::get('get-adminuser', [AdminUserController::class, 'getAdminUser'])->name('get.admin.user');
    Route::get('toggle-adminuser/{id}', [AdminUserController::class, 'toggleAdminUser']);
});

Route::get('/load-more-images', [HomeController::class, 'loadMoreImages'])->name('loadMoreImages');

Route::group(['middleware' => ['auth', 'role:member', 'prevent-back-history']], function () {

    Route::get('profile', [UserController::class, 'profileIndex'])->name('profile');
    Route::post('profile-update', [UserController::class, 'profileUpdate'])->name('profile-update');
    Route::post('update-password', [UserController::class, 'updatePassword'])->name('update.password');

    //purchase team route
    Route::post('purchase-team', [EventPaymentController::class, 'purchaseTeam'])->name('purchase.team');
    Route::post('join-participant', [EventPaymentController::class, 'joinParticipant'])->name('join.participant');

    Route::post('join-player', [PlayerController::class, 'joinPlayer'])->name('join.player');
});
