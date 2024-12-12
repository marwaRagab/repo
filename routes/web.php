<?php
require __DIR__ . '/auth.php';

use App\Exports\ClientsExport;
use App\Http\Controllers\advancedController;
use App\Http\Controllers\Auth\LoginController;
// use App\Exports\ClientsExport;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BokerController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\HumanResources\ClientController;
use App\Http\Controllers\HumanResources\CommuncationMethodController;
use App\Http\Controllers\HumanResources\MemberController;
use App\Http\Controllers\HumanResources\TransactionsCompletedController;
use App\Http\Controllers\HumanResources\UserController;
use App\Http\Controllers\ImportingCompanies\ClassController;
use App\Http\Controllers\ImportingCompanies\CompanyController;

// use App\Exports\ClientsExport;
//// use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\ImportingCompanies\MarkController;
use App\Http\Controllers\ImportingCompanies\ProductController;
// use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ImportingCompanies\PurchaseOrdersController;
use App\Http\Controllers\ImportingCompanies\TawreedController;
use App\Http\Controllers\ImportingCompanies\TransferProductController;
use App\Http\Controllers\InstallmentApproveController;
use App\Http\Controllers\InstallmentCarController;
use App\Http\Controllers\InstallmentClientController;
use App\Http\Controllers\InstallmentClientNoteController;
use App\Http\Controllers\InstallmentIssueController;
use App\Http\Controllers\InstallmentPercentageController;
use App\Http\Controllers\InstallmentSubmissionController;
use App\Http\Controllers\Installment\InstallmentController;
use App\Http\Controllers\Military_affairs\CertificateController;
use App\Http\Controllers\Military_affairs\CheckingController;
use App\Http\Controllers\Military_affairs\DelegatesController;
use App\Http\Controllers\Military_affairs\EqrardainController;
use App\Http\Controllers\Military_affairs\Excute_actionsController;
use App\Http\Controllers\Military_affairs\Execute_alertController;
use App\Http\Controllers\Military_affairs\ImageController;
use App\Http\Controllers\Military_affairs\Military_affairsController;
use App\Http\Controllers\Military_affairs\Open_fileController;

// use App\Http\Controllers\Showroom\ShowroomController;
use App\Http\Controllers\Military_affairs\PapersController;
use App\Http\Controllers\Military_affairs\SearchController;
// use App\Http\Controllers\Military_affairs\CheckingController;

use App\Http\Controllers\Military_affairs\SettlementController;
use App\Http\Controllers\Military_affairs\Stop_bankController;

// use App\Http\Controllers\Military_affairs\Military_affairsController;
use App\Http\Controllers\Military_affairs\Stop_carController;
use App\Http\Controllers\Military_affairs\Stop_salaryController;

// use App\Http\Controllers\Military_affairs\EqrardainController;

// use App\Http\Controllers\Transfer\TransferController;

use App\Http\Controllers\Military_affairs\Stop_travelController;
use App\Http\Controllers\MinistryController;
// use App\Http\Controllers\Military_affairs\Stop_bankController;
use App\Http\Controllers\MinistryPercentageController;
use App\Http\Controllers\NationalityController;

// use App\Http\Controllers\Military_affairs\Stop_travelController;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\old_dbController;
use App\Http\Controllers\OttuPaymentController;
// use App\Http\Controllers\Military_affairs\Stop_travelController;

use App\Http\Controllers\Payments\PaymentsController;

// use App\Http\Controllers\Military_affairs\Excute_actionsController;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoliceStationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Showroom\ShowroomController;
use App\Http\Controllers\TechnicalSupport\ProblemController;
use App\Http\Controllers\TechnicalSupport\RequestController;
use App\Http\Controllers\Transfer\TransferController;
use App\Http\Controllers\WorkingIncomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ImportingCompanies\Tawreed\TawreedController;
//
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

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);

    return view('login');
});
Route::get('/db/{type}', [old_dbController::class, 'index']);
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Route::get('/run-artisan-commands', function () {
    // Run the Artisan commands
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

    return response()->json(['message' => 'Artisan commands executed successfully']);
});

Route::get('/login', [LoginController::class, 'show_login'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/reset_password', [LoginController::class, 'show_reset'])->name('show_reset');
Route::post('/reset_password', [LoginController::class, 'reset_password'])->name('reset');

Route::get('/dasboard', [LoginController::class, 'dasboard'])->name('dasboard');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/insert_to_invoice', [InstallmentApproveController::class, 'insert_to_invoice']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // advanced
    Route::get('/new', [advancedController::class, 'index'])->name('advanced.addnew');
    Route::get('/notes/{id}', [advancedController::class, 'Notesindex'])->name('advanced.notes');
    Route::get('/issue/{id}', [advancedController::class, 'Issueindex'])->name('advanced.issue');
    Route::get('/car/{id}', [advancedController::class, 'Carindex'])->name('advanced.car');
    Route::get('/myinstall/accept-condition/{id}', [advancedController::class, 'acceptCondationindex'])->name('advanced.acceptCondation');
    Route::get('/myinstall/accept/{id}', [advancedController::class, 'acceptindex'])->name('advanced.accept');
    Route::get('/myinstall/reject/{id}', [advancedController::class, 'rejectindex'])->name('advanced.reject');
    Route::get('/myinstall/archive/{id}', [advancedController::class, 'archiveindex'])->name('advanced.archive');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // bank
    Route::get('banks', [BankController::class, 'index'])->name('bank.index');
    Route::post('bank/store', [BankController::class, 'store'])->name('bank.store');
    Route::get('bank/edit/{id}', [BankController::class, 'edit'])->name('bank.edit');
    Route::any('bank/update/{id}', [BankController::class, 'update'])->name('bank.update');
    Route::any('bank/delete/{id}', [BankController::class, 'destroy'])->name('bank.destroy');
    Route::any('bank/show/{id}', [BankController::class, 'show'])->name('bank.show');

    Route::get('/open_file/{id?}', [Open_fileController::class, 'index'])->name('open_file');
    Route::post('/return_to_lated', [Open_fileController::class, 'return_to_lated'])->name('return_to_lated');
    Route::post('/to_ex_alert', [Open_fileController::class, 'convert_ex_alert'])->name('to_ex_alert');
    Route::get('/case_proof/{id?}', [Open_fileController::class, 'index_case_proof'])->name('case_proof');
    Route::post('/convert_to_execute', [Open_fileController::class, 'convert_to_execute']);
    Route::get('/stop_travel/{id?}', [Stop_travelController::class, 'index'])->name('stop_travel');
    Route::get('/Execute_alert/{id?}', [Execute_alertController::class, 'index'])->name('execute_alert');
    Route::post('/add_a3lan', [Execute_alertController::class, 'add_a3lan_date']);
    Route::post('/add_notes', [Open_fileController::class, 'add_notes']);
    Route::get('/show_convert/{id}', [Open_fileController::class, 'show']);
    Route::any('/update_a3lan', [Execute_alertController::class, 'update_a3lan']);
    Route::get('/Certificate/{id?}', [CertificateController::class, 'index'])->name('Certificate');
    Route::get('/data_certificate', [CertificateController::class, 'data_certificate']);
    /// ghad routes

    Route::get('/stop_bank/{id?}', [Stop_bankController::class, 'index'])->name('stop_bank');
    Route::post('/stop_travel_convert', [Stop_travelController::class, 'stop_travel_convert']);
    Route::get('military_affairs/stop_bank/archive/{id?}', [Stop_bankController::class, 'archive'])->name('stop_bank.archive');
    Route::get( 'military_affairs/stop_bank/print_archive/{id?}', [Stop_bankController::class, 'print_archive'])->name('stop_bank.print_archive');
    Route::get( 'military_affairs/stop_bank/check_info_in_banks/{id?}', [Stop_bankController::class, 'check_info_in_banks'])->name('stop_bank.check_info_in_banks');
    Route::post('military_affairs/stop_bank/save_banks_info', [Stop_bankController::class, 'saveBanksInfo'])->name('stop_bank.save_banks_info');
    Route::get( 'military_affairs/stop_bank/check_info_in_job/{id?}', [Stop_bankController::class, 'check_info_in_job'])->name('stop_bank.check_info_in_job');
    Route::post('military_affairs/stop_bank/save_jobs_info', [Stop_bankController::class, 'save_jobs_info'])->name('stop_bank.save_jobs_info');


    // Route::get('/checking/{id?}', [ CheckingController::class, 'index'])->name('checking');
    // Route::post('/update_actions_up/', [ CheckingController::class, 'update_actions_up']);
    // Route::post('/update_actions_reminder/', [ CheckingController::class, 'update_actions_reminder']);
    // Route::get('/Excute_actions/{id?}', [ Excute_actionsController::class, 'index'])->name('excute_actions');
    // Route::post('/add_amount/', [ Excute_actionsController::class, 'add_amount']);
    // Route::post('/add_check', [ Excute_actionsController::class, 'add_check']);
    // Route::post('/change_states', [ Stop_bankController::class, 'change_states']);
    // Route::get('/all_checks/{id?}', [ Excute_actionsController::class, 'all_checks_index'])->name('all_checks');
    // Route::post('/add_check_finished', [ Excute_actionsController::class, 'add_check_finished']);

    Route::get('/checking/{id?}', [CheckingController::class, 'index'])->name('checking');
    Route::post('/update_actions_up/', [CheckingController::class, 'update_actions_up']);
    Route::post('/update_actions_reminder/', [CheckingController::class, 'update_actions_reminder']);
    Route::get('/Excute_actions/{id?}', [Excute_actionsController::class, 'index'])->name('excute_actions');
    Route::post('/add_amount/', [Excute_actionsController::class, 'add_amount']);
    Route::post('/add_check', [Excute_actionsController::class, 'add_check']);
    Route::post('/change_states', [Stop_bankController::class, 'change_states']);
    Route::get('/all_checks/{id?}', [Excute_actionsController::class, 'all_checks_index'])->name('all_checks');
    Route::post('/add_check_finished', [Excute_actionsController::class, 'add_check_finished']);

    Route::get('/eqrardain/{id?}', [EqrardainController::class, 'index'])->name('eqrardain');
    //Route::get('/please_cancel_eqrar/{id?}', [ EqrardainController::class, 'please_cancel_eqrar']);

    Route::get('military_affairs', [Military_affairsController::class, 'index'])->name('military_affairs');
    Route::get('military_affairs/stop_car/{governorate_id?}/{stop_car_type?}/{police_station_id?}', [Stop_carController::class, 'index'])->name('stop_car');

    Route::get('military_affairs/stop_salary/{governorate_id?}/{stop_salary_type?}/{ministry?}', [Stop_salaryController::class, 'index'])->name('stop_salary');

    Route::get('military_affairs/image/{governorate_id?}', [ImageController::class, 'index'])->name('image');
    Route::post('military_affairs/image/to_a3lan_eda3', [ImageController::class, 'to_a3lan_eda3'])->name('image.to_a3lan_eda3');
    Route::get('military_affairs/image/athbat_7ala/{installment_id}', [ImageController::class, 'athbat_7ala'])->name('image.athbat_7ala');

    Route::get('military_affairs/convert/{installment_id}', [Military_affairsController::class, 'convert'])->name('military_affairs.convert');
    Route::get('military_affairs/papers/eqrar_dain', [PapersController::class, 'eqrar_not_received'])->name('papers.eqrar_dain');
    Route::get('military_affairs/papers/nmozag_eqrar/{installment_id}', [PapersController::class, 'nmozag_eqrar'])->name('papers.nmozag_eqrar');

    Route::get('military_affairs/papers/eqrar_dain_received', [PapersController::class, 'eqrar_received'])->name('papers.eqrar_dain_received');
    Route::get('military_affairs/papers/getall_eqrar', [PapersController::class, 'getall_eqrar'])->name('papers.getalleqrar');
    Route::get('military_affairs/papers/getall_eqrar_received', [PapersController::class, 'getall_eqrar_received'])->name('papers.getalleqrar_received');
    Route::post('military_affairs/papers/to_eqrar_dain', [PapersController::class, 'to_eqrar_dain'])->name('papers.to_eqrar_dain');
    Route::post('military_affairs/papers/to_open_file', [PapersController::class, 'to_open_file'])->name('papers.to_open_file');
    Route::get('military_affairs/papers/get_count_eqrar_dain/{slug?}', [PapersController::class, 'get_count_eqrar_dain'])->name('military_affairs.get_count_eqrar_dain');

    Route::get('military_affairs/convert/{installment_id}', [Military_affairsController::class, 'convert'])->name('military_affairs.convert');
    Route::get('military_affairs/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('military_affairs/search', [SearchController::class, 'get_searched'])->name('search.get_searched');

    Route::get('military_affairs/delegates', [DelegatesController::class, 'index'])->name('military_affairs.delegates');
    Route::post('military_affairs/delegates/{user_id}', [DelegatesController::class, 'update'])->name('delegate.update');
    Route::get('military_affairs/delegates/get_statistics', [DelegatesController::class, 'get_statistics'])->name('military_affairs.delegates.get_statistics');
    Route::get('military_affairs/admin/get_statistics_details/{user_id}', [DelegatesController::class, 'get_statistics_details'])->name('military_affairs.get_statistics_details');
    Route::get('military_affairs/show_images/{id}', [DelegatesController::class, 'show_images'])->name('show_images');
    Route::get('military_affairs/admin/get_statistics_deligations/{user_id}', [DelegatesController::class, 'get_statistics_deligations'])->name('military_affairs.get_statistics_deligations');
    Route::get('military_affairs/admin/get_statistics_notes_details/{user_id}', [DelegatesController::class, 'get_statistics_notes_details'])->name('military_affairs.get_statistics_notes_details');
    Route::get('military_affairs/admin/get_statistics_lawaffaires/{user_id}', [DelegatesController::class, 'get_statistics_lawaffaires'])->name('military_affairs.get_statistics_lawaffaires');
    Route::get('military_affairs/admin/get_statistics_emp/{user_id}', [DelegatesController::class, 'get_statistics_emp'])->name('military_affairs.get_statistics_emp');

    // ghada military_affairs routes
    Route::get('/open_file/{id?}', [Open_fileController::class, 'index'])->name('open_file');
    Route::post('/return_to_lated', [Open_fileController::class, 'return_to_lated'])->name('return_to_lated');
    Route::post('/to_ex_alert', [Open_fileController::class, 'convert_ex_alert'])->name('to_ex_alert');
    Route::get('/case_proof/{id?}', [Open_fileController::class, 'index_case_proof'])->name('case_proof');
    Route::post('/convert_to_execute', [Open_fileController::class, 'convert_to_execute']);
    Route::get('/stop_travel/{id?}', [Stop_travelController::class, 'index'])->name('stop_travel');
    Route::get('/Execute_alert/{id?}', [Execute_alertController::class, 'index'])->name('execute_alert');
    Route::post('/add_a3lan', [Execute_alertController::class, 'add_a3lan_date']);
    Route::post('/add_notes', [Open_fileController::class, 'add_notes']);
    Route::get('/show_convert/{id}', [Open_fileController::class, 'show']);
    Route::any('/update_a3lan', [Execute_alertController::class, 'update_a3lan']);
    Route::get('/Certificate/{id?}', [CertificateController::class, 'index'])->name('Certificate');
    Route::get('/convert_book_info/{id?}', [CertificateController::class, 'convert_book_info']);
    Route::post('/convert_to_export', [CertificateController::class, 'convert_to_export']);
    Route::post('/convert_to_money', [CertificateController::class, 'convert_to_money']);
    Route::post('/convert_to_stop_salary', [CertificateController::class, 'convert_to_stop_salary']);
    Route::get('/data_certificate/{id?}', [CertificateController::class, 'data_certificate']);
    Route::get('/change_states_bank/{id1}/{id2}', [Stop_bankController::class, 'change_states_bank']);
    Route::get('/stop_bank/{id?}', [Stop_bankController::class, 'index'])->name('stop_bank');
    Route::post('/stop_travel_convert', [Stop_travelController::class, 'stop_travel_convert']);
    Route::get('/checking/{id?}', [CheckingController::class, 'index'])->name('checking');
    Route::post('/update_actions_up/', [CheckingController::class, 'update_actions_up']);
    Route::post('/update_actions_reminder/', [CheckingController::class, 'update_actions_reminder']);
    Route::get('/Excute_actions/{id?}', [Excute_actionsController::class, 'index'])->name('excute_actions');
    Route::post('/add_amount/', [Excute_actionsController::class, 'add_amount']);
    Route::post('/add_check', [Excute_actionsController::class, 'add_check']);
    Route::get('/military_affairs/settlement', [SettlementController::class, 'index'])->name('settle.index');
    Route::post('/add_settlement', [SettlementController::class, 'add_settlement'])->name('settle.add_settlement');
    Route::get('/show_settlement/{id?}', [SettlementController::class, 'show_settlement']);
    Route::post('/pay_settlement', [SettlementController::class, 'pay_settlement']);
    Route::post('/cancel_settlement', [SettlementController::class, 'cancel_settlement']);
    Route::post('/change_states', [Stop_bankController::class, 'change_states']);
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
    Route::get('/print_invoice/{id}/{id1}/{id2}/{id3}', [PaymentsController::class, 'print_invoice']);
    Route::get('/set_archief/{id}', [PaymentsController::class, 'set_archief']);
    Route::get('/print_all/{ids}/{seriall}', [PaymentsController::class, 'print_all']);
    Route::get('/archieve_all/{ids}', [PaymentsController::class, 'archieve_all']);
    Route::get('/invoices_installment', [PaymentsController::class, 'invoices_installment_index'])->name('invoices_installment');
    Route::post('/get_invoices_papers', [PaymentsController::class, 'get_invoices_papers']);
    Route::get('/installment/invoices_installment/print_invoice/{id1}/{id2}', [PaymentsController::class, 'get_invoices_papers']);
    Route::get('/export_all', [PaymentsController::class, 'export_all']);
    Route::get('/print_invoice_export/{id1}/{id2}', [PaymentsController::class, 'print_invoice']);

    // Route::Resource('branches', BranchController::class);
    // Route::get('branches/getall', [BranchController::class, 'getall'])->name('branches.getall');
    // Route::Resource('banks', BankController::class);

    // government
    Route::get('government', [GovernorateController::class, 'index'])->name('government.index');
    Route::post('government/store', [GovernorateController::class, 'store'])->name('government.store');
    Route::get('government/edit/{id}', [GovernorateController::class, 'edit'])->name('government.edit');
    Route::any('government/update/{id}', [GovernorateController::class, 'update'])->name('government.update');
    Route::any('government/delete/{id}', [GovernorateController::class, 'destroy'])->name('government.destroy');
    Route::any('government/show/{id}', [GovernorateController::class, 'show'])->name('government.show');

    // region
    Route::get('region', [RegionController::class, 'index'])->name('region.index');
    Route::post('region/store', [RegionController::class, 'store'])->name('region.store');
    Route::get('region/edit/{id}', [RegionController::class, 'edit'])->name('region.edit');
    Route::any('region/update/{id}', [RegionController::class, 'update'])->name('region.update');
    Route::any('region/delete/{id}', [RegionController::class, 'destroy'])->name('region.destroy');
    Route::any('region/show/{id}', [RegionController::class, 'show'])->name('region.show');
    Route::get('region/filter/{id}', [RegionController::class, 'filter'])->name('region.filter');

    // courts
    Route::get('courts', [CourtController::class, 'index'])->name('courts.index');
    Route::post('courts/store', [CourtController::class, 'store'])->name('courts.store');
    Route::get('courts/edit/{id}', [CourtController::class, 'edit'])->name('courts.edit');
    Route::any('courts/update/{id}', [CourtController::class, 'update'])->name('courts.update');
    Route::any('courts/delete/{id}', [CourtController::class, 'destroy'])->name('courts.destroy');
    Route::any('courts/show/{id}', [CourtController::class, 'show'])->name('courts.show');

    // nationality
    Route::get('nationality', [NationalityController::class, 'index'])->name('nationality.index');
    Route::post('nationality/store', [NationalityController::class, 'store'])->name('nationality.store');
    Route::get('nationality/edit/{id}', [NationalityController::class, 'edit'])->name('nationality.edit');
    Route::any('nationality/update/{id}', [NationalityController::class, 'update'])->name('nationality.update');
    Route::any('nationality/delete/{id}', [NationalityController::class, 'destroy'])->name('nationality.destroy');
    Route::any('nationality/show/{id}', [NationalityController::class, 'show'])->name('nationality.show');

    // installment__percentages
    Route::get('installment__percentages', [InstallmentPercentageController::class, 'index'])->name('installment__percentages.index');
    Route::post('installment__percentages/store', [InstallmentPercentageController::class, 'store'])->name('installment__percentages.store');
    Route::get('installment__percentages/edit/{id}', [InstallmentPercentageController::class, 'edit'])->name('installment__percentages.edit');
    Route::any('installment__percentages/update/{id}', [InstallmentPercentageController::class, 'update'])->name('installment__percentages.update');
    Route::any('installment__percentages/delete/{id}', [InstallmentPercentageController::class, 'destroy'])->name(name: 'installment__percentages.destroy');
    Route::any('installment__percentages/show/{id}', [InstallmentPercentageController::class, 'show'])->name('installment__percentages.show');

    // ministry_percentages
    Route::get('ministry_percentages', [MinistryPercentageController::class, 'index'])->name('ministry_percentages.index');
    Route::post('ministry_percentages/store', [MinistryPercentageController::class, 'store'])->name('ministry_percentages.store');
    Route::get('ministry_percentages/edit/{id}', [MinistryPercentageController::class, 'edit'])->name('ministry_percentages.edit');
    Route::any('ministry_percentages/update/{id}', [MinistryPercentageController::class, 'update'])->name('ministry_percentages.update');
    Route::any('ministry_percentages/delete/{id}', [MinistryPercentageController::class, 'destroy'])->name(name: 'ministry_percentages.destroy');
    Route::any('ministry_percentages/show/{id}', [MinistryPercentageController::class, 'show'])->name('ministry_percentages.show');

    // ministry
    Route::get('ministry', [MinistryController::class, 'index'])->name('ministry.index');
    Route::post('ministry/store', [MinistryController::class, 'store'])->name('ministry.store');
    Route::get('ministry/edit/{id}', [MinistryController::class, 'edit'])->name('ministry.edit');
    Route::any('ministry/update/{id}', [MinistryController::class, 'update'])->name('ministry.update');
    Route::any('ministry/delete/{id}', [MinistryController::class, 'destroy'])->name(name: 'ministry.destroy');
    Route::any('ministry/show/{id}', [MinistryController::class, 'show'])->name('ministry.show');

    // Working Income
    Route::get('WorkingIncome', [WorkingIncomeController::class, 'index'])->name('WorkingIncome.index');
    Route::post('WorkingIncome/store', [WorkingIncomeController::class, 'store'])->name('WorkingIncome.store');
    Route::get('WorkingIncome/edit/{id}', [WorkingIncomeController::class, 'edit'])->name('WorkingIncome.edit');
    Route::any('WorkingIncome/update/{id}', [WorkingIncomeController::class, 'update'])->name('WorkingIncome.update');
    Route::any('WorkingIncome/delete/{id}', [WorkingIncomeController::class, 'destroy'])->name(name: 'WorkingIncome.destroy');
    Route::any('WorkingIncome/show/{id}', [WorkingIncomeController::class, 'show'])->name('WorkingIncome.show');

    // police stations
    Route::get('police_stations', [PoliceStationController::class, 'index'])->name('police_stations.index');
    Route::post('police_stations/store', [PoliceStationController::class, 'store'])->name('police_stations.store');
    Route::get('police_stations/edit/{id}', [PoliceStationController::class, 'edit'])->name('police_stations.edit');
    Route::any('police_stations/update/{id}', [PoliceStationController::class, 'update'])->name('police_stations.update');
    Route::any('police_stations/delete/{id}', [PoliceStationController::class, 'destroy'])->name(name: 'police_stations.destroy');
    Route::any('police_stations/show/{id}', [PoliceStationController::class, 'show'])->name('police_stations.show');

    // لbranch
    Route::get('branch', [BranchController::class, 'index'])->name('branch.index');
    Route::post('branch/store', [BranchController::class, 'store'])->name('branch.store');
    Route::get('branch/edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
    Route::any('branch/update/{id}', [BranchController::class, 'update'])->name('branch.update');
    Route::any('branch/delete/{id}', [BranchController::class, 'destroy'])->name('branch.destroy');
    Route::any('branch/show/{id}', [BranchController::class, 'show'])->name('branch.show');

    // permission
    Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::any('permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::any('permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    Route::any('permission/show/{id}', [PermissionController::class, 'show'])->name('permission.show');

    // Route::Resource( 'broker', BokerController::class);
    Route::get('/broker', [BokerController::class, 'index'])->name('broker.index');
    // Route::get('broker/getall', [BokerController::class, 'getAll'])->name('getallbroker');
    Route::delete('/broker/delete/{id}', [BokerController::class, 'destroy'])->name('broker.delete');
    Route::put('/broker/update/{id}', [BokerController::class, 'update'])->name('broker.update');
    Route::post('broker/store', [BokerController::class, 'store'])->name('broker.store');
    // Route::get('/myinstall/broker', [BokerController::class, 'getbroker'])->name('myinstall.broker');

    // installmentClient
    Route::redirect('/installmentClient', '/installmentClient/advanced');
    Route::get('/installmentClient/{status}', [InstallmentClientController::class, 'index'])->name('installmentClient.index');
    Route::get('installmentClient/getall/{status}', [InstallmentClientController::class, 'getAll'])->name('installmentClient.getall');
    Route::any('/installmentClient/delete/{id}', [InstallmentClientController::class, 'destroy'])->name('installmentClient.delete');
    Route::get('/installmentClient/edit/{id}', [InstallmentClientController::class, 'edit'])->name('installmentClientbroker.edit');
    // Route::post('transaction/store', [InstallmentClientController::class, 'store'])->name('installmentClient.store');
    Route::any('/myinstall/admin/index/{status}', [InstallmentClientController::class, 'myinstall'])->name('myinstall.index');
    Route::post('myinstall/update/{id}', [InstallmentClientController::class, 'update_myinstall'])->name('myinstall.update');
    Route::get('/myinstall/notes/{id}', [InstallmentClientController::class, 'getNotes']);

    Route::get('/myinstall/install/{id}', [InstallmentClientController::class, 'install'])->name('myinstall.install');

    Route::get('/myinstall/notesissue/{id}', [InstallmentClientController::class, 'getNotesIssue']);
    Route::get('/myinstall/notescar/{id}', [InstallmentClientController::class, 'getNotesCar']);

    Route::get('/installments/search', [InstallmentClientController::class, 'search'])->name('installments.search');
    Route::post('/check-civil-number', [InstallmentClientController::class, 'checkCivilNumber'])->name('checkCivilNumber');
    Route::post('/check-civil-number-accept', [InstallmentClientController::class, 'checkCivilNumber_accept'])->name('checkCivilNumber_accept');

    Route::get('payment/process/{id}', [OttuPaymentController::class, 'process'])->name('payment.process');
    Route::post('/payment/webhook', [PaymentController::class, 'webhook']);
    Route::get('/payment/cron-job', [PaymentController::class, 'cronJob']);
    Route::get('/payment/success', [PaymentController::class, 'success']);
    Route::post('/payment/auto-debit/{token}/{session}', [PaymentController::class, 'autoDebit']);
    Route::post('/payment/get-card-details/{instClientId}', [PaymentController::class, 'getCardDetails']);
    Route::post('/payment/process-initiating/{id}', [PaymentController::class, 'processInitiating']);
    Route::post('/payment/pay-from-ottu/{installmentId}', [PaymentController::class, 'payFromOttu']);

    // فورم التقديم ف المعاملات المقدمة
    Route::get('Aksat/convert_approved/{id}', [InstallmentClientController::class, 'convert_approved'])->name('installment.convert_approved');
    Route::get('Aksat/convert_approvedCopy/{id}', [InstallmentClientController::class, 'convert_approvedCopy'])->name('installment.convert_approvedCopy');

    Route::post('Aksat/convert_approved', [InstallmentClientController::class, 'convert_approved_store'])->name('installment.store_approved');

    // عملاء الاقساط
    Route::get('installment/admin', [InstallmentController::class, 'index'])->name('installment.admin');
    // Route::get('installment/getall', [InstallmentController::class, 'getAll'])->name('installment.getall');
    Route::post('installment/location/{client_id}', [InstallmentController::class, 'storelocation'])->name('installment.location');
    Route::post('/get-coordinates', [InstallmentController::class, 'getCoordinatesAttribute']);
    Route::get('installment/admin/finished_installments', [InstallmentController::class, 'finished_installments'])->name('installment.finished_installments');
    Route::get('installment/excel', [InstallmentController::class, 'getExcel'])->name('installment.excel');
    Route::get('/export-clients', function () {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    })->name('export.clients');

    Route::get('installment/show-installment/{id}', [InstallmentController::class, 'show_installment'])->name('installment.show-installment');
    Route::post('installment/pay_from/{id}', [InstallmentController::class, 'pay_from'])->name('installment.pay_one');
    Route::post('installment/pay_part/{id}', [InstallmentController::class, 'pay_part'])->name('installment.pay_part');
    Route::get('installment/show_upload_papers/{id}', [InstallmentController::class, 'show_upload_papers'])->name('installment.show_upload_papers');
    Route::post('installment/upload_papers/{id?}', [InstallmentController::class, 'upload_papers']);

    Route::post('installment/pay_total_installs/{id}', [InstallmentController::class, 'pay_total_installs'])->name('installment.pay_total');
    Route::post('installment/pay_total_discount_installs/{id}', [InstallmentController::class, 'pay_total_with_discount'])->name('installment.pay_total_discount');
    Route::post('installment/pay_some_installs/{id}', [InstallmentController::class, 'pay_some_of_amount'])->name('installment.pay_some');
    Route::post('installment/pay_settle/{id}', [InstallmentController::class, 'pay_settle'])->name('installment.pay_settle');
    Route::post('installment/pay_from_all/{id}', [InstallmentController::class, 'get_sum_installments'])->name('installment.pay_all');

    Route::get('installment/lated-installments', [InstallmentController::class, 'lated_installments'])->name('installment.lated-installments');
    // lated_installments_update
    Route::get('installment/lated_installments_update/{id}', [InstallmentController::class, 'lated_installments_update'])->name('installment.lated_installments_update');
    Route::get('installment/warning_print_paper/{id}', [InstallmentController::class, 'warning_print_paper']);
    Route::get('installment/print_contrct/{id}', [InstallmentController::class, 'print_contrct']);
    Route::get('installment/print_install_paper_info/{id}', [InstallmentController::class, 'print_install_paper_info']);
    Route::get('installment/recive_install_paper/{id}', [InstallmentController::class, 'recive_install_paper']);
    Route::get('installment/print_invoice/{id}', [InstallmentController::class, 'print_invoice']);
    Route::get('installment/edit_images/{id}', [InstallmentController::class, 'edit_images'])->name('installment/edit_images');
    Route::post('installment/upload_edit_images/{id?}', [InstallmentController::class, 'upload_edit_images']);

    Route::get('installment/admin/print_finished_installments/{id}', [InstallmentController::class, 'print_finished_installments'])->name('installment.print_finished_installments');
    // istallment submission
    Route::get('/installmentsubmission/{id}', [InstallmentSubmissionController::class, 'index'])->name('installmentsubmission.index');
    Route::post('installmentsubmission/store', [InstallmentSubmissionController::class, 'store'])->name('installmentsubmission.store');
    Route::get('/installmentApprove/{id}', [InstallmentApproveController::class, 'index'])->name('installmentApprove.index');
    Route::get('/installmentApproveCopy/{id}', [InstallmentApproveController::class, 'indexCopy'])->name('installmentApprove.indexCopy');
    Route::post('/installmentApprove', [InstallmentApproveController::class, 'store'])->name('installmentApprove.store');
    Route::get('/installmentApprove/print_eqrardain_mothaq/{id}', [InstallmentApproveController::class, 'print_eqrardain_mothaq']);
    Route::get('/installmentApprove/print_eqrardain/{id}/{id2}', [InstallmentApproveController::class, 'print_eqrardain']);
    Route::get('/installment/admin/print_recive_ins_money/{id}/{id2}', [InstallmentController::class, 'print_recive_ins_money'])->name('installment.print_recive_ins_money');;
    Route::get('/installment/admin/madionia_certificate/{id}', [InstallmentController::class, 'madionia_certificate'])->name('installment.madionia_certificate');;

    Route::post('installmentClient/store', [InstallmentClientController::class, 'store'])->name('installmentClient.store');
    Route::post('installmentClient/update/{id}', [InstallmentClientController::class, 'update'])->name('installmentClient.update');

    // Installment Client Car
    Route::get('/car-inquiry/{id}', [InstallmentCarController::class, 'create'])->name('carInquiry');
    Route::post('/InstallmentCar', [InstallmentCarController::class, 'store'])->name('InstallmentCar.store');
    // installment Issue
    Route::get('installmentIssue/{id}', [InstallmentIssueController::class, 'index'])->name('installmentIssue.index');
    Route::any('installmentIssue/store', [InstallmentIssueController::class, 'store'])->name('installmentIssue.store');

    // Installment Client Note
    Route::get('InstallmentClientNote/getall/{id}', [InstallmentClientNoteController::class, 'getAll'])->name('InstallmentClientNote.getall');
    Route::post('InstallmentClientNote/store', [InstallmentClientNoteController::class, 'store'])->name('InstallmentClientNote.store');

    //tawreed
    // Route::view('/tawreed/cart', 'importingCompanies.tawreed.cart');

    Route::get('/tawreed', [TawreedController::class, 'index'])->name('tawreed.index'); //->middleware('permission:view_companies');
    Route::get('tawreed/search-form/{companyId}', [TawreedController::class, 'searchForm'])->name('tawreed.searchForm'); //->middleware('permission:view_products');
    Route::post('tawreed/search-form/{companyId}', [TawreedController::class, 'searchResults'])->name('tawreed.searchResults'); //->middleware('permission:view_products');
    Route::delete('tawreed/cart/clear', [TawreedController::class, 'clearCart'])->name('cart.clear'); //->middleware('permission:delete_cart');
    Route::post('/tawreed/cart', [TawreedController::class, 'addToCart'])->name('tawreed.addToCart'); //->middleware('permission:create_cart');
    Route::get('/tawreed/cart', [TawreedController::class, 'createCart'])->name('tawreed.cart'); //->middleware('permission:view_cart');
    Route::delete('tawreed/cart/delete/{product_id}', [TawreedController::class, 'deleteProductFromCart'])->name('cart.delete'); //->middleware('permission:delete_cart');
    Route::get('tawreed/print_order_company/{id}', [TawreedController::class, 'print_order_company'])->name('tawreed.print_order_company'); //->middleware('permission:view_products');
    Route::get('tawreed/print_purchase/{id}', [TawreedController::class, 'print_purchase'])->name('tawreed.print_purchase'); //->middleware('permission:view_products');

    Route::get('/transfer/get_product_by_nymber', [InstallmentApproveController::class, 'getProductDetailsByNumber'])->name('products.getByNumber');

    Route::post('/tawreed/cart/add-to-purchase-orders', [TawreedController::class, 'addToPurchaseOrders'])->name('tawreed.addToPurchaseOrders'); //->middleware('permission:create_orders_files');
    Route::get('tawreed/purchase-orders', [TawreedController::class, 'purchaseOrders'])->name('tawreed.purchaseOrders'); //->middleware('permission:view_orders_files');
    Route::post('/tawreed/purchase-orders/sending/{id}', [TawreedController::class, 'sending'])->name('purchaseOrders.sending'); //->middleware('permission:update_orders_files');
    Route::delete('/tawreed/purchase-orders/delete/{id}', [TawreedController::class, 'deletePurchaseOrder'])->name('purchaseOrders.delete'); //->middleware('permission:delete_orders_files');
    Route::get('/tawreed/purchase-orders-archive', [TawreedController::class, 'purchaseOrdersArchive'])->name('tawreed.purchaseOrdersArchive'); //->middleware('permission:view_orders_files');

    Route::get('showwroom/getall', [ShowroomController::class, 'getAll'])->name('showroom.getAll');
    Route::get('showwroom/productsRecieving', [ShowroomController::class, 'index'])->name('shoowroom.index');
    Route::post('showroom/update_purchase/{id}', [ShowroomController::class, 'updateOrder'])->name('update_purchase_order');
    Route::get('showroom/show_serial/{id}', [ShowroomController::class, 'show_serial'])->name('showroom.showSerial');
    Route::post('showroom/add_serial/{id}', [ShowroomController::class, 'add_serial'])->name('showroom.addSerial');

    //Products
    Route::get('/transfer/get_available_products', [TransferController::class, 'get_available_products'])->name('Transfer.getAvailableProducts'); //->middleware('permission:view_products_items');
    Route::get('/transfer/show_available_products/{classId}', [TransferController::class, 'show_available_products'])->name('Transfer.showAvailableProducts'); //->middleware('permission:view_products_items');
    Route::post('/transfer/available_products/delete/{id}', [TransferController::class, 'delete_available_product'])->name('products.items.delete'); //->middleware('permission:update_products_items');
    Route::get('/products/data', [ProductController::class, 'getProductsData'])->name('products.data');

    // Route::get('/transfer/get_product_by_nymber', [InstallmentApproveController::class, 'getProductDetailsByNumber'])->name('products.getByNumber');
    // Importing companies
    // Route::Resource('products', ProductController::class);
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); //->middleware('permission:view_products');
    Route::post('/products', [ProductController::class, 'store'])->name('saving'); //->middleware('permission:create_products');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('updating'); //->middleware('permission:update_products');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('deleting'); //->middleware('permission:delete_products');
    Route::get('/products/get_product_by_number', [ProductController::class, 'getProductDetailsByNumber'])->name('products.getByNumber'); //->middleware('permission:view_products');
    Route::get('/products/print_all', [ProductController::class, 'print_all'])->name('products.print_all'); //->middleware('permission:view_products');

    //Human Resources

    //users
    Route::get('/human-resources/users', [UserController::class, 'index'])->name('users.index'); //->middleware('permission:view_users');
    Route::post('/human-resources/users', [UserController::class, 'store'])->name('users.store'); //->middleware('permission:create_users');
    Route::put('/human-resources/users/{id}', [UserController::class, 'update'])->name('users.update'); //->middleware('permission:update_users');

    //clients
    Route::get('/human-resources/clients', [ClientController::class, 'index'])->name('clients.index'); //->middleware('permission:view_clients');
    Route::get('/human-resources/clients/show_client/{id}', [ClientController::class, 'show_client'])->name('clients.show'); //->middleware('permission:view_clients');
    Route::post('/human-resources/clients', [ClientController::class, 'store'])->name('clients.store'); //->middleware('permission:create_clients');
    Route::put('/human-resources/clients/{id}', [ClientController::class, 'update'])->name('clients.update'); //->middleware('permission:update_clients');
    Route::delete('/human-resources/clients/delete/{id}', [ClientController::class, 'destroy'])->name('clients.delete'); //->middleware('permission:delete_clients');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notificatoin.index');

    Route::get('/update-tab', [NotificationController::class, 'updateTab']);

    //transactions
    Route::get('/human-resources/transactions-done', [TransactionsCompletedController::class, 'index'])->name('transactions.done.index'); //->middleware('permission:view_transactions_completed');
    Route::post('/human-resources/transactions-done', [TransactionsCompletedController::class, 'store'])->name('transactions.done.store'); //->middleware('permission:create_transactions_completed');
    Route::put('/human-resources/transactions-done/{id}', [TransactionsCompletedController::class, 'update'])->name('transactions.done.update'); //->middleware('permission:update_transactions_completed');
    Route::delete('/human-resources/transactions-done/delete/{id}', [TransactionsCompletedController::class, 'destroy'])->name('transactions.done.delete'); //->middleware('permission:delete_transactions_completed');

    // roles
    Route::get('/human-resources/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/human-resources/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::any('/human-resources/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::any('/human-resources/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::any('/human-resources/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::any('/human-resources/roles/show/{id}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');

    //communication methods
    Route::get('/human-resources/communication-methods', [CommuncationMethodController::class, 'index'])->name('communication.index'); //->middleware('permission:view_communcation_methods');
    Route::post('/human-resources/communication-methods', [CommuncationMethodController::class, 'store'])->name('communication.store'); //->middleware('permission:create_communcation_methods');
    Route::put('/human-resources/communication-methods/{id}', [CommuncationMethodController::class, 'update'])->name('communication.update'); //->middleware('permission:update_communcation_methods');
    Route::delete('/human-resources/communication-methods/delete/{id}', [CommuncationMethodController::class, 'destroy'])->name('communication.delete'); //->middleware('permission:delete_communcation_methods');

    //Members
    Route::get('/human-resources/members', [MemberController::class, 'index'])->name('member.index'); //->middleware('permission:view_users');
    Route::post('/human-resources/members', [MemberController::class, 'store'])->name('member.store'); //->middleware('permission:create_users');
    Route::put('/human-resources/members/{id}', [MemberController::class, 'update'])->name('member.update'); //->middleware('permission:update_users');
    Route::delete('/human-resources/members/delete/{id}', [MemberController::class, 'destroy'])->name('member.delete'); //->middleware('permission:delete_users');

    //orders
    Route::get('/orders', [PurchaseOrdersController::class, 'index'])->name('orders.index');
    Route::delete('/orders/delete/{id}', [PurchaseOrdersController::class, 'destroy'])->name('orders.delete');
    Route::post('/orders/sending/{id}', [PurchaseOrdersController::class, 'sending'])->name('orders.sending');
    Route::get('/orders/order-products/{id}', [PurchaseOrdersController::class, 'showOrderProducts'])->name('orders.products');
    Route::get('/orders/print_invoice/{id}', [PurchaseOrdersController::class, 'print_invoice'])->name('orders.print_invoice');

    //marks
    Route::get('/marks', [MarkController::class, 'index'])->name('mark.index');
    Route::post('/marks', [MarkController::class, 'store'])->name('mark.store');
    Route::put('/marks/{id}', [MarkController::class, 'update'])->name('mark.update');

    //classes
    Route::get('/classes', [ClassController::class, 'index'])->name('class.index');
    Route::post('/classes', [ClassController::class, 'store'])->name('class.store');
    Route::put('/classes/{id}', [ClassController::class, 'update'])->name('class.update');

    //companies
    Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('company.create');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/companies', [CompanyController::class, 'store'])->name('company.store');
    Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('company.update');

    //transfer-products
    Route::get('/transfer-products', [TransferProductController::class, 'index'])->name('transferProduct.index');
    Route::get('/transfer-products/show-class-products/{classId}', [TransferProductController::class, 'getAvailableProductsByClassId'])->name('transferProduct.getProductsByClass');
    Route::post('/transfer-products/add-to-cart', [TransferProductController::class, 'addToCart'])->name('transferProduct.addToCart');
    Route::get('/transfer-products/cart', [TransferProductController::class, 'viewCart'])->name('transferProduct.viewCart');
    Route::delete('/transfer-products/delete-from-cart/{id}', [TransferProductController::class, 'deleteFromCart'])->name('transferProduct.deleteFromCart');
    Route::post('/transfer-products/transfer', [TransferProductController::class, 'transfer'])->name('transferProduct.transfer');

    //Technical Support
    Route::get('/technical-support/problems', [ProblemController::class, 'index'])->name('supportProblem.index');
    Route::post('/technical-support/problems', [ProblemController::class, 'store'])->name('supportProblem.store');
    Route::get('/technical-support/problems/{id}', [ProblemController::class, 'show'])->name('supportProblem.show');
    Route::post('/technical-support/problems/update/{id}', [ProblemController::class, 'updateStatus'])->name('supportProblem.updateStatus');
    Route::post('/technical-support/problems/{id}', [ProblemController::class, 'addReply'])->name('supportProblem.addReply');

    Route::get('/technical-support/Requests', [RequestController::class, 'index'])->name('supportRequest.index');
    Route::post('/technical-support/Requests', [RequestController::class, 'store'])->name('supportRequest.store');
    Route::get('/technical-support/Requests/{id}', [RequestController::class, 'show'])->name('supportRequest.show');
    Route::post('/technical-support/Requests/update/{id}', [RequestController::class, 'updateStatus'])->name('supportRequest.updateStatus');
    Route::post('/technical-support/Requests/{id}', [RequestController::class, 'addReply'])->name('supportRequest.addReply');
});
