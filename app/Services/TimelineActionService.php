<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AmountCollection;
use App\Models\ActionTimeline;
use DataTables;
use Illuminate\Support\Str;

class TimelineActionService
{
    public function actionOn($request){
        $payment_id = $request->dep_id;

        Self::checkExistStatus($payment_id);

        $actionTimeline = new ActionTimeline;
        $actionTimeline->payment_id = $payment_id;
        $actionTimeline->payment_status = $request->status;
        $actionTimeline->action_by = Auth::user()->id;
        $actionTimeline->save();

        return true;
    }

    public function checkExistStatus($id){
        $actionTimeline = ActionTimeline::where('payment_id',$id)->latest()->first();
        if($actionTimeline){
            $actionTimeline->status = false;
            $actionTimeline->save();
        }
        return true;
    }

    // public function comment(){
    //      // Create a new comment
    //     $comment = new Comment();
    //     $comment->comment = $message;
    //     $comment_josn['comment_by'] = Auth::user()->name;
    //     $comment_josn['comment'] = $message;
    //     $comment->comment_json = json_encode($comment_josn);
    //     $comment->commented_by = Auth::user()->id;


    //     // Associate the comment with a post
    //     $post = CandidateProfileForm::find($commentable_id);
    //     $post->comments()->save($comment);

    //     // Associate the comment with a user profile
    //     $userProfile = CandidateProfileForm::find($commentable_id);
    //     $userProfile->comments()->save($comment);
    // }
}
