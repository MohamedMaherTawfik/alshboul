<?php
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\CaseController;
use App\Http\Controllers\Admin\CaseNotesController;
use App\Http\Controllers\Admin\DurationController;
use App\Http\Controllers\Admin\editController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\PublicSearchController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AgreementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CaseTypeController;
use App\Http\Controllers\Admin\SettlementProceduralController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TrashedController;
use App\Http\Controllers\ApplyCareerController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\visitorReviewController;
use App\Http\Middleware\roleMiddleware;
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
    Route::post('/', [visitorReviewController::class, 'store'])->name('review');
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
    Route::post('/login', [AuthLoginController::class, 'login'])->name('loginclient');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');
});

Route::get('/user', function () {

    return view('user.auth.login');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', roleMiddleware::class]], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    Route::get('/visit-clients', [ClientController::class, 'visit'])->name('client.visit');

    Route::get('/action-clients', [ClientController::class, 'clientProcedural'])->name('client.action.index');
    Route::get('/action-clients/client/{client}', [ClientController::class, 'ClientShowProcedural'])->name('client.show');
    Route::get('/action-clients/client/{client}/procedural', [ClientController::class, 'showProcedural'])->name('client.procedural.sub.index');
    Route::post('/action-clients/client/{client}/procedural/storeSub', [ClientController::class, 'storeSub'])->name('subprocedural.store');
    Route::post('/action-clients/client/{client}/store', [ClientController::class, 'clientstoreProcedural'])->name('client.procedural.store');
    Route::post('/action-clients/client/{client}/store/file/add', [ClientController::class, 'addFile'])->name('Client.procedural.add.file');
    Route::post('/action-clients/client/{client}/update', [ClientController::class, 'clientUpdateProcedural'])->name('client.procedural.update');
    Route::delete('/action-clients/client/{client}/delete', [ClientController::class, 'clientDeleteProcedural'])->name('client.procedural.delete');
    Route::delete('/action-client/delete', [ClientController::class, 'destroy1'])->name('client.action.delete');
    Route::POST('/action-client/store', [ClientController::class, 'store1'])->name('client.action.store');
    Route::post('/action-client/action/{id}', [ClientController::class, 'update1'])->name('client.action.update');

    Route::POST('/action-sub/store', [ClientController::class, 'store2'])->name('client.subaction.store');


    Route::get('/client/delete', [ClientController::class, 'indexDelete'])->name('client.indexDelete');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('client.create');
    Route::POST('/clientstore', [ClientController::class, 'store'])->name('client.store');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::post('/clients/{client}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/{client}/delete', [ClientController::class, 'destroy'])->name('client.delete');
    Route::get('/client/{client}/restore', [ClientController::class, 'restore'])->name('client.restore');

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

    Route::get('/careers/all', [CareerController::class, 'indexAdmin'])->name('career.index');
    Route::get('/careers/all', [CareerController::class, 'createC'])->name('career.index');
    Route::get('/careers/all', [CareerController::class, 'indexAdmin'])->name('career.index');

    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('/agreements/create', [AgreementController::class, 'create'])->name('agreement.create');
    Route::post('/agreements', [AgreementController::class, 'store'])->name('agreement.store');
    Route::get('/agreements/{id}/edit', [AgreementController::class, 'edit'])->name('agreement.edit');
    Route::post('/agreements/{id}', [AgreementController::class, 'update'])->name('agreement.update');
    Route::delete('/agreement/delete', [AgreementController::class, 'destroy'])->name('agreement.delete');
    Route::get('/agreements/deleted', [AgreementController::class, 'indexDelete'])->name('agreement.indexDelete');
    Route::get('/agreement/{id}/restore', [AgreementController::class, 'restore'])->name('agreement.restore');
    Route::get('/agreements/{id}', [AgreementController::class, 'show'])->name('agreement.show');

    Route::get('/settlements/{settlements}/all', [SettlementController::class, 'index'])->name('settlement.index');
    Route::get('/settlements/{settlements}/create/new', [SettlementController::class, 'create'])->name('settlement.create');
    Route::post('/settlements/{settlements}/store/new', [SettlementController::class, 'store'])->name('settlement.store');
    Route::get('/settlements/{id}/edit', [SettlementController::class, 'edit'])->name('settlement.edit');
    Route::post('/settlements/{id}', [SettlementController::class, 'update'])->name('settlement.update');
    Route::delete('/settlement/delete', [SettlementController::class, 'destroy'])->name('settlement.delete');
    Route::get('/settlements/deleted', [SettlementController::class, 'indexDelete'])->name('settlement.indexDelete');
    Route::get('/settlement/{id}/restore', [SettlementController::class, 'restore'])->name('settlement.restore');
    Route::get('/settlements/{id}', [SettlementController::class, 'show'])->name('settlement.show');

    Route::get('/{settlement}/show/show/settlement/procedure', [SettlementProceduralController::class, 'showProcedure'])->name('settlements.procedure');
    Route::get('/{settlement}/show/show/settlement/procedure/create', [SettlementProceduralController::class, 'createProcedure'])->name('settlements.procedure.create');
    Route::get('/{settlement}/show/show/settlement/procedure/edit', [SettlementProceduralController::class, 'editProcedure'])->name('settlement.procedural.edit');
    Route::post('/{settlement}/show/show/settlement/procedure/store', [SettlementProceduralController::class, 'storeProcedure'])->name('settlements.procedure.store');
    Route::post('/{settlement}/show/show/settlement/procedure/update', [SettlementProceduralController::class, 'updateProcedure'])->name('settlement.procedural.update');
    Route::delete('/{settlement}/show/show/settlement/procedure/delete', [SettlementProceduralController::class, 'deleteProcedure'])->name('settlement.procedural.destroy');
    Route::post('/{settlement}/show/show/settlement/procedure/add/file', [SettlementProceduralController::class, 'addFile'])->name('settlement.procedural.add.file');
    Route::delete('/{settlement}/show/show/settlement/procedure/delete/file/destroy', [SettlementProceduralController::class, 'deleteFile'])->name('settlements.files.destroy');
    Route::get('/{settlement}/show/show/settlement/procedure/sub/procedure', [SettlementProceduralController::class, 'subProcedure'])->name('settlement.procedural.show');
    Route::post('/{settlement}/show/showsettlement/procedure/sub/store', [SettlementProceduralController::class, 'storSubProcedure'])->name('settlements.subprocedure.store');

    Route::get('/executive-cases/type/{item}/all', [ExecutiveCaseController::class, 'index'])->name('executive-case.index');
    Route::get('/executive-cases/type/{item}/expenses', [ExecutiveCaseController::class, 'expenses'])->name('executive-case.expenses');
    Route::get('/executive-cases/type/{executiveCase}/settlement/all', [ExecutiveCaseController::class, 'caseSettlements'])->name('executive-case.settlement');
    Route::get('/executive-cases/type/{executiveCase}/create/settlement', [ExecutiveCaseController::class, 'createSettlement'])->name('executive-case.settlement.create');
    Route::post('/executive-cases/type/{executiveCase}/store/settlement', [ExecutiveCaseController::class, 'storeSettlement'])->name('executive-case.settlement.store');
    Route::get('/executive-cases/type/{settlement}/edit/settlement/go', [ExecutiveCaseController::class, 'editSettlement'])->name('executive-case.settlement.edit');
    Route::post('/executive-cases/type/{settlement}/update/settlement/go', [ExecutiveCaseController::class, 'updateSettlement'])->name('executive-case.settlement.update');
    Route::delete('/executive-cases/type/{settlement}/delete/settlement/go', [ExecutiveCaseController::class, 'deleteSettlement'])->name('executive-case.settlement.delete');
    Route::get('/executive-cases/type/{item}/create', [ExecutiveCaseController::class, 'create'])->name('executive-case.create');
    Route::post('/executive-cases/{item}/store', [ExecutiveCaseController::class, 'store'])->name('executive-case.store');
    Route::post('/executive-cases/{executiveCase}/add/file', [ExecutiveCaseController::class, 'addFile'])->name('executive-case.add.file');
    Route::post('/executive-cases/{executiveCase}/add/subProcedural', [ExecutiveCaseController::class, 'subProcedural'])->name('executiveCases.subprocedure.store');
    Route::get('/executive-cases/{executiveCase}/procedural/show', [ExecutiveCaseController::class, 'executiveProcedural'])->name('executive-case.procedural.show');
    Route::get('/executive-cases/{executiveCase}/edit', [ExecutiveCaseController::class, 'edit'])->name('executive-case.edit');
    Route::post('/executive-cases/{executiveCase}/update', [ExecutiveCaseController::class, 'update'])->name('executive-case.update');
    Route::delete('/executive-case/delete/{executiveCase}', [ExecutiveCaseController::class, 'destroy'])->name('executive-case.delete');
    Route::get('/executive-cases/deleted', [ExecutiveCaseController::class, 'indexDelete'])->name('executive-case.indexDelete');
    Route::get('/executive-case/{id}/restore', [ExecutiveCaseController::class, 'restore'])->name('executive-case.restore');
    Route::get('/executive-cases/{id}', [ExecutiveCaseController::class, 'show'])->name('executive-case.show');

    // ProceduralRecord admin routes
    Route::get('/procedural-records/{executiveCase}/action', [ProceduralRecordController::class, 'actions'])->name('procedural-record.index');
    Route::get('/procedural-records/create/{executiveCase}', [ProceduralRecordController::class, 'create'])->name('procedural-record.create');
    Route::post('/procedural-records/create/{executiveCase}', [ProceduralRecordController::class, 'store'])->name('procedural-record.store');
    Route::get('/procedural-records/{executiveCase}/edit', [ProceduralRecordController::class, 'edit'])->name('procedural-record.edit');
    Route::post('/procedural-records/{executiveCase}/update', [ProceduralRecordController::class, 'update'])->name('procedural-record.update');
    Route::delete('/procedural-records/{executiveCase}/delete', [ProceduralRecordController::class, 'destroy'])->name('procedural-record.delete');
    Route::delete('/procedural-records/{executiveCase}/delete/file', [ProceduralRecordController::class, 'destroyFile'])->name('procedural-executiveCase.file.destroy');
    Route::get('/procedural-records/{id}/show/{executiveCase?}', [ProceduralRecordController::class, 'show'])->name('procedural-record.show');

    Route::get('/public/search', [PublicSearchController::class, 'index'])->name('public.search.index');
    Route::post('/public/search/find', [PublicSearchController::class, 'search'])->name('public.search.find');

    Route::get('/vistiors/reviews/all', [visitorReviewController::class, 'index'])->name('visitors.index');

    Route::get('/chat/admin/{userId?}', [Message::class, 'index'])->name('chat.with');
    Route::get('/chat/lawyer/{userId?}', [Message::class, 'index2'])->name('chat.with1');
    Route::get('/chat/user/{userId?}', [Message::class, 'index3'])->name('chat.with2');

    Route::get('/show/user', [Message::class, 'showNotifications'])->name('show.notification');
    Route::post('/notifications/read/{message}', [Message::class, 'readMessage'])->name('show.notification.read');

    Route::get('/settlement-actions/{settlement_id}', [SettlementActionController::class, 'index'])->name('settlement-action.list');
    Route::get('/settlement-actions/{settlement_id}/create', [SettlementActionController::class, 'create'])->name('settlement-action.create');
    Route::get('/settlement-actions/{id}/edit', [SettlementActionController::class, 'edit'])->name('settlement-action.edit');
    Route::get('/settlement-actions/{settlement_id}/deleted', [SettlementActionController::class, 'deleted'])->name('settlement-action.deleted');
    Route::get('/settlement-actions/{id}/show', [SettlementActionController::class, 'show'])->name('settlement-action.show');

    Route::get('/transactions/{transaction}/all/transactions', [TransactionController::class, 'index'])->name('transactions.all');
    Route::get('/transactions/{transaction}/create/new', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions/{transaction}/store/new', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit/new', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::post('/transactions/{transaction}/update/new', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}/destroy/new', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/transactions/{transaction}/procedural/new', [TransactionController::class, 'allProcedural'])->name('transactions.procedural.create');
    Route::post('/transactions/{transaction}/procedural/new/file', [TransactionController::class, 'addFile'])->name('transactions.procedural.create.file');
    Route::post('/transactions/{transaction}/procedural/new', [TransactionController::class, 'storeProcedural'])->name('transactions.procedural.store');
    Route::get('/transactions/{transaction}/procedural/edit', [TransactionController::class, 'editProcedural'])->name('transactions.procedural.edit');
    Route::delete('/transactions/{transaction}/procedural/edit/deleteFile', [TransactionController::class, 'deleteFile'])->name('transactions.procedure.file.delete');
    Route::post('/transactions/{transaction}/procedural/update', [TransactionController::class, 'updateprocedural'])->name('transactions.procedural.update');
    Route::delete('/transactions/{transaction}/procedural/delete', [TransactionController::class, 'deleteProcedural'])->name('transactions.procedural.destroy');


    Route::get('/archives/system', [ArchiveController::class, 'index'])->name('archive.index');
    Route::get('/archives/system/main', [ArchiveController::class, 'createMain'])->name('archive.main.create');
    Route::post('/archives/system/main', [ArchiveController::class, 'storeMain'])->name('archive.main.store');
    Route::get('/archives/system/sub-main/{id}', [ArchiveController::class, 'createSubMain'])->name('archive.subMain.create');
    Route::post('/archives/system/sub-main', [ArchiveController::class, 'storeSubMain'])->name('archive.subMain.store');
    Route::get('/archives/system/create/archive', [ArchiveController::class, 'create'])->name('archive.create');
    Route::post('/archives/system/create/archive', [ArchiveController::class, 'store'])->name('archive.store');
    Route::get('/archives/system/{archive}/edit', [ArchiveController::class, 'edit'])->name('archive.edit');
    Route::post('/archives/system/{archive}/update', [ArchiveController::class, 'update'])->name('archive.update');
    Route::delete('/archives/system/{archive}/delete', [ArchiveController::class, 'destroy'])->name('archive.destroy');
    Route::get('/archives/system/archives/indexdelete/', [ArchiveController::class, 'deletedArchive'])->name('archive.indexDelete');
    Route::post('/archives/system/archives/indexdelete/{archive}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::get('/archives/reports', [ArchiveController::class, 'index1'])->name('archive.reports');
    Route::get('/archives/reports/search', [ArchiveController::class, 'search'])->name('archive.reports.search');

    Route::get('/missions/add', [MissionController::class, 'create'])->name('mission.add');
    Route::post('/missions/add', [MissionController::class, 'store'])->name('mission.store');
    Route::get('/missions/finished', [MissionController::class, 'index'])->name('mission.finished');
    Route::get('/search/missions/finished', [MissionController::class, 'search'])->name('mission.finished.search');
    Route::get('/search/missions/finished/find', [MissionController::class, 'search1'])->name('mission.finished.search.go');
    Route::get('/search/missions/unfinished', [MissionController::class, 'search2'])->name('mission.unfinished.search');
    Route::get('/search/missions/unfinished/find', [MissionController::class, 'search3'])->name('mission.unfinished.search.go');
    Route::get('/missions/unfinished', [MissionController::class, 'index1'])->name('mission.unfinished');
    Route::post('/missions/finished/{mission}/finished', [MissionController::class, 'finished'])->name('mission.unfinished.finished');
    Route::post('/missions/unfinished/{mission}/unfinished', [MissionController::class, 'unfinished'])->name('mission.finished.unfinished');
    Route::delete('/missions/{mission}/delete', [MissionController::class, 'destroy'])->name('mission.delete');
    Route::get('/missions/deleted', [MissionController::class, 'deletedMissions'])->name('mission.indexDelete');
    Route::post('/missions/{mission}/restore', [MissionController::class, 'restore'])->name('mission.restore');
    Route::get('/missions/{mission}/show', [MissionController::class, 'show'])->name('mission.show');
    Route::get('/missions/show/me', [MissionController::class, 'myMissions'])->name('me.missions.show');

    Route::get('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'تم تعليم الإشعار كمقروء.');
    })->name('notifications.read');

    Route::get('/casetypes', [CaseTypeController::class, 'index'])->name('casetypes.index');
    Route::get('/casetypes/create', [CaseTypeController::class, 'create'])->name('casetypes.create');
    Route::post('/casetypes', [CaseTypeController::class, 'store'])->name('casetypes.store');
    Route::get('/casetypes/{id}/edit', [CaseTypeController::class, 'edit'])->name('casetypes.edit');
    Route::get('/casetypes/{casetype}/show', [CaseTypeController::class, 'show'])->name('casetypes.show');
    Route::get('/casetypes/{casetype}/create/settlement', [CaseTypeController::class, 'storeSettlement'])->name('casetypes.create.settlement');
    Route::post('/casetypes/{id}', [CaseTypeController::class, 'update'])->name('casetypes.update');

    Route::get('/casetypes/createCase/get/{case}', [CaseController::class, 'createCase'])->name('casetypes.create.case');
    Route::get('/casetypes/cases/all', [CaseController::class, 'allCases'])->name('cases.all');
    Route::post('/casetypes/createCase/store/{case}', [CaseController::class, 'storeCase'])->name('casetypes.store.case');
    Route::get('/casetypes/{id}/delete', [CaseTypeController::class, 'destroy'])->name('casetypes.destroy');
    Route::get('/{case}/edit/editcase', [CaseController::class, 'edit'])->name('cases.edit');
    Route::get('/{case}/show/showcase', [CaseController::class, 'show'])->name('cases.show');
    Route::post('/{case}/show/showcase/session/uploadFile', [CaseController::class, 'uploadFile'])->name('sessions.uploadFile');
    Route::get('/{case}/show/showcase/durations', [CaseController::class, 'showDurations'])->name('cases.show.durations');
    Route::get('/{case}/show/showcase/notes', [CaseController::class, 'showNotes'])->name('cases.show.notes');
    Route::get('/{case}/show/showcase/procedure', [CaseController::class, 'showProcedure'])->name('cases.procedure');
    Route::get('/{case}/show/showcase/procedure/create', [CaseController::class, 'createProcedure'])->name('cases.procedure.create');
    Route::post('/{case}/show/showcase/procedure/store', [CaseController::class, 'storeProcedure'])->name('cases.procedure.store');
    Route::get('/{case}/show/showcase/procedure/edit/case/go', [CaseController::class, 'editProcedure'])->name('cases.procedure.edit');
    Route::post('/{case}/show/showcase/procedure/update/case', [CaseController::class, 'updateProcedure'])->name('cases.procedure.update');
    Route::delete('/{case}/show/showcase/procedure/delete/case', [CaseController::class, 'deleteProcedure'])->name('cases.procedure.delete');
    Route::post('/{case}/show/showcase/procedure/add/file', [CaseController::class, 'addFile'])->name('procedural.add.file');

    Route::get('/cases/trashed/{caseType}', [TrashedController::class, 'trashedCases'])
        ->name('cases.trashed');
    Route::get('/settlements/trashed/{settlement}', [TrashedController::class, 'trashedSettlements'])
        ->name('settlement.trashed');
    Route::get('/executive/trashed/{executiveCase}', [TrashedController::class, 'trashedExecutives'])
        ->name('executive.trashed');
    Route::get('/transactions/trashed/{transaction}', [TrashedController::class, 'trashedTransactions'])
        ->name('transactions.trashed');

    Route::get('/{case}/show/showcase/procedure/sub/procedure', [CaseController::class, 'subProcedure'])->name('case.procedural.show');
    Route::post('/{case}/show/showcase/procedure/sub/store', [CaseController::class, 'storSubProcedure'])->name('cases.subprocedure.store');
    Route::get('/{case}/show/showcase/procedure/sub/edit', [CaseController::class, 'editSubProcedure'])->name('case.procedural.edit');
    Route::post('/{case}/show/showcase/procedure/sub/update/go', [CaseController::class, 'updateSubProcedure'])->name('cases.procedure.update');
    Route::delete('/{case}/show/showcase/procedure/sub/delete', [CaseController::class, 'deleteSubProcedure'])->name('case.procedural.delete');
    Route::delete('/{case}/show/showcase/procedure/procedure/sub/deleteFile/go', [CaseController::class, 'deleteFiles'])->name('cases.procedure.file.delete');
    Route::get('/{case}/memos/memocase', [CaseController::class, 'memos'])->name('cases.memos');
    Route::get('/search/cases/searchCase', [CaseController::class, 'searchPage'])->name('cases.search');
    Route::get('/search/cases/search/find', [CaseController::class, 'search'])->name('cases.search.find');
    Route::get('/{case}/log', [CaseController::class, 'log'])->name('cases.logs');
    Route::post('/{case}/update', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('/{case}/delete', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::get('/{case}/add', [CaseController::class, 'add'])->name('cases.add');
    Route::post('/{case}/add', [CaseController::class, 'storeAdd'])->name('cases.storeAdd');
    Route::get('/{case}/sessions/all', [CaseController::class, 'caseSessions'])->name('cases.sessions');
    Route::get('{session}/edit/session', [CaseController::class, 'editSession'])->name('cases.session.edit');
    Route::post('/{session}/edit/session', [CaseController::class, 'updateSession'])->name('cases.session.update');
    Route::delete('/{session}/delete/session', [CaseController::class, 'destroySession'])->name('cases.session.delete');
    Route::delete('/{session}/delete/session/file/go', [CaseController::class, 'deleteSessionFile'])->name('cases.session.delete.files');
    Route::get('/{case}/settlement', [CaseController::class, 'settlement'])->name('cases.settlement');
    Route::post('/{case}/settlement', [CaseController::class, 'storeSettlement'])->name('cases.storeSettlement');
    Route::get('/{case}/expenses', [CaseController::class, 'expenses'])->name('cases.expenses');
    Route::post('/{case}/expenses', [CaseController::class, 'storeExpenses'])->name('cases.storeExpenses');

    Route::get('/dashboard/durations/all', [DurationController::class, 'index'])->name('duration.all');
    Route::get('/search/dashboard/durations', [DurationController::class, 'search'])->name('duration.search');
    Route::get('/search/dashboard/durations/periods', [DurationController::class, 'search1'])->name('duration.search.go');
    Route::get('/{case}/durations/all', [DurationController::class, 'caseDurations'])->name('case.duration.all');
    Route::post('/{case}/durations/submit', [DurationController::class, 'submitDuration'])->name('case.duration.submit');
    Route::get('/{case}/duration/create', [DurationController::class, 'createDuration'])->name('cases.duration.create');
    Route::post('/{case}/duration/store', [DurationController::class, 'storeDuration'])->name('cases.duration.store');

    Route::get('/dashboard/notes/all/', [CaseNotesController::class, 'index'])->name('note.all');
    Route::get('/search/dashboard/notes', [CaseNotesController::class, 'search'])->name('note.search');
    Route::get('/search/dashboard/notes/notes', [CaseNotesController::class, 'search1'])->name('note.search.go');
    Route::get('/dashboard/notes/all/', [CaseNotesController::class, 'index'])->name('note.all');
    Route::post('{case}/dashboard/submit', [CaseNotesController::class, 'submitNote'])->name('case.note.submit');
    Route::get('/{case}/notes/all', [CaseNotesController::class, 'caseNotes'])->name('case.notes.all');
    Route::get('/{case}/notes/create', [CaseNotesController::class, 'create'])->name('cases.notes.create');
    Route::post('/{case}/notes/store', [CaseNotesController::class, 'store'])->name('cases.notes.store');

    Route::get('/{case}/log', [CaseController::class, 'log'])->name('log');
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

    Route::prefix('edit')->group(function () {
        Route::get('/casetypes/{type}/edit', [editController::class, 'editCaseType'])->name('casetypes.edit.new');
        Route::post('/casetypes/{type}/update', [editController::class, 'updateCaseType'])->name('casetypes.update.new');
        Route::get('/settlements/{type}/edit', [editController::class, 'editSettlement'])->name('settlements.edit.new');
        Route::post('/settlements/{type}/update', [editController::class, 'updateSettlement'])->name('settlements.update.new');
        Route::get('/transactions/{type}/edit', [editController::class, 'editTransaction'])->name('transactions.edit.new');
        Route::post('/transactions/{type}/update', [editController::class, 'updateTransaction'])->name('transactions.update.new');
        Route::get('/excutiveCases/{type}/edit', [editController::class, 'editExcutiveCase'])->name('excutiveCases.edit.new');
        Route::post('/excutiveCases/{type}/update', [editController::class, 'updateExcutiveCase'])->name('excutiveCases.update.new');
    });

    Route::prefix('destroy')->group(function () {
        Route::get('/casetypes/{type}', [editController::class, 'destroyCaseType'])->name('casetypes.destroy.new');
        Route::get('/settlements/{type}', [editController::class, 'destroySettlement'])->name('settlements.destroy.new');
        Route::get('/transactions/{type}', [editController::class, 'destroyTransaction'])->name('transactions.destroy.new');
        Route::get('/excutiveCases/{type}', [editController::class, 'destroyExcutiveCase'])->name('excutiveCases.destroy.new');
    });


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

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [LoginController::class, 'showLogin'])->name('login');
    Route::POST('login', [LoginController::class, 'login'])->name('admin.login');
});
Route::group(['prefix' => 'user', 'middleware' => 'guest'], function () {
    Route::get('/login', [UserLoginController::class, 'showLogin'])->name('login.user');
    Route::post('/login', [UserLoginController::class, 'login'])->name('user.login');
});