@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Block1 - Создание</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('block1.index') }}">Block1</a></li>
                        <li class="breadcrumb-item active">Создание</li>
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

                            <form id="block1Form" action="{{ route('block1.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="title">Заголовок <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea name="description" id="description" rows="5" 
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="picture">Изображение</label>
                                    <div class="custom-file">
                                        <input type="file" name="picture" id="picture" 
                                               class="custom-file-input @error('picture') is-invalid @enderror" 
                                               accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="picture">Выберите файл</label>
                                        @error('picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Максимальный размер: 2MB. Форматы: JPEG, PNG, JPG, GIF</small>
                                    
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <div class="position-relative d-inline-block">
                                            <img id="previewImg" src="" alt="Preview" 
                                                 style="max-width: 300px; max-height: 300px; object-fit: cover;" 
                                                 class="img-thumbnail">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute" 
                                                    style="top: 5px; right: 5px;" 
                                                    onclick="clearImage()" 
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
            const fileLabel = input.nextElementSibling;

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
                fileLabel.textContent = input.files[0].name;
            } else {
                preview.style.display = 'none';
                fileLabel.textContent = 'Выберите файл';
            }
        }

        // Обновление label для файла
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Выберите файл';
            e.target.nextElementSibling.textContent = fileName;
        });

        function clearImage() {
            const pictureInput = document.getElementById('picture');
            const preview = document.getElementById('imagePreview');
            const fileLabel = pictureInput.nextElementSibling;
            
            pictureInput.value = '';
            preview.style.display = 'none';
            fileLabel.textContent = 'Выберите файл';
        }
    </script>
@endsection
