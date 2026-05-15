import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

export default function Index({ personalInfos, filters = {} }) {
    const { flash } = usePage().props;
    const { search = '' } = filters;

    function handleFilterChange(key, value) {
        router.get(route('personal-info.index'), { ...filters, [key]: value, page: 1 }, { preserveState: true, replace: true });
    }

    function formatCpf(cpf) {
        if (!cpf) return '-';
        const c = cpf.replace(/\D/g, '');
        if (c.length !== 11) return cpf;
        return c.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    }

    function formatRg(rg) {
        if (!rg) return '-';
        const r = rg.replace(/\D/g, '');
        if (r.length !== 9) return rg;
        return r.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4');
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Funcionários</h2>
                <Link href={route('personal-info.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Funcionário</Link>
            </div>
        }>
            <Head title="Funcionários" />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 flex gap-4">
                    <input type="text" value={search} onChange={e => handleFilterChange('search', e.target.value)}
                        placeholder="Buscar por nome ou CPF..."
                        className="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">CPF</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">RG</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data Nascimento</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Sexo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Estado Civil</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {personalInfos.data.length === 0 ? (
                                <tr><td colSpan="8" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum funcionário encontrado.</td></tr>
                            ) : personalInfos.data.map((p) => (
                                <tr key={p.id}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{p.user?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{formatCpf(p.user?.cpf)}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{formatRg(p.rg)}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.birth_date || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.gender || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.marital_status?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">{p.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Não</span>}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <Link href={route('personal-info.show', p.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        <Link href={route('personal-info.edit', p.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {personalInfos.links && (
                    <div className="mt-4 flex justify-center gap-1">
                        {personalInfos.links.map((link, i) => (
                            <button key={i} onClick={() => {
                                if (link.url) router.get(link.url, {}, { preserveState: true, replace: true });
                            }} disabled={!link.url}
                                className={`rounded px-3 py-1 text-sm ${link.active ? 'bg-indigo-600 text-white' : link.url ? 'bg-white text-gray-700 hover:bg-gray-100' : 'bg-gray-100 text-gray-400'}`}
                                dangerouslySetInnerHTML={{ __html: link.label }} />
                        ))}
                    </div>
                )}
            </div></div>
        </AuthenticatedLayout>
    );
}
