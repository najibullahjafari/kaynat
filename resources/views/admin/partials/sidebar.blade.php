<div x-data="{ open: false }" @click.away="open = false" class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
        <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200">
            <span class="text-xl font-semibold text-gray-800">
                Kaynat Admin
            </span>
        </div>
        <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <nav class="flex-1 space-y-2">
                {{-- <x-admin.nav-link href="{{ route('admin.dashboard') }}"
                    :active="request()->routeIs('admin.dashboard')">
                    <x-icons.dashboard class="w-5 h-5" />
                    <span>Dashboard</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.dynamic-content') }}"
                    :active="request()->routeIs('admin.dynamic-content')">
                    <x-icons.content class="w-5 h-5" />
                    <span>Dynamic Content</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.sections') }}" :active="request()->routeIs('admin.sections')">
                    <x-icons.section class="w-5 h-5" />
                    <span>Sections</span>
                </x-admin.nav-link> --}}

                <x-admin.nav-link href="{{ route('admin.solutions') }}" :active="request()->routeIs('admin.solutions')">
                    <x-icons.solution class="w-5 h-5" />
                    <span>Solutions</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.features') }}" :active="request()->routeIs('admin.features')">
                    <x-icons.feature class="w-5 h-5" />
                    <span>Features</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.technology') }}"
                    :active="request()->routeIs('admin.technology')">
                    <x-icons.tech class="w-5 h-5" />
                    <span>Technology</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.industries') }}"
                    :active="request()->routeIs('admin.industries')">
                    <x-icons.industry class="w-5 h-5" />
                    <span>Industries</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.testimonials') }}"
                    :active="request()->routeIs('admin.testimonials')">
                    <x-icons.testimonial class="w-5 h-5" />
                    <span>Testimonials</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.team') }}" :active="request()->routeIs('admin.team')">
                    <x-icons.team class="w-5 h-5" />
                    <span>Team</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.contacts') }}" :active="request()->routeIs('admin.contacts')">
                    <x-icons.contact class="w-5 h-5" />
                    <span>Contacts</span>
                </x-admin.nav-link>

                <x-admin.nav-link href="{{ route('admin.settings') }}" :active="request()->routeIs('admin.settings')">
                    <x-icons.settings class="w-5 h-5" />
                    <span>Settings</span>
                </x-admin.nav-link>
            </nav>
            <div class="mt-8 border-t pt-4">
                <a href="{{ route('profile.admin.edit') }}"
                    class="flex items-center space-x-2 px-2 py-2 rounded hover:bg-gray-100 transition">
                    <i class="fa fa-user-edit text-gray-500"></i>
                    <span>Edit Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-2 px-2 py-2 rounded hover:bg-gray-100 transition w-full text-left">
                        <i class="fa fa-sign-out-alt text-gray-500"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>