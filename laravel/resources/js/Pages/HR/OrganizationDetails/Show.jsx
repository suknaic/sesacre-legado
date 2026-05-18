import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ organizationDetail }) {
    const d = organizationDetail;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">{d.name}</h2>
                <Link href={route('organization-details.edit', d.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
            </div>
        }>
            <Head title={d.name} />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg"><div className="p-6">
                    <dl className="grid grid-cols-2 gap-4">
                        <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{d.name}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Categoria</dt><dd className="mt-1 text-sm text-gray-900">{d.category?.name || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">CNPJ</dt><dd className="mt-1 text-sm text-gray-900">{d.cnpj || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Cidade</dt><dd className="mt-1 text-sm text-gray-900">{d.city?.name || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Endereço</dt><dd className="mt-1 text-sm text-gray-900">{d.address || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Bairro</dt><dd className="mt-1 text-sm text-gray-900">{d.neighborhood || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">CEP</dt><dd className="mt-1 text-sm text-gray-900">{d.zip_code || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Telefone</dt><dd className="mt-1 text-sm text-gray-900">{d.phone || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Gestor</dt><dd className="mt-1 text-sm text-gray-900">{d.manager?.name || '-'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Principal</dt><dd className="mt-1 text-sm text-gray-900">{d.is_principal ? 'Sim' : 'Não'}</dd></div>
                        <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{d.is_active ? 'Sim' : 'Não'}</dd></div>
                    </dl>
                    <div className="mt-6">
                        <Link href={route('organization-details.index')} className="text-sm text-gray-600 hover:text-gray-900">Voltar</Link>
                    </div>
                </div></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
