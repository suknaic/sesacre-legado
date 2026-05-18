import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ planMaterial }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Material</h2>
                <Link href={route('plan-materials.edit', planMaterial.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
            </div>
        }>
            <Head title="Material" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('plan-materials.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Código</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.code || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Código Descrição</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.description_code || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome Descrição</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.description_name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Código Grupo</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.group_code || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome Grupo</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.group_name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Código Subgrupo</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.subgroup_code || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome Subgrupo</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.subgroup_name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo de Material</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.material_type || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Código Elemento Despesa</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.expense_element_code || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo de Despesa (ID)</dt><dd className="mt-1 text-sm text-gray-900">{planMaterial.expense_type_id || '-'}</dd></div>
                        </dl>
                    </div>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
