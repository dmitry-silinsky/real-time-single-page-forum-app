<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\{CreateRequest, UpdateRequest};
use App\Http\Resources\QuestionResource;
use App\Models\{Question, User};
use Auth;
use Exception;
use Illuminate\Http\{JsonResponse, Resources\Json\AnonymousResourceCollection, Response};

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $questions = Question::latest()->get();

        return QuestionResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return QuestionResource
     */
    public function store(CreateRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $question = $user->questions()->create($request->validated());

        return new QuestionResource($question);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Question $question
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Question $question)
    {
        $question->update($request->validated());

        return (new QuestionResource($question->fresh()))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return Response
     */
    public function destroy(Question $question)
    {
        try {
            $question->delete();
            return response(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response('Error while deleting', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
