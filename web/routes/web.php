<?php
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AgreementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CaseTypeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\ApplyCareerController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Http\Controllers\Message;
use App\Http\Controllers\Admin\MoveBarController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AboutUsPageController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServicesPageController;
use App\Http\Controllers\Admin\ExecutiveCaseController;
use App\Http\Controllers\Admin\ProceduralRecordController;
use App\Http\Controllers\Admin\SettlementActionController;




Route::get('change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        Session::put('locale', $lang);
        App::setLocale($lang);
    }
    return Redirect::back();
})->name('change.language');


Route::group(['middleware' => ['setLanguage']], function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');
    Route::get('/about-us', [AboutUsPageController::class, 'index'])->name('about-us');
    Route::get('/services', [ServicesPageController::class, 'index'])->name('services');

    // Apply Career Routes
    Route::get('/apply-careers', [ApplyCareerController::class, 'index'])->name('apply-careers.index');
    Route::get('/apply-careers/create', [ApplyCareerController::class, 'create'])->name('apply-careers.create');
    Route::post('/apply-careers', [ApplyCareerController::class, 'store'])->name('apply-careers.store');
    Route::get('/apply-careers/{id}', [ApplyCareerController::class, 'show'])->name('apply-careers.show');
    Route::get('/apply-careers/{id}/edit', [ApplyCareerController::class, 'edit'])->name('apply-careers.edit');
    Route::put('/apply-careers/{id}', [ApplyCareerController::class, 'update'])->name('apply-careers.update');
    Route::delete('/apply-careers/{id}', [ApplyCareerController::class, 'destroy'])->name('apply-careers.destroy');

    // Auth Routes
    Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login1');
    Route::post('/login', [AuthLoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');
});

Route::get('/user', function () {

    return view('user.auth.login');
});
// Route::get('/', function () {
//     if (Auth::check()) {
//         if (Auth::user()->role == 'superadmin') {
//             return redirect()->route('admin.dashboard');
//         } elseif (Auth::user()->role == 'User') {
//             return redirect()->route('user.dashboard');
//         }
//     }
//     return view('admin.auth.login');
// });




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'check_role:superadmin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    Route::get('/visit-clients', [ClientController::class, 'visit'])->name('client.visit');

    Route::get('/action-clients', [ClientController::class, 'action'])->name('client.action');
    Route::delete('/action-client/delete', [ClientController::class, 'destroy1'])->name('client.action.delete');
    Route::POST('/action-client/store', [ClientController::class, 'store1'])->name('client.action.store');
    Route::post('/action-client/action/{id}', [ClientController::class, 'update1'])->name('client.action.update');

    Route::POST('/action-sub/store', [ClientController::class, 'store2'])->name('client.subaction.store');


    Route::get('/client/delete', [ClientController::class, 'indexDelete'])->name('client.indexDelete');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('client.create');
    Route::POST('/clientstore', [ClientController::class, 'store'])->name('client.store');
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::post('/clients/{id}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/delete', [ClientController::class, 'destroy'])->name('client.delete');
    Route::get('/client/{id}/restore', [ClientController::class, 'restore'])->name('client.restore');

    Route::get('/request-client', [ClientRequestController::class, 'index'])->name('request.index');
    Route::post('/request-client', [ClientRequestController::class, 'replay'])->name('request.reply');
    Route::post('/request-client/modify', [ClientRequestController::class, 'replayModify'])->name('request.replayModify');
    Route::get('/request-client/create', [ClientRequestController::class, 'create'])->name('request.create');
    Route::POST('/request-client/store', [ClientRequestController::class, 'store'])->name('request.store');
    Route::get('/request-client/{id}/edit', [ClientRequestController::class, 'edit'])->name('request.edit');
    Route::post('/request-client/{id}', [ClientRequestController::class, 'update'])->name('request.update');
    Route::get('/request-client/delete/{id}', [ClientRequestController::class, 'destroy'])->name('request.delete');

    Route::get('/lawyers', [LawyerController::class, 'index'])->name('lawyer.index');
    Route::get('/lawyer/delete', [LawyerController::class, 'indexDelete'])->name('lawyer.indexDelete');
    Route::get('/lawyers/create', [LawyerController::class, 'create'])->name('lawyer.create');
    Route::POST('/lawyerstore', [LawyerController::class, 'store'])->name('lawyer.store');
    Route::get('/lawyers/{id}/edit', [LawyerController::class, 'edit'])->name('lawyer.edit');
    Route::post('/lawyers/{id}', [LawyerController::class, 'update'])->name('lawyer.update');
    Route::delete('/lawyer/delete', [LawyerController::class, 'destroy'])->name('lawyer.delete');
    Route::get('/lawyer/{id}/restore', [LawyerController::class, 'restore'])->name('lawyer.restore');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/delete', [UserController::class, 'indexDelete'])->name('user.indexDelete');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::POST('/userstore', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
  
  Route::get('/agreements', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('/agreements/create', [AgreementController::class, 'create'])->name('agreement.create');
    Route::post('/agreements', [AgreementController::class, 'store'])->name('agreement.store');
    Route::get('/agreements/{id}/edit', [AgreementController::class, 'edit'])->name('agreement.edit');
    Route::post('/agreements/{id}', [AgreementController::class, 'update'])->name('agreement.update');
    Route::delete('/agreement/delete', [AgreementController::class, 'destroy'])->name('agreement.delete');
    Route::get('/agreements/deleted', [AgreementController::class, 'indexDelete'])->name('agreement.indexDelete');
    Route::get('/agreement/{id}/restore', [AgreementController::class, 'restore'])->name('agreement.restore');
    Route::get('/agreements/{id}', [AgreementController::class, 'show'])->name('agreement.show');
  
    Route::get('/settlements', [SettlementController::class, 'index'])->name('settlement.index');
    Route::get('/settlements/create', [SettlementController::class, 'create'])->name('settlement.create');
    Route::post('/settlements', [SettlementController::class, 'store'])->name('settlement.store');
    Route::get('/settlements/{id}/edit', [SettlementController::class, 'edit'])->name('settlement.edit');
    Route::post('/settlements/{id}', [SettlementController::class, 'update'])->name('settlement.update');
    Route::delete('/settlement/delete', [SettlementController::class, 'destroy'])->name('settlement.delete');
    Route::get('/settlements/deleted', [SettlementController::class, 'indexDelete'])->name('settlement.indexDelete');
    Route::get('/settlement/{id}/restore', [SettlementController::class, 'restore'])->name('settlement.restore');
    Route::get('/settlements/{id}', [SettlementController::class, 'show'])->name('settlement.show');


   Route::get('/executive-cases/type/{id}', [ExecutiveCaseController::class, 'index'])->name('executive-case.index');
    Route::get('/executive-cases/type/{id}/create', [ExecutiveCaseController::class, 'create'])->name('executive-case.create');
    Route::post('/executive-cases', [ExecutiveCaseController::class, 'store'])->name('executive-case.store');
    Route::get('/executive-cases/{id}/edit', [ExecutiveCaseController::class, 'edit'])->name('executive-case.edit');
    Route::post('/executive-cases/{id}', [ExecutiveCaseController::class, 'update'])->name('executive-case.update');
    Route::delete('/executive-case/delete', [ExecutiveCaseController::class, 'destroy'])->name('executive-case.delete');
    Route::get('/executive-cases/deleted', [ExecutiveCaseController::class, 'indexDelete'])->name('executive-case.indexDelete');
    Route::get('/executive-case/{id}/restore', [ExecutiveCaseController::class, 'restore'])->name('executive-case.restore');
    Route::get('/executive-cases/{id}', [ExecutiveCaseController::class, 'show'])->name('executive-case.show');

    // ProceduralRecord admin routes
    Route::get('/procedural-records', [ProceduralRecordController::class, 'index'])->name('procedural-record.index');
    Route::get('/procedural-records/{case_id?}', [ProceduralRecordController::class, 'index'])->name('procedural-record.index');
    Route::get('/procedural-records/create/{case_id?}', [ProceduralRecordController::class, 'create'])->name('procedural-record.create');
    Route::get('/procedural-records/{id}/edit', [ProceduralRecordController::class, 'edit'])->name('procedural-record.edit');
    Route::get('/procedural-records/{id}/show/{case_id?}', [ProceduralRecordController::class, 'show'])->name('procedural-record.show');

  
    Route::get('/chat/admin/{userId?}', [Message::class, 'index'])->name('chat.with');
      Route::get('/chat/lawyer/{userId?}', [Message::class, 'index2'])->name('chat.with1');
        Route::get('/chat/user/{userId?}', [Message::class, 'index3'])->name('chat.with2');

 Route::get('/settlement-actions/{settlement_id}', [SettlementActionController::class, 'index'])->name('settlement-action.list');
Route::get('/settlement-actions/{settlement_id}/create', [SettlementActionController::class, 'create'])->name('settlement-action.create');
Route::get('/settlement-actions/{id}/edit', [SettlementActionController::class, 'edit'])->name('settlement-action.edit');
Route::get('/settlement-actions/{settlement_id}/deleted', [SettlementActionController::class, 'deleted'])->name('settlement-action.deleted');
Route::get('/settlement-actions/{id}/show', [SettlementActionController::class, 'show'])->name('settlement-action.show');


    Route::get('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'تم تعليم الإشعار كمقروء.');
    })->name('notifications.read');

    // Case Types Routes
    Route::get('/casetypes', [CaseTypeController::class, 'index'])->name('casetypes.index');
    Route::get('/casetypes/create', [CaseTypeController::class, 'create'])->name('casetypes.create');
    Route::post('/casetypes', [CaseTypeController::class, 'store'])->name('casetypes.store');
    Route::get('/casetypes/{id}/edit', [CaseTypeController::class, 'edit'])->name('casetypes.edit');
    Route::post('/casetypes/{id}', [CaseTypeController::class, 'update'])->name('casetypes.update');
    Route::get('/casetypes/{id}/delete', [CaseTypeController::class, 'destroy'])->name('casetypes.destroy');

    // AboutUs Routes
    Route::get('/aboutus', [AboutUsController::class, 'index'])->name('aboutus.index');
    Route::get('/aboutus/create', [AboutUsController::class, 'create'])->name('aboutus.create');
    Route::post('/aboutus', [AboutUsController::class, 'store'])->name('aboutus.store');
    Route::get('/aboutus/{id}/edit', [AboutUsController::class, 'edit'])->name('aboutus.edit');
    Route::post('/aboutus/{id}', [AboutUsController::class, 'update'])->name('aboutus.update');
    Route::get('/aboutus/{id}/delete', [AboutUsController::class, 'destroy'])->name('aboutus.destroy');

    // SocialLink Routes
    Route::get('/social-links', [SocialLinkController::class, 'index'])->name('sociallinks.index');
    Route::get('/social-links/edit', [SocialLinkController::class, 'edit'])->name('sociallinks.edit');
    Route::put('/social-links', [SocialLinkController::class, 'update'])->name('sociallinks.update');

    // Slider Routes
    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::put('/sliders/{id}', [SliderController::class, 'update'])->name('sliders.update');
    Route::get('/sliders/{id}/delete', [SliderController::class, 'destroy'])->name('sliders.destroy');

    // Move Bar Routes
    Route::get('/move-bars', [MoveBarController::class, 'index'])->name('move-bars.index');
    Route::get('/move-bars/create', [MoveBarController::class, 'create'])->name('move-bars.create');
    Route::post('/move-bars', [MoveBarController::class, 'store'])->name('move-bars.store');
    Route::get('/move-bars/{id}/edit', [MoveBarController::class, 'edit'])->name('move-bars.edit');
    Route::post('/move-bars/{id}', [MoveBarController::class, 'update'])->name('move-bars.update');
    Route::delete('/move-bars/{id}/delete', [MoveBarController::class, 'destroy'])->name('move-bars.destroy');

    // Career Routes
    Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
    Route::get('/careers/create', [CareerController::class, 'create'])->name('careers.create');
    Route::post('/careers', [CareerController::class, 'store'])->name('careers.store');
    Route::get('/careers/{id}/edit', [CareerController::class, 'edit'])->name('careers.edit');
    Route::post('/careers/{id}', [CareerController::class, 'update'])->name('careers.update');
    Route::delete('/careers/{id}/delete', [CareerController::class, 'destroy'])->name('careers.destroy');
    Route::get('/apply-careers', [CareerController::class, 'apply'])->name('apply-careers.all');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'check_role:User']], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');

    Route::get('/request-client', [ClientRequestController::class, 'index1'])->name('user.request.index');
    Route::get('/request-client/create', [ClientRequestController::class, 'create'])->name('user.request.create');
    Route::POST('/request-client/store', [ClientRequestController::class, 'store'])->name('user.request.store');



    Route::get('/chat/{userId?}', [Message::class, 'index1'])->name('user.chat.with');

    Route::get('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'تم تعليم الإشعار كمقروء.');
    })->name('notifications.read');
});

Route::group(['prefix' => 'admin', 'middleware' => 'guest'], function () {
    Route::get('/', [LoginController::class, 'showLogin'])->name('login');
    Route::POST('login', [LoginController::class, 'login'])->name('admin.login');
});
Route::group(['prefix' => 'user', 'middleware' => 'guest'], function () {
    Route::get('/login', [UserLoginController::class, 'showLogin'])->name('login.user');
    Route::POST('login', [UserLoginController::class, 'login'])->name('user.login');
});

// Welcome Page Route
