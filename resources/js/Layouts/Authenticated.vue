<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('grupos.index')" :active="route().current('grupos.index')">
                                    Grupos
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('personas.index')" :active="route().current('personas.index')">
                                    Personas
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('medios.index')" :active="route().current('medios.index')">
                                    Medios
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('etiquetas.index')" :active="route().current('etiquetas.index')">
                                    Etiquetas
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('categorias.index')" :active="route().current('categorias.index')">
                                    Categorias
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('tipos.index')" :active="route().current('tipos.index')">
                                    Tipos
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('tipos-links.index')" :active="route().current('tipos-links.index')">
                                    Tipos de Links
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('links.index')" :active="route().current('links.index')">
                                    Links
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('grupos.index')" :active="route().current('grupos.index')">
                            Grupos
                        </BreezeResponsiveNavLink>
                         <BreezeResponsiveNavLink :href="route('personas.index')" :active="route().current('personas.index')">
                            Personas
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('medios.index')" :active="route().current('medios.index')">
                            Medios
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('etiquetas.index')" :active="route().current('etiquetas.index')">
                            Etiquetas
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('categorias.index')" :active="route().current('categorias.index')">
                            Categorias
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('tipos.index')" :active="route().current('tipos.index')">
                            Tipos
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('tipos-links.index')" :active="route().current('tipos-links.index')">
                            Tipos de Links
                        </BreezeResponsiveNavLink>
                        <BreezeResponsiveNavLink :href="route('links.index')" :active="route().current('links.index')">
                            Links
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>
