<?php

namespace App\Http\Controllers\API;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CommentController extends Controller
{
    /*******************
     * list all the comments.
     */
    public function index()
    {
        try {
            if (@\Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count()) {
                $comments = Comment::whereParentId(0)->orderbydesc('id')->paginate();
                return response()->json($comments, 200);
            }
            if (\Auth::user()->checkedHasAnyRole([RoleTypes::MECHANIC, RoleTypes::MOBILE_MECHANIC, RoleTypes::STABLE_MECHANIC])->count()) {
                $comments = Comment::whereMechanicId(\Auth::user()->mechanic->id)->whereParentId(0)->orderbydesc('id')->paginate();
                return response()->json($comments, 200);
            }
            $comments = Comment::whereParentId(0)->whereUserId(\Auth::user()->id)->orderbydesc('id')->paginate();
            return response()->json($comments, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 301);
        }
    }

    /********************
     * @param Request $request
     * for save a new comment
     */
    public function store(Request $request)
    {
        $rules = array(
            "user_id" => "required|exists:users,id",
            "mechanic_id" => "required|exists:users,id",
            "context" => "required|string",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            DB::beginTransaction();
            $request->request->add(['accepted' => false]);
            $comment = Comment::create($request->all());
            DB::commit();
            return response()->json([$comment->id, 'comment added successfully wait for accept by admin.'], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

    /***************
     * @param $id
     * @param Request $request
     * when admin want to save comment.
     */
    public function accepted($id, Request $request)
    {
        $rules = array(
            'accepted' => 'required|boolean'
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            if (!@\Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count()) {
                return response()->json(['message' => "sorry you can't access this section"], 401);
            }
            DB::beginTransaction();
            $comment = Comment::findOrFail($id);
            if (@$comment) {
                $comment->accepted = $request->accepted;
                $comment->save();
                DB::commit();
                return response()->json([$comment->id, 'comment status changed successfully.'], 200);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'fails, your comment not found.'], 401);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }


    public function reply($id, Request $request)
    {
        $rules = array(
            "context" => "required|string",
            "parent_id" => "required|exists:comments,id",
            "user_id" => "required|exists:users,id",        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $currentComment = Comment::findOrFail($id);
            if (@\Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count()) {
                $comment = Comment::create([
                    'user_id' => \Auth::user()->id,
                    'parent_id' => $currentComment->id,
                    'mechanic_id' => $currentComment->mechanic_id,
                    'context' => $request->context,
                    'accepted' => true,
                ]);
                return response()->json($comment, 200);
            }
            return response()->json(['status' => "you can't access this section"], 301);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }


    public function mechanic($id)
    {
        try {
            $comments = Comment::whereMechanicId($id)->orderByDesc('id')->take(7)->get();
            return response()->json($comments, 200);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }


    /*******************
     * @param $id
     * show all comments for a mechanic
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();
            $comment = Comment::findOrFail($id);
            if (@\Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count()) {
                if ($comment->where('user_id', '=', \Auth::user()->id)->count())
                    return response()->json($comment, 200);
            }

            if (\Auth::user()->checkedHasAnyRole([RoleTypes::MECHANIC, RoleTypes::MOBILE_MECHANIC, RoleTypes::STABLE_MECHANIC])->count()) {
                $comments = Comment::whereMechanicId(\Auth::user()->mechanic->id)->orderbydesc('id')->paginate();
                return response()->json($comments, 200);
            }

            if (@$comment) {
                $comment->save();
                DB::commit();
                return response()->json([$comment->id, 'comment status changed successfully.'], 200);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'fails, your comment not found.'], 401);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

    /*******************
     * @param $id
     * delete comment
     */
    public function delete($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            if (@$comment) {
                if (@\Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count()) {
                    $comment->delete();
                    return response()->json(['message' => 'delete comment successfully.'], 200);
                }
                if (\Auth::user()->checkedHasAnyRole([RoleTypes::MECHANIC, RoleTypes::MOBILE_MECHANIC, RoleTypes::STABLE_MECHANIC])->count()) {
                    $comment->findMechanic(\Auth::user()->mechanic->id)->delete();
                    return response()->json(['message' => 'delete comment successfully.'], 200);
                }
                return response()->json(["message" => "fails! you can't delete this item."], 401);
            } else {
                return response()->json(['message' => 'fails, your comment not found.'], 401);
            }
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

}
