<?php
	
namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller {
    public function index() {
        $categories = Category ::orderBy( 'name' ) -> get();

	    return view( 'categories.index', [ 'categories' => $categories ] );
	}
	
	public function create() {
		return view( 'categories.create_category' );
	}
	
	public function store( StoreCategoryRequest $request ) {
		Category ::create( $request -> except( '_token' ) );
		session() -> flash( 'success', 'Category created successfully' );
		
		return redirect() -> route( 'categories.index' );
	}
	
	public function edit( $id ) {
		$category = Category ::findOrFail( $id );
		
		return view( 'categories.edit_category', [ 'category' => $category ] );
	}
	
	public function update( $id, UpdateCategoryRequest $request ) {
		$category = Category ::findOrFail( $id );
		$category -> update( $request -> except( '_token' ) );
		session() -> flash( 'success', 'Category update successfully' );
		
		return redirect() -> route( 'categories.index' );
	}
	
	public function destroy( $id ) {
		$category = Category ::findOrFail( $id );
		if ($category->products()->count() > 0)
		{
			session() -> flash( 'failure', 'Cannot delete, there are products in this category' );	
		} else {
			$category -> delete();
			session() -> flash( 'success', 'Category deleted successfully' );
		}
		
		return redirect() -> route( 'categories.index' );
	}

	    public function show($id)
    {
        $cat = Category::findOrFail($id);
        $products = $cat->products()->paginate(config('pagination.value'));

        return view('home', ['products' => $products, 'sortName' => '', 'query'=>'']);
    }
}