<?php

namespace App\Http\Controllers\usercontroller\notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserNotification;
use Auth;
use Validator;

class UserNotificationController extends Controller
{
    public function index(Request $request){
        // SECURITY
            $validator = Validator::make(['filter' => $request->filter],[
                'filter' => 'nullable|in:unread,read',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Filter Notifikasi Tidak Sesuai !',
                    'message' => 'Mohon untuk menggunakan filter yang telah disediakan',
                ]);
            }
        // END

        // MAIN LOGIC
            switch ($request->filter) {
                case 'unread':
                    $user_notifications = Auth::user()->unreadNotifications;
                    $filter = 'unread';
                    break;

                case 'read':
                    $user_notifications = Auth::user()->readNotifications;
                    $filter = 'read';
                    break;

                default:
                    $user_notifications = Auth::user()->unreadNotifications;
                    $filter = 'unread';
                    break;
            }
        // END

        // RETURN
            return view('user-dashboard.user-notification.user-notification',compact(['user_notifications','filter']));
        // END
        
    }
}
