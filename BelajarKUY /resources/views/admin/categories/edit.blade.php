@extends('layouts.admin')

@section('content')

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">

    <div>

        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Edit Category
        </h1>

        <p class="text-sm text-slate-500 mt-2">
            Update your category information.
        </p>

    </div>

    <a href="{{ route('admin.categories.index') }}"
       class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-5 py-3 rounded-2xl text-sm font-medium shadow-sm transition flex items-center gap-2">

        <i data-lucide="arrow-left"
           class="w-4 h-4"></i>

        Back

    </a>

</div>

<!-- FORM -->
<div class="max-w-4xl">

    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">

        <!-- HEADER -->
        <div class="px-8 py-6 border-b border-slate-100">

            <h1 class="text-lg font-semibold text-slate-900">
                Edit Category
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Update category details below.
            </p>

        </div>

        <!-- FORM -->
        <form action="{{ route('admin.categories.update', $category) }}"
              method="POST"
              class="p-8">

            @csrf
            @method('PUT')

            <!-- NAME -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Category Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full bg-[#f8fafc] border border-slate-200 rounded-2xl px-5 py-4 text-sm outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all">

            </div>

            <!-- SLUG -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Category Slug
                </label>

                <input type="text"
                       name="slug"
                       value="{{ old('slug', $category->slug) }}"
                       class="w-full bg-[#f8fafc] border border-slate-200 rounded-2xl px-5 py-4 text-sm outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all">

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Description
                </label>

                <textarea name="description"
                          rows="6"
                          class="w-full bg-[#f8fafc] border border-slate-200 rounded-2xl px-5 py-4 text-sm outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all resize-none">{{ old('description', $category->description) }}</textarea>

            </div>

            <!-- STATUS -->
            <div class="mb-8">

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Status
                </label>

                <label class="flex items-center gap-3 bg-[#f8fafc] border border-slate-200 rounded-2xl px-5 py-4 cursor-pointer">

                    <input type="checkbox"
                           name="status"
                           value="1"
                           {{ $category->status ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-200">

                    <div>

                        <h1 class="text-sm font-medium text-slate-800">
                            Active Category
                        </h1>

                        <p class="text-xs text-slate-400 mt-1">
                            This category will be visible publicly.
                        </p>

                    </div>

                </label>

            </div>

            <!-- BUTTON -->
            <div class="flex items-center gap-4">

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 hover:opacity-90 text-white px-6 py-4 rounded-2xl text-sm font-semibold shadow-lg shadow-blue-100 transition flex items-center gap-2">

                    <i data-lucide="save"
                       class="w-4 h-4"></i>

                    Update Category

                </button>

                <a href="{{ route('admin.categories.index') }}"
                   class="text-slate-500 hover:text-slate-800 text-sm font-medium transition">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection