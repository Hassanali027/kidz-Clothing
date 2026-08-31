@extends('admin.layout')

@section('header_title', 'Add New Product')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            ✗ {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>Validation Errors:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-card">
        <div class="card-header">
            <h2>Add New Product</h2>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" value="{{ old('name') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->name }}" {{ old('category') == $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @empty
                            <option value="" disabled>No categories available</option>
                        @endforelse
                    </select>
                    <small style="color: #666;">Select from categories you created</small>
                </div>
                <div class="form-group">
                    <label>Age Group</label>
                    <input type="text" name="age_group" class="form-control" value="{{ old('age_group') }}" placeholder="e.g. 5-8" required>
                </div>
            </div>

            <div class="form-group">
                <label>Review Count</label>
                <input type="number" name="review_count" class="form-control" min="0" value="{{ old('review_count', 0) }}" placeholder="e.g. 26">
                <small style="color: #666;">Set how many reviews should appear on this product.</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Product Type (Optional)</label>
                    <select name="product_type" class="form-control js-product-type-select">
                        <option value="">Select Product Type</option>
                        @foreach(($productTypes ?? collect()) as $productType)
                            <option value="{{ $productType }}" {{ old('product_type') == $productType ? 'selected' : '' }}>{{ $productType }}</option>
                        @endforeach
                        <option value="__custom" {{ old('product_type') == '__custom' ? 'selected' : '' }}>Add custom type</option>
                    </select>
                    <input type="text" name="product_type_custom" class="form-control js-product-type-custom" placeholder="Enter custom product type" value="{{ old('product_type_custom') }}" style="display:none; margin-top:10px;">
                    <small style="color: #666;">Connects with front-end filters. Custom types appear automatically after saving a product.</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (Rs.)</label>
                    <input type="number" name="price" class="form-control" placeholder="0.00" step="0.01" value="{{ old('price') }}" required>
                </div>
                <div class="form-group">
                    <label>Sale Price (Rs.)</label>
                    <input type="number" name="sale_price" class="form-control" placeholder="0.00" step="0.01" value="{{ old('sale_price') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Product Color (Optional)</label>
                    <input type="text" name="color" class="form-control" placeholder="e.g. Red, Blue, Multi-color" value="{{ old('color') }}">
                </div>
                <div class="form-group">
                    <label>Standard Size (Optional)</label>
                    <input type="text" name="size" class="form-control" placeholder="Separate choices with commas: Small, Medium, Large" value="{{ old('size') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter product description">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Product Images</label>
                <input type="file" name="product_images[]" class="form-control" multiple accept="image/*">
                <small style="color: #666; font-size: 13px;">You can upload multiple images (JPG, PNG, GIF, WEBP - Max 5MB each)</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" placeholder="0" value="{{ old('stock_quantity', 0) }}" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="out-of-stock" {{ old('status') == 'out-of-stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
            </div>

            <!-- Display Sections -->
            <div class="form-group">
                <label style="margin-bottom: 12px;">Display Product In (Select where to show this product)</label>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="display_sections[]" value="featured_products">
                        <span class="checkbox-text">
                            <strong>Featured Products</strong>
                            <small>Show in Featured Products section on homepage</small>
                        </span>
                    </label>

                    <label class="checkbox-label">
                        <input type="checkbox" name="display_sections[]" value="new_arrivals">
                        <span class="checkbox-text">
                            <strong>New Arrivals</strong>
                            <small>Show in New Arrivals section on homepage</small>
                        </span>
                    </label>

                    <label class="checkbox-label">
                        <input type="checkbox" name="display_sections[]" value="shop_by_category">
                        <span class="checkbox-text">
                            <strong>Shop by Category</strong>
                            <small>Show in Shop by Category section (Boys/Girls/Baby Wear)</small>
                        </span>
                    </label>

                    <label class="checkbox-label">
                        <input type="checkbox" name="display_sections[]" value="shop_by_age">
                        <span class="checkbox-text">
                            <strong>Shop by Age</strong>
                            <small>Show in Shop by Age section (0-2, 2-5, 5-8, 8-14 Years)</small>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Related Products -->
            <div class="form-group">
                <label>Related Products (You May Also Like)</label>
                
                <!-- Custom Dropdown Container -->
                <div class="custom-dropdown-container">
                    <!-- Selected Products Display (Clickable to open dropdown) -->
                    <div id="selectedProductsDisplay" class="selected-products-box" onclick="toggleDropdown()">
                        <span style="color: #999; font-size: 14px;" id="emptyMessage">No products selected yet</span>
                    </div>

                    <!-- Dropdown Panel -->
                    <div id="dropdownPanel" class="dropdown-panel" style="display: none;">
                        <!-- Search Input -->
                        <input type="text" id="relatedProductSearch" class="form-control" placeholder="Search products by name..." style="margin-bottom: 8px;">
                        
                        <!-- Product List -->
                        <div id="productList" class="product-list">
                            @php
                                $allProducts = \App\Models\Product::where('status', 'active')->orderBy('name', 'asc')->get();
                            @endphp
                            @forelse($allProducts as $prod)
                                <div class="product-item" data-id="{{ $prod->id }}" data-name="{{ $prod->name }}" data-category="{{ $prod->category }}">
                                    {{ $prod->name }} ({{ $prod->category }})
                                </div>
                            @empty
                                <div style="padding: 12px; color: #999; text-align: center;">No products available</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Hidden input to store selected product IDs -->
                <input type="hidden" name="related_products[]" id="relatedProductsInput" value="">
                <div id="hiddenInputsContainer"></div>
                
                <small style="color: #666;">Click on the box above to select products. Selected products will appear as tags.</small>
            </div>

            <style>
            .custom-dropdown-container {
                position: relative;
            }
            .selected-products-box {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                min-height: 50px;
                padding: 12px;
                background: white;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                cursor: pointer;
                transition: border-color 0.2s;
                align-items: center;
            }
            .selected-products-box:hover {
                border-color: #cbd5e0;
            }
            .selected-products-box.active {
                border-color: #2196F3;
            }
            .dropdown-panel {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                margin-top: 4px;
                background: white;
                border: 2px solid #2196F3;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 1000;
                padding: 12px;
            }
            .product-list {
                max-height: 250px;
                overflow-y: auto;
                border: 1px solid #e2e8f0;
                border-radius: 6px;
            }
            .product-item {
                padding: 10px 12px;
                cursor: pointer;
                transition: background 0.2s;
                border-bottom: 1px solid #f0f0f0;
            }
            .product-item:last-child {
                border-bottom: none;
            }
            .product-item:hover {
                background: #f8f9fa;
            }
            .product-item.selected {
                background: #e3f2fd;
                color: #2196F3;
                font-weight: 500;
            }
            .product-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: #2196F3;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
            }
            .product-tag .remove-btn {
                background: rgba(255,255,255,0.3);
                border: none;
                color: white;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                line-height: 1;
                transition: background 0.2s;
            }
            .product-tag .remove-btn:hover {
                background: rgba(255,255,255,0.5);
            }
            </style>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const productTypeSelect = document.querySelector('.js-product-type-select');
                const customProductType = document.querySelector('.js-product-type-custom');

                function toggleCustomProductType() {
                    if (!productTypeSelect || !customProductType) return;

                    const isCustom = productTypeSelect.value === '__custom';
                    customProductType.style.display = isCustom ? 'block' : 'none';
                    customProductType.required = isCustom;
                    if (isCustom) {
                        customProductType.focus();
                    }
                }

                if (productTypeSelect) {
                    productTypeSelect.addEventListener('change', toggleCustomProductType);
                    toggleCustomProductType();
                }

                const searchInput = document.getElementById('relatedProductSearch');
                const dropdownPanel = document.getElementById('dropdownPanel');
                const displayBox = document.getElementById('selectedProductsDisplay');
                const productList = document.getElementById('productList');
                const hiddenInput = document.getElementById('relatedProductsInput');
                const productItems = document.querySelectorAll('.product-item');
                
                let selectedProducts = [];
                
                updateDisplay();

                // Toggle dropdown
                window.toggleDropdown = function() {
                    const isOpen = dropdownPanel.style.display === 'block';
                    dropdownPanel.style.display = isOpen ? 'none' : 'block';
                    displayBox.classList.toggle('active', !isOpen);
                };

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.custom-dropdown-container')) {
                        dropdownPanel.style.display = 'none';
                        displayBox.classList.remove('active');
                    }
                });

                // Search functionality
                searchInput.addEventListener('input', function(e) {
                    e.stopPropagation();
                    const searchTerm = this.value.toLowerCase();
                    
                    productItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                    });
                });

                // Product item click
                productItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const productId = parseInt(this.dataset.id);
                        
                        if (selectedProducts.includes(productId)) {
                            // Remove from selection
                            selectedProducts = selectedProducts.filter(id => id !== productId);
                        } else {
                            // Add to selection
                            selectedProducts.push(productId);
                        }
                        
                        updateDisplay();
                        updateProductItems();
                        updateHiddenInput();
                    });
                });

                function updateDisplay() {
                    if (selectedProducts.length === 0) {
                        displayBox.innerHTML = '<span style="color: #999; font-size: 14px;">No products selected yet</span>';
                        return;
                    }

                    displayBox.innerHTML = '';
                    
                    selectedProducts.forEach(productId => {
                        const item = document.querySelector(`.product-item[data-id="${productId}"]`);
                        if (!item) return;
                        
                        const tag = document.createElement('div');
                        tag.className = 'product-tag';
                        tag.innerHTML = `
                            <span>${item.dataset.name}</span>
                            <button type="button" class="remove-btn" onclick="removeProduct(${productId}); event.stopPropagation();">×</button>
                        `;
                        
                        displayBox.appendChild(tag);
                    });
                }

                function updateProductItems() {
                    productItems.forEach(item => {
                        const productId = parseInt(item.dataset.id);
                        if (selectedProducts.includes(productId)) {
                            item.classList.add('selected');
                        } else {
                            item.classList.remove('selected');
                        }
                    });
                }

                function updateHiddenInput() {
                    // Clear existing hidden inputs
                    const container = document.getElementById('hiddenInputsContainer') || displayBox.parentElement;
                    const existingInputs = container.querySelectorAll('input[name="related_products[]"]');
                    existingInputs.forEach(input => {
                        if (input.id !== 'relatedProductsInput') {
                            input.remove();
                        }
                    });
                    
                    // Create new hidden inputs for each selected product
                    selectedProducts.forEach(productId => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'related_products[]';
                        input.value = productId;
                        container.appendChild(input);
                    });
                }

                // Global remove function
                window.removeProduct = function(productId) {
                    selectedProducts = selectedProducts.filter(id => id !== productId);
                    updateDisplay();
                    updateProductItems();
                    updateHiddenInput();
                };
            });
            </script>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Add Product</button>
                <a href="{{ route('admin.products') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
