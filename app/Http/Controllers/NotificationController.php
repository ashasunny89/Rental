<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notifications;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Google\Auth\CredentialsLoader;
use App\Models\PushNotification;
use App\Models\Device;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
        public function sendnotification(Request $request)
        {
            return view('pages.notification.send');
        }
                
        public function listnotification()
        {
            return view('pages.notification.list');
        }

        

    //Validation 
        public function notification(Request $request)
        {
            $request->validate([
                'name'=>'required',
                'message'=>'required',
                'date'=>'required',
            ]);
        //insertion
            $query = DB::table('notifications')->insert([
                'name' => $request->input('name'),
                'message' => $request->input('message'),
                'date' => $request->input('date'),
                'created_at' => now(),
                'updated_at' => now(),                          
            ]);
            return back()->with('success','inserted successfully');
        }
        
        //view list all notifications
        public function list(Request $request)
        {
            $notificationShow = DB::table('notifications')->get();
            return view('pages.notification.list', compact('notificationShow'));
        }

        //view list all notifications
        public function get_notification(Request $request)
        {
            $notificationShow = DB::table('push_notifications')->get();
            return response (['data'=>$notificationShow],200);
        }

        public function EditNotification($id)
        {
            $notificationShow = DB::table('notifications')->where('id',$id)->get();
            return view('pages.notification.edit', compact('notificationShow'));
        }

        public function UpdateNotification(Request $request)
        {       
            $update =[
                'name' => $request->name,
                'message' => $request->message,
                'date' => $request->date
            ];
            DB::table('notifications')->where('id', $request->id)->update($update);
            return back()->with('success','inserted successfully');
        }

        public function DeleteNotification($id)
        {
                //    return back()->with('success','successfully deleted');

        
        DB::table('notifications')->where('id', $id)->delete();
        return back()->with('success','successfully deleted');
        // return dd('message deleted');
        }



        
        public function pushnotification(Request $request)
        {
            return view('pages.pushnotification');
        }

        public function sendPushNotification(Request $request)
        {
            $SERVER_API_KEY = 'AAAAsWHEPCM:APA91bH_wqnKF1adjuqOMTF9p27Or2OvngR4cHhD8SlB3d581z4_Maqgr_r6fs4TPSuVMAajhV7fpSQni9c8c2K0gTJJkd7jdeEcdqJAsZLdY2z2PpI7IRPWOUc941FqBQYR2iGfSpvz';

            // Get the list of users to send notifications to (e.g., users with specific criteria)
            $users = Device::select('id', 'user_id', 'device_token', 'device_type')->get()->toArray();
            // dd($users);

            // Create an array to store valid registration IDs for the selected users
            $registrationIds = [];
            // Loop through the selected users and collect their valid device tokens
            foreach ($users as $user) {
                if (!empty($user['device_token'])) {
                    $registrationIds[] = $user['device_token'];
                }
            }
            // dd($registrationIds);

            // Check if there are valid registration IDs to proceed
            if (empty($registrationIds)) {
                return redirect()->back()->with('error', 'No valid device tokens found');
            }

            // Define your notification content
            $notificationData = [
                "registration_ids" => $registrationIds,
                "notification" => [
                    "title" => $request->input('title'),
                    "body" => $request->input('message'),
                ],
            ];
            // dd($notificationData);

            $headers = [
                'Authorization' => 'key=' . $SERVER_API_KEY,
                'Content-Type' => 'application/json',
            ];

            try {
                 $response = Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $notificationData);
                // echo $response->successful();
                // dd($response);
                // Log the response for debugging
                Log::info('FCM Response:', $response->json());

                if ($response->successful()) {
                    // Notification sent successfully; handle success if needed
                    foreach ($users as $user) {
                        $pushNotification = new PushNotification([
                            'user_id' => $user['user_id'],
                            "title" => $request->title,
                            "message" => $request->message,
                        ]);

                        // Save only if 'message' is not null
                        $pushNotification->save();
                    }
                    // dd($response);

                    return redirect()->back()->with('success', 'Notification sent and saved successfully');
                } else {
                    return redirect()->back()->with('error', 'Notification sent Failed');

                }
            } catch (\Exception $e) {
                // Log the exception for debugging
                Log::error('Exception: ' . $e->getMessage());

                // Handle any exceptions that may occur during the request
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

        // private function removeInvalidRegistrationId($invalidRegistrationId)
        // {
        //     // Assuming you have a Device model with a 'device_token' column
        //     Device::where('device_token', $invalidRegistrationId)->delete();
        // }

        // public function sendPushNotification(Request $request)
        // {
        //     $SERVER_API_KEY = 'AAAAsWHEPCM:APA91bH_wqnKF1adjuqOMTF9p27Or2OvngR4cHhD8SlB3d581z4_Maqgr_r6fs4TPSuVMAajhV7fpSQni9c8c2K0gTJJkd7jdeEcdqJAsZLdY2z2PpI7IRPWOUc941FqBQYR2iGfSpvz';

        //     // Define your notification content
        //     $notificationData = [
        //         "notification" => [
        //             "title" => $request->input('title'),
        //             "body" => $request->input('message'),
        //         ],
        //         "to" => "/topics/all", // Send to a specific topic or to a device directly
        //     ];
        //     // dd($notificationData);
        //     $headers = [
        //         'Authorization' => 'key=' . $SERVER_API_KEY,
        //         'Content-Type' => 'application/json',
        //     ];

        //     try {
        //         $response = Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $notificationData);

        //         // Log the response for debugging
        //         // Log::info('FCM Response:', $response->json());

        //         if ($response->successful()) {
        //             // Notification sent successfully; handle success if needed
        //             return redirect()->back()->with('success', 'Notification sent successfully');
        //         } else {
        //             return redirect()->back()->with('error', 'Notification sending failed');
        //         }

        //     } catch (\Exception $e) {
        //         // Log the exception for debugging
        //         Log::error('Exception: ' . $e->getMessage());

        //         // Handle any exceptions that may occur during the request
            
        //         return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        //     }
        //     dd($response);

        // }    

}

    




           
