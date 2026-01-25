<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $company->name ?? config('app.name', 'N/A') }}</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"/>

  @vite(['resources/js/app.js'])
</head>
<body>

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('layouts.navbar')
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.header')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between my-4">
                        {{-- LEFT : Title --}}
                        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            Edit {{ $product->name }} Product
                        </h2>

                        {{-- RIGHT : Action Button --}}
                        <a href="{{ url()->previous() }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium
                                text-white bg-blue-600 rounded-lg
                                hover:bg-blue-700 transition
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Back
                        </a>
                    </div>

                    @include('layouts.message')

                    {{-- PRODUCT CREATE CARD --}}
                    <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:bg-gray-800">
                        <form action="{{ route('product.modify', $product->id) }}" method="POST" enctype="multipart/form-data"
                            class="px-6 pb-6 space-y-6"
                            x-data="productImageUploader()"
                            x-init="
                                @if($product->image)
                                    setExistingImage('{{ asset('storage/products/'.$product->image) }}', '{{ $product->image }}')
                                @endif
                            ">
                            @csrf
                            @method('PUT')

                            {{-- Grid --}}
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                                {{-- Left: Basic Info --}}
                                <div class="space-y-5">

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                            Product Name <span class="text-red-500">*</span>
                                        </label>
                                        <input name="name" value="{{ old('name', $product->name) }}"
                                            class="block w-full px-4 py-2 text-sm border rounded-lg
                                                    bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                    border-gray-200 dark:border-gray-600
                                                    focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                            placeholder="e.g. A4 Paper 80gsm" required>
                                        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">SKU</label>
                                            <input name="sku" value="{{ old('sku', $product->sku) }}"
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                                placeholder="Auto generate if empty">
                                            @error('sku')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                                Unit
                                            </label>

                                            <select name="unit" required
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                    bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                    border-gray-200 dark:border-gray-600
                                                    focus:border-purple-400 focus:outline-none
                                                    focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900">

                                                <option value="" selected disable>-- Select Unit --</option>

                                                <option value="pcs"   @selected(old('unit', $product->unit) == 'pcs')>pcs (Piece)</option>
                                                <option value="box"   @selected(old('unit', $product->unit) == 'box')>box</option>
                                                <option value="pack"  @selected(old('unit', $product->unit) == 'pack')>pack</option>
                                                <option value="dozen" @selected(old('unit', $product->unit) == 'dozen')>dozen</option>
                                                <option value="g"     @selected(old('unit', $product->unit) == 'g')>gram (g)</option>
                                                <option value="kg"    @selected(old('unit', $product->unit) == 'kg')>kilogram (kg)</option>
                                                <option value="ton"   @selected(old('unit', $product->unit) == 'ton')>ton</option>
                                                <option value="ml"    @selected(old('unit', $product->unit) == 'ml')>milliliter (ml)</option>
                                                <option value="l"     @selected(old('unit', $product->unit) == 'l')>liter (l)</option>
                                                <option value="ft"    @selected(old('unit', $product->unit) == 'ft')>feet (ft)</option>
                                                <option value="m"     @selected(old('unit', $product->unit) == 'm')>meter (m)</option>


                                            </select>

                                            @error('unit')
                                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                                Price <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                                placeholder="0.00" required>
                                            @error('price')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Discount</label>
                                            <input type="number" step="0.01" name="discount" value="{{ old('discount', $product->discount) }}"
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                                placeholder="0.00">
                                            @error('discount')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Stock</label>
                                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                                placeholder="0">
                                            @error('stock')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Min Stock</label>
                                            <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}"
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                                placeholder="0">
                                            @error('min_stock')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        {{-- Category --}}                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Category</label>
                                            <select name="category_id" id="category" required
                                                    class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900">
                                                <option disabled selected>-- Select Category --</option>
                                                @foreach($categories as $c)
                                                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                        <span id="loader" class="inline-block h-12 w-12 rounded-full
                                                    border-[5px]
                                                    border-gray-900 dark:border-gray-200
                                                    border-b-transparent
                                                    animate-spin">
                                            </span>
                                        {{-- Subcategory --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                                <span>Subcategory</span>                                                
                                            </label>
                                            <select name="subcategory_id" id="subCategory" required
                                                    class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900
                                                        disabled:opacity-60 disabled:cursor-not-allowed">

                                                <option disabled selected>-- Select Sub-Category --</option>
                                                {{-- initial option for edit --}}
                                                @if($product->subcategory)
                                                    <option value="{{ $product->subcategory_id }}" selected>
                                                        {{ $product->subcategory->name }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('subcategory_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                    </div>




                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Description</label>
                                        <textarea name="description" rows="4"
                                                class="block w-full px-4 py-2 text-sm border rounded-lg
                                                        bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                        border-gray-200 dark:border-gray-600
                                                        focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900"
                                                placeholder="Write product details...">{{ old('description', $product->description) }}</textarea>
                                        @error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="status" value="1"
                                                class="text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                                 {{ old('status', $product->status) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Active</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Right: Image Upload --}}
                                <div class="space-y-4">

                                    <div class="flex items-center justify-between">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Product Photo</label>

                                        <button type="button" @click="clearFile()"
                                                class="text-xs font-semibold px-3 py-1.5 rounded-lg
                                                    bg-gray-100 hover:bg-gray-200 text-gray-700
                                                    dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                                            <i class="fa-solid fa-xmark mr-1"></i> Clear
                                        </button>
                                    </div>

                                    {{-- Dropzone --}}
                                    <div
                                        class="relative rounded-xl border-2 border-dashed
                                            border-gray-200 dark:border-gray-600
                                            bg-gray-50 dark:bg-gray-700/40
                                            p-5 transition"
                                        :class="dragging ? 'ring-2 ring-purple-400 border-purple-400' : ''"
                                        @dragover.prevent="dragging=true"
                                        @dragleave.prevent="dragging=false"
                                        @drop.prevent="handleDrop($event)"
                                    >
                                        <input type="file" name="image" accept="image/*" class="hidden" x-ref="file"
                                            @change="handleFile($event)">

                                        <div class="flex flex-col items-center justify-center text-center gap-2">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center
                                                        bg-purple-100 text-purple-700
                                                        dark:bg-purple-600 dark:text-white">
                                                <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                            </div>

                                            <div class="text-sm text-gray-700 dark:text-gray-200 font-semibold">
                                                Drag & drop image here
                                            </div>

                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                or
                                                <button type="button"
                                                        class="text-purple-600 dark:text-purple-300 font-semibold hover:underline"
                                                        @click="$refs.file.click()">
                                                    Browse
                                                </button>
                                                (JPG/PNG/WebP, max 2MB)
                                            </div>
                                        </div>

                                        {{-- Preview --}}
                                        <template x-if="previewUrl">
                                            <div class="mt-5">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Preview</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400" x-text="fileName"></div>
                                                </div>

                                                <div class="w-full overflow-hidden rounded-xl
                                                            bg-white dark:bg-gray-800
                                                            border border-gray-200 dark:border-gray-700">
                                                    <img :src="previewUrl" alt="Preview" class="w-full h-56 object-cover">
                                                </div>

                                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400" x-show="fileSizeText">
                                                    Size: <span x-text="fileSizeText"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    @error('image')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Footer Buttons --}}
                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end pt-2">
                                <a href="{{ url()->previous() }}"
                                class="inline-flex justify-center px-5 py-2.5 text-sm font-semibold rounded-lg
                                        bg-gray-100 hover:bg-gray-200 text-gray-700
                                        dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                                </a>

                                <button type="submit"
                                        class="inline-flex justify-center px-5 py-2.5 text-sm font-semibold rounded-lg
                                            text-white bg-purple-600 hover:bg-purple-700
                                            focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                                            dark:focus:ring-offset-gray-800">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> Save Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>
    
    {{-- Alpine helper for drag-drop + preview --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function productImageUploader() {
            return {
                dragging: false,
                previewUrl: null,
                fileName: '',
                fileSizeText: '',

                setExistingImage(url, name) {
                    this.previewUrl = url;
                    this.fileName = name || 'Existing image';
                    this.fileSizeText = 'Existing image';
                },

                handleFile(e) {
                    const file = e.target.files?.[0];
                    if (!file) return;
                    this.setPreview(file);
                },

                handleDrop(e) {
                    this.dragging = false;
                    const file = e.dataTransfer.files?.[0];
                    if (!file) return;

                    // put dropped file into input so it submits normally
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    this.$refs.file.files = dt.files;

                    this.setPreview(file);
                },

                setPreview(file) {
                    if (!file.type?.startsWith('image/')) {
                        this.clearFile();
                        alert('Please select an image file.');
                        return;
                    }

                    this.fileName = file.name;
                    this.fileSizeText = this.formatBytes(file.size);

                    if (this.previewUrl) URL.revokeObjectURL(this.previewUrl);
                    this.previewUrl = URL.createObjectURL(file);
                },

                clearFile() {
                    this.dragging = false;
                    this.fileName = '';
                    this.fileSizeText = '';

                    if (this.previewUrl) {
                        URL.revokeObjectURL(this.previewUrl);
                        this.previewUrl = null;
                    }

                    if (this.$refs.file) {
                        this.$refs.file.value = null;
                    }
                },

                formatBytes(bytes) {
                    if (!bytes && bytes !== 0) return '';
                    const sizes = ['B', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(1024));
                    return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
                }
            }
        }

        $(document).ready(function(){
            const loader = $('#loader');
            const category = $('#category');
            const subCategory = $('#subCategory');

            const selectedSubId = "{{ old('subcategory_id', $product->subcategory_id) }}";

            function loadSubcategories(categoryId, selectedId = null) {
                if (!categoryId) {
                    subCategory.html('<option value="" disabled selected>-- Select Sub-Category --</option>');
                    return;
                }

                loader.removeClass('hidden');

                $.ajax({
                    url: "/product/get-SubCategory/" + categoryId,
                    type: "GET",
                    success: function (data) {
                        const list = data.subCategory || [];
                        let html = '<option value="" disabled selected>-- Select Sub-Category --</option>';

                        list.forEach(s => {
                            const sel = (selectedId && String(selectedId) === String(s.id)) ? 'selected' : '';
                            html += `<option value="${s.id}" ${sel}>${s.name}</option>`;
                        });

                        subCategory.html(html);
                    },
                    error: function () {
                        alert('Failed to fetch subcategories.');
                    },
                    complete: function () {
                        loader.addClass('hidden');
                    }
                });
            }

            // ✅ page load: ensure correct subcategory list exists
            loadSubcategories(category.val(), selectedSubId);

            // ✅ on change
            category.on('change', function () {
                loadSubcategories($(this).val(), null);
            });
        });
    </script>
    

</body>
</html>
