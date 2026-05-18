<?php

use App\Http\Controllers\AnnualPlanController;
use App\Http\Controllers\BudgetProposalController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommitmentController;
use App\Http\Controllers\Compras\FinContratoController;
use App\Http\Controllers\Compras\FornecedorController;
use App\Http\Controllers\Compras\MaterialConsumoController;
use App\Http\Controllers\Compras\MaterialPermanenteController;
use App\Http\Controllers\Compras\MedicamentoController;
use App\Http\Controllers\Compras\ServicoController;
use App\Http\Controllers\Contabil\ConEmpenhoAnulacaoController;
use App\Http\Controllers\Contabil\ConEmpenhoController;
use App\Http\Controllers\Contabil\ConLiquidacaoController;
use App\Http\Controllers\Contabil\ConPagamentoController;
use App\Http\Controllers\ContractLocationController;
use App\Http\Controllers\ContractSituationController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationFormationController;
use App\Http\Controllers\EducationLevelController;
use App\Http\Controllers\EmploymentBondController;
use App\Http\Controllers\EmploymentContractController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\FeriasLicencasController;
use App\Http\Controllers\Financeiro\AutorizacaoController;
use App\Http\Controllers\Financeiro\CentralDemandaController;
use App\Http\Controllers\Financeiro\CentralResponsavelController;
use App\Http\Controllers\Financeiro\DocTramitacaoController;
use App\Http\Controllers\Financeiro\DocumentoFiscalController;
use App\Http\Controllers\Financeiro\DocumentoSituacaoController;
use App\Http\Controllers\Financeiro\DocVincEncaminhamentoController;
use App\Http\Controllers\Financeiro\DocVincRecebimentoController;
use App\Http\Controllers\Financeiro\OrdemController;
use App\Http\Controllers\Financeiro\PedidoController;
use App\Http\Controllers\Financeiro\PreOrdemController;
use App\Http\Controllers\Financeiro\TipoDocumentoController;
use App\Http\Controllers\Financeiro\TipoSolicitacaoController;
use App\Http\Controllers\JobFunctionController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\LegalEntityController;
use App\Http\Controllers\MaritalStatusController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\Orcamento\BlocoOrcamentarioController;
use App\Http\Controllers\Orcamento\CentralLiberacaoController;
use App\Http\Controllers\Orcamento\ConvenioController;
use App\Http\Controllers\Orcamento\DespesaController;
use App\Http\Controllers\Orcamento\DespesaElementoController;
use App\Http\Controllers\Orcamento\FonteController;
use App\Http\Controllers\Orcamento\PortariaController;
use App\Http\Controllers\Orcamento\ProgramaTrabalhoController;
use App\Http\Controllers\Orcamento\QddController;
use App\Http\Controllers\Orcamento\QddValorController;
use App\Http\Controllers\Orcamento\RedeTematicaController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationDetailController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PerDiemRequestController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\PlanActionController;
use App\Http\Controllers\PlanMaterialController;
use App\Http\Controllers\PlanObjectiveController;
use App\Http\Controllers\ProcessTypeController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\RecruitmentHistoryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StrategicPlanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('commitments', CommitmentController::class);
    Route::resource('purchase-requests', PurchaseRequestController::class);
    Route::resource('procurements', ProcurementController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('strategic-plans', StrategicPlanController::class);
    Route::resource('annual-plans', AnnualPlanController::class);
    Route::resource('per-diem-requests', PerDiemRequestController::class);

    // Planning
    Route::resource('plan-objectives', PlanObjectiveController::class);
    Route::resource('plan-actions', PlanActionController::class);
    Route::resource('plan-materials', PlanMaterialController::class);
    Route::resource('budget-proposals', BudgetProposalController::class);
    Route::resource('measurement-units', MeasurementUnitController::class);

    // HR - Administration
    Route::resource('job-positions', JobPositionController::class);
    Route::resource('job-functions', JobFunctionController::class);
    Route::resource('employment-bonds', EmploymentBondController::class);
    Route::resource('education-formations', EducationFormationController::class);
    Route::resource('education-levels', EducationLevelController::class);
    Route::resource('marital-statuses', MaritalStatusController::class);

    // HR - Origem
    Route::resource('countries', CountryController::class);
    Route::get('states/{state}/cities', [StateController::class, 'cities'])->name('states.cities');
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);

    // HR - Situações Contratuais
    Route::resource('contract-situations', ContractSituationController::class);

    // HR - Férias, Licenças e Concessões
    Route::get('ferias-licencas', [FeriasLicencasController::class, 'index'])->name('ferias-licencas.index');
    Route::get('ferias-licencas/create', [FeriasLicencasController::class, 'create'])->name('ferias-licencas.create');
    Route::post('ferias-licencas', [FeriasLicencasController::class, 'store'])->name('ferias-licencas.store');
    Route::get('ferias-licencas/{recruitmentHistory}', [FeriasLicencasController::class, 'show'])->name('ferias-licencas.show');
    Route::get('ferias-licencas/{recruitmentHistory}/edit', [FeriasLicencasController::class, 'edit'])->name('ferias-licencas.edit');
    Route::put('ferias-licencas/{recruitmentHistory}', [FeriasLicencasController::class, 'update'])->name('ferias-licencas.update');
    Route::delete('ferias-licencas/{recruitmentHistory}', [FeriasLicencasController::class, 'destroy'])->name('ferias-licencas.destroy');

    // HR - People
    Route::resource('personal-info', PersonalInfoController::class);
    Route::resource('employment-contracts', EmploymentContractController::class);
    Route::resource('employment-contracts.locations', ContractLocationController::class);
    Route::resource('employment-contracts.recruitment-history', RecruitmentHistoryController::class);

    // Purchasing
    Route::resource('suppliers', SupplierController::class);

    // Administration
    Route::resource('legal-entities', LegalEntityController::class);
    Route::resource('expense-types', ExpenseTypeController::class);
    Route::resource('process-types', ProcessTypeController::class);
    Route::resource('organizations', OrganizationController::class);
    Route::resource('organization-details', OrganizationDetailController::class);

    // Orcamento
    Route::prefix('orcamento')->name('orcamento.')->group(function () {
        Route::resource('qdd', QddController::class);
        Route::resource('qdd-valor', QddValorController::class);
        Route::resource('programa-trabalho', ProgramaTrabalhoController::class);
        Route::resource('fontes', FonteController::class);
        Route::resource('despesas', DespesaController::class);
        Route::resource('despesa-elementos', DespesaElementoController::class);
        Route::resource('blocos-orcamentarios', BlocoOrcamentarioController::class);
        Route::resource('redes-tematicas', RedeTematicaController::class);
        Route::resource('portarias', PortariaController::class);
        Route::resource('central-liberacoes', CentralLiberacaoController::class);
        Route::resource('convenios', ConvenioController::class);
    });

    // Financeiro
    Route::prefix('financeiro')->name('financeiro.')->group(function () {
        Route::get('pedidos-dashboard', [PedidoController::class, 'dashboardQuantidades'])->name('pedidos.dashboard');
        Route::post('pedidos/{pedido}/autorizar-imediato', [PedidoController::class, 'autorizarImediato'])->name('pedidos.autorizar-imediato');
        Route::post('pedidos/{pedido}/autorizar-central', [PedidoController::class, 'autorizarCentral'])->name('pedidos.autorizar-central');
        Route::post('pedidos/{pedido}/autorizar-orcamentario', [PedidoController::class, 'autorizarOrcamentario'])->name('pedidos.autorizar-orcamentario');
        Route::post('pedidos/{pedido}/autorizar-financeiro', [PedidoController::class, 'autorizarFinanceiro'])->name('pedidos.autorizar-financeiro');
        Route::post('pedidos/{pedido}/autorizar-ordenador', [PedidoController::class, 'autorizarOrdenador'])->name('pedidos.autorizar-ordenador');
        Route::resource('pedidos', PedidoController::class);
        Route::resource('autorizacoes', AutorizacaoController::class);
        Route::resource('centrais-demanda', CentralDemandaController::class);
        Route::resource('centrais-responsavel', CentralResponsavelController::class);
        Route::resource('tipos-solicitacao', TipoSolicitacaoController::class);
        Route::resource('pre-ordens', PreOrdemController::class);
        Route::resource('ordens', OrdemController::class);
        Route::post('ordens/{ordem}/requisitar', [OrdemController::class, 'requisitar'])->name('ordens.requisitar');
        Route::post('ordens/{ordem}/finalizar', [OrdemController::class, 'finalizar'])->name('ordens.finalizar');
        Route::post('ordens/{ordem}/cancelar', [OrdemController::class, 'cancelar'])->name('ordens.cancelar');
        Route::resource('documentos-fiscais', DocumentoFiscalController::class);
        Route::post('documentos-fiscais/{documentoFiscal}/encaminhar', [DocumentoFiscalController::class, 'encaminhar'])->name('documentos-fiscais.encaminhar');
        Route::post('documentos-fiscais/{documentoFiscal}/receber', [DocumentoFiscalController::class, 'receber'])->name('documentos-fiscais.receber');
        Route::post('documentos-fiscais/{documentoFiscal}/liquidar', [DocumentoFiscalController::class, 'liquidar'])->name('documentos-fiscais.liquidar');
        Route::post('documentos-fiscais/{documentoFiscal}/pagar', [DocumentoFiscalController::class, 'pagar'])->name('documentos-fiscais.pagar');
        Route::post('documentos-fiscais/{documentoFiscal}/cancelar', [DocumentoFiscalController::class, 'cancelarAction'])->name('documentos-fiscais.cancelar');
        Route::resource('doc-tramitacoes', DocTramitacaoController::class);
        Route::resource('tipos-documento', TipoDocumentoController::class);
        Route::resource('documentos-situacao', DocumentoSituacaoController::class)->only(['index', 'show']);
        Route::resource('doc-vinc-encaminhamentos', DocVincEncaminhamentoController::class)->except(['edit', 'update', 'show']);
        Route::resource('doc-vinc-recebimentos', DocVincRecebimentoController::class)->except(['edit', 'update', 'show']);
    });

    // Contábil
    Route::prefix('contabil')->name('contabil.')->group(function () {
        Route::resource('empenhos', ConEmpenhoController::class)->only(['index', 'create', 'store', 'show']);
        Route::delete('empenhos/{empenho}/cancelar', [ConEmpenhoController::class, 'cancelar'])->name('empenhos.cancelar');
        Route::resource('empenhos-anulacao', ConEmpenhoAnulacaoController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('empenhos-anulacao/{empenhoAnulacao}/assinar', [ConEmpenhoAnulacaoController::class, 'assinar'])->name('empenhos-anulacao.assinar');
        Route::delete('empenhos-anulacao/{empenhoAnulacao}/cancelar', [ConEmpenhoAnulacaoController::class, 'cancelar'])->name('empenhos-anulacao.cancelar');
        Route::resource('liquidacoes', ConLiquidacaoController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('liquidacoes/{liquidacao}/assinar', [ConLiquidacaoController::class, 'assinar'])->name('liquidacoes.assinar');
        Route::post('liquidacoes/{liquidacao}/finalizar-pagamento', [ConLiquidacaoController::class, 'finalizarPagamento'])->name('liquidacoes.finalizar-pagamento');
        Route::delete('liquidacoes/{liquidacao}/cancelar', [ConLiquidacaoController::class, 'cancelar'])->name('liquidacoes.cancelar');
        Route::resource('pagamentos', ConPagamentoController::class)->only(['index', 'create', 'store', 'show']);
        Route::delete('pagamentos/{pagamento}/cancelar', [ConPagamentoController::class, 'cancelar'])->name('pagamentos.cancelar');
    });

    // Compras
    Route::prefix('compras')->name('compras.')->group(function () {
        Route::resource('fornecedores', FornecedorController::class);
        Route::resource('contratos', FinContratoController::class);
        Route::resource('medicamentos', MedicamentoController::class)->only(['index', 'create', 'store']);
        Route::resource('servicos', ServicoController::class)->only(['index', 'create', 'store']);
        Route::resource('materiais-consumo', MaterialConsumoController::class)->only(['index', 'create', 'store']);
        Route::resource('materiais-permanente', MaterialPermanenteController::class)->only(['index', 'create', 'store']);
    });

    // Placeholder pages (pages ainda nao implementadas)
    Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
});

require __DIR__.'/auth.php';
