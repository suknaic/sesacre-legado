import Dropdown from '@/Components/Dropdown';
import Sidebar from '@/Components/Sidebar';
import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function AuthenticatedLayout({ header, children }) {
    const user = usePage().props.auth.user;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    return (
        <div className="flex min-h-screen bg-gray-100">
            <Sidebar open={sidebarOpen} onClose={() => setSidebarOpen(false)} />

            <div className="flex flex-1 flex-col lg:pl-64">
                <nav className="sticky top-0 z-30 flex h-16 items-center border-b border-gray-200 bg-white shadow-sm">
                    <div className="flex flex-1 items-center px-4 sm:px-6">
                        <button
                            onClick={() => setSidebarOpen(true)}
                            className="mr-3 rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden"
                        >
                            <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div className="hidden lg:flex lg:flex-1" />

                        <div className="flex items-center gap-4">
                            <div className="relative">
                                <Dropdown>
                                    <Dropdown.Trigger>
                                        <button className="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                                            <div className="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                                                <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span className="hidden sm:inline">{user.name}</span>
                                            <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </Dropdown.Trigger>
                                    <Dropdown.Content>
                                        <Dropdown.Link href={route('profile.edit')}>
                                            Meus Dados
                                        </Dropdown.Link>
                                        <Dropdown.Link href={route('logout')} method="post" as="button">
                                            Sair
                                        </Dropdown.Link>
                                    </Dropdown.Content>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </nav>

                {header && (
                    <header className="border-b border-gray-200 bg-white">
                        <div className="mx-auto px-4 py-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                <main className="flex-1">
                    {children}
                </main>
            </div>
        </div>
    );
}
