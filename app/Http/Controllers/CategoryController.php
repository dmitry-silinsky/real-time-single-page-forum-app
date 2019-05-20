<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\{CreateRequest, UpdateRequest};
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\{JsonResponse, Resources\Json\AnonymousResourceCollection, Response};

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return Response
     */
    public function store(CreateRequest $request)
    {
        Category::create($request->validated());

        return response('Created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->all());

        return (new CategoryResource($category->fresh()))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response('Error while deleting', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
