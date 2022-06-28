<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyTestMail;
use App\Mail\ForgotPassword;
use App\Mail\ContactMail;
use App\Models\User;

class EmailController extends Controller
{
    public $adminmail = 'admin@mail.com';
    
    public function verifyEmail($user_id){
        $user = User::find($user_id);
        
        if($user){
        
            \Mail::to($user->email)->send(new MyTestMail($user));
        }else{
         
            return back()->with('Order Not Found');
        }
    }
    public function contactUs($subject, $name, $email, $comment){
        $object['subject'] = $subject;
        $object['name'] = $name;
        $object['email'] = $email;
        $object['comment'] = $comment;


        \Mail::to($email)->send(new ContactMail($object));
    }

    public function forgotpassword(Request $request)
    {
        $userfind=User::where('email',$request->email)->first();
        // dd($request->all());
        if($userfind){
            $userfind->is_reset = 1;
            $userfind->save();
            $details = $userfind;
            // \Mail::to($userfind->email)->send(new ForgotPassword($details));
            \Mail::to('devpetyr911@gmail.com')->send(new ForgotPassword($details));
            return back()->with('success','An email has been sent to you!');
        }else{
            return back()->with('error','Your email is not valid');
        }

    }
}
