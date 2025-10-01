<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Create New Category') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <!-- Header -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">New Category Details</h3>
                        <a href="{{ route('categories.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500;">
                            Back to Categories
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div style="padding: 1.5rem;">
                    <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                        @csrf

                        <!-- Category Name -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="name" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Category Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="e.g., Healthcare, Travel, Education..."
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937;"
                                   required>
                            @error('name')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color Selection -->
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                Category Color *
                            </label>
                            
                            <!-- Color Picker Grid -->
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); gap: 0.5rem; margin-bottom: 1rem;">
                                @foreach($colorOptions as $hex => $name)
                                    <div style="position: relative;">
                                        <input type="radio" 
                                               id="color_{{ $loop->index }}" 
                                               name="color" 
                                               value="{{ $hex }}" 
                                               {{ old('color') === $hex ? 'checked' : '' }}
                                               style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; z-index: 2;">
                                        <label for="color_{{ $loop->index }}" 
                                               style="display: flex; flex-direction: column; align-items: center; cursor: pointer; padding: 0.5rem; border: 2px solid transparent; border-radius: 0.5rem; transition: all 0.2s;"
                                               onmouseover="this.style.borderColor='#d1d5db'"
                                               onmouseout="this.style.borderColor='transparent'"
                                               onclick="updatePreview('{{ $hex }}', '{{ $name }}')">
                                            <div style="width: 40px; height: 40px; background-color: {{ $hex }}; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></div>
                                            <span style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem; text-align: center;">{{ $name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Custom Color Input -->
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem; padding: 0.75rem; background-color: #f9fafb; border-radius: 0.375rem;">
                                <label for="custom_color" style="font-size: 0.875rem; color: #374151; font-weight: 500;">
                                    Or pick custom color:
                                </label>
                                <input type="color" 
                                       id="custom_color" 
                                       value="#10b981"
                                       onchange="selectCustomColor(this.value)"
                                       style="width: 40px; height: 40px; border: none; border-radius: 50%; cursor: pointer;">
                            </div>
                            
                            @error('color')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="description" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Description (Optional)
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Brief description of what expenses this category covers..."
                                      style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937; resize: vertical;">{{ old('description') }}</textarea>
                            @error('description')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div style="margin-bottom: 2rem; padding: 1rem; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 0.5rem;">
                            <h4 style="color: #0369a1; font-weight: 600; margin: 0 0 0.75rem 0;">Preview:</h4>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div id="preview_circle" style="width: 3rem; height: 3rem; background-color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <span id="preview_initial" style="color: white; font-weight: bold; font-size: 1.25rem;">N</span>
                                </div>
                                <div>
                                    <p id="preview_name" style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin: 0;">
                                        New Category
                                    </p>
                                    <p id="preview_description" style="color: #6b7280; font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                                        Category description will appear here
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                            <a href="{{ route('categories.index') }}" 
                               style="background-color: #f3f4f6; color: #374151; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; border: 1px solid #d1d5db;">
                                Cancel
                            </a>
                            <button type="submit" 
                                    style="background-color: #10b981; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 500; font-size: 1rem;">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div style="margin-top: 1.5rem; background-color: #fffbeb; border: 1px solid #fed7aa; border-radius: 0.5rem; padding: 1rem;">
                <h4 style="color: #92400e; font-weight: 600; margin: 0 0 0.5rem 0;">💡 Category Tips:</h4>
                <ul style="color: #92400e; font-size: 0.875rem; margin: 0; padding-left: 1.25rem;">
                    <li>Choose descriptive names (e.g., "Food & Dining" instead of just "Food")</li>
                    <li>Pick colors that make sense (e.g., red for food, blue for transport)</li>
                    <li>Categories help you track spending patterns in different areas</li>
                    <li>You can always edit or delete unused categories later</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- JavaScript for Live Preview -->
    <script>
        function updatePreview(color, colorName) {
            const nameInput = document.getElementById('name');
            const descInput = document.getElementById('description');
            const previewCircle = document.getElementById('preview_circle');
            const previewInitial = document.getElementById('preview_initial');
            const previewName = document.getElementById('preview_name');
            const previewDescription = document.getElementById('preview_description');
            
            // Update color
            previewCircle.style.backgroundColor = color;
            
            // Update initial
            const name = nameInput.value || 'New Category';
            previewInitial.textContent = name.charAt(0).toUpperCase();
            
            // Update name
            previewName.textContent = name;
            
            // Update description
            const desc = descInput.value || 'Category description will appear here';
            previewDescription.textContent = desc;
            
            // Update selected radio button styles
            document.querySelectorAll('input[name="color"]').forEach(radio => {
                const label = radio.nextElementSibling;
                if (radio.value === color) {
                    radio.checked = true;
                    label.style.borderColor = color;
                    label.style.transform = 'scale(1.05)';
                } else {
                    label.style.borderColor = 'transparent';
                    label.style.transform = 'scale(1)';
                }
            });
        }
        
        function selectCustomColor(color) {
            // Create a new radio button for custom color if it doesn't exist
            const existingCustom = document.querySelector(`input[value="${color}"]`);
            if (!existingCustom) {
                // Uncheck all existing radios
                document.querySelectorAll('input[name="color"]').forEach(radio => {
                    radio.checked = false;
                    radio.nextElementSibling.style.borderColor = 'transparent';
                    radio.nextElementSibling.style.transform = 'scale(1)';
                });
                
                // Update the form to use custom color
                const colorInput = document.createElement('input');
                colorInput.type = 'hidden';
                colorInput.name = 'color';
                colorInput.value = color;
                document.getElementById('categoryForm').appendChild(colorInput);
            }
            
            updatePreview(color, 'Custom');
        }
        
        // Update preview when typing
        document.getElementById('name').addEventListener('input', function() {
            const selectedColor = document.querySelector('input[name="color"]:checked');
            const color = selectedColor ? selectedColor.value : '#10b981';
            updatePreview(color, 'Selected');
        });
        
        document.getElementById('description').addEventListener('input', function() {
            const selectedColor = document.querySelector('input[name="color"]:checked');
            const color = selectedColor ? selectedColor.value : '#10b981';
            updatePreview(color, 'Selected');
        });
        
        // Initialize preview with default values
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview('#10b981', 'Default');
        });
    </script>
</x-app-layout>