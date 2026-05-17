<x-admin-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
            <a href="{{ route('admin.categories.index') }}" style="color: #64748b; transition: color 0.2s;" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">
                <i data-lucide="arrow-left" style="width: 20px; height: 20px;"></i>
            </a>
            <h1 class="admin-page-title" style="margin: 0;">Edit Category</h1>
        </div>
        <p class="admin-page-subtitle" style="margin-left: 32px;">Update information for {{ $category->name }}.</p>
    </x-slot>

    <div class="admin-card" style="max-width: 800px;">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" id="categoryForm">
            @csrf
            @method('PUT')
            
            <div style="display: grid; gap: 24px;">
                
                <!-- Name -->
                <div>
                    <label for="name" style="display: block; font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 8px;">Category Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required 
                        style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; font-family: inherit;" 
                        onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'"
                        onkeyup="generateSlug(this.value)">
                    @error('name') <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" style="display: block; font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 8px;">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" 
                        style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; background: #f8fafc; color: #64748b; outline: none; transition: border-color 0.2s; font-family: inherit;" 
                        onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                    @error('slug') <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>

                <!-- Image Upload (Cloudinary Frontend Mock) -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 8px;">Category Image</label>
                    
                    <div id="imagePreviewContainer" style="display: {{ $category->image ? 'block' : 'none' }}; margin-bottom: 16px; position: relative; width: 160px; height: 160px; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <img id="imagePreview" src="{{ $category->image ?? '' }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                        <div id="uploadOverlay" style="position: absolute; inset: 0; background: rgba(255,255,255,0.8); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; display: none;">
                            <div style="width: 24px; height: 24px; border: 3px solid #e2e8f0; border-top-color: #2563eb; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                            <span style="font-size: 0.7rem; font-weight: 600; color: #2563eb;">Uploading...</span>
                        </div>
                        <button type="button" onclick="removeImage()" style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(239,68,68,0.9)'" onmouseout="this.style.background='rgba(0,0,0,0.5)'">
                            <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                        </button>
                    </div>

                    <div id="uploadArea" style="display: {{ $category->image ? 'none' : 'block' }}; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 40px; text-align: center; background: #f8fafc; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='#2563eb'; this.style.background='#eff6ff'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'" onclick="document.getElementById('image').click()">
                        <div style="width: 48px; height: 48px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); color: #2563eb;">
                            <i data-lucide="upload-cloud"></i>
                        </div>
                        <p style="font-size: 0.9rem; font-weight: 600; color: #1e293b; margin-bottom: 4px;">Click to upload image</p>
                        <p style="font-size: 0.75rem; color: #64748b;">PNG, JPG or WEBP (Max. 2MB)</p>
                    </div>
                    
                    <input type="file" id="image" accept="image/*" style="display: none;" onchange="handleImageSelect(event)">
                    <!-- Hidden input to store Cloudinary URL for backend submission -->
                    <input type="hidden" name="image" id="imageUrl" value="{{ old('image', $category->image) }}">
                    
                    @error('image') <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" style="display: block; font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 8px;">Description</label>
                    <textarea id="description" name="description" rows="4" 
                        style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; font-family: inherit; resize: vertical;" 
                        onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">{{ old('description', $category->description) }}</textarea>
                    @error('description') <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>

                <!-- Status Toggle -->
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div>
                        <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">Active Status</p>
                        <p style="font-size: 0.7rem; color: #64748b;">If inactive, this category won't be visible to users.</p>
                    </div>
                    <label style="margin-left: auto; position: relative; display: inline-block; width: 44px; height: 24px;">
                        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;" onchange="toggleStatus(this)">
                        <span id="toggleSlider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ old('status', $category->status) ? '#2563eb' : '#cbd5e1' }}; transition: .4s; border-radius: 24px;">
                            <span id="toggleKnob" style="position: absolute; content: ''; height: 18px; width: 18px; left: {{ old('status', $category->status) ? '22px' : '3px' }}; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></span>
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                    <a href="{{ route('admin.categories.index') }}" style="padding: 12px 24px; background: #f1f5f9; color: #475569; border-radius: 12px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        Cancel
                    </a>
                    <button type="submit" id="submitBtn" style="padding: 12px 32px; background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; border: none; border-radius: 12px; font-size: 0.85rem; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(37,99,235,0.2); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(37,99,235,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(37,99,235,0.2)'">
                        Update Category
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>

    <script>
        // Only generate slug if user edits name manually and slug matches old name
        const originalName = "{{ $category->name }}";
        function generateSlug(text) {
            const slugInput = document.getElementById('slug');
            // If user hasn't manually changed the slug from original, update it
            if(document.getElementById('name').value !== originalName && slugInput.value.trim() !== '') {
                const slug = text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
                slugInput.value = slug;
            }
        }

        function toggleStatus(checkbox) {
            const slider = document.getElementById('toggleSlider');
            const knob = document.getElementById('toggleKnob');
            if (checkbox.checked) {
                slider.style.backgroundColor = '#2563eb';
                knob.style.left = '22px';
            } else {
                slider.style.backgroundColor = '#cbd5e1';
                knob.style.left = '3px';
            }
        }

        function handleImageSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('uploadArea').style.display = 'none';
                document.getElementById('imagePreviewContainer').style.display = 'block';
                
                simulateCloudinaryUpload(file, e.target.result);
            }
            reader.readAsDataURL(file);
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imageUrl').value = '';
            document.getElementById('imagePreviewContainer').style.display = 'none';
            document.getElementById('uploadArea').style.display = 'block';
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('submitBtn').style.opacity = '1';
        }

        function simulateCloudinaryUpload(file, dataUrl) {
            const overlay = document.getElementById('uploadOverlay');
            const btn = document.getElementById('submitBtn');
            
            overlay.style.display = 'flex';
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.innerHTML = 'Uploading Image...';

            setTimeout(() => {
                overlay.style.display = 'none';
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.innerHTML = 'Update Category';
                document.getElementById('imageUrl').value = dataUrl; 
            }, 1500);
        }
    </script>
</x-admin-layout>
