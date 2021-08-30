<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * UserController class
 */
class UserController extends Controller
{
    // Response data: status and message
    private $status;
    private $message;

    /**
     * Register function
     *
     * @param RegisterRequest $request
     * @return object
     */
    public function register(RegisterRequest $request)
    {
        // Start logging register
        $logging = Log::channel('user_register');
        $logging->info('[START] User Register--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        try {
            $params = $request->only('email', 'name', 'password');

            $logging->info('Request params: ' . json_encode($params));

            $user = new User();

            // Create user
            DB::beginTransaction();
            $user->email = $params['email'];
            $user->name = $params['name'];
            $user->password = bcrypt($params['password']);
            $user->save();

            $logging->info(sprintf('Register user [%s] Success !', $user->name));

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $logging->error('Register Error: ' . $e->getMessage());

            $this->status = config('constants.status.ERROR.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        // End logging
        $logging->info('[END] User Register--------------------');

        return $this->formatResponseData();
    }

    /**
     * Login function
     *
     * @param UserRequest $request
     * @return object
     */
    public function login(UserRequest $request)
    {
        // Start logging register
        $logging = Log::channel('user_login');
        $logging->info('[START] User Login--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        $credentials = $request->only('name', 'password');

        // Check credentials
        if (!($token = JWTAuth::attempt($credentials))) {
            $logging->error(sprintf('Logging user [%s] Failed!', $credentials['name']));
            $this->status = config('constants.status.ERROR.LOGGING_FAIL');
            $this->message = config('constants.message.ERROR.LOGGING_FAIL');
        }

        $logging->info(sprintf('Logging user [%s] Success!', $credentials['name']));

        // End logging register
        $logging->info('[END] User Login--------------------');

        return $this->formatResponseData($token);
    }

    /**
     * Get info function
     *
     * @return object
     */
    public function getInfo()
    {
        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        return $this->formatResponseData();
    }

    /**
     * Logout
     *
     * @param LogoutRequest $request
     *
     * @return object
     */
    public function logout(LogoutRequest $request)
    {
        // Start logging register
        $logging = Log::channel('user_logout');
        $logging->info('[START] User Logout--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();
        
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            $logging->info('Logout Success!');
        } catch (JWTException $e) {
            $logging->error('Logout Error: ' . $e->getMessage());

            $this->status = config('constants.status.ERROR.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        // End logging register
        $logging->info('[END] User Logout--------------------');

        return $this->formatResponseData();
    }

    /**
     * Format response data function
     *
     * @param object $token
     * @param object $data
     * @return string
     */
    private function formatResponseData($token = null, $data = null)
    {
        $responseData = [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $data,
            'user' => '',
            'access_token' => ''
        ];

        if (Auth::check()) {
            $responseData['user'] = Auth::user()->name;
        }

        if ($token) {
            $responseData['access_token'] = $token;
            return response()->json($responseData)->header('Authorization', $token);
        }

        return response()->json($responseData);
    }

    /**
     * Set up status and message is success
     *
     * @return void
     */
    private function setUpStatusAndMessageSuccess()
    {
        $this->status = config('constants.status.OK');
        $this->message = config('constants.message.OK');
    }
}
