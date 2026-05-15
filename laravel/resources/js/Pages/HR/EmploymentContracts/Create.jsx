import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useState } from 'react';

function validateCPF(cpf) {
    const cleaned = cpf.replace(/\D/g, '');
    if (cleaned.length !== 11) return 'CPF deve conter exatamente 11 dígitos.';
    if (/^(\d)\1{10}$/.test(cleaned)) return 'CPF inválido (todos os dígitos iguais).';
    for (let t = 9; t < 11; t++) {
        let d = 0;
        for (let c = 0; c < t; c++) d += parseInt(cleaned[c]) * ((t + 1) - c);
        d = ((10 * d) % 11) % 10;
        if (parseInt(cleaned[t]) !== d) return 'CPF inválido.';
    }
    return null;
}

export default function Create({ personalInfos = [], employmentBonds = [], jobPositions = [], legalEntities = [], organizations = [], jobFunctions = [] }) {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors, setError, clearErrors } = useForm({
        registration_number: '', personal_info_id: '', employment_bond_id: '', job_position_id: '',
        legal_entity_id: '', admission_date: '', termination_date: '', workload: '',
        notes: '', is_active: true,
        contract_locations: [],
    });
    const [cpfError, setCpfError] = useState(null);
    const [selectedPersonalInfo, setSelectedPersonalInfo] = useState(null);

    function handlePersonalInfoChange(id) {
        setData('personal_info_id', id);
        const pi = personalInfos.find(p => p.id == id);
        setSelectedPersonalInfo(pi || null);
        if (pi?.cpf) {
            const err = validateCPF(pi.cpf);
            setCpfError(err);
        } else {
            setCpfError('Funcionário sem CPF cadastrado.');
        }
    }

    function handleSubmit(e) {
        e.preventDefault();
        if (selectedPersonalInfo?.cpf && validateCPF(selectedPersonalInfo.cpf)) {
            setCpfError(validateCPF(selectedPersonalInfo.cpf));
            return;
        }
        clearErrors();
        post(route('employment-contracts.store'));
    }

    function addLocation() {
        setData('contract_locations', [...data.contract_locations, { organization_id: '', job_function_id: '', workload: '', start_date: '', end_date: '' }]);
    }

    function removeLocation(i) {
        setData('contract_locations', data.contract_locations.filter((_, idx) => idx !== i));
    }

    function setLocation(i, field, value) {
        const locs = [...data.contract_locations];
        locs[i] = { ...locs[i], [field]: value };
        setData('contract_locations', locs);
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Contrato de Trabalho</h2>}>
            <Head title="Novo Contrato" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('employment-contracts.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Funcionário *</label>
                            <select value={data.personal_info_id} onChange={e => handlePersonalInfoChange(e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {personalInfos.map((p) => <option key={p.id} value={p.id}>{p.name}{p.cpf ? ` - ${p.cpf}` : ''}</option>)}
                            </select>
                            {cpfError && <p className="mt-1 text-sm text-red-600">{cpfError}</p>}
                            {errors.personal_info_id && <p className="mt-1 text-sm text-red-600">{errors.personal_info_id}</p>}
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Matrícula</label>
                                <input type="text" value={data.registration_number} onChange={e => setData('registration_number', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Vínculo</label>
                                <select value={data.employment_bond_id} onChange={e => setData('employment_bond_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {employmentBonds.map((b) => <option key={b.id} value={b.id}>{b.name}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Cargo</label>
                                <select value={data.job_position_id} onChange={e => setData('job_position_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {jobPositions.map((j) => <option key={j.id} value={j.id}>{j.name}</option>)}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Pessoa Jurídica</label>
                                <select value={data.legal_entity_id} onChange={e => setData('legal_entity_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {legalEntities.map((l) => <option key={l.id} value={l.id}>{l.name}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data de Admissão *</label>
                                <input type="date" value={data.admission_date} onChange={e => setData('admission_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.admission_date && <p className="mt-1 text-sm text-red-600">{errors.admission_date}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data de Término</label>
                                <input type="date" value={data.termination_date} onChange={e => setData('termination_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.termination_date && <p className="mt-1 text-sm text-red-600">{errors.termination_date}</p>}
                            </div>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Carga Horária (horas) *</label>
                            <input type="number" value={data.workload} onChange={e => setData('workload', e.target.value)}
                                min="1" max="40"
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.workload && <p className="mt-1 text-sm text-red-600">{errors.workload}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea value={data.notes} onChange={e => setData('notes', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3" />
                        </div>

                        <div className="mb-6">
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span className="text-sm text-gray-700">Ativo</span>
                            </label>
                        </div>

                        <div className="mb-6">
                            <div className="flex items-center justify-between mb-2">
                                <h3 className="text-lg font-medium text-gray-900">Lotações</h3>
                                <button type="button" onClick={addLocation}
                                    className="rounded-md bg-green-600 px-3 py-1 text-sm font-semibold text-white shadow hover:bg-green-500">+ Adicionar Lotação</button>
                            </div>
                            {errors.contract_locations && <p className="mb-2 text-sm text-red-600">{errors.contract_locations}</p>}
                            {data.contract_locations.map((loc, i) => (
                                <div key={i} className="mb-4 rounded-md border border-gray-200 p-4">
                                    <div className="mb-2 flex items-center justify-between">
                                        <span className="text-sm font-medium text-gray-700">Lotação #{i + 1}</span>
                                        <button type="button" onClick={() => removeLocation(i)}
                                            className="text-sm text-red-600 hover:text-red-800">Remover</button>
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-xs font-medium text-gray-600">Organização *</label>
                                            <select value={loc.organization_id} onChange={e => setLocation(i, 'organization_id', e.target.value)}
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Selecione...</option>
                                                {organizations.map((o) => <option key={o.id} value={o.id}>{o.name}</option>)}
                                            </select>
                                        </div>
                                        <div>
                                            <label className="block text-xs font-medium text-gray-600">Função</label>
                                            <select value={loc.job_function_id} onChange={e => setLocation(i, 'job_function_id', e.target.value)}
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Selecione...</option>
                                                {jobFunctions.map((f) => <option key={f.id} value={f.id}>{f.name}</option>)}
                                            </select>
                                        </div>
                                    </div>
                                    <div className="mt-2 grid grid-cols-3 gap-4">
                                        <div>
                                            <label className="block text-xs font-medium text-gray-600">Carga Horária *</label>
                                            <input type="number" value={loc.workload} onChange={e => setLocation(i, 'workload', e.target.value)}
                                                min="1" max="40"
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-medium text-gray-600">Data Início *</label>
                                            <input type="date" value={loc.start_date} onChange={e => setLocation(i, 'start_date', e.target.value)}
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-medium text-gray-600">Data Fim</label>
                                            <input type="date" value={loc.end_date} onChange={e => setLocation(i, 'end_date', e.target.value)}
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('employment-contracts.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
                            <button type="submit" disabled={processing}
                                className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">
                                {processing ? 'Salvando...' : 'Salvar'}</button>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
