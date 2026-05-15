import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ organization }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{organization.name}</h2>}>
            <Head title={organization.name} />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('organizations.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{organization.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Organização Superior</dt><dd className="mt-1 text-sm text-gray-900">{organization.parent?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Categoria</dt><dd className="mt-1 text-sm text-gray-900">{organization.category?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CNPJ</dt><dd className="mt-1 text-sm text-gray-900">{organization.cnpj || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Cidade</dt><dd className="mt-1 text-sm text-gray-900">{organization.city?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Endereço</dt><dd className="mt-1 text-sm text-gray-900">{organization.address || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Bairro</dt><dd className="mt-1 text-sm text-gray-900">{organization.neighborhood || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CEP</dt><dd className="mt-1 text-sm text-gray-900">{organization.zip_code || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">E-mail</dt><dd className="mt-1 text-sm text-gray-900">{organization.email || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Telefone</dt><dd className="mt-1 text-sm text-gray-900">{organization.phone || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Latitude</dt><dd className="mt-1 text-sm text-gray-900">{organization.latitude || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Longitude</dt><dd className="mt-1 text-sm text-gray-900">{organization.longitude || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Gestor</dt><dd className="mt-1 text-sm text-gray-900">{organization.manager?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Principal</dt><dd className="mt-1 text-sm text-gray-900">{organization.is_principal ? 'Sim' : 'Não'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{organization.is_active ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6"><Link href={route('organizations.edit', organization.id)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
