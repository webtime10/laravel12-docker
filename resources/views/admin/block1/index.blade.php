@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Block1 - Список</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Block1</li>
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
                            <a href="{{ route('block1.create') }}" class="btn btn-primary mb-3">
                                <i class="fa fa-plus"></i> Создать
                            </a>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>Заголовок</th>
                                            <th>Описание</th>
                                            <th style="width: 150px">Изображение</th>
                                            <th style="width: 150px">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($block1 as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ Str::limit($item->description, 100) }}</td>
                                                <td>
                                                    @if($item->picture)
                                                        <img src="{{ asset($item->picture) }}" alt="{{ $item->title }}" 
                                                             style="max-width: 100px; max-height: 100px; object-fit: cover;" 
                                                             class="img-thumbnail">
                                                    @else
                                                        <span class="text-muted">Нет изображения</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('block1.edit', $item->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('block1.destroy', $item->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Подтвердите удаление')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Нет данных</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $block1->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
