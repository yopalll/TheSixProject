@extends('layouts.admin')

@section('content')

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">

    <div>

        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Dashboard
        </h1>

        <p class="text-sm text-slate-500 mt-2">
            Welcome back! Here's what's happening today.
        </p>

    </div>

    <div class="flex items-center gap-3">

        <button class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-2xl text-sm font-medium shadow-sm transition flex items-center gap-2">

            <i data-lucide="calendar"
               class="w-4 h-4 text-slate-400"></i>

            This Month

        </button>

        <button class="bg-gradient-to-r from-blue-600 to-blue-500 hover:opacity-90 text-white px-4 py-2.5 rounded-2xl text-sm font-medium shadow-lg shadow-blue-100 transition flex items-center gap-2">

            <i data-lucide="download"
               class="w-4 h-4"></i>

            Export

        </button>

    </div>

</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200/60 p-6 shadow-sm hover:shadow-md transition-all duration-300">

        <div class="flex items-start justify-between mb-5">

            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">

                <i data-lucide="users"
                   class="w-5 h-5 text-blue-600"></i>

            </div>

            <span class="bg-emerald-50 text-emerald-600 text-xs font-medium px-2 py-1 rounded-lg border border-emerald-100">
                +12%
            </span>

        </div>

        <p class="text-sm text-slate-500 mb-2">
            Total Students
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            12,845
        </h1>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200/60 p-6 shadow-sm hover:shadow-md transition-all duration-300">

        <div class="flex items-start justify-between mb-5">

            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center">

                <i data-lucide="book-open"
                   class="w-5 h-5 text-orange-500"></i>

            </div>

            <span class="bg-emerald-50 text-emerald-600 text-xs font-medium px-2 py-1 rounded-lg border border-emerald-100">
                +8
            </span>

        </div>

        <p class="text-sm text-slate-500 mb-2">
            Active Courses
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            248
        </h1>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200/60 p-6 shadow-sm hover:shadow-md transition-all duration-300">

        <div class="flex items-start justify-between mb-5">

            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">

                <i data-lucide="credit-card"
                   class="w-5 h-5 text-emerald-600"></i>

            </div>

            <span class="bg-emerald-50 text-emerald-600 text-xs font-medium px-2 py-1 rounded-lg border border-emerald-100">
                +18%
            </span>

        </div>

        <p class="text-sm text-slate-500 mb-2">
            Total Revenue
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            Rp 84.2M
        </h1>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200/60 p-6 shadow-sm hover:shadow-md transition-all duration-300">

        <div class="flex items-start justify-between mb-5">

            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center">

                <i data-lucide="shopping-cart"
                   class="w-5 h-5 text-rose-500"></i>

            </div>

            <span class="bg-slate-100 text-slate-500 text-xs font-medium px-2 py-1 rounded-lg border border-slate-200">
                Review
            </span>

        </div>

        <p class="text-sm text-slate-500 mb-2">
            Pending Orders
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            36
        </h1>

    </div>

</div>

<!-- CONTENT -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- TABLE -->
    <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">

        <!-- HEADER -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">

            <div>

                <h1 class="text-lg font-semibold text-slate-900">
                    Recent Transactions
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    Latest course purchases.
                </p>

            </div>

            <button class="text-sm text-blue-600 font-medium">
                View All
            </button>

        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-[#f8fafc] text-slate-500 uppercase text-[11px] tracking-wider">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            Student
                        </th>

                        <th class="px-6 py-4 text-left">
                            Course
                        </th>

                        <th class="px-6 py-4 text-right">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-left">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold">
                                    A
                                </div>

                                <div>

                                    <h1 class="font-medium text-slate-800">
                                        Andi Rahmat
                                    </h1>

                                    <p class="text-xs text-slate-400">
                                        andi@email.com
                                    </p>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            UI/UX Design
                        </td>

                        <td class="px-6 py-4 text-right font-semibold text-slate-900">
                            Rp 350K
                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-3 py-1 rounded-full text-xs font-medium">
                                Paid
                            </span>

                        </td>

                    </tr>

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-semibold">
                                    S
                                </div>

                                <div>

                                    <h1 class="font-medium text-slate-800">
                                        Siti Permata
                                    </h1>

                                    <p class="text-xs text-slate-400">
                                        siti@email.com
                                    </p>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            Laravel Advanced
                        </td>

                        <td class="px-6 py-4 text-right font-semibold text-slate-900">
                            Rp 499K
                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-amber-50 text-amber-600 border border-amber-100 px-3 py-1 rounded-full text-xs font-medium">
                                Pending
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- POPULAR COURSES -->
    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100">

            <h1 class="text-lg font-semibold text-slate-900">
                Popular Courses
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Best selling courses.
            </p>

        </div>

        <div class="p-4 space-y-3">

            <!-- ITEM -->
            <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">

                        <i data-lucide="pen-tool"
                           class="w-5 h-5 text-blue-600"></i>

                    </div>

                    <div>

                        <h1 class="font-medium text-slate-800">
                            UI/UX Design
                        </h1>

                        <p class="text-xs text-slate-400">
                            1,245 students
                        </p>

                    </div>

                </div>

                <span class="font-semibold text-slate-900">
                    Rp 350K
                </span>

            </div>

            <!-- ITEM -->
            <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center">

                        <i data-lucide="code"
                           class="w-5 h-5 text-orange-500"></i>

                    </div>

                    <div>

                        <h1 class="font-medium text-slate-800">
                            Laravel Advanced
                        </h1>

                        <p class="text-xs text-slate-400">
                            982 students
                        </p>

                    </div>

                </div>

                <span class="font-semibold text-slate-900">
                    Rp 499K
                </span>

            </div>

        </div>

    </div>

</div>

@endsection