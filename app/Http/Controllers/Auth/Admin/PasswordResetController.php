<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App;

use App\Http\Requests\ForgotPasswordRequest; 
use App\Http\Requests\FindTokenRequest;
use App\Http\Requests\ChangePasswordRequest;

use Carbon\Carbon;

use App\Models\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    
}
