<?php

namespace App\Http\Controllers;

use App\Http\Requests\Replies\{CreateRequest, UpdateRequest};
use App\Http\Resources\ReplyResource;
use App\Models\{Question, Reply};
use App\Notifications\Reply\NewReplyNotification;
use Auth;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\{JsonResponse, Resources\Json\AnonymousResourceCollection, Response};

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt')->only('store', 'update', 'destroy', 'like', 'unlike');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Question $question
     * @return AnonymousResourceCollection
     */
    public function index(Question $question)
    {
        $replies = $question->replies()->withCount('likes')->latest()->get();

        return ReplyResource::collection($replies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param Question $question
     * @return ReplyResource
     */
    public function store(CreateRequest $request, Question $question)
    {
        $data = array_merge($request->validated(), ['user_id' => Auth::id()]);

        /** @var Reply $reply */
        $reply = $question->replies()->create($data);

        if ($reply->user_id !== $question->user_id) {
            $question->user->notify(new NewReplyNotification($reply));
        }

        return new ReplyResource($reply);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @param int $reply
     * @return ReplyResource
     */
    public function show(Question $question, int $reply)
    {
        $reply = $question->replies()->findOrFail($reply);

        return new ReplyResource($reply);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Question $question
     * @param int $reply
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Question $question, int $reply)
    {
        $reply = $question->replies()->findOrFail($reply);

        $reply->update($request->validated());

        return (new ReplyResource($reply->fresh()))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param int $reply
     * @return Response
     */
    public function destroy(Question $question, int $reply)
    {
        $reply = $question->replies()->findOrFail($reply);

        try {
            $reply->delete();
            return response(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            return response('Error while deleting', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Question $question
     * @param int $reply
     * @return ResponseFactory|Response
     */
    public function like(Question $question, int $reply)
    {
        /** @var Reply $reply */
        $reply = $question->replies()->findOrFail($reply);

        $reply->like(auth()->user());

        return response(null, Response::HTTP_ACCEPTED);
    }

    /**
     * @param Question $question
     * @param int $reply
     * @return ResponseFactory|Response
     */
    public function unlike(Question $question, int $reply)
    {
        /** @var Reply $reply */
        $reply = $question->replies()->findOrFail($reply);

        $reply->unlike(auth()->user());

        return response(null, Response::HTTP_ACCEPTED);
    }
}
