<x-admin-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="admin-page-title">Categories</h1>
                <p class="admin-page-subtitle">Manage course categories, subcategories, and topics.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; padding: 10px 20px; border-radius: 12px; font-size: 0.85rem; font-weight: 600; text-decoration: none; box-shadow: 0 4px 12px rgba(37,99,235,0.2); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
                Add Category
            </a>
        </div>
    </x-slot>

    <!-- Filters and Search -->
    <div class="admin-card" style="margin-bottom: 24px; padding: 16px 24px;">
        <form method="GET" action="{{ route('admin.categories.index') }}" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 250px; position: relative;">
                <i data-lucide="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or slug..." style="width: 100%; padding: 10px 16px 10px 42px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.85rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="min-width: 150px;">
                <select name="status" style="width: 100%; padding: 10px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.85rem; outline: none; appearance: none; background: #fff url('data:image/svg+xml;utf8,<svg fill=\'%2394a3b8\' height=\'20\' viewBox=\'0 0 24 24\' width=\'20\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>') no-repeat right 12px center; background-size: 16px;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" style="padding: 10px 20px; background: #f1f5f9; color: #334155; border: none; border-radius: 12px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.categories.index') }}" style="font-size: 0.8rem; color: #ef4444; text-decoration: none; font-weight: 500;">Clear Filters</a>
            @endif
        </form>
    </div>

    <!-- Data Table -->
    <div class="admin-card" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="text-align: left; padding: 14px 24px; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Image</th>
                        <th style="text-align: left; padding: 14px 24px; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Category</th>
                        <th style="text-align: left; padding: 14px 24px; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                        <th style="text-align: left; padding: 14px 24px; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Courses</th>
                        <th style="text-align: left; padding: 14px 24px; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Created</th>
                        <th style="text-align: right; padding: 14px 24px; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 14px 24px;">
                                @if($category->image)
                                    <div style="width: 48px; height: 48px; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                        <i data-lucide="image" style="width: 20px; height: 20px;"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 14px 24px;">
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem; margin-bottom: 2px;">{{ $category->name }}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">{{ $category->slug }}</div>
                            </td>
                            <td style="padding: 14px 24px;">
                                @if($category->status)
                                    <span style="background: #f0fdf4; color: #16a34a; padding: 4px 12px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #22c55e;"></span> Active
                                    </span>
                                @else
                                    <span style="background: #fef2f2; color: #dc2626; padding: 4px 12px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #ef4444;"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 14px 24px; color: #64748b; font-weight: 500;">
                                <!-- Stub relationship call since Course model doesn't exist yet -->
                                {{-- $category->courses()->count() --}}
                                0
                            </td>
                            <td style="padding: 14px 24px; color: #64748b; font-size: 0.8rem;">
                                {{ $category->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding: 14px 24px; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; transition: all 0.2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'" title="Edit">
                                        <i data-lucide="edit-2" style="width: 16px; height: 16px;"></i>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #fef2f2; color: #ef4444; border: none; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'" title="Delete">
                                        <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                    </button>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px 24px; text-align: center; color: #94a3b8;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                    <div style="width: 64px; height: 64px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                                        <i data-lucide="folder-search" style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <div>
                                        <p style="font-weight: 600; color: #475569; font-size: 1rem;">No categories found</p>
                                        <p style="font-size: 0.85rem; margin-top: 4px;">Get started by creating a new category.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Delete Category?',
                html: `Are you sure you want to delete <strong>${name}</strong>?<br>This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'admin-card',
                    confirmButton: 'action-btn hover-red',
                    cancelButton: 'action-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
        
        // Show success message if exists
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>
</x-admin-layout>
