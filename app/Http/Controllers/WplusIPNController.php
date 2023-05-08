<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use \Carbon\Carbon;

use App\Models\User;
use App\Models\JvzooProduct;
use App\Models\JvzooProductTransaction;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Notifications\UserCreationNotification;
use App\Notifications\UserUpgradeNotification;
use App\Notifications\UserRefundNotification;
use Log;

class WplusIPNController extends Controller
{
    public function WPlus(Request $request)
    {
        $data = $request->all();
        Log::debug(json_encode($data));

        if(isset($data['WP_SECURITYKEY']) && $data['WP_SECURITYKEY'] === 'ded33f196ae01c00aeb5c9800263d39') {
            if(!$data['WP_ITEM_NUMBER'] || !$data['WP_BUYER_EMAIL'] || !$data['WP_BUYER_NAME'] || !$data['WP_TXNID'] || !$data['WP_ACTION']) {
                return response(['message' => 'Incorrect fields!'], 422);
            }

            $d = [
                'productId'     => $data['WP_ITEM_NUMBER'],
                'customerEmail' => $data['WP_BUYER_EMAIL'],
                'customerName'  => $data['WP_BUYER_NAME'],
                'transactionId' => $data['WP_TXNID'],
                'transactionType' => $data['WP_ACTION']
            ];
            
            switch ($d['transactionType']) {
                case 'sale':
                    $response = $this->createUser($d);
                    break;
                case 'refund':
                    $response = $this->detachUser($d);
                    break;
            }

            return response(['message' => $response]);
        }

        return response(['message' => 'Verification Failed!'], 422);
    }

    private function createUser($data)
    {
        $role = JvzooProduct::where('product_id', $data['productId'])->first();

        if(!$role){
            return response([
                'message' => 'Product Validation Failed!'
            ]);
        }

        $email = $data['customerEmail'];
        $password = false;
        $user = User::where('email', $email)->first();
        $userId;

        if(!$user) {
            $password = Str::random(10);
            $userModel;
            $username;

            $newUser = User::create([
                'name'      => $data['customerName'] ? $data['customerName'] : substr($email, 0, strpos($email, '@')),
                'email'     => $email,
                'password'  => bcrypt($password),
                'active_status' => 1,
                'created_by'    => 2,
            ]);

            $newUser->assignRole($role->funnel);
            $userModel = $newUser;
            $username = $newUser->name;
            $userId = $newUser->id;

            $userInfo = [
                'username' => $username, 
                'email'    => $email,
                'password' => $password,
                'product'  => $role->name
            ];

            JvzooProductTransaction::create([
                'user_id'           => $userId ,
                'product_id'        => $role->id,
                'transaction_id'    => $data['transactionId'],
                'transaction_type'  => 'sale'
            ]);

            Notification::send($userModel, new UserCreationNotification($userInfo));

            return 'User Created Successfully!';
        }else {
            // if user exist update role
            $currentRole = Role::select('roles.name as name','mr.model_id')
                ->join('model_has_roles as mr','roles.id', '=', 'mr.role_id')
                ->where('mr.model_id', $user->id)
                ->first();

            if($role->funnel != $currentRole->name){
                $user->removeRole($currentRole->name);
                $user->assignRole($role->funnel);

                $userInfo = [
                    'username'=> $user->name, 
                    'product' => $role->funnel
                ];
                $userId = $user->id;

                JvzooProductTransaction::create([
                    'user_id'           => $userId ,
                    'product_id'        => $role->id,
                    'transaction_id'    => $data['transactionId'],
                    'transaction_type'  => 'sale'
                ]);
                
                Notification::send($user, new UserUpgradeNotification($userInfo));

                return 'User Bundle Upgraded!';
            }
        }
    }

    private function detachUser($d)
    {
        // detach user role
        $user = User::where('email', $d['customerEmail'])->first(); 
        $role = JvzooProduct::where('product_id', $d['productId'])->first();

        if ($user) {
            $id = $user->id;

            $currentRole = Role::select('roles.name as name','mr.model_id')
                ->join('model_has_roles as mr','roles.id', '=', 'mr.role_id')
                ->where('mr.model_id', $id)
                ->first();

            if($currentRole){
                $user->removeRole($currentRole->name);
                $user->delete();
    
                $userInfo = [
                    'username'=> $user->name, 
                    'product' => $role->name
                ];

                JvzooProductTransaction::create([
                    'user_id'           => $id,
                    'product_id'        => $d['productId'],
                    'transaction_id'    => $d['transactionId'],
                    'transaction_type'  => 'RFND'
                ]);

                Notification::send($user, new UserRefundNotification($userInfo));
    
                return response([
                    'message' => 'User Detached'
                ]);
            }
        }        
    }
}
