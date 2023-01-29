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

class JVZooIPNController extends Controller
{
    public function JVZoo(Request $request)
    {
        $data = $request->all();

        if(!isset($_POST["cverify"])){

            return response([
                'message' => 'Verification Failed!'
            ]);
        }

        $TYPE = isset($data['ctransaction']) ? $data['ctransaction'] : 'SALE';

        $d = array("TYPE"           => $TYPE,
                "EMAIL"             => isset($data['ccustemail']) ? $data['ccustemail'] : null,
                "TRANSACTION_ID"    => isset($data["ctransreceipt"]) ? $data["ctransreceipt"] : null,
                "PRODUCT_ID"        => isset($data['cproditem']) ? $data['cproditem'] : null );

        if(!$d['PRODUCT_ID'] || !$d['EMAIL'] || !$d['TRANSACTION_ID']  ){

            return response([
                'message' => 'Item does not exist.'
            ], 404);
        }

        switch ($TYPE) {
            case 'SALE':
                $response = $this->createUser($d);

                return response(['message' => $response]);

                break;
            case 'RFND':
                
                $response = $this->detachUser($d);
                
                return response(['message' => $response]);

                break;
        }
    }

    private function createUser($data)
    {
        $role = JvzooProduct::where('product_id', $data['PRODUCT_ID'])->first();

        if(!$role){
            return response([
                'message' => 'Product Validation Failed!'
            ]);
        }

        $email = $data['EMAIL'];
        $password = false;
        $user = User::where('email', $email)->first();
        $userId;

        if(!$user) {
            $password = Str::random(10);
            $userModel;
            $username;

            $newUser = User::create([
                'name'      => substr($email, 0, strpos($email, '@')),
                'email'     => $email,
                'password'  => bcrypt($password),
                'created_by'    => 1,
            ]);

            $newUser->assignRole($role->funnel);
            $userModel = $newUser;
            $username = $newUser->name;
            $userId = $newUser->id;

            $userInfo = [
                'username'=> $username, 
                'email' => $email,
                'password'=> $password,
                'product' => $role->name
            ];

            JvzooProductTransaction::create([
                'user_id'           => $userId ,
                'product_id'        => $data['PRODUCT_ID'],
                'transaction_id'    => $data['TRANSACTION_ID'],
                'transaction_type'  => 'SALE'
            ]);

            Notification::send($userModel, new UserCreationNotification($userInfo));

            return response([
                'message' => 'User Created Successfully!'
            ]);
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
                    'product_id'        => $data['PRODUCT_ID'],
                    'transaction_id'    => $data['TRANSACTION_ID'],
                    'transaction_type'  => 'SALE'
                ]);
                
                Notification::send($user, new UserUpgradeNotification($userInfo));

                return response([
                    'message' => 'Package Upgraded!'
                ]);
            }
        }
    }

    private function detachUser($d)
    {
        // detach user role
        $user = User::where('email', $d['EMAIL'])->first(); 
        $role = JvzooProduct::where('product_id', $d['PRODUCT_ID'])->first();

        if($user){
            $id = $user->id;

            $currentRole = Role::select('roles.name as name','mr.model_id')
                ->join('model_has_roles as mr','roles.id', '=', 'mr.role_id')
                ->where('mr.model_id', $id)
                ->first();
        }

        if($currentRole){
            $user->removeRole($currentRole->name);
            $user->delete();

            $userInfo = [
                'username'=> $user->name, 
                'product' => $role->name
            ];

            JvzooProductTransaction::create([
                'user_id'           => $id,
                'product_id'        => $d['PRODUCT_ID'],
                'transaction_id'    => $d['TRANSACTION_ID'],
                'transaction_type'  => 'RFND'
            ]);

            Notification::send($user, new UserRefundNotification($userInfo));

            return response([
                'message' => 'User Detached'
            ]);
        }
    }

    public function jvzipnVerification() 
    {
        $secretKey = "lckn6Mez43k5df";
        $pop = "";
        $ipnFields = array();

        foreach ($_POST AS $key => $value) {
            if ($key == "cverify") {
                continue;
            }
            $ipnFields[] = $key;
        }
        sort($ipnFields);
        foreach ($ipnFields as $field) {
            // if Magic Quotes are enabled $_POST[$field] will need to be
            // un-escaped before being appended to $pop
            $pop = $pop . $_POST[$field] . "|";
        }
        $pop = $pop . $secretKey;
        if ('UTF-8' != mb_detect_encoding($pop))
        {
            $pop = mb_convert_encoding($pop, "UTF-8");
        }
        $calcedVerify = sha1($pop);
        $calcedVerify = strtoupper(substr($calcedVerify,0,8));
        return $calcedVerify == $_POST["cverify"];
    }
}
