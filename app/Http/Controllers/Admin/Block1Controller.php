<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Block1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Block1 - Список';
        $block1 = Block1::orderBy('id', 'desc')->paginate(15);
        return view('admin.block1.index', compact('block1', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Block1 - Создание';
        return view('admin.block1.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->only(['title', 'description']);
        
        // Загрузка изображения
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/block1'), $fileName);
            $data['picture'] = 'uploads/block1/' . $fileName;
        }
        
        Block1::create($data);
        
        return redirect()->route('block1.index')
            ->with('success', 'Запись успешно создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Block1 - Редактирование';
        $block1 = Block1::findOrFail($id);
        return view('admin.block1.edit', compact('block1', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $block1 = Block1::findOrFail($id);
        $data = $request->only(['title', 'description']);
        
        // Удаление текущего изображения если запрошено
        if ($request->has('delete_picture') && $request->delete_picture == '1') {
            if ($block1->picture && file_exists(public_path($block1->picture))) {
                unlink(public_path($block1->picture));
            }
            $data['picture'] = null;
        }
        
        // Загрузка нового изображения
        if ($request->hasFile('picture')) {
            // Удаление старого изображения
            if ($block1->picture && file_exists(public_path($block1->picture))) {
                unlink(public_path($block1->picture));
            }
            
            $file = $request->file('picture');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/block1'), $fileName);
            $data['picture'] = 'uploads/block1/' . $fileName;
        }
        
        $block1->update($data);
        
        return redirect()->route('block1.index')
            ->with('success', 'Запись успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $block1 = Block1::findOrFail($id);
        
        // Удаление изображения
        if ($block1->picture && file_exists(public_path($block1->picture))) {
            unlink(public_path($block1->picture));
        }
        
        $block1->delete();
        
        return redirect()->route('block1.index')
            ->with('success', 'Запись успешно удалена');
    }
}
