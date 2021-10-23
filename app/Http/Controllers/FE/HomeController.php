<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\User;
use App\Models\Products;
use App\Models\Posts;
use DateTime;
use App\Http\Controllers\Controller;

use Mail;
use App\Models\BankCollaborators;
use App\Models\Collaborators;
use App\Models\Company;
use App\Models\CtvJobs;
use App\Models\CtvJobsJoin;
use App\Models\CusJobs;
use App\Models\CusJobsJoin;
use App\Models\CollaboratorsJobs;
use App\Models\MyBank;
use App\Models\DetailCollaboratorsJobs;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailTemplate;
use App\Jobs\SendEmailTemplatePO;
use App\Models\MailTemplate;
use App\Models\MailPo;
use App\Models\TransactionLog;
use NumberFormatter;
use PDF;
use Helper;

class HomeController extends Controller
{
    private $limit = 20;
    private $mail_template_id = 18;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function reportInterpreter(Request $request , $slug){
        $message = ['status' => 0 , 'message' =>'報告メールを送付しました。 ご協力いただき、ありがとうございます。' ];
        // $str = $slug;
        // echo base64_encode($str);die;
        $idJob = base64_decode($slug);
        $jobDetail = Company::find($idJob);
        $id = '';
        $address_pd = '';
        $ngay_pd = '';
        if ($jobDetail) {
            if($jobDetail->status == 6) {
                $message = ['status' => 2 , 'message' =>'案件がクローズしました。 ご協力いただき、ありがとうございます。' ];
            } else {
                $id = $jobDetail->id;
                $address_pd = $jobDetail->address_pd;
                $ngay_pd = $jobDetail->ngay_pd;
                if ($request->isMethod('post')) {
                    $fileLink = '';
                    try {
                        $ctvJob = CollaboratorsJobs::where('jobs_id', $idJob)->first();
                        $ctvDetail = Collaborators::where('id', $ctvJob->collaborators_id)->first();
                        $mailTemplate = MailTemplate::where('id',$this->mail_template_id)->first();
                        $bodyMail = $mailTemplate->body;
                        $subject = $mailTemplate->subject;
                        if ($ctvJob) {
                            
                            $dataDetail = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $ctvJob->id)->first();
                            if ($dataDetail) {
                                $dataDetail->gio_phien_dich = $request->ngay_phien_dich_begin . " " . $request->gio_phien_dich;
                                $dataDetail->gio_ket_thuc =  $request->ngay_phien_dich_end . " " . $request->gio_ket_thuc;
                                $dataDetail->phi_giao_thong = (int) Helper::decodeCurrency($request->phi_giao_thong) ;
                                $dataDetail->gio_tang_ca = $request->gio_tang_ca;
                                $dataDetail->note = $request->note;
                                $dataDetail->save();
                            } else {
                                $dataDetail = new DetailCollaboratorsJobs();
                                $dataDetail->collaborators_jobs_id = $ctvJob->id;
                                $dataDetail->ngay_phien_dich = $ngay_pd;
                                $dataDetail->gio_phien_dich = $request->ngay_phien_dich_begin . " " . $request->gio_phien_dich;
                                $dataDetail->gio_ket_thuc =  $request->ngay_phien_dich_end . " " . $request->gio_ket_thuc;
                                $dataDetail->phi_giao_thong = (int) Helper::decodeCurrency($request->phi_giao_thong) ;
                                $dataDetail->gio_tang_ca = $request->gio_tang_ca;
                                $dataDetail->note = $request->note;
                                $dataDetail->company_id =$idJob;
                                $dataDetail->save();
                            }

                            $dataLog = new TransactionLog();
                            $dataLog->title = "通訳報告";
                            $dataLog->content = "通訳者から報告を受けました。<br> <a target=\"_blank\" href=\"/admin/projectview/".$idJob."\">受注No.".$idJob."</a>";
                            $dataLog->creator_name =  strtoupper($ctvDetail->name);
                            $dataLog->create_date = date('Y-m-d');
                            $dataLog->save();

                            $subject = str_replace("[ngay_pd]",$ngay_pd, $subject);
                            $subject = str_replace("[id]",$idJob, $subject);
                            
                            $bodyMail = str_replace("[name]",strtoupper($ctvDetail->name), $bodyMail);
                            $bodyMail = str_replace("[id]",$idJob, $bodyMail);
                            $bodyMail = str_replace("[ten_phien_dich]",strtoupper($ctvDetail->name) , $bodyMail);
                            $bodyMail = str_replace("[phone_phien_dich]",$ctvDetail->phone, $bodyMail);
                            $bodyMail = str_replace("[email_phien_dich]",$ctvDetail->email, $bodyMail);
                            $bodyMail = str_replace("[ngay_pd]",$ngay_pd, $bodyMail);
                            $bodyMail = str_replace("[address_pd]", $address_pd, $bodyMail);
                            $bodyMail = str_replace("[thoi_gian_bat_dau]",$request->ngay_phien_dich_begin . " " . $request->gio_phien_dich, $bodyMail);
                            $bodyMail = str_replace("[thoi_gian_ket_thuc]",$request->ngay_phien_dich_end . " " . $request->gio_ket_thuc, $bodyMail);
                            $bodyMail = str_replace("[thoi_gian_overtime]",$request->gio_tang_ca, $bodyMail);
                            $bodyMail = str_replace("[phi_giao_thong]",$request->phi_giao_thong, $bodyMail);
                            $bodyMail = str_replace("[noi_dung_phien_dich]",$request->note, $bodyMail);

                        } else {
                            $message = ['status' => 2 , 'message' =>'システムエラーが発生しました。 大変お手数ですが、担当者までご連絡ください。' ];             
                        }
                        if ($_FILES["fileToUpload"]["name"] != '') {
                            $target_dir = "media/userfiles/files/";
                            $target_file = $target_dir.time().'-' . basename($_FILES["fileToUpload"]["name"]);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
                            if (file_exists($target_file)) {
                                echo "Sorry, file already exists.";die;
                                $uploadOk = 0;
                            }
                            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                                echo "Sorry, your file is too large.";die;
                                $uploadOk = 0;
                            }
                            if ($uploadOk == 0) {
                                echo "Sorry, your file was not uploaded."; die;
                            } else {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    $dataDetail->file_hoa_don = '/'.$target_file;
                                    $bodyMail = str_replace("[file]",url('/'.$target_file), $bodyMail);
                                    $dataDetail->save();
                                } else {
                                    echo "Sorry, there was an error uploading your file."; die;
                                }
                            }
                        }
                        
                            
                        $message = [
                            'title' => $subject,
                            'mail_to' => $ctvDetail->email,
                            'mail_cc' => $mailTemplate->cc_mail,
                            'body' => $bodyMail
                        ];
                        SendEmailTemplatePO::dispatch($message)->delay(now()->addMinute(1));
                        
                        $message = ['status' => 1 , 'message' =>'報告メールを送付しました。ご協力いただき、ありがとうございます。' ];
                        
                    } catch (Exception $e) { 
                        echo 'Message: ' .$e->getMessage();die;
                        $message = ['status' => 2 , 'message' =>'システムエラーが発生しました。 大変お手数ですが、担当者までご連絡ください。' ];             
                    } 
                }
            }
        } else {
            $message = ['status' => 2 , 'message' =>'システムエラーが発生しました。 大変お手数ですが、担当者までご連絡ください。' ];
        }

        
        $nowDate = date('Y-m-d');
        return view(
            'admin.reports.report-interpreter',
            compact(['nowDate','message', 'id', 'address_pd', 'ngay_pd'])
        );
    }
}
