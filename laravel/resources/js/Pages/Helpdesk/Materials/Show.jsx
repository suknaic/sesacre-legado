import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ material }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">{material.name}</h2>
                <div className="flex gap-2">
                    <Link href={route('materials.edit', material.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                        Editar
                    </Link>
                    <Link href={route('materials.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">
                        Voltar
                    </Link>
                </div>
            </div>
        }>
            <Head title={material.name} />
            <div className="py-8">
                <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <span className="text-sm font-medium text-gray-500">Nome</span>
                                <p className="text-gray-900">{material.name}</p>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Marca</span>
                                    <p className="text-gray-900">{material.brand || '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Modelo</span>
                                    <p className="text-gray-900">{material.model || '-'}</p>
                                </div>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Patrimônio</span>
                                    <p className="text-gray-900">{material.patrimony_number || '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Nº Serial</span>
                                    <p className="text-gray-900">{material.serial_number || '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Estado</span>
                                    <p className="text-gray-900">{material.state || '-'}</p>
                                </div>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Data de Aquisição</span>
                                    <p className="text-gray-900">{material.purchase_date?.split('T')[0] || '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Preço</span>
                                    <p className="text-gray-900">{material.price ? `R$ ${material.price}` : '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Garantia</span>
                                    <p className="text-gray-900">{material.warranty_months ? `${material.warranty_months} meses` : '-'}</p>
                                </div>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Processador</span>
                                <p className="text-gray-900">{material.processor || '-'}</p>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span className="text-sm font-medium text-gray-500">RAM</span>
                                    <p className="text-gray-900">{material.ram_memory ? `${material.ram_memory} GB` : '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">HD</span>
                                    <p className="text-gray-900">{material.hd_size ? `${material.hd_size} GB` : '-'}</p>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Wireless</span>
                                    <p className="text-gray-900">{material.has_wireless ? 'Sim' : 'Não'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
