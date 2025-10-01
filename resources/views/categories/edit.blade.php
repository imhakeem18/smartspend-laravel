<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <!-- Header -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Edit: {{ $category->name }}</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('categories.show', $category) }}" 
                               style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                View
                            </a>
                            <a href="{{ route('categories.index') }}" 
                               style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div style="padding: 1.5rem;">
                    <form action="{{ route('categories.update', $category) }}" method="POST" id="categoryForm">
                        @csrf
                        @method('PUT')

                        <!-- Category Name -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="name" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Category Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}"
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
                                               {{ (old('color', $category->color) === $hex) ? 'checked' : '' }}
                                               style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; z-index: 2;">
                                        <label for="color_{{ $loop->index }}" 
                                               style="display: flex; flex-direction: column; align-items: center; cursor: pointer; padding: 0.5rem; border: 2px solid {{ (old('color', $category->color) === $hex) ? $hex : 'transparent' }}; border-radius: 0.5rem; transition: all 0.2s; transform: {{ (old('color', $category->color) === $hex) ? 'scale(1.05)' : 'scale(1)' }};"
                                               onmouseover="this.style.borderColor='#d1d5db'"
                                               onmouseout="this.style.borderColor='{{ (old('color', $category->color) === $hex) ? $hex : 'transparent' }}'"
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
                                       value="{{ old('color', $category->color) }}"
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
                                      style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937; resize: vertical;">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div style="margin-bottom: 2rem; padding: 1rem; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 0.5rem;">
                            <h4 style="color: #0369a1; font-weight: 600; margin: 0 0 0.75rem 0;">Preview:</h4>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div id="preview_circle" style="width: 3rem; height: 3rem; background-color: {{ old('color', $category->color) }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <span id="preview_initial" style="color: white; font-weight: bold; font-size: 1.25rem;">{{ strtoupper(substr(old('name', $category->name), 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p id="preview_name" style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin: 0;">
                                        {{ old('name', $category->name) }}
                                    </p>
                                    <p id="preview_description" style="color: #6b7280; font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                                        {{ old('description', $category->description) ?: 'No description' }}
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
                                    style="background-color: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 500; font-size: 1rem;">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Usage Info -->
                @php
                    $expenseCount = $category->expenses()->count();
                    $totalAmount = $category->expenses()->sum('amount');
                @endphp
                
                @if($expenseCount > 0)
                    <div style="margin: 0 1.5rem 1.5rem 1.5rem; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 1rem;">
                        <h4 style="color: #dc2626; font-weight: 600; margin: 0 0 0.5rem 0;">⚠️ Category Usage:</h4>
                        <p style="color: #dc2626; font-size: 0.875rem; margin: 0;">
                            This category is used by <strong>{{ $expenseCount }}</strong> expense{{ $expenseCount === 1 ? '' : 's' }} 
                            totaling <strong>${{ number_format($totalAmount, 2) }}</strong>.
                            Changes to this category will affect all associated expenses.
                        </p>
                    </div>
                @endif
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
            const name = nameInput.value || 'Category';
            previewInitial.textContent = name.charAt(0).toUpperCase();
            
            // Update name
            previewName.textContent = name;
            
            // Update description
            const desc = descInput.value || 'No description';
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
                let colorInput = document.querySelector('input[name="color"][type="hidden"]');
                if (!colorInput) {
                    colorInput = document.createElement('input');
                    colorInput.type = 'hidden';
                    colorInput.name = 'color';
                    document.getElementById('categoryForm').appendChild(colorInput);
                }
                colorInput.value = color;
            }
            
            updatePreview(color, 'Custom');
        }
        
        // Update preview when typing
        document.getElementById('name').addEventListener('input', function() {
            const selectedColor = document.querySelector('input[name="color"]:checked');
            const customColorInput = document.getElementById('custom_color');
            const color = selectedColor ? selectedColor.value : customColorInput.value;
            updatePreview(color, 'Selected');
        });
        
        document.getElementById('description').addEventListener('input', function() {
            const selectedColor = document.querySelector('input[name="color"]:checked');
            const customColorInput = document.getElementById('custom_color');
            const color = selectedColor ? selectedColor.value : customColorInput.value;
            updatePreview(color, 'Selected');
        });
    </script>
</x-app-layout>