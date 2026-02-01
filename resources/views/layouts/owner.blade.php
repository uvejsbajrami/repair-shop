<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Owner Dashboard') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $shopSettings = shop_settings();
        $primaryColor = $shopSettings?->primary_color ?? '#2563eb';
        $accentColor = $shopSettings?->accent_color ?? '#22c55e';

        // Calculate darker shade for header (darken by ~10%)
        $primaryDarker = $primaryColor;
        if (preg_match('/^#([A-Fa-f0-9]{6})$/', $primaryColor, $matches)) {
            $hex = $matches[1];
            $r = max(0, hexdec(substr($hex, 0, 2)) - 25);
            $g = max(0, hexdec(substr($hex, 2, 2)) - 25);
            $b = max(0, hexdec(substr($hex, 4, 2)) - 25);
            $primaryDarker = sprintf('#%02x%02x%02x', $r, $g, $b);
        }
    @endphp

    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --primary-darker: {{ $primaryDarker }};
            --accent-color: {{ $accentColor }};
        }

        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Custom color classes */
        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-primary-darker { background-color: var(--primary-darker) !important; }
        .text-primary { color: var(--primary-color) !important; }
        .bg-accent { background-color: var(--accent-color) !important; }
        .text-accent { color: var(--accent-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }
        .ring-primary:focus { --tw-ring-color: var(--primary-color) !important; }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-white flex-shrink-0 hidden md:flex flex-col">
            <!-- Sidebar Header -->
            <div class="p-6 bg-primary-darker">
                <a href="/">
                    <h1 class="text-2xl font-bold">Owner Dashboard</h1>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                @if (auth()->user()?->isAdmin())
                    <a href="{{ url('/admin') }}"
                        class="sidebar-link flex items-center px-6 py-3 text-white transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <span>Admin Panel</span>
                    </a>
                @endif
                <a href="{{ route('owner.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Overview</span>
                </a>


                <a href="{{ route('owner.repairs') }}"
                    class="sidebar-link {{ request()->routeIs('owner.repairs') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Repairs / Jobs</span>
                </a>

                @php
                    $shopForNav = \App\Models\Shop::where('owner_id', auth()->id())->first();
                    $maxEmployeesForNav = $shopForNav?->shopPlan?->plan?->max_employees ?? 0;
                @endphp
                @if ($maxEmployeesForNav > 0 || $maxEmployeesForNav == -1)
                    <a href="{{ route('owner.employees.index') }}"
                        class="sidebar-link {{ request()->routeIs('owner.employees.*') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span>Employees</span>
                    </a>
                @endif

                @if (in_array(current_plan(), ['standard', 'pro']))
                    <a href="{{ route('owner.repairs.logs') }}"
                        class="sidebar-link {{ request()->routeIs('owner.repairs.logs') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                        <span>Repair Logs</span>
                    </a>
                @endif

                @if (current_plan() === 'pro')
                    <a href="{{ route('owner.repairs.all') }}"
                        class="sidebar-link {{ request()->routeIs('owner.repairs.all') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        <span>Export Data</span>
                    </a>

                    <a href="{{ route('owner.settings') }}"
                        class="sidebar-link {{ request()->routeIs('owner.settings') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Shop Settings</span>
                    </a>
                @endif
            </nav>

            <!-- Upgrade Plan Button in Sidebar -->
            @if (App\Models\PlanApplication::where('user_id', auth()->id())->where('status', 'pending')->exists())
                <div class="px-4 py-4 border-t border-white/20 mt-auto">
                    <p class="font-bold text-white">Application Pending</p>
                    <p class="text-sm mt-1 text-white/80">Please wait until your application is approved.</p>
                </div>
            @else
                <div class="px-4 py-4 border-t border-white/20 mt-auto">
                    <a href="/#plansSection"
                        class="flex items-center justify-center w-full px-4 py-3 bg-white text-primary rounded-lg font-semibold hover:bg-gray-100 transition shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Upgrade Plan
                    </a>
                </div>
            @endif
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="md:hidden text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Page Title (visible on mobile) -->
                    <h2 class="md:hidden text-lg font-semibold text-gray-800">Owner Dashboard</h2>

                    <!-- Right Side: Search, Notifications, Profile -->
                    <div class="flex items-center space-x-4 ml-auto">
                        <!-- Search Bar (hidden on mobile) -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <input type="text" placeholder="Search..."
                                    class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff"
                                    alt="Profile" class="w-10 h-10 rounded-full border-2 border-gray-200">
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Owner</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200"
                                style="display: none;">

                                <a href="{{ route('profile') }}"
                                    class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Profile
                                    </div>
                                    @if (current_plan())
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium rounded-full
                                            @if (current_plan() === 'pro') bg-purple-100 text-purple-700
                                            @elseif(current_plan() === 'standard') bg-blue-100 text-blue-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ ucfirst(current_plan()) }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-500">
                                            No Plan
                                        </span>
                                    @endif
                                </a>

                                @php
                                    $userShop = \App\Models\Shop::where('owner_id', auth()->id())->first();
                                    $hasPendingRenewal = $userShop
                                        ? \App\Models\PlanApplication::where('user_id', auth()->id())
                                            ->where('shop_id', $userShop->id)
                                            ->where('type', 'renewal')
                                            ->where('status', 'pending')
                                            ->exists()
                                        : false;
                                @endphp

                                @if ($userShop && $userShop->shopPlan)
                                    @if ($hasPendingRenewal)
                                        <span
                                            class="flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Renewal Pending
                                        </span>
                                    @else
                                        <a href="{{ route('renew') }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            Renew Plan
                                        </a>
                                    @endif
                                @endif

                                <div class="border-t border-gray-100"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <!-- Plan Status Notifications -->
                @php
                    $shop = \App\Models\Shop::with('shopPlan')
                        ->where('owner_id', auth()->id())
                        ->first();
                    $shopPlan = $shop?->shopPlan;
                    $now = \Carbon\Carbon::now();

                    // Real-time status check
                    $isExpired = false;
                    $isGrace = false;

                    if ($shopPlan) {
                        // Check if past grace period
                        if ($shopPlan->grace_ends_at && $now->gt(\Carbon\Carbon::parse($shopPlan->grace_ends_at))) {
                            $isExpired = true;
                        }
                        // Check if in grace period
                        elseif ($shopPlan->ends_at && $now->gt(\Carbon\Carbon::parse($shopPlan->ends_at))) {
                            if (
                                $shopPlan->grace_ends_at &&
                                $now->lte(\Carbon\Carbon::parse($shopPlan->grace_ends_at))
                            ) {
                                $isGrace = true;
                            } else {
                                $isExpired = true;
                            }
                        }
                        // Also check status field
                        elseif ($shopPlan->status === 'expired') {
                            $isExpired = true;
                        } elseif ($shopPlan->status === 'grace') {
                            $isGrace = true;
                        }
                    }

                    $graceEndsAt = $shopPlan?->grace_ends_at;
                @endphp

                @if ($isExpired)
                    <div
                        class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-bold">Plan Expired</p>
                            <p class="text-sm mt-1">Your subscription has expired. Please renew your plan to continue
                                managing repairs and accessing all features.</p>
                            <a href="{{ route('renew') }}"
                                class="inline-block mt-2 text-sm font-semibold underline hover:no-underline">Renew Now
                                →</a>
                        </div>
                    </div>
                @elseif($isGrace)
                    <div
                        class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 px-4 py-3 rounded-lg mb-6 flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-bold">Grace Period</p>
                            <p class="text-sm mt-1">Your plan has ended. You have until
                                {{ \Carbon\Carbon::parse($graceEndsAt)->format('M d, Y') }} to renew before losing
                                access.</p>
                            <a href="{{ route('renew') }}"
                                class="inline-block mt-2 text-sm font-semibold underline hover:no-underline">Renew Plan
                                →</a>
                        </div>
                    </div>
                @endif

                <!-- Payment Proof Required Alert (shows for any pending application needing proof) -->
                @php
                    $pendingAppNeedingProof = getPendingApplicationNeedingProof();
                @endphp
                @if ($pendingAppNeedingProof)
                    <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 px-4 py-4 rounded-lg mb-6 flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold">Payment Proof Required</p>
                            <p class="text-sm mt-1">Please upload your payment proof to complete your application.</p>
                            <a href="{{ route('plan.payment-proof.upload', ['application' => $pendingAppNeedingProof->id]) }}"
                                class="inline-flex items-center mt-3 px-5 py-2.5 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition text-sm shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Upload Payment Proof
                            </a>
                        </div>
                    </div>
                @endif

                <!-- No Plan Alert -->
                @if (!$shop || !$shopPlan)
                    <div
                        class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 px-4 py-4 rounded-lg mb-6 flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            @php
                                $pendingApp = getPendingApplicationNeedingProof();
                            @endphp

                            @if ($pendingApp)
                                <p class="font-bold">Payment Proof Required</p>
                                <p class="text-sm mt-1">Please upload your payment proof to complete your application.
                                </p>
                                <a href="{{ route('plan.payment-proof.upload', ['application' => $pendingApp->id]) }}"
                                    class="inline-flex items-center mt-3 px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload Payment Proof
                                </a>
                            @elseif (App\Models\PlanApplication::where('user_id', auth()->id())->where('status', 'pending')->exists())
                                <p class="font-bold">Application Pending</p>
                                <p class="text-sm mt-1">Your application is being reviewed. Please wait until it is
                                    approved.</p>
                            @else
                                <p class="font-bold">No Active Plan</p>
                                <p class="text-sm mt-1">You don't have an active plan yet. Select a plan to get started
                                    and unlock all features for your repair shop.</p>
                                <a href="/#plansSection"
                                    class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-sm">
                                    Choose a Plan →
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Warning Message (Pending Plan) -->
                @if (session('warning'))
                    <div
                        class="bg-amber-100 border border-amber-400 text-amber-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('warning') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Mobile Sidebar -->
    <aside id="mobileSidebar"
        class="fixed left-0 top-0 bottom-0 w-64 bg-primary text-white z-50 transform -translate-x-full transition-transform duration-300 md:hidden overflow-y-auto">
        <div class="p-6 bg-primary-darker flex justify-between items-center">
            <a href="/">
                <h1 class="text-2xl font-bold">Owner Dashboard</h1>
            </a>
            <button id="closeMobileMenu" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <nav class="py-4">
            @if (auth()->user()?->isAdmin())
                <a href="{{ url('/admin') }}"
                    class="sidebar-link flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    <span>Admin Panel</span>
                </a>
            @endif
            <a href="{{ route('owner.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Overview</span>
            </a>

            <a href="{{ route('owner.repairs') }}"
                class="sidebar-link {{ request()->routeIs('owner.repairs') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Repairs / Jobs</span>
            </a>

            @if ($maxEmployeesForNav > 0 || $maxEmployeesForNav == -1)
                <a href="{{ route('owner.employees.index') }}"
                    class="sidebar-link {{ request()->routeIs('owner.employees.*') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <span>Employees</span>
                </a>
            @endif

            @if (in_array(current_plan(), ['standard', 'pro']))
                <a href="{{ route('owner.repairs.logs') }}"
                    class="sidebar-link {{ request()->routeIs('owner.repairs.logs') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    <span>Repair Logs</span>
                </a>
            @endif

            @if (current_plan() === 'pro')
                <a href="{{ route('owner.repairs.all') }}"
                    class="sidebar-link {{ request()->routeIs('owner.repairs.all') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Export Data</span>
                </a>

                <a href="{{ route('owner.settings') }}"
                    class="sidebar-link {{ request()->routeIs('owner.settings') ? 'active' : '' }} flex items-center px-6 py-3 text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Shop Settings</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- Alpine.js for dropdown -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileSidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.remove('hidden');
            });
        }

        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', () => {
                mobileSidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            });
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', () => {
                mobileSidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            });
        }
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
