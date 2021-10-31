<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\MailTemplate;
use App\Models\Payslip;
use App\Models\PayslipPartern;
use App\Models\TransactionLog;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailTemplate;
use App\Jobs\SendEmailTemplatePO;
use Helper;
use App\Models\Admin;
use App\Models\HistoryLog;
use App\Models\WorkPartern;
use App\Models\NationalHoliday;
use App\Models\BoPhan;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use PDF;

class PaySController extends Controller
{
    private $limit = 20;
    private $mail_template_id = 15;
    private $defSortName = "id";
    private $defSortType = "DESC";

    
}
