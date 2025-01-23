<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Boker;
use App\Models\Branch;
use App\Repositories\BankRepository;
use App\Repositories\RoleRepository;
use App\Repositories\BokerRepository;
use App\Repositories\CourtRepository;
use App\Repositories\BranchRepository;
use App\Repositories\RegionRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\MinistryRepository;
use App\Repositories\PermissionRepository;
use App\Interfaces\BankRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Repositories\GovernorateRepository;
use App\Repositories\NationalityRepository;
use App\Interfaces\BokerRepositoryInterface;
use App\Interfaces\CourtRepositoryInterface;
use App\Repositories\NotificationRepository;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\RegionRepositoryInterface;
use App\Repositories\PoliceStationRepository;
use App\Repositories\WorkingIncomeRepository;
use App\Repositories\InstallmentCarRepository;
use App\Interfaces\MinistryRepositoryInterface;
use App\Repositories\InstallmentNoteRepository;
use App\Repositories\InstallmentIssueRepository;
use App\Interfaces\PermissionRepositoryInterface;
use App\Repositories\InstallmentClientRepository;
use App\Repositories\Payments\PaymentsRepository;
use App\Repositories\Showroom\ShowroomRepository;
use App\Repositories\Transfer\TransferRepository;
use App\Interfaces\GovernorateRepositoryInterface;
use App\Interfaces\NationalityRepositoryInterface;
use App\Repositories\MinistryPercentageRepository;
use App\Interfaces\NotificationRepositoryInterface;
use App\Repositories\HumanResources\UserRepository;
use App\Interfaces\PoliceStationRepositoryInterface;
use App\Interfaces\WorkingIncomeRepositoryInterface;
use App\Interfaces\InstallmentCarRepositoryInterface;
use App\Repositories\HumanResources\ClientRepository;
use App\Repositories\HumanResources\MemberRepository;
use App\Repositories\InstallmentClientNoteRepository;
use App\Repositories\InstallmentPercentageRepository;
use App\Interfaces\InstallmentNoteRepositoryInterface;
use App\Repositories\Military_affairs\ImageRepository;
use App\Interfaces\InstallmentIssueRepositoryInterface;
use App\Repositories\ImportingCompanies\MarkRepository;
use App\Repositories\Military_affairs\PapersRepository;
use App\Repositories\Military_affairs\SearchRepository;
use App\Interfaces\Payments\PaymentsRepositoryInterface;
use App\Interfaces\Showroom\ShowroomRepositoryInterface;
use App\Interfaces\Transfer\TransferRepositoryInterface;
use App\Repositories\ImportingCompanies\ClassRepository;
use App\Repositories\TechnicalSupport\ProblemRepository;
use App\Repositories\TechnicalSupport\RequestRepository;
use App\Interfaces\InstallmentClientsRepositoryInterface;
use App\Interfaces\MinistryPercentageRepositoryInterface;
use App\Repositories\Military_affairs\CheckingRepository;
use App\Repositories\Military_affairs\Stop_carRepository;
use App\Interfaces\HumanResources\UserRepositoryInterface;
use App\Repositories\ImportingCompanies\CompanyRepository;
use App\Repositories\ImportingCompanies\ProductRepository;
use App\Repositories\ImportingCompanies\TawreedRepository;

use App\Repositories\Military_affairs\EqrardainRepository;
use App\Repositories\Military_affairs\Open_fileRepository;
use App\Repositories\Military_affairs\Stop_bankRepository;
use App\Repositories\Military_affairs\SettlementRepository;
use App\Interfaces\HumanResources\ClientRepositoryInterface;
use App\Interfaces\HumanResources\MemberRepositoryInterface;
use App\Interfaces\InstallmentClientNoteRepositoryInterface;
use App\Interfaces\InstallmentPercentageRepositoryInterface;
use App\Repositories\Military_affairs\CertificateRepository;
use App\Repositories\Military_affairs\Stop_salaryRepository;
use App\Repositories\Military_affairs\Stop_travelRepository;
use App\Interfaces\Military_affairs\ImageRepositoryInterface;
use App\Interfaces\ImportingCompanies\MarkRepositoryInterface;
use App\Interfaces\Military_affairs\PapersRepositoryInterface;
use App\Interfaces\Military_affairs\SearchRepositoryInterface;
use App\Repositories\Military_affairs\Execute_alertRepository;
use App\Interfaces\ImportingCompanies\ClassRepositoryInterface;
use App\Interfaces\TechnicalSupport\ProblemRepositoryInterface;
use App\Interfaces\TechnicalSupport\RequestRepositoryInterface;
use App\Repositories\Military_affairs\Excute_actionsRepository;
use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;
use App\Interfaces\ImportingCompanies\CompanyRepositoryInterface;
use App\Interfaces\ImportingCompanies\ProductRepositoryInterface;
use App\Interfaces\ImportingCompanies\TawreedRepositoryInterface;
use App\Interfaces\Military_affairs\EqrardainRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_bankRepositoryInterface;
use App\Repositories\HumanResources\CommuncationMethodRepository;
use App\Repositories\ImportingCompanies\PurchaseOrdersRepository;
use App\Repositories\Military_affairs\Military_affairsRepository;
use App\Interfaces\Military_affairs\SettlementRepositoryInterface;
use App\Repositories\ImportingCompanies\TransferProductRepository;
use App\Interfaces\Military_affairs\CertificateRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_salaryRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Repositories\HumanResources\TransactionsCompletedRepository;
use App\Interfaces\Military_affairs\Execute_alertRepositoryInterface;
use App\Interfaces\Military_affairs\Excute_actionsRepositoryInterface;
use App\Interfaces\HumanResources\CommuncationMethodRepositoryInterface;
use App\Interfaces\ImportingCompanies\PurchaseOrdersRepositoryInterface;
use App\Interfaces\Military_affairs\Military_affairsRepositoryInterface;
use App\Interfaces\ImportingCompanies\TransferProductRepositoryInterface;
use App\Interfaces\HumanResources\TransactionsCompletedRepositoryInterface;
use App\Interfaces\TechnicalSupport\ReportRepositoryInterface;
use App\Repositories\TechnicalSupport\ReportRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NationalityRepositoryInterface::class, NationalityRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(GovernorateRepositoryInterface::class, GovernorateRepository::class);
        $this->app->bind(CourtRepositoryInterface::class, CourtRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(PoliceStationRepositoryInterface::class, PoliceStationRepository::class);
        $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
        $this->app->bind(InstallmentPercentageRepositoryInterface::class, InstallmentPercentageRepository::class);
        $this->app->bind(MinistryPercentageRepositoryInterface::class, MinistryPercentageRepository::class);
        $this->app->bind(MinistryRepositoryInterface::class, MinistryRepository::class);
        $this->app->bind(BokerRepositoryInterface::class, BokerRepository::class);
        $this->app->bind(CommuncationMethodRepositoryInterface::class, CommuncationMethodRepository::class);
        $this->app->bind(TransactionsCompletedRepositoryInterface::class, TransactionsCompletedRepository::class);
        $this->app->bind(InstallmentClientsRepositoryInterface::class, InstallmentClientRepository::class);
        $this->app->bind(InstallmentIssueRepositoryInterface::class, InstallmentIssueRepository::class);
        $this->app->bind(InstallmentCarRepositoryInterface::class, InstallmentCarRepository::class);

        $this->app->bind(InstallmentNoteRepositoryInterface::class, InstallmentNoteRepository::class);
        $this->app->bind(InstallmentClientNoteRepositoryInterface::class, InstallmentClientNoteRepository::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(TawreedRepositoryInterface::class, TawreedRepository::class);
        $this->app->bind(Open_fileRepositoryInterface::class, Open_fileRepository::class);
        $this->app->bind(ShowroomRepositoryInterface::class, ShowroomRepository::class);
        $this->app->bind(TransferRepositoryInterface::class, TransferRepository::class);
        $this->app->bind(CertificateRepositoryInterface::class, CertificateRepository::class);
        $this->app->bind(Execute_alertRepositoryInterface::class, Execute_alertRepository::class);
        $this->app->bind(Stop_carRepositoryInterface::class, Stop_carRepository::class);
        $this->app->bind(Stop_salaryRepositoryInterface::class, Stop_salaryRepository::class);

        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);

        $this->app->bind(Military_affairsRepositoryInterface::class, Military_affairsRepository::class);
        $this->app->bind(PapersRepositoryInterface::class, PapersRepository::class);
        $this->app->bind(Execute_alertRepositoryInterface::class, Execute_alertRepository::class);

        $this->app->bind(Military_affairsRepositoryInterface::class, Military_affairsRepository::class);
        $this->app->bind(PapersRepositoryInterface::class, PapersRepository::class);
        $this->app->bind(Stop_travelRepositoryInterface::class, Stop_travelRepository::class);
        $this->app->bind(Stop_bankRepositoryInterface::class, Stop_bankRepository::class);
        $this->app->bind(CheckingRepositoryInterface::class, CheckingRepository::class);
        $this->app->bind(Excute_actionsRepositoryInterface::class, Excute_actionsRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(EqrardainRepositoryInterface::class, EqrardainRepository::class);
        $this->app->bind(SettlementRepositoryInterface::class, SettlementRepository::class);
        $this->app->bind(WorkingIncomeRepositoryInterface::class, WorkingIncomeRepository::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(PaymentsRepositoryInterface::class, PaymentsRepository::class);
        $this->app->bind(PurchaseOrdersRepositoryInterface::class, PurchaseOrdersRepository::class);
        $this->app->bind(MarkRepositoryInterface::class, MarkRepository::class);
        $this->app->bind(ClassRepositoryInterface::class, ClassRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(TransferProductRepositoryInterface::class, TransferProductRepository::class);
        $this->app->bind(SearchRepositoryInterface::class, SearchRepository::class);
         $this->app->bind(ProblemRepositoryInterface::class, ProblemRepository::class);
        $this->app->bind(RequestRepositoryInterface::class, RequestRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);



    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('ar');
    }
}