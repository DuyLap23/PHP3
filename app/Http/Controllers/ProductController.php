<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->with('category')->cursorPaginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create',compact('categories'));
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
            'price.required' => 'Giá này là trường bắt buộc.',
            'price.numeric' => 'Giá này phải là một số.',
            'quantity.required' => 'Số luồng là trường bắt buộc.',
            'quantity.numeric' => 'Số luồng phải là một số.',
            'description.required' => 'Một trình nghĩa là trường bắt buộc.',
            'description.min' => 'Nhập tối thiểu 20 kí tự.',
            'category_id.required' => 'Danh mục là trường bắt buộc.',
            
        ];
        
        $validate = $request->validate([
            'name' => ['required', 'max:30'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'description' => ['required', 'min:20'],
            'category_id' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], $messages);
        try {
            $data = $validate;
            $data['status'] = $request->boolean('status', false);
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('products', $request->file('image'));
            }

            Product::query()->create($data);

            return redirect()->route('products.index')->with('success', 'Thêm không thành công!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::query()->with('category')->find($id);
        $categories = Category::all();
        return view('products.edit', compact('products','categories'));
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
            'price.required' => 'Giá này là trường bắt buộc.',
            'price.numeric' => 'Giá này phải là một số.',
            'quantity.required' => 'Số luồng là trường bắt buộc.',
            'quantity.numeric' => 'Số luồng phải là một số.',
            'description.required' => 'Một trình nghĩa là trường bắt buộc.',
            'description.min' => 'Nhập tối thiểu 20 kí tự.',
            'category_id.required' => 'Danh mục là trường bắt buộc.',
            
        ];
        
        $validate = $request->validate([
            'name' => ['required', 'max:30'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'description' => ['required', 'min:20'],
            'category_id' => ['required'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], $messages);
        try {
            DB::beginTransaction();
            $model = Product::query()->with('category')->findOrFail($id);
            $data = $validate;

            $data['status'] = $request->boolean('status', false);
            if ($request->hasFile('image')) 
            {
                $data['image'] = Storage::put('products', $request->file('image'));
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
            return redirect()->route('products.index')->with('success', 'Thêm không thành công!');
        } catch (\Exception $exception) {
            // DB::rollBack();
            dd($exception);
            return redirect()
                ->back()
                ->with('error', 'Thêm không thành công!' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Product::query()->with('category')->find($id);

        $model->delete();

        if ($model->image && Storage::exists($model->image)) {
            Storage::delete($model->image);
        }
        return redirect()->route('products.index')->with('success', 'Xóa thành công!');
    }
}
