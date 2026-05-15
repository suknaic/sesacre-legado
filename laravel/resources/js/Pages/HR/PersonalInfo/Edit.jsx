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

export default function Edit({ personalInfo, maritalStatuses = [], educationFormations = [], states = [] }) {
    const { flash } = usePage().props;
    const { data, setData, put, processing, errors, setError, clearErrors } = useForm({
        name: personalInfo.user?.name || '',
        email: personalInfo.user?.email || '',
        cpf: personalInfo.user?.cpf || '',
        phone: personalInfo.user?.phone || '',
        mobile: personalInfo.user?.mobile || '',
        address: personalInfo.user?.address || '',
        neighborhood: personalInfo.user?.neighborhood || '',
        zip_code: personalInfo.user?.zip_code || '',
        city_id: personalInfo.user?.city_id || '',
        gender: personalInfo.gender || '',
        rg: personalInfo.rg || '',
        issuing_agency: personalInfo.issuing_agency || '',
        issuing_state_id: personalInfo.issuing_state_id || '',
        marital_status_id: personalInfo.marital_status_id || '',
        education_formation_id: personalInfo.education_formation_id || '',
        skills: personalInfo.skills || '',
        father_name: personalInfo.father_name || '',
        mother_name: personalInfo.mother_name || '',
        birth_date: personalInfo.birth_date || '',
        cns_number: personalInfo.cns_number || '',
        is_active: personalInfo.is_active ?? true,
    });

    const [cpfError, setCpfError] = useState(null);
    const [addressStateId, setAddressStateId] = useState('');
    const [cityOptions, setCityOptions] = useState([]);
    const [loadingCities, setLoadingCities] = useState(false);

    function loadCities(stateId) {
        setAddressStateId(stateId);
        setData('city_id', '');
        if (!stateId) {
            setCityOptions([]);
            return;
        }
        setLoadingCities(true);
        fetch(`/states/${stateId}/cities`)
            .then(res => res.json())
            .then(data => setCityOptions(data))
            .catch(() => setCityOptions([]))
            .finally(() => setLoadingCities(false));
    }

    function handleCpfBlur() {
        if (data.cpf) {
            const err = validateCPF(data.cpf);
            setCpfError(err);
        }
    }

    function handleCepBlur() {
        const cep = data.zip_code?.replace(/\D/g, '');
        if (cep && cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(res => res.json())
                .then(json => {
                    if (!json.erro) {
                        setData('address', json.logradouro || '');
                        setData('neighborhood', json.bairro || '');
                    }
                })
                .catch(() => {});
        }
    }

    function handleSubmit(e) {
        e.preventDefault();
        if (data.cpf) {
            const err = validateCPF(data.cpf);
            if (err) { setCpfError(err); return; }
        }
        setCpfError(null);
        clearErrors();
        put(route('personal-info.update', personalInfo.id));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar {personalInfo.user?.name || 'Funcionário'}</h2>}>
            <Head title="Editar Funcionário" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('personal-info.show', personalInfo.id)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                        <h3 className="mb-4 text-lg font-medium text-gray-900">Dados do Usuário</h3>
                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Nome *</label>
                                <input type="text" value={data.name} onChange={e => setData('name', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">CPF *</label>
                                <input type="text" value={data.cpf} onChange={e => setData('cpf', e.target.value)} onBlur={handleCpfBlur}
                                    placeholder="000.000.000-00"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {cpfError && <p className="mt-1 text-sm text-red-600">{cpfError}</p>}
                                {errors.cpf && <p className="mt-1 text-sm text-red-600">{errors.cpf}</p>}
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">E-mail</label>
                                <input type="email" value={data.email} onChange={e => setData('email', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.email && <p className="mt-1 text-sm text-red-600">{errors.email}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Telefone</label>
                                <input type="text" value={data.phone} onChange={e => setData('phone', e.target.value)}
                                    placeholder="(68) 99999-9999"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" value={data.mobile} onChange={e => setData('mobile', e.target.value)}
                                    placeholder="(68) 99999-9999"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">CEP</label>
                                <input type="text" value={data.zip_code} onChange={e => setData('zip_code', e.target.value)} onBlur={handleCepBlur}
                                    placeholder="69900-000"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Endereço</label>
                            <input type="text" value={data.address} onChange={e => setData('address', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>

                        <div className="mb-4 grid grid-cols-3 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Bairro</label>
                                <input type="text" value={data.neighborhood} onChange={e => setData('neighborhood', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">UF</label>
                                <select value={addressStateId} onChange={e => loadCities(Number(e.target.value) || '')}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {(states || []).map((s) => <option key={s.id} value={s.id}>{s.code}</option>)}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Cidade</label>
                                <select value={data.city_id} onChange={e => setData('city_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {loadingCities && <option value="" disabled>Carregando...</option>}
                                    {!loadingCities && (cityOptions || []).map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
                                </select>
                            </div>
                        </div>

                        <hr className="my-6" />

                        <h3 className="mb-4 text-lg font-medium text-gray-900">Dados Pessoais</h3>
                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Sexo</label>
                                <select value={data.gender} onChange={e => setData('gender', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                                {errors.gender && <p className="mt-1 text-sm text-red-600">{errors.gender}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                <input type="date" value={data.birth_date} onChange={e => setData('birth_date', e.target.value)}
                                    max={new Date().toISOString().split('T')[0]}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.birth_date && <p className="mt-1 text-sm text-red-600">{errors.birth_date}</p>}
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">RG</label>
                                <input type="text" value={data.rg} onChange={e => setData('rg', e.target.value)}
                                    placeholder="00.000.000-0"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.rg && <p className="mt-1 text-sm text-red-600">{errors.rg}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Órgão Expedidor</label>
                                <input type="text" value={data.issuing_agency} onChange={e => setData('issuing_agency', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">UF do Órgão Expedidor</label>
                                <select value={data.issuing_state_id} onChange={e => setData('issuing_state_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {(states || []).map((s) => <option key={s.id} value={s.id}>{s.name}</option>)}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Estado Civil</label>
                                <select value={data.marital_status_id} onChange={e => setData('marital_status_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {(maritalStatuses || []).map((m) => <option key={m.id} value={m.id}>{m.name}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Formação</label>
                                <select value={data.education_formation_id} onChange={e => setData('education_formation_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {(educationFormations || []).map((f) => <option key={f.id} value={f.id}>{f.name}</option>)}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">CNS</label>
                                <input type="text" value={data.cns_number} onChange={e => setData('cns_number', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Nome do Pai</label>
                                <input type="text" value={data.father_name} onChange={e => setData('father_name', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Nome da Mãe</label>
                                <input type="text" value={data.mother_name} onChange={e => setData('mother_name', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Habilidades</label>
                            <textarea value={data.skills} onChange={e => setData('skills', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3" />
                        </div>

                        <div className="mb-6">
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span className="text-sm text-gray-700">Ativo</span>
                            </label>
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('personal-info.show', personalInfo.id)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
