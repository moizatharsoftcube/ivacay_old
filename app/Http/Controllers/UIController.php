<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\ReviewModel;
use App\Models\ImageModel;
use App\Models\PackageModel;
use App\Models\ProfileModel;
use App\Models\CountryModel;
use App\Models\MembershipPlanModel;
use App\Models\MembershipModel;
use Carbon\Carbon;

class UIController extends EmailController
{
    public function index()
    {
        $countries = CountryModel::all();
        return view('index',compact('countries'));
    }
    public function for_guide()
    {
        return view('for_guide');
    }
    public function articles()
    {
        return view('articles');
    }
    public function faq()
    {
        return view('faq');
    }
    public function about_us()
    {
        return view('about-us');
    }
//    public function reviews()
//    {
//        $reviews = ReviewModel::where('status', 1)->with('getReviewUser')->get();
//        $review_star = ReviewModel::where('status', 1)->pluck('star')->avg();
//        $review_avg = number_format((float)$review_star, 1, '.', '');
//        $excellent = ReviewModel::where('star', 5)->where('status', 1)->pluck('star')->count();
//        $good = ReviewModel::where('star', 4)->where('status', 1)->pluck('star')->count();
//        $average = ReviewModel::where('star', 3)->where('status', 1)->pluck('star')->count();
//        $poor = ReviewModel::where('star', 2)->where('status', 1)->pluck('star')->count();
//        $terrible = ReviewModel::where('star', 1)->where('status', 1)->pluck('star')->count();
//
//        //Excellent
//        if($excellent  <= 0){$excellent_bar = 'bar-1';}
//        elseif ($excellent < 10  && $excellent > 0){$excellent_bar = 'bar-2';}
//        elseif ($excellent < 30  && $excellent > 10){$excellent_bar = 'bar-3';}
//        elseif ($excellent < 60  && $excellent > 30){$excellent_bar = 'bar-4';}
//        elseif ($excellent <= 100  && $excellent > 60){$excellent_bar = 'bar-5';}
//        elseif ($excellent > 100){$excellent_bar = 'bar-6';}
//
//        //Good
//        if($good  <= 0){$good_bar = 'bar-1';}
//        elseif ($good < 10  && $good > 0){$good_bar = 'bar-2';}
//        elseif ($good < 30  && $good > 10){$good_bar = 'bar-3';}
//        elseif ($good < 60  && $good > 30){$good_bar = 'bar-4';}
//        elseif ($good <= 100  && $good > 60){$good_bar = 'bar-5';}
//        elseif ($good > 100){$good_bar = 'bar-6';}
//
//        //Average
//        if($average  <= 0){$average_bar = 'bar-1';}
//        elseif ($average < 10  && $average > 0){$average_bar = 'bar-2';}
//        elseif ($average < 30  && $average > 10){$average_bar = 'bar-3';}
//        elseif ($average < 60  && $average > 30){$average_bar = 'bar-4';}
//        elseif ($average <= 100  && $average > 60){$average_bar = 'bar-5';}
//        elseif ($average > 100){$average_bar = 'bar-6';}
//
//        //Poor
//        if($poor  <= 0){$poor_bar = 'bar-1';}
//        elseif ($poor < 10  && $poor > 0){$poor_bar = 'bar-2';}
//        elseif ($poor < 30  && $poor > 10){$poor_bar = 'bar-3';}
//        elseif ($poor < 60  && $poor > 30){$poor_bar = 'bar-4';}
//        elseif ($poor <= 100  && $poor > 60){$poor_bar = 'bar-5';}
//        elseif ($poor > 100){$poor_bar = 'bar-6';}
//
//        //Terrible
//        if($terrible  <= 0){$terrible_bar = 'bar-1';}
//        elseif ($terrible < 10  && $terrible > 0){$terrible_bar = 'bar-2';}
//        elseif ($terrible < 30  && $terrible > 10){$terrible_bar = 'bar-3';}
//        elseif ($terrible < 60  && $terrible > 30){$terrible_bar = 'bar-4';}
//        elseif ($terrible <= 100  && $terrible > 60){$terrible_bar = 'bar-5';}
//        elseif ($terrible > 100){$terrible_bar = 'bar-6';}
//
//        return view('reviews', compact('reviews', 'review_avg','excellent','good','average','poor','terrible','excellent_bar','good_bar','average_bar','poor_bar','terrible_bar'));
//    }

    public function submit_review(Request $request)
    {
        $request->validate([
            'message' => 'required|max:1000',
            'rating' => 'required|numeric|min:1|max:5'
        ]);
        if (Auth::check() && Auth::user()->id) {
            $review_model = new ReviewModel();
            $review_model->user_id = Auth::user()->id;
            $review_model->message = $request->message;
            $review_model->star = $request->rating;
            $review_model->status = 0;
            $review_model->save();
            if ($review_model->save()) {
                return redirect()->route('UI_reviews')->with('success', 'submitted');
            }
        } else {
            return redirect()->route('UI_reviews')->with('error', 'Login Requried');
        }
        return redirect()->route('UI_index');
    }
    public function share_experience()
    {
        $reviews = ReviewModel::where('status', 1)->with('getReviewUser')->get();
        $review_star = ReviewModel::where('status', 1)->pluck('star')->avg();
        $review_avg = number_format((float)$review_star, 1, '.', '');

        $excellent = ReviewModel::where('star', 5)->where('status', 1)->pluck('star')->count();
        $good = ReviewModel::where('star', 4)->where('status', 1)->pluck('star')->count();
        $average = ReviewModel::where('star', 3)->where('status', 1)->pluck('star')->count();
        $poor = ReviewModel::where('star', 2)->where('status', 1)->pluck('star')->count();
        $terrible = ReviewModel::where('star', 1)->where('status', 1)->pluck('star')->count();

        //Excellent
        if($excellent  <= 0){$excellent_bar = 'bar-1';}
        elseif ($excellent < 10  && $excellent > 0){$excellent_bar = 'bar-2';}
        elseif ($excellent < 30  && $excellent > 10){$excellent_bar = 'bar-3';}
        elseif ($excellent < 60  && $excellent > 30){$excellent_bar = 'bar-4';}
        elseif ($excellent <= 100  && $excellent > 60){$excellent_bar = 'bar-5';}
        elseif ($excellent > 100){$excellent_bar = 'bar-6';}

        //Good
        if($good  <= 0){$good_bar = 'bar-1';}
        elseif ($good < 10  && $good > 0){$good_bar = 'bar-2';}
        elseif ($good < 30  && $good > 10){$good_bar = 'bar-3';}
        elseif ($good < 60  && $good > 30){$good_bar = 'bar-4';}
        elseif ($good <= 100  && $good > 60){$good_bar = 'bar-5';}
        elseif ($good > 100){$good_bar = 'bar-6';}

        //Average
        if($average  <= 0){$average_bar = 'bar-1';}
        elseif ($average < 10  && $average > 0){$average_bar = 'bar-2';}
        elseif ($average < 30  && $average > 10){$average_bar = 'bar-3';}
        elseif ($average < 60  && $average > 30){$average_bar = 'bar-4';}
        elseif ($average <= 100  && $average > 60){$average_bar = 'bar-5';}
        elseif ($average > 100){$average_bar = 'bar-6';}

        //Poor
        if($poor  <= 0){$poor_bar = 'bar-1';}
        elseif ($poor < 10  && $poor > 0){$poor_bar = 'bar-2';}
        elseif ($poor < 30  && $poor > 10){$poor_bar = 'bar-3';}
        elseif ($poor < 60  && $poor > 30){$poor_bar = 'bar-4';}
        elseif ($poor <= 100  && $poor > 60){$poor_bar = 'bar-5';}
        elseif ($poor > 100){$poor_bar = 'bar-6';}

        //Terrible
        if($terrible  <= 0){$terrible_bar = 'bar-1';}
        elseif ($terrible < 10  && $terrible > 0){$terrible_bar = 'bar-2';}
        elseif ($terrible < 30  && $terrible > 10){$terrible_bar = 'bar-3';}
        elseif ($terrible < 60  && $terrible > 30){$terrible_bar = 'bar-4';}
        elseif ($terrible <= 100  && $terrible > 60){$terrible_bar = 'bar-5';}
        elseif ($terrible > 100){$terrible_bar = 'bar-6';}

        return view('share-experience', compact('reviews', 'review_avg','excellent','good','average','poor','terrible','excellent_bar','good_bar','average_bar','poor_bar','terrible_bar'));
    }

    public function service_provider()
    {
        return view('service_provider');
    }
    public function search_country(Request $request)
    {
        if($request->ajax())
        {
            if($request->search != null)
            {
                $part = CountryModel::where('name','LIKE','%'.$request->search.'%')
                // ->orWhere('title','LIKE','%'.$request->search.'%')
                ->get();

                $output = '<table class="table table-striped">
                                    <tbody>';
                if (count($part) > 0)
                {
                    foreach($part as $value)
                    {
                        $route = route('UI_country_specific_packages',[$value->id]);
                        $output .=
                            '<tr><a href="'.$route.'">
                                ' . $value->name . '
                            </a></tr>';
                    }
                } else {
                    $output .= '<tr><a href="javascript:void(0)">No Result Found. Please search a correct name.</a></tr>';
                }
                $output .= '</tbody>
                        </table>';
                return $output;
            } else {
                return $output = '';
            }
        }
    }


    public function vacationer()
    {
        $countries = CountryModel::all();
        return view('vacationer', compact('countries'));
    }
    public function plan_journey()
    {
        return view('contact_us');
    }
    public function build_package()
    {
        $countries = CountryModel::all();
        return view('build_your_package', compact('countries'));
    }
    public function contact_us(Request $req)
    {
        $this->contactUs($req->subject, $req->username, $req->email, $req->comment);
        return back()->with('success','Response submitted Successfully');
    }



    public function sign_up()
    {
        $countries = CountryModel::all();
        return view('sign_up', compact('countries'));
    }
    public function create_account(Request $req)
    {
        $rules = $this->validate($req, [
            'username' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required'],
            'user_role' => ['required'],
            'country_id' => ['required'],
            'image' => ['required','mimes:jpeg,png,jpg,max:2048'],
        ]);
        $user = new User();
        $user->username = $req->username;
        $user->email = $req->email;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
        $user->user_role = $req->user_role;

        if($req->image){
            $imageName = time() . '.' . $req->image->getClientOriginalExtension();
            $req->image->move(public_path('/users'), $imageName);
        }
        $user->avatar = $imageName;

        $user->save();

        $profile = new ProfileModel();
        $profile->user_id = $user->id;
        $profile->full_name = $user->username;
        $profile->country_id = $req->country_id;
        $profile->phone = $req->phone;
        // $profile->country = $req->country;
        $profile->save();

        //to shoot an email
        $this->verifyEmail($user->id);

        return back()->with('success','Account created successfully!');
    }

    public function login()
    {
        if(!Auth::check())
        {
            return view('login');
        } else {
            $countries = CountryModel::all();
            return view('index',compact('countries'));
        }
    }
    public function loggedin(Request $req)
    {
        $this->validate($req, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if(!empty($req->email) && !empty($req->password)){
            $userfind = User::where('email', $req->email)->where('status', 1)->first();
            if($userfind){
                /*means found user*/
                if(Hash::check($req->password, $userfind->password)){
                    /*matched password*/
                    Auth::login($userfind);
                    if(Auth::check()){
                        // dd($userfind->user_role == 1); //means if user is a guider
                        if($userfind->user_role == 1) //means if user is a guider
                        {
                            if($userfind->profile_status == 0)
                            {
                                return redirect()->route('Guider_membership_plan');
                            } else {
                                Auth::logout();
                                return back()->with('error', 'Your profile is locked. Contact owner to unlock it');
                            }
                        } else if($userfind->user_role == 0)
                        {
                            return back()->with('success', 'Logged in successfully');
                            // return redirect()->route('UI_index');
                        }
                        // return redirect(route('UI_index'));
                        return redirect()->back();
                    }else{
                        return redirect(route('UI_login'));
                    }
                    /*matched password end*/
                }else{
                    return redirect(route('UI_login'))->with('error','Password is incorrect')->with('email', $req->email);
                }
                /*means found user end*/
            }else{
                return back()->with('error','Email not found or You didn\'t confirm your email yet');
            }
        }else{
            return redirect(route('UI_login'))->with('warning','Please fill required fields');
        }
    }

    //execute from user email
    public function user_verified($id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();

        return redirect(route('UI_login'))->with('success', 'Email authorized! You can login now.');
    }
    public function logout()
    {
        Auth::logout();
        return redirect(route('UI_index'));
    }




    public function personal_concierge_service()
    {
        return view('personal_concierge_service');
    }
    public function personal_concierge_service2()
    {
        return view('personal_concierge_service2');
    }

    public function forgotpasswordView()
    {
        return view('forgot-password');
    }
    public function reset_password(User $user)
    {
        if($user->is_reset === 1)
        {
            return view('reset-password',compact('user'));
        }
        else{
            return redirect()->route('UI_index')->with('error','Link not found');
        }

    }
    protected function reset_password_data(User $user,Request $request)
    {
        $data = $request->validate([
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);

        if($user->is_reset === 1)
        {
            $user->password = Hash::make($request->new_password);
            $user->is_reset = 0;
            $user->save();
            return redirect()->route('UI_index')->with('success','Password Update Successfully');
        }
        else
        {
            return redirect()->route('UI_index')->with('error','Your Link Expired');
        }
    }

}
