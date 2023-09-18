<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionChangePasswordRequest;
use App\Http\Requests\CustomerLoginRequest;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\sendMailJob;
use App\Mail\SendMail;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function viewLogin()
    {
        return view('client.login');
    }

    public function viewRegister()
    {
        return view('client.register');
    }

    public function actionLogin(CustomerLoginRequest $request)
    {
        // Bước 1 sẽ dùng email và password để login => Cấu hình login cho table Customer
        $login = Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password]);
        if($login) {
            $customer = Auth::guard('customer')->user();
            if($customer->is_active) {
                Auth::guard('customer')->logout();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Bạn đã đăng nhập thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Vui lòng vào email để kích hoạt tài khoản!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Tài khoản hoặc mật khẩu không chính xác!',
            ]);
        }
    }

    public function actionRegister(CustomerRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $hash   =   Str::uuid();
            Customer::create([
                'email'         => $request->email,
                'phone'         => $request->phone,
                'password'      => bcrypt($request->password),
                'hash_active'   => $hash,
            ]);

            $data['email']  = $request->email;
            $data['link']   = env('APP_URL') . '/active/' . $hash;

            // Gửi email
            sendMailJob::dispatch($request->email, 'Kích Hoạt Tài Khoản', $data, 'mail.active');

            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Vui lòng vào email để kích hoạt tài khoản',
            ]);

        } catch(Exception $e) {
            DB::rollBack();
        }
    }

    public function activeCustomer($hash)
    {
        $customer = Customer::where('hash_active', $hash)->first();
        if($customer) {
            if($customer->is_active) {
                toastr()->warning('Tài khoản của bạn đã được kích hoạt trước đó rồi!');
            } else {
                $customer->is_active = 1;
                $customer->save();
                toastr()->success('Tài khoản của bạn đã được kích hoạt!');
            }
        } else {
            toastr()->error('Liên kết không tồn tại!');
        }

        return redirect('/login');
    }

    public function viewForgot()
    {
        return view('client.forgot');
    }

    public function actionForgot(ForgotPasswordRequest $request)
    {
        $customer               = Customer::where('email', $request->email)->first();
        $customer->hash_reset   = Str::uuid();
        $customer->save();

        $data['email']          = $customer->email;
        $data['link']           = env('APP_URL') . '/change-password/' . $customer->hash_reset;

        sendMailJob::dispatch($customer->email, 'Khôi Phục Mật Khẩu Của Tài Khoản', $data, 'mail.forgot');

        return response()->json([
            'status'    => true,
            'message'   => 'Vui lòng vào email để thay đổi mật khẩu!',
        ]);
    }

    public function viewChangePassword($hash)
    {
        $hash_reset = $hash;
        $customer   = Customer::where('hash_reset', $hash)->first();

        if($customer) {
            return view('client.change_pass', compact('hash_reset'));
        } else {
            toastr()->error('Mã reset không tồn tại!');
            return redirect('/login');
        }
    }

    public function actionChangePassword(ActionChangePasswordRequest $request)
    {
        $customer   = Customer::where('hash_reset', $request->hash_reset)->first();
        if($customer) {
            $customer->hash_reset = null;
            $customer->password   = bcrypt($request->password);
            $customer->save();

            return response()->json([
                'status'    => true,
                'message'   => 'Tài khoản của bạn đã thay đổi mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Thông tin không tồn tại!',
            ]);
        }
    }
}
