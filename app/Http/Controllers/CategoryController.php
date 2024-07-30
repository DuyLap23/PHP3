<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->cursorPaginate(5);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Tên là trường bắt buộc.',
            'name.max' => 'Tên không được vượt quá 30 ký tự.',
            'image.required' => 'Hình ảnh là trường bắt buộc.',
            'image.image' => 'Tệp phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
        
        $validate = $request->validate([
            'name' => ['required', 'max:30'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], $messages);
        try {
            $data = $validate;
            $data['status'] = $request->boolean('status', false);
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('categories', $request->file('image'));
            }

            Category::query()->create($data);

            return redirect()->route('home')->with('success', 'Thêm không thành công!');
        } catch (\Exception $exception) {
            // DB::rollBack();
            dd($exception);
            return redirect()
                ->back()
                ->with('error', 'Thêm không thành công!' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::query()->find($id);
        return view('categories.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::query()->find($id);
        return view('categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'name.required' => 'Tên là trường bắt buộc.',
            'name.max' => 'Tên không được vượt quá 30 ký tự.',
            'image.required' => 'Hình ảnh là trường bắt buộc.',
            'image.image' => 'Tệp phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
        
        $validate = $request->validate([
            'name' => ['required', 'max:30'],
            'image' => [ 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], $messages);
        try {
            DB::beginTransaction();
            $model = Category::query()->findOrFail($id);
            $data = $validate;
            $data['status'] = $request->boolean('status', false);

            if ($request->hasFile('image')) 
            {
                $data['image'] = Storage::put('categories', $request->file('image'));
                $oldImage = $model->image;
            } else 
            {
                $oldImage = null;
            }

            $model->update($data);
            if ($oldImage && Storage::exists($oldImage)) 
            {
                Storage::delete($oldImage);
            }
            DB::commit();

            return redirect()->route('home')->with('success', 'Cập nhật không thành công!');
        } catch (\Exception $exception) {
            // DB::rollBack();
            dd($exception);
            return redirect()
                ->back()
                ->with('error', 'Cập nhật không thành công!' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Category::query()->find($id);
        $model->delete();
        if ($model->image && Storage::exists($model->image)) {
            Storage::delete($model->image);
        }
        return redirect()->back()->with('success', 'Xóa thành công!');
    }
}
