<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AuthorizationsTrait;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    use AuthorizationsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('manageCategories', Category::class);

        $data['title'] = 'فهرست دسته بندی ها';
        $data['active'] = 'categories';
        $data['categories'] = Category::orderBy("created_at", "desc")->paginate(10);
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view("admin.category.all", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create', Category::class);

        $category = new Category;
        $category->title = $request->title;
        $category->save();

        return redirect()->back()->with("success_message", "با موفقیت ثبت شد.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data['active'] = 'categories';
        $data['category'] = $category;
        $data['title'] = 'ویرایش دسته بندی ها';
        $data['categories'] = Category::orderBy("created_at", "desc")->paginate(10);
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view("admin.category.all", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        Gate::authorize('update', $category);

        $category->title = $request->title;
        $category->save();

        return redirect('categories')->with("success_message", "با موفقیت ویرایش شد.");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        $category->posts()->detach();

        $category->delete();

        return redirect()->back()->with('success_message', 'دسته بندی با موفقیت حذف شد.');

    }
}
