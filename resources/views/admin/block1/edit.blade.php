@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Block1 - Редактирование</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('block1.index') }}">Block1</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="submit" form="block1Form" class="btn btn-primary float-right" title="Сохранить">
                                <i class="fa fa-save"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form id="block1Form" action="{{ route('block1.update', $block1->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="title">Заголовок <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title', $block1->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea name="description" id="description" rows="5" 
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $block1->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="picture">Изображение</label>
                                    
                                    @if($block1->picture)
                                        <div class="mb-3">
                                            <p>Текущее изображение:</p>
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset($block1->picture) }}" alt="{{ $block1->title }}" 
                                                     id="currentImage"
                                                     style="max-width: 300px; max-height: 300px; object-fit: cover;" 
                                                     class="img-thumbnail">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute" 
                                                        style="top: 5px; right: 5px;" 
                                                        onclick="deleteCurrentImage()" 
                                                        title="Удалить изображение">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="delete_picture" id="delete_picture" value="0">
                                    @endif

                                    <div class="custom-file">
                                        <input type="file" name="picture" id="picture" 
                                               class="custom-file-input @error('picture') is-invalid @enderror" 
                                               accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="picture">
                                            {{ $block1->picture ? 'Заменить изображение' : 'Выберите файл' }}
                                        </label>
                                        @error('picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Максимальный размер: 2MB. Форматы: JPEG, PNG, JPG, GIF</small>
                                    
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <p>Новое изображение:</p>
                                        <div class="position-relative d-inline-block">
                                            <img id="previewImg" src="" alt="Preview" 
                                                 style="max-width: 300px; max-height: 300px; object-fit: cover;" 
                                                 class="img-thumbnail">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute" 
                                                    style="top: 5px; right: 5px;" 
                                                    onclick="clearNewImage()" 
                                                    title="Удалить изображение">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const currentImage = document.getElementById('currentImage');
            const fileLabel = input.nextElementSibling;

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                    
                    // Скрываем текущее изображение если выбрано новое
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }

                reader.readAsDataURL(input.files[0]);
                fileLabel.textContent = input.files[0].name;
            } else {
                preview.style.display = 'none';
                if (currentImage) {
                    currentImage.style.display = 'block';
                }
                fileLabel.textContent = '{{ $block1->picture ? "Заменить изображение" : "Выберите файл" }}';
            }
        }

        // Обновление label для файла
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : '{{ $block1->picture ? "Заменить изображение" : "Выберите файл" }}';
            e.target.nextElementSibling.textContent = fileName;
        });

        function deleteCurrentImage() {
            if (confirm('Удалить текущее изображение?')) {
                const currentImage = document.getElementById('currentImage');
                const deleteInput = document.getElementById('delete_picture');
                const pictureInput = document.getElementById('picture');
                const preview = document.getElementById('imagePreview');
                
                if (currentImage) {
                    currentImage.closest('.mb-3').style.display = 'none';
                }
                if (deleteInput) {
                    deleteInput.value = '1';
                }
                pictureInput.value = '';
                preview.style.display = 'none';
            }
        }

        function clearNewImage() {
            const pictureInput = document.getElementById('picture');
            const preview = document.getElementById('imagePreview');
            const fileLabel = pictureInput.nextElementSibling;
            const currentImage = document.getElementById('currentImage');
            
            pictureInput.value = '';
            preview.style.display = 'none';
            fileLabel.textContent = '{{ $block1->picture ? "Заменить изображение" : "Выберите файл" }}';
            
            if (currentImage) {
                currentImage.closest('.mb-3').style.display = 'block';
            }
        }
    </script>
@endsection
