<?php

namespace App\Laravel\Middleware\Api;

use Closure, Helper;
use App\Laravel\Models\User;
use App\Laravel\Models\Article;
use App\Laravel\Models\Chat;
use App\Laravel\Models\ChatParticipant;
use App\Laravel\Models\ChatConversation;


use App\Laravel\Models\Mentorship;
use App\Laravel\Models\MentorshipParticipant;
use App\Laravel\Models\MentorshipConversation;

use App\Laravel\Models\ArticleReaction;
use App\Laravel\Models\ArticleComment;



class ExistRecord
{

    protected $format;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $record
     * @return mixed
     */
    public function handle($request, Closure $next, $record)
    {
        $this->format = $request->format;
        $response = array();

        switch (strtolower($record)) {
            case 'mtrsp_message':
                if(! $this->_exist_mtrsp_message($request)) {
                    $response = [
                        'msg' => "Message not found.",
                        'status' => FALSE,
                        'status_code' => "MESSAGE_NOT_FOUND",
                        'hint' => "Make sure the 'msg_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'gc_message':
                if(! $this->_exist_gc_message($request)) {
                    $response = [
                        'msg' => "Message not found.",
                        'status' => FALSE,
                        'status_code' => "MESSAGE_NOT_FOUND",
                        'hint' => "Make sure the 'msg_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'mentorship':
                if(! $this->_exist_mentorship($request)) {
                    $response = [
                        'msg' => "Mentorship not found.",
                        'status' => FALSE,
                        'status_code' => "MENTORSHIP_NOT_FOUND",
                        'hint' => "Make sure the 'mentorship_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'mentorship_participant':
                if(! $this->_exist_mentorship_participant($request)) {
                    $response = [
                        'msg' => "User is not of the mentorship.",
                        'status' => FALSE,
                        'status_code' => "USER_NOT_FOUND",
                        'hint' => "Make sure the 'user_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'own_mentorship':
                if(! $this->_exist_own_mentorship($request)) {
                    $response = [
                        'msg' => "Mentorship not found.",
                        'status' => FALSE,
                        'status_code' => "MENTORSHIP_NOT_FOUND",
                        'hint' => "Make sure the 'mentorship_id' from your request parameter exists and valid to your list of mentorship."
                    ];
                }
            break;

            case 'ongoing_mentorship':
                if($this->_exist_ongoing_mentorship($request)) {
                    $response = [
                        'msg' => "Unable to proceed request. There's an active mentorship going on.",
                        'status' => FALSE,
                        'status_code' => "MENTORSHIP_ONGOING",
                        'hint' => "Make sure the you don't have ongoing mentorship to proceed."
                    ];
                }
            break;

            case 'article':
                if(! $this->_exist_article($request)) {
                    $response = [
                        'msg' => "Article not found.",
                        'status' => FALSE,
                        'status_code' => "ARTICLE_NOT_FOUND",
                        'hint' => "Make sure the 'article_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'own_article':
                if(! $this->_exist_own_article($request)) {
                    $response = [
                        'msg' => "Article not found.",
                        'status' => FALSE,
                        'status_code' => "ARTICLE_NOT_FOUND",
                        'hint' => "Make sure the 'article_id' from your request parameter exists and valid to your list of articles."
                    ];
                }
            break;

            case 'chat':
                if(! $this->_exist_chat($request)) {
                    $response = [
                        'msg' => "Chat Group not found.",
                        'status' => FALSE,
                        'status_code' => "GROUP_NOT_FOUND",
                        'hint' => "Make sure the 'chat_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'chat_participant':
                if(! $this->_exist_chat_participant($request)) {
                    $response = [
                        'msg' => "User is not a participant in the group.",
                        'status' => FALSE,
                        'status_code' => "USER_NOT_FOUND",
                        'hint' => "Make sure the 'user_id' from your request parameter exists and valid."
                    ];
                }
            break;


            case 'own_chat':
                if(! $this->_exist_own_chat($request)) {
                    $response = [
                        'msg' => "Chat Group not found.",
                        'status' => FALSE,
                        'status_code' => "GROUP_NOT_FOUND",
                        'hint' => "Make sure the 'chat_id' from your request parameter exists and valid to your list of group chats."
                    ];
                }
            break;

            case 'reaction':
                if(! $this->_exist_reaction($request)) {
                    $response = [
                        'msg' => "Article reaction not found.",
                        'status' => FALSE,
                        'status_code' => "REACTION_NOT_FOUND",
                        'hint' => "Make sure the 'reaction_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'own_reaction':
                if(! $this->_exist_own_reaction($request)) {
                    $response = [
                        'msg' => "Article reaction not found.",
                        'status' => FALSE,
                        'status_code' => "REACTION_NOT_FOUND",
                        'hint' => "Make sure the 'reaction_id' from your request parameter exists and valid to your list of reactions."
                    ];
                }
            break;


            case 'comment':
                if(! $this->_exist_comment($request)) {
                    $response = [
                        'msg' => "Comment not found.",
                        'status' => FALSE,
                        'status_code' => "COMMENT_NOT_FOUND",
                        'hint' => "Make sure the 'comment_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'own_comment':
                if(! $this->_exist_own_comment($request)) {
                    $response = [
                        'msg' => "Comment not found.",
                        'status' => FALSE,
                        'status_code' => "COMMENT_NOT_FOUND",
                        'hint' => "Make sure the 'comment_id' from your request parameter exists and valid to your list of comments."
                    ];
                }
            break;

            case 'user':
                if(! $this->_exist_user($request)) {
                    $response = [
                        'msg' => "Account not found.",
                        'status' => FALSE,
                        'status_code' => "USER_NOT_FOUND",
                        'hint' => "Make sure the 'user_id' from your request parameter exists and valid."
                    ];
                }
            break;

            case 'mentee':
                if(! $this->_exist_mentee($request)) {
                    $response = [
                        'msg' => "You don't have permission on your request..",
                        'status' => FALSE,
                        'status_code' => "UNAUTHORIZED_ACCESS",
                        'hint' => "Make sure your account is a valid mentee role."
                    ];
                }
            break;

            case 'mentor':
                if(! $this->_exist_mentor($request)) {
                    $response = [
                        'msg' => "You don't have permission on your request.",
                        'status' => FALSE,
                        'status_code' => "UNAUTHORIZED_ACCESS",
                        'hint' => "Make sure your account is a valid mentor role."
                    ];
                }
            break;
            
            case 'notification':
                if(! $this->_exist_notification($request)) {
                    $response = [
                        'msg' => "Notification not found.",
                        'status' => FALSE,
                        'status_code' => "NOTIFICATION_NOT_FOUND",
                        'hint' => "Make sure the 'notification_id' from your request parameter exists and valid."
                    ];
                }
            break;
           
        }

        if(empty($response)) {
            return $next($request);
        }

        switch ($this->format) {
            case 'json':
                return response()->json($response, 404);
            break;
            case 'xml':
                return response()->xml($response, 404);
            break;
        }
    }

    private function _exist_chat_participant($request) {

        $user = $request->get('user_data');

        $is_participant = ChatParticipant::where('chat_id',$request->get('chat_id'))->where('user_id',$user->id)->first();
        
        if($is_participant) {
            $request->merge(['chat_participant_data' => $is_participant]);
            return TRUE;
        }

        return FALSE;
    }


    private function _exist_chat($request) {

        $user = $request->user();

        $is_participant = ChatParticipant::where('chat_id',$request->get('chat_id'))->where('user_id',$user->id)->first();

        if(!$is_participant){
            return FALSE;
        }

        $chat = Chat::find( $request->get('chat_id') );
        
        if($chat) {
            $request->merge(['chat_data' => $chat]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_ongoing_mentorship($request) {
        $user = $request->user();
        $mentorship = Mentorship::where('owner_user_id',$user->id)->where('status','active')->first();
        
        if($mentorship) {
            $request->merge(['mentorship_data' => $mentorship]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_own_chat($request) {
        $user = $request->user();
        $chat = Chat::where('id', $request->get('chat_id') )->where('owner_user_id',$user->id)->first();
        
        if($chat) {
            $request->merge(['chat_data' => $chat]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_mentorship_participant($request) {

        $user = $request->get('user_data');

        $is_participant = MentorshipParticipant::where('mentorship_id',$request->get('mentorship_id'))->where('user_id',$user->id)->first();
        
        if($is_participant) {
            $request->merge(['mentorship_participant_data' => $is_participant]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_mentorship($request) {

        $user = $request->user();

        $is_participant = MentorshipParticipant::where('mentorship_id',$request->get('mentorship_id'))->where('user_id',$user->id)->first();

        if(!$is_participant){
            return FALSE;
        }

        $mentorship = Mentorship::find( $request->get('mentorship_id') );
        
        if($mentorship) {
            $request->merge(['mentorship_data' => $mentorship]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_own_mentorship($request) {
        $user = $request->user();
        $mentorship = Mentorship::where('id', $request->get('mentorship_id') )->where('owner_user_id',$user->id)->first();
        
        if($mentorship) {
            $request->merge(['mentorship_data' => $mentorship]);
            return TRUE;
        }

        return FALSE;
    }

    

    private function _exist_gc_message($request) {
        $msg = ChatConversation::where('chat_id',$request->get('chat_id'))->where('type','message')->find( $request->get('msg_id') );
        
        if($msg) {
            $request->merge(['msg_data' => $msg]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_mtrsp_message($request) {
        $msg = MentorshipConversation::where('mentorship_id',$request->get('mentorship_id'))->where('type','message')->find( $request->get('msg_id') );
        
        if($msg) {
            $request->merge(['msg_data' => $msg]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_reaction($request) {
        $reaction = ArticleReaction::find( $request->get('reaction_id') );
        
        if($reaction) {
            $request->merge(['reaction_data' => $reaction]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_own_reaction($request) {
        $user = $request->user();
        $reaction = ArticleReaction::where('id', $request->get('reaction_id') )->where('user_id',$user->id)->first();
        
        if($reaction) {
            $request->merge(['reaction_data' => $reaction]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_comment($request) {
        $comment = ArticleComment::find( $request->get('comment_id') );
        
        if($comment) {
            $request->merge(['comment_data' => $comment]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_own_comment($request) {
        $user = $request->user();
        $comment = ArticleComment::where('id', $request->get('comment_id') )->where('user_id',$user->id)->first();
        
        if($comment) {
            $request->merge(['comment_data' => $comment]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_article($request) {
        $article = Article::find( $request->get('article_id') );
        
        if($article) {
            $request->merge(['article_data' => $article]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_own_article($request) {
        $user = $request->user();
        $article = Article::where('id', $request->get('article_id') )->where('user_id',$user->id)->first();
        
        if($article) {
            $request->merge(['article_data' => $article]);
            return TRUE;
        }

        return FALSE;
    }


    private function _exist_user($request) {
        $user = User::types(['mentor','mentee'])->find( $request->get('user_id') );
        
        if($user) {
            $request->merge(['user_data' => $user]);
            return TRUE;
        }

        return FALSE;
    }

    private function _exist_mentee($request) {
        $user = $request->user();

        if($user->type == "mentee") {return TRUE;}
        return FALSE;
    }

    private function _exist_mentor($request) {
        $user = $request->user();

        if($user->type == "mentor") {return TRUE;}
        return FALSE;
    }

    private function _exist_notification($request) {
        $notification = $request->auth->notifications()->where('id', $request->get('notification_id'))->first();
        
        if($notification) {
            $request->merge(['notification_data' => $notification]);
            return TRUE;
        }

        return FALSE;
    }
    
}