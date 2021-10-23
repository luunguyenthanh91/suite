@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件ビュー')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <div id="list-data">
        <div class="modal fade" id="myModal">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">((objSendMail.name))</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div id="bodyModal" class="modal-body">
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.mail_to') }}</label>
                            <div class="search-form" >
                                <input type="text" class="form-control" v-model="objSendMail.mail_cc" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.mail_subject') }}</label>
                            <div class="search-form" >
                                <input type="text" class="form-control" v-model="objSendMail.title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.mail_body') }}</label>
                            <div class="search-form" >
                            <textarea type="text" class="form-control" v-model="objSendMail.body" rows="50" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3" style="background:#673FF7" @click="submitSendMail()">
                            <i class="fas fa-paper-plane">{{ trans('label.send') }}</i>
                        </a> 
                        <a type="button" class="btn btn-outline-secondary3" style="background:red" data-dismiss="modal">
                            <i class="fas fa-window-close">{{ trans('label.cancel') }}</i>
                        </a> 
                    </div>
                    </div>
            </div>
        </div>
        <div class="modal fade" id="leftMenu">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.submit_approve") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12" style="margin-top:15px;margin-bottom:15px;">
                                <div class="col-lg-12">
                                    <table class="signTable">
                                        <tr>
                                            <td class="signTableThCreator">{{ trans('label.create_user') }}</td>
                                            <td class="signTableThChecker">{{ trans('label.checker') }}</td>
                                            <td class="signTableThApprover">{{ trans('label.approver') }}</td>
                                        </tr>    
                                        <tr>
                                            <td class="signTableDate approveDateGroup">
                                            {{@$data->date_start}}
                                            </td>
                                            <td class="signTableDate approveDateGroup">
                                            {{@$data->checked_date}}
                                            </td>
                                            <td class="signTableDate approveDateGroup">
                                            {{@$data->approved_date}}
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td class="signTableTd">
                                                <div class="plusRed">
                                                    <div class="circle">{{@$data->creator}}</div>
                                                </div>
                                            </td>
                                            <td class="signTableTd">
                                                <a type="button" class="btn btn-outline-secondary3 signButtonCheck" data-toggle="modal" data-target="#promoteCheckDlg" v-if="'{{@$data->checked_date}}' == ''">
                                                {{ trans('label.submit_check') }}
                                                </a>
                                                <div class="plusRed" v-if="'{{@$data->checked_date}}' != ''">
                                                    <div class="circle">{{@$data->checker}}</div>
                                                </div>
                                            </td>
                                            <td class="signTableTd">
                                                <a type="button" class="btn btn-outline-secondary signButton" @click="promoteApprove('{{$id}}')" v-if="'{{@$data->approved_date}}' == ''">
                                                {{ trans('label.submit_approve') }}
                                                </a> 
                                                <div class="plusRed" v-if="'{{@$data->approved_date}}' != ''">
                                                    <div class="circle">{{@$data->approver}}</div>
                                                </div>
                                            </td>
                                        </tr>   
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.sendmail") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12" style="margin-top:15px;margin-bottom:15px;">
                                <div v-for="(itemCTV, index) in listBankAccount">
                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                        @if($itemMailTemplate->name == "通訳依頼通知")
                                            <a  class="dropdown-item" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                <i class="fas fa-envelope"></i><span class="labelButtonDropMenu">{{ trans('label.notice_mail') }}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                        @if($itemMailTemplate->name == "通訳報告願い")
                                            <a  class="dropdown-item" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                <i class="fas fa-envelope"></i><span class="labelButtonDropMenu">{{ trans('label.report_mail') }}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                        @if($itemMailTemplate->name == "手配手数料請求")
                                        <a v-bind:class='loai_job == 2 ? "" : "hidden"'  class="dropdown-item" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                            <i class="fas fa-envelope"></i><span class="labelButtonDropMenu">{{ trans('label.money_mail') }}</span>
                                        </a>
                                        @endif
                                    @endforeach
                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                        @if($itemMailTemplate->name == "入金確認完了通知")
                                        <a v-bind:class='loai_job == 2 ? "" : "hidden"'  class="dropdown-item" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                            <i class="fas fa-envelope"></span></i><span class="labelButtonDropMenu">{{ trans('label.check_money_mail') }}
                                        </a>
                                        @endif
                                    @endforeach
                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                        @if($itemMailTemplate->name == "給与振込完了通知")
                                        <a v-bind:class='loai_job == 1 ? "" : "hidden"' class="dropdown-item" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                            <i class="fas fa-envelope"></i><span class="labelButtonDropMenu">{{ trans('label.send_money_mail') }}</span>
                                        </a>
                                        @endif
                                    @endforeach
                                </div> 
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.pdf_table3") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12" style="margin-top:15px;margin-bottom:15px;">
                                <a  class="dropdown-item" href="/admin/partner-sale-receipt-pdf/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_detail_pay_sale') }}</span>
                                </a>  
                                <a  class="dropdown-item" href="/admin/company/pdf/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_detail_pay') }}</span>
                                </a>  
                                <a  class="dropdown-item" href="/admin/company/pdf-type/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_receipt') }}</span>
                                </a>  
                                <div class="dropdown-divider"></div> 
                                <a class="dropdown-item" href="/admin/project-report-pdf/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_report') }}</span>
                                </a>
                                <a class="dropdown-item" href="/admin/project-report-person-pdf/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_report_person') }}</span>
                                </a>
                                <div class="dropdown-divider"></div> 
                                <a class="dropdown-item" href="/admin/project-invoice-pdf/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_invoice') }}</span>
                                </a>
                                <a class="dropdown-item" href="/admin/project-invoice-person-pdf/{{$id}}">
                                    <i class="fas fa-file-pdf"></i><span class="labelButtonDropMenu">{{ trans('label.pdf_invoice_person') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="promoteCheckDlg">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div id="bodyModal" class="modal-body">
                    <label>{{ trans('label.id') }}{{@$data->id}} (<span v-if='{{@$data->status}} == 1'>{{ trans('label.status1') }}</span>
                            <span v-if='{{@$data->status}} == 2'>{{ trans('label.status2') }}</span>
                            <span v-if='{{@$data->status}} == 3'>{{ trans('label.status3') }}</span>
                            <span v-if='{{@$data->status}} == 8'>{{ trans('label.status8') }}</span>
                            <span v-if='{{@$data->status}} == 4'>{{ trans('label.status4') }}</span>
                            <span v-if='{{@$data->status}} == 5'>{{ trans('label.status5') }}</span>
                            <span v-if='{{@$data->status}} == 6'>{{ trans('label.status6') }}</span>
                            <span v-if='{{@$data->status}} == 7'>{{ trans('label.status7') }}</span>
                        )
                    </label>
                    <br>
                    @if (@$data->cus_jobs_id)
                        <label v-for="(itemCTV, index) in listAcountCustomer">
                            <b><u>
                                <a target="_blank" :href="'/admin/customer-view/' + itemCTV.cus_jobs_id">
                                    (( parseName(itemCTV.info.name) ))
                                </a>
                            </u></b>
                        </label>
                        <label v-for="(itemCTV, index) in listAcountSale" class="spaceLabel">
                            <b><u>
                                <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                <span>(</span>(( parseName(itemCTV.info.name) )) {{ trans('label.sama') }}<span>)</span>
                                </a>
                            </u></b>
                        </label>
                        <br>
                    @else 
                        <label v-for="(itemCTV, index) in listAcountSale">
                            <b><u>
                                <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                    (( parseName(itemCTV.info.name) )) {{ trans('label.sama') }}
                                </a>
                            </u></b>
                        </label>
                        <br>
                    @endif 
                    <label>{{@$data->ngay_pd}} {{@$data->address_pd}}</label><br>
                    <label v-for="(itemCTV, index) in listBankAccount">
                        (( parseName(itemCTV.info.name) ))
                        (<span>
                        {{ trans('label.tel2') }}: (( parsePhone(itemCTV.info.phone) ))
                        </span>)
                    </label>
                    <div class="page-separator-line"></div>
                    <br>
                    {{ trans('label.chk_msg') }}
                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">  
                            <tr>
                                <td>{{ trans('label.earning') }}</td>
                                <td>
                                {{ trans('label.deposit_date') }}: {{@$data->date_company_pay}}
                                <br>
                                {{ trans('label.earning') }}: <span>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->tong_thu}}') ))</span>
                                <br>
                                {{ trans('label.benefit') }}: 
                                <span ><span v-if="{{@$data->price_nhanduoc}} < 0" class="femaleClass">(( parseMoney({{@$data->price_nhanduoc}}) ))</span></span>
                                <span ><span v-if="{{@$data->price_nhanduoc}} >= 0">(( parseMoney({{@$data->price_nhanduoc}}) ))</span></span>
                                </td>
                                <td>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input type="checkbox" id="chkEarning" v-model="chkEarning" class="form-check-input">
                                    <label for="chkEarning">{{ trans('label.chk_finish') }}</label>
                                </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ trans('label.sale_cost') }}</span>
                                </td>
                                <td>
                                    <div v-for="(itemCTV, index) in listAcountSale">
                                        {{ trans('label.bank_date') }}: (( itemCTV.ngay_chuyen_khoan ))
                                        <br>
                                        {{ trans('label.bank_name') }}: 
                                        <span v-if="itemCTV.payplace == 1">
                                            <span v-if=" itemCTV.info.ten_bank ">((itemCTV.info.ten_bank)) <br></span>
                                            <span v-if=" itemCTV.info.chinhanh ">((itemCTV.info.chinhanh)) <br> </span>
                                            <span v-if=" itemCTV.info.stk ">((itemCTV.info.stk)) <br></span>
                                            <span v-if=" itemCTV.info.ten_chutaikhoan ">(( parseName(itemCTV.info.ten_chutaikhoan) )) <br></span>
                                        </span>
                                        <div v-if="itemCTV.payplace == 2">
                                            {{ trans('label.cash') }}
                                        </div> 
                                        <br> 
                                        {{ trans('label.transfer_money') }}: (( parseMoney(itemCTV.price_total) ))
                                        <br>
                                        {{ trans('label.bank_fee2') }}: (( parseMoney(itemCTV.phi_chuyen_khoan) ))
                                    </div>
                                </td>
                                <td>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input type="checkbox"  id="chkSaleCost" v-model="chkSaleCost" class="form-check-input">
                                    <label for="chkSaleCost">{{ trans('label.chk_finish') }}</label>
                                </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ trans('label.interpreter_cost') }}</span>
                                </td>
                                <td>
                                    <div v-for="(itemCTV, index) in listBankAccount">
                                    {{ trans('label.bank_date') }}: (( itemCTV.ngay_chuyen_khoan ))
                                    <br>
                                    {{ trans('label.bank_name') }}: 
                                    <span v-for="itemBank in itemCTV.listBank">
                                        <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.ten_bank))<br></span> 
                                        <span v-if=" itemBank.id == itemCTV.bank_id && itemBank.chinhanh">((itemBank.chinhanh))<br></span> 
                                        <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.stk))<br></span> 
                                        <span v-if=" itemBank.id == itemCTV.bank_id">(( parseName(itemBank.ten_chutaikhoan) ))<br></span> 
                                    </span>
                                    <span v-if="itemCTV.bank_id == 2">
                                        {{ trans('label.cash') }}
                                    </span>
                                    <br>
                                    {{ trans('label.transfer_money') }}: (( parseMoney(itemCTV.price_total) ))
                                    <br>
                                    {{ trans('label.bank_fee') }}: (( parseMoney(itemCTV.phi_chuyen_khoan) ))
                                    </div>
                                </td>
                                <td>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input type="checkbox"  id="chkInterpreterCost" v-model="chkInterpreterCost" class="form-check-input">
                                    <label for="chkInterpreterCost">{{ trans('label.chk_finish') }}</label>
                                </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ trans('label.move_fee') }}</span>
                                </td>
                                <td>
                                    <div v-for="(itemCTV, index) in listBankAccount">
                                        {{ trans('label.move_fee') }}: (( parseMoney(itemCTV.phi_giao_thong_total) ))
                                        <br>
                                        {{ trans('label.receipt_file') }}: 
                                        <div v-for="(item1, index1) in itemCTV.dateList">
                                            <a v-if="item1.file_hoa_don" target="_blank" :href="'' + item1.file_hoa_don">
                                                ((item1.file_hoa_don))
                                                <br>
                                            </a>
                                            <span v-if="!item1.file_hoa_don">{{ trans('label.not') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input type="checkbox"  id="chkMoveFee" v-model="chkMoveFee" class="form-check-input">
                                    <label for="chkMoveFee">{{ trans('label.chk_finish') }}</label>
                                </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ trans('label.interpreter_tax') }}</span>
                                </td>
                                <td>
                                    <div v-for="(itemCTV, index) in listBankAccount">
                                    {{ trans('label.tax_date') }}: (( itemCTV.paytaxdate )) 
                                    <br>
                                    {{ trans('label.tax_org_value') }}: (( parseMoney(itemCTV.phi_phien_dich_total) ))
                                    <br>
                                    {{ trans('label.tax_percent') }}: {{$data->percent_vat_ctvpd}}
                                    <br>
                                    {{ trans('label.tax') }}: (( parseMoney(itemCTV.thue_phien_dich_total) ))
                                    </div>
                                </td>
                                <td>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input type="checkbox" id="chkTaxCost" v-model="chkTaxCost" class="form-check-input">
                                    <label for="chkTaxCost">{{ trans('label.chk_finish') }}</label>
                                </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary3" style="background:#673FF7"  :disabled="chkTaxCost == 0 || chkMoveFee == 0 || chkInterpreterCost == 0 || chkSaleCost == 0 || chkEarning == 0" @click="promoteCheck('{{$id}}')">
                        {{ trans('label.ok') }}
                        </button> 
                        <button type="button" class="btn btn-outline-secondary3" style="background:red" data-dismiss="modal">
                        {{ trans('label.cancel') }}
                        </button> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/projectupdate/{{$id}}" v-if="'{{@$data->approved_date}}' == ''">
                    <i class="fas fa-edit"><span class="labelButton">{{ trans('label.edit') }}</span></i>
                </a>
                @if (Auth::guard('admin')->user()->id == 1 )
                <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="deleteRecore('{{$id}}')">
                    <i class="fas fa-trash-alt"><span class="labelButton">{{ trans('label.delete') }}</span></i>
                </a> 
                @endif    
                <div class="vl3"></div> 
                <a type="button" class="btn btn-outline-secondary3 menuButtonMobile" data-toggle="modal" data-target="#leftMenu">
                    <i class="fas fa-th-large"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-12">
            <div style="col-lg-auto">
                <div style="width:100%;text-align:left !important;">
                    <label>{{ trans('label.id') }}{{@$data->id}} (<span v-if='{{@$data->status}} == 1'>{{ trans('label.status1') }}</span>
                            <span v-if='{{@$data->status}} == 2'>{{ trans('label.status2') }}</span>
                            <span v-if='{{@$data->status}} == 3'>{{ trans('label.status3') }}</span>
                            <span v-if='{{@$data->status}} == 8'>{{ trans('label.status8') }}</span>
                            <span v-if='{{@$data->status}} == 4'>{{ trans('label.status4') }}</span>
                            <span v-if='{{@$data->status}} == 5'>{{ trans('label.status5') }}</span>
                            <span v-if='{{@$data->status}} == 6'>{{ trans('label.status6') }}</span>
                            <span v-if='{{@$data->status}} == 7'>{{ trans('label.status7') }}</span>
                        )
                    </label>
                    <br>
                    @if (@$data->cus_jobs_id != '')
                        <label v-for="(itemCTV, index) in listAcountCustomer">
                            <b><u>
                                <a target="_blank" :href="'/admin/customer-view/' + itemCTV.id">
                                    (( parseName(itemCTV.info.name) ))
                                </a>
                            </u></b>
                        </label>
                        <label v-for="(itemCTV, index) in listAcountSale" class="spaceLabel">
                            <b><u>
                                <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                <span>(</span>(( parseName(itemCTV.info.name) )) {{ trans('label.sama') }}<span>)</span>
                                </a>
                            </u></b>
                        </label>
                        <br>
                    @else 
                        <label v-for="(itemCTV, index) in listAcountSale">
                            <b><u>
                                <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                    (( parseName(itemCTV.info.name) )) {{ trans('label.sama') }}
                                </a>
                            </u></b>
                        </label>
                        <br>
                    @endif 
                    <label>{{@$data->ngay_pd}} {{@$data->address_pd}}</label><br>
                    <label v-for="(itemCTV, index) in listBankAccount">
                        <i v-if="itemCTV.info.male == 1" class="fa fa-male maleClass"></i>
                        <i v-if="itemCTV.info.male == 2" class="fa fa-female femaleClass"></i>
                        <a target="_blank" :href="'/admin/partner-interpreter-view/' + itemCTV.info.id">
                            (( parseName(itemCTV.info.name) ))
                        </a>
                        <a target="_blank" :href="'tel:'+itemCTV.phone">
                            (<span>
                            {{ trans('label.tel2') }}: (( parsePhone(itemCTV.info.phone) ))
                            </span>)
                        </a>
                    </label>
                </div>
            </div>
        </div>
        <div class="container page__container page-section page_container_custom">
            <div class="col-lg-12">
                <div class="card dashboard-area-tabs p-relative o-hidden projectViewMobile">
                    <div class="card-header p-0 nav">
                        <div class="row no-gutters" role="tablist">
                            <div class="col-auto">
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click active" id="tab1">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.property') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab3">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.customer') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab4">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.sale') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab5">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.interpreter') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.earning') }}</strong>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="detailtab1">   
                            <div class="row">                        
                                <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                    <tr>
                                        <td>{{ trans('label.id') }}</td>
                                        <td>
                                            {{@$data->id}}
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans('label.date_start') }}</td>
                                        <td>
                                        {{@$data->date_start}} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.status') }}</td>
                                        <td>
                                            <!-- <span v-if='{{@$data->status}} == 0 || {{@$data->status}} == ""'>{{ trans('label.status0') }}</span> -->
                                            <span v-if='{{@$data->status}} == 1'>{{ trans('label.status1') }}</span>
                                            <span v-if='{{@$data->status}} == 2'>{{ trans('label.status2') }}</span>
                                            <span v-if='{{@$data->status}} == 3'>{{ trans('label.status3') }}</span>
                                            <span v-if='{{@$data->status}} == 8'>{{ trans('label.status8') }}</span>
                                            <span v-if='{{@$data->status}} == 4'>{{ trans('label.status4') }}</span>
                                            <span v-if='{{@$data->status}} == 5'>{{ trans('label.status5') }}</span>
                                            <span v-if='{{@$data->status}} == 6'>{{ trans('label.status6') }}</span>
                                            <span v-if='{{@$data->status}} == 7'>{{ trans('label.status7') }}</span>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans('label.type_trans') }}</td>
                                        <td>
                                            <span v-if="'{{@$data->type_trans}}' == 1">{{ trans('label.type_trans1') }}</span>
                                            <span v-if="'{{@$data->type_trans}}' == 2">{{ trans('label.type_trans2') }}</span>
                                            <span v-if="'{{@$data->type_trans}}' == 3">{{ trans('label.type_trans3') }}</span>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td>{{ trans('label.language') }}</td>
                                        <td>
                                        @if ( @$data->type_lang == "VNM" )
                                            <span>{{ trans('label.type_lang1') }}</span>
                                        @endif
                                        @if ( @$data->type_lang ==  "PHL" )
                                            <span>{{ trans('label.type_lang2') }}</span>
                                        @endif
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans('label.type') }}</td>
                                        <td>
                                            <span v-if="'{{@$data->loai_job}}' == 1">{{ trans('label.type1') }}</span>
                                            <span v-if="'{{@$data->loai_job}}' == 2">{{ trans('label.type2') }}</span>
                                            <span v-if="'{{@$data->loai_job}}' == 3">{{ trans('label.type3') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.tax_percent') }}</td>
                                        <td>
                                        {{@$data->percent_vat_ctvpd}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.ngay_phien_dich') }}</td>
                                        <td>
                                        {{@$data->ngay_pd}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.address_pd') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="fullWidth">{{@$data->address_pd}}</span>
                                                <a target="_blank" href="http://maps.google.com/maps?q={{@$data->address_pd}}" id="link-map-address" type="button" class="btn btn-outline-secondary" style="border:0">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.contract_money') }}</td>
                                        <td>
                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->tienphiendich}}') ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.deposit_date') }}</td>
                                        <td>
                                            {{@$data->date_company_pay}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.deposit_bank_name') }}</td>
                                        <td>
                                            @foreach($allMyBank as $itemBank)
                                                @if ($data->stk_thanh_toan_id == $itemBank->id)
                                                    (( parseBank({{$itemBank}}) ))
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="highlight">{{ trans('label.deposit') }}</span></td>
                                        <td>
                                        <span class="highlight">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->tong_thu}}') ))</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.deposit_status') }}</td>
                                        <td>
                                            (( convertStatusBank({{$data->status_bank}}) ))
                                        </td>
                                    </tr>
                                        <tr>
                                            <td>{{ trans('label.employee') }}</td>
                                            <td>
                                                @if(@$data->employee_id)
                                                <a target="_blank" href="/admin/user-view/{{@$data->employee_id}}">
                                                    {{@$data->employee_id}}<span class="spaceLabel">({{@$data->employee_name}})</span>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    <tr>
                                        <td>{{ trans('label.order_id') }}</td>
                                        <td>
                                        @if(@$data->po_id)<a target="_blank" href="/admin/po-view/{{@$data->po_id}}">{{@$data->po_id}}</a>@endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.note') }}</td>
                                        <td>
                                        <div class="text-block" v-html="">
                                        <p>{!! @$data->description !!}</p>
                                        </div>
                                        </td>
                                    </tr> 
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab3">
                            <div class="row">                        
                                <table v-for="(itemCTV, index) in listAcountCustomer" class="table thead-border-top-0 table-nowrap table-mobile propertiesTables"> 
                                    <tr>
                                        <td>{{ trans('label.customer') }}</td>
                                        <td>
                                            <a target="_blank" :href="'/admin/customer-view/' + itemCTV.info.id">
                                            {{ trans('label.id_customer') }}(( itemCTV.info.id ))
                                            </a><br>
                                            (( parseName(itemCTV.info.name) )) <br>
                                            (( parseAddr(itemCTV.info.address) ))<br>
                                            {{ trans('label.tel2') }}: (( parsePhone(itemCTV.info.phone) )) <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.contact_person_id') }}</td>
                                        <td>
                                            <a v-if="itemCTV.contact_user_id" target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.contact_user_id">
                                            {{ trans('label.id_sale') }}(( itemCTV.contact_user_id ))
                                            </a>
                                            <br>
                                            (( parseName(itemCTV.contact_user_name) )) <br>
                                            {{ trans('label.tel2') }}: (( parsePhone(itemCTV.contact_user_phone) )) <br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab4">  
                            <div class="row">            
                                <table v-for="(itemCTV, index) in listAcountSale" class="table thead-border-top-0 table-nowrap table-mobile propertiesTables"> 
                                    <tr>
                                        <td>{{ trans('label.sale') }}</td>
                                        <td>
                                            <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                                (( parseName(itemCTV.info.name) ))
                                            </a><br>
                                            (( parseAddr(itemCTV.info.address) ))<br>
                                            {{ trans('label.tel2') }}: (( parsePhone(itemCTV.info.phone) )) <br>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="highlight">{{ trans('label.sale_cost') }}</span></td>
                                        <td>
                                        <span class="highlight">(( parseMoney(itemCTV.price_total) ))</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.bank_date') }}</td>
                                        <td>
                                            (( itemCTV.ngay_chuyen_khoan ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.bank_name') }}</td>
                                        <td>
                                            <span v-if="itemCTV.payplace == 1">
                                                <span v-if=" itemCTV.info.ten_bank ">((itemCTV.info.ten_bank)) <br></span>
                                                <span v-if=" itemCTV.info.chinhanh ">((itemCTV.info.chinhanh)) <br> </span>
                                                <span v-if=" itemCTV.info.stk ">((itemCTV.info.stk)) <br></span>
                                                <span v-if=" itemCTV.info.ten_chutaikhoan ">(( parseName(itemCTV.info.ten_chutaikhoan) )) <br></span>
                                            </span>
                                            <div v-if="itemCTV.payplace == 2">
                                                {{ trans('label.cash') }}
                                            </div>                                                          
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.transfer_money') }}</td>
                                        <td>
                                            (( parseMoney(itemCTV.price_total) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.fee') }}</td>
                                        <td>
                                            (( parseMoney(itemCTV.phi_chuyen_khoan) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.bank_status') }}</td>
                                        <td>
                                            (( convertStatusBank(itemCTV.status) ))
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab5">
                            <div class="row">            
                                <table v-for="(itemCTV, index) in listBankAccount" class="table thead-border-top-0 table-nowrap table-mobile propertiesTables"> 
                                    <tr>
                                        <td>{{ trans('label.interpreter') }}</td>
                                        <td>
                                            <div v-for="itemCTV in listBankAccount">
                                                <i v-if="itemCTV.info.male == 1" class="fa fa-male maleClass"></i>
                                                <i v-if="itemCTV.info.male == 2" class="fa fa-female femaleClass"></i>
                                                <a target="_blank" :href="'/admin/partner-interpreter-view/' + itemCTV.info.id">
                                                    (( parseName(itemCTV.info.name) ))
                                                </a>
                                                <br>
                                                <span>(( parseAddr(itemCTV.info.address) ))</span><br>
                                                <span>{{ trans('label.tel2') }}: (( parsePhone(itemCTV.info.phone) ))</span><br>
                                                <a type="button" class="btn btn-outline-secondary3"  style="background:#B8054E" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+itemCTV.info.address+'&s=1&fl=1&to='+address_pd">
                                                    <i class="fa fa-train"></i>
                                                </a>
                                                <a type="button" class="btn btn-outline-secondary3"  style="background:#6a5acd" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+itemCTV.info.address+'/'+address_pd">
                                                    <i class="fa fa-map"></i>
                                                </a>
                                                <!-- <a v-if="itemCTV.bank_id == 2" type="button" class="btn btn-outline-secondary3" style="background:#e22e5d" href="/admin/partner-sale-receipt-pdf/{{$id}}">
                                                    <i class="fas fa-file-pdf"><span class="labelButton">{{ trans('label.pdf_receipt') }}</span></i>
                                                </a> -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="highlight">{{ trans('label.interpreter_cost') }}</span></td>
                                        <td>
                                        <span class="highlight">(( parseMoney(itemCTV.phi_phien_dich_total) ))</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="highlight">{{ trans('label.move_fee') }}</span></td>
                                        <td>
                                        <span class="highlight">(( parseMoney(itemCTV.phi_giao_thong_total) ))</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.total2') }}</td>
                                        <td>
                                            (( parseMoney(itemCTV.price_total) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.bank_date') }}</td>
                                        <td>
                                            (( itemCTV.ngay_chuyen_khoan ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.bank_name') }}</td>
                                        <td>
                                            <div v-for="itemBank in itemCTV.listBank">
                                                <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.ten_bank))<br></span> 
                                                <span v-if=" itemBank.id == itemCTV.bank_id && itemBank.chinhanh">((itemBank.chinhanh))<br></span> 
                                                <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.stk))<br></span> 
                                                <span v-if=" itemBank.id == itemCTV.bank_id">(( parseName(itemBank.ten_chutaikhoan) ))<br></span> 
                                            </div>
                                            <span v-if="itemCTV.bank_id == 2">
                                                {{ trans('label.cash') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.transfer_money') }}</td>
                                        <td>
                                            (( parseMoney(itemCTV.price_total) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="highlight">{{ trans('label.bank_fee') }}</span></td>
                                        <td>
                                        <span class="highlight"> (( parseMoney(itemCTV.phi_chuyen_khoan) ))</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.bank_status') }}</td>
                                        <td>
                                            (( convertStatusBank(itemCTV.status) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.tax_date') }}</td>
                                        <td>
                                            (( itemCTV.paytaxdate )) 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.tax_org_value') }}</td>
                                        <td>
                                        <span v-for="(item, index) in listBankAccount">
                                            (( parseMoney(item.phi_phien_dich_total) ))
                                        </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.tax_percent') }}</td>
                                        <td>
                                        {{$data->percent_vat_ctvpd}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="highlight">{{ trans('label.tax') }}</span></td>
                                        <td>
                                        <span class="highlight">(( parseMoney(itemCTV.thue_phien_dich_total) ))</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.tax_status') }}</td>
                                        <td>
                                            (( convertStatusBank(itemCTV.paytaxstatus) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.ngay_phien_dich') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                (( item1.ngay_phien_dich ))
                                            </span>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>{{ trans('label.begin_time') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                (( item1.gio_phien_dich ))
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.end_time') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                (( item1.gio_ket_thuc ))
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.work_time') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                (( parseTime(item1.gio_phien_dich,item1.gio_ket_thuc) ))
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.expand_time') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                <div v-if="parseTime(item1.gio_phien_dich,item1.gio_ket_thuc) > 4">
                                                (( parseTime(item1.gio_phien_dich,item1.gio_ket_thuc) - 4))
                                                </div>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.route_move') }}</td>
                                        <td>
                                            <div v-for="(item1, index1) in itemCTV.dateList" class="text-block" v-html="item1.gio_tang_ca">
                                            (( item1.gio_tang_ca ))
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.interpreter_cost') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                (( parseMoney(item1.phi_phien_dich) ))
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.move_fee') }}</td>
                                        <td>
                                            <span v-for="(item1, index1) in itemCTV.dateList">
                                                (( parseMoney(item1.phi_giao_thong) ))
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.receipt_file') }}</td>
                                        <td>
                                            <div v-for="(item1, index1) in itemCTV.dateList">
                                                <a v-if="item1.file_hoa_don" target="_blank" :href="'' + item1.file_hoa_don">
                                                    ((item1.file_hoa_don))
                                                    <br>
                                                </a>
                                                <a v-if=" item1.file_hoa_don " type="button" class="btn btn-outline-secondary3" style="background:#f38434" target="_blank" href="/admin/move-fee-receipt-pdf/{{$id}}">
                                                    <i class="fas fa-download"><span class="labelButton">{{ trans('label.show_receipt') }}</span></i>
                                                </a> 
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.report_content') }}</td>
                                        <td>
                                            <div v-for="(item1, index1) in itemCTV.dateList" class="text-block" v-html="item1.note">
                                            (( item1.note ))
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.note') }}</td>
                                        <td>
                                            <div v-for="(item1, index1) in itemCTV.dateList" class="text-block" v-html="item1.note2">
                                            (( item1.note2 ))
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab2">
                            <div class="row">                                                
                            <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">
                                        <thead class="thead-light" style="text-align:right">
                                        <tr>
                                            <th style="border: 1px solid #CCC;background:#eee"></th>
                                            <th class="minWidthCol" style="color:gray; text-align:center;background:#eee;border: 1px solid #CCC;">{{ trans('label.gues') }}</th>
                                            <th class="minWidthCol" style="text-align:center;background:#eee;border: 1px solid #CCC;">{{ trans('label.real') }}</th>
                                        </tr>
                                        </thead>
                                        <tr>
                                            <td>{{ trans('label.company_pay') }}</td>
                                            <td class="textAlignR" style="color:gray">
                                                (( parseMoney({{@$data->tong_thu_du_kien}}) ))
                                            </td>
                                            <td class="textAlignR">
                                                (( parseMoney({{@$data->tong_thu}}) ))
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.sale_cost') }}</td>
                                            <td class="textAlignR" style="color:gray">
                                                (( parseMoneyMinus({{@$data->price_sale}}) ))
                                            </td>
                                            <td class="textAlignR">
                                                <span class="textAlignR" v-for="(item, index) in listAcountSale">
                                                    (( parseMoneyMinus(item.price_total) ))
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.interpreter_cost') }}</td>
                                            <td class="textAlignR" style="color:gray">
                                                (( parseMoneyMinus({{@$data->price_send_ctvpd}}) ))
                                            </td>
                                            <td class="textAlignR">
                                                <span v-for="(item, index) in listBankAccount">
                                                    (( parseMoneyMinus(item.phi_phien_dich_total) ))
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.tax') }}</td>
                                            <td class="textAlignR" style="color:gray">
                                                (( parseMoneyMinus({{@$data->price_vat_ctvpd}}) ))
                                            </td>
                                            <td class="textAlignR">
                                                <span v-for="(item, index) in listBankAccount">
                                                    (( parseMoneyMinus(item.thue_phien_dich_total) ))
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.move_fee') }}</td>
                                            <td class="textAlignR" style="color:gray">
                                                (( parseMoneyMinus({{@$data->ortherPrice}}) ))
                                            </td>
                                            <td class="textAlignR">
                                                <span v-for="(item, index) in listBankAccount">
                                                    (( parseMoneyMinus(item.phi_giao_thong_total) ))
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.bank_fee') }}</td>
                                            <td class="textAlignR" style="color:gray">
                                                (( parseMoneyMinus({{@$data->price_company_duytri}}) ))
                                            </td>
                                            <td class="textAlignR">
                                                <span v-for="(item, index) in listAcountSale">
                                                    (( parseMoneyMinus(item.phi_chuyen_khoan) ))
                                                </span><br>
                                                <span v-for="(item, index) in listBankAccount">
                                                    (( parseMoneyMinus(item.phi_chuyen_khoan) ))
                                                </span>
                                            </td>
                                        </tr>
                                        <tr style="border-top: solid 1px #000">
                                            <td><span class="highlight">{{ trans('label.benefit') }}</span></td>
                                            <td class="textAlignR" style="color:gray">
                                                <span>(( parseMoney({{@$data->tong_kimduocdukien}}) ))</span>
                                            </td>
                                            <td class="textAlignR">
                                            <span class="highlight"><span v-if="{{@$data->price_nhanduoc}} < 0" class="femaleClass">(( parseMoney({{@$data->price_nhanduoc}}) ))</span></span>
                                            <span class="highlight"><span v-if="{{@$data->price_nhanduoc}} >= 0">(( parseMoney({{@$data->price_nhanduoc}}) ))</span></span>
                                            </td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="error-details" style="display:none">
        <span id="copyName"></span><br>
        <span id="copyFurigana"></span><br>
        <span id="copyPhone"></span><br>
    </div>
    
    <!-- // END Page Content -->

    <!-- Footer -->

    @include('admin.component.footer')

    <!-- // END Footer -->

</div>
@include('admin.component.left-bar')
<!-- // END drawer-layout__content -->

<!-- Drawer -->

@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>



<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });
        $('.tab-child-click').on('click', function (){
            $('.tab-child-click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane-child').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });

        

        $('#listDate').datepick({ 
        multiSelect: 999, 
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1});


        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );

        jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
            jQuery(this).toggle();
        });

        $(window).keydown(function(event){
            if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3]) && ($(event.target)[0]!=$("textarea")[4]) ) {
                event.preventDefault();
                return false;
            }
        });

    });
    var imgId;

    function chooseImage(id) {
        imgId = id;
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileField;
        finder.popup();
    }
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileField(fileUrl) {
        document.getElementById('chooseImage_img' + imgId).src = fileUrl;
        document.getElementById('chooseImage_input' + imgId).value = fileUrl;
        document.getElementById('chooseImage_div' + imgId).style.display = '';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = 'none';
    }

    function clearImage(imgId) {
        document.getElementById('chooseImage_img' + imgId).src = '';
        document.getElementById('chooseImage_input' + imgId).value = '';
        document.getElementById('chooseImage_div' + imgId).style.display = 'none';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = '';
    }


    function chooseFile(event)
    {   
        id= event.rel;
        imgId = id;
        console.log('chooseImage_input' + imgId);
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileFieldFile;
        finder.popup();
    } 
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileFieldFile( fileUrl )
    {
        document.getElementById( 'chooseImage_input' + imgId).value = fileUrl;
        $("#chooseImage_input"+ imgId).val(fileUrl)[0].dispatchEvent(new Event('input'));

    }
    function clearFile(event)
    {
        imgId= event.rel;
        document.getElementById( 'chooseImage_input' + imgId ).value = '';
        $("#chooseImage_input"+ imgId).val('')[0].dispatchEvent(new Event('input'));
    }


    function addMoreImg()
    {
        jQuery("ul#images > li.hidden").filter(":first").removeClass('hidden');
    }

//]]>
</script>
<style type="text/css">
    #images { list-style-type: none; margin: 0; padding: 0;}
    #images li { margin: 10px; float: left; text-align: center;  height: 190px;}
    .modal-backdrop {
        display: none !important;
    }
</style>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);


new Vue({
    el: '#list-data',
    data: {
        listBankAccount: [],
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        listPage: [],
        conditionName: '',
        jplt: '',
        male: '',
        addModal: 1,
        edit_form: 0,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        instan: 25,
        long: '{{@$data->longitude}}',
        lat: '{{@$data->latitude}}',
        kinh_vido: '',
        ga_gannhat: '{{@$data->ga}}',
        address_pd: '{{@$data->address_pd}}',
        groups: [],
        loai_job : '{{@$data->loai_job}}',
        listAcountSale: [],
        loadingTableSale: 0,
        countSales: 0,
        pageSales: 1,
        listSales: [],
        listPageSales: [],
        conditionNameSale: '',
        listAcountCustomer: [],
        loadingTableCustomer: 0,
        countCustomer: 0,
        pageCustomer: 1,
        listCustomer: [],
        listPageCustomer: [],
        conditionNameCustomer: '',
        objSendMail : [],
        listSendMail : [],
        flagSendMail : '{{$flagSendMail}}',
        userCustomerId: '{{$flagCustomer}}',
        typehoahong: '{{$data->typehoahong}}',
        percent_vat_ctvpd: '{{$data->percent_vat_ctvpd}}',
        showListPD : 0,
        showListCus : 0,
        showListCtv : 0,
        isMobile : ( viewPC )? false : true,
        marginTop: "100px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classRowContent: (viewPC)? "" : "rowContent ",
        classRightGrid: "col-lg-10",
        classLefttGrid: "col-lg-2",
        hiddenMenu: "displayNone",
        chkTaxCost: 0,
        chkMoveFee: 0,
        chkInterpreterCost: 0,
        chkSaleCost: 0,
        chkEarning :0,
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
        @foreach($dataColla as $itemConnect)

        $.ajax({
            url: "/admin/collaborators/get-detail-id/{{$itemConnect->collaborators_id}}",
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                that.listBankAccount.push({
                    id: '{{$itemConnect->id}}',
                    type: 'update',
                    collaborators_id: '{{$itemConnect->collaborators_id}}',
                    price_total: '{{$itemConnect->price_total}}',
                    phi_phien_dich_total: '{{$itemConnect->phi_phien_dich_total}}',
                    phi_giao_thong_total: '{{$itemConnect->phi_giao_thong_total}}',
                    thue_phien_dich_total: '{{$itemConnect->thue_phien_dich_total}}',
                    bank_id: '{{$itemConnect->bank_id}}',
                    listBank: res.data.bank,
                    ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                    phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                    dateList: @json($itemConnect['dateList']),
                    status: '{{$itemConnect->status}}',
                    paytaxdate: '{{$itemConnect->paytaxdate}}',
                    paytaxstatus: '{{$itemConnect->paytaxstatus}}',
                    paytaxplace: '{{$itemConnect->paytaxplace}}',
                    info: res.data
                });
            },
            error: function(xhr, textStatus, error) {
                Swal.fire({
                    title: "Có lỗi dữ liệu nhập vào!",
                    type: "warning",

                });
            }
        });

        @endforeach

        @foreach($allMailTemplate as $itemMailTemplate)
            that.listSendMail.push({
                name: '{{$itemMailTemplate->name}}',
                title: '{{$itemMailTemplate->subject}}',
                mail_cc: '{{$itemMailTemplate->cc_mail}}',
                body: @json($itemMailTemplate->body) 
            });
        @endforeach

        @foreach($dataSales as $itemConnect)      
            that.listAcountSale.push({
                id: '{{$itemConnect->id}}',
                type: 'update',
                ctv_jobs_id: '{{$itemConnect->ctv_jobs_id}}',
                price_total: '{{$itemConnect->price_total}}',
                ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                payplace: '{{$itemConnect->payplace}}',
                status: '{{$itemConnect->status}}',
                info: @json($itemConnect['userInfo']),
            });

        @endforeach
        @foreach($dataCustomer as $itemConnect)
            that.listAcountCustomer.push({
                id: '{{$itemConnect->id}}',
                type: 'update',
                cus_jobs_id: '{{$itemConnect->id}}',
                contact_user_id: '{{$itemConnect->contact_user_id}}',
                price_total: '{{$itemConnect->price_total}}',
                ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                status: '{{$itemConnect->status}}',
                info: @json($itemConnect['userInfo']),
            });
        @endforeach
    },
    methods: {
        HideLeft: function() {
            if (this.classRightGrid == "col-lg-12") {
                this.classRightGrid = "col-lg-10";
                this.classLefttGrid = "col-lg-2";
                this.hiddenMenu = "displayNone";
            } else {
                this.classRightGrid = "col-lg-12";
                this.classLefttGrid = "col-lg-0 displayNone";
                this.hiddenMenu = "";
            }
        },
        execCopyClipboad() {
            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();
        },
        copyClipboadCTV(_i) {
            $('#copyName').html(this.parseName(_i.name));
            $('#copyFurigana').html(_i.address);
            $('#copyPhone').html(this.parsePhone(_i.phone));

            this.execCopyClipboad();
        },
        copyClipboadCTVpd(_i) {
            $('#copyName').html(this.parseName(_i.name));
            $('#copyFurigana').html(_i.furigana);
            $('#copyPhone').html(this.parsePhone(_i.phone));

            this.execCopyClipboad();
        },
        copyClipboad(_i) {
            $('#copyName').html(_i.codejob);
            $('#copyFurigana').html(_i.ngay_pd);
            $('#copyPhone').html(_i.address_pd);

            this.execCopyClipboad();
        },
        copyClipboadLink(_i) {
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            var url = baseUrl + "/projectview/" + _i.id;
            $('#copyName').html(url);
            $('#copyFurigana').html("");
            $('#copyPhone').html("");

            this.execCopyClipboad();
        },
        toggelPd() {
            this.showListPD = this.showListPD == 1 ? 0 : 1;
        },
        toggelCus() {
            this.showListCus = this.showListCus == 1 ? 0 : 1;
        },
        toggelCtv() {
            this.showListCtv = this.showListCtv == 1 ? 0 : 1;
        },
        calculatorCheck() {
            var totalAlerMessage = $('#totalIWill').val() - $('#priceDuyTri').val() - $('#priceOrther').val() - $('#priceVat').val() - 500;
            alert("営業者報酬 : "+ (totalAlerMessage * 10 / 100));
        },
        copyClipboad(_i) {
            $('#copyName').html(_i.name);
            $('#copyFurigana').html(_i.furigana);
            $('#copyPhone').html(_i.phone);

            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();

        },
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            // if ('{{@$data->address_pd}}' !=  this.address_pd) {
            //     const that = this;
            //     $.ajax({
            //         type: 'GET',
            //         url: "http://api.positionstack.com/v1/forward?access_key=d4eb3bcee90d3d0a824834770881ce70&query=" + this.address_pd,
            //         success: function(data) {
            //             that.long = data.data[0].latitude;
            //             that.lat = data.data[0].longitude;
            //             setTimeout(function(){ $('.form-data').submit(); }, 1000);

            //         },
            //         error: function(xhr, textStatus, error) {
            //             Swal.fire({
            //                 title: "Có lỗi dữ liệu nhập vào!",
            //                 type: "warning",

            //             });
            //         }
            //     });
            // } else {
            //     setTimeout(function(){ $('.form-data').submit(); }, 1000);
            // }
            setTimeout(function(){ $('.form-data').submit(); }, 1000);
        },
        sendMailTemplate(_idMail) {
            if (this.flagSendMail == 0) {
                Swal.fire({
                    title: "Chọn thông dịch viên và lưu lại trước khi gửi mail.",
                    type: "warning",
                });
                return;
            }
            this.objSendMail = this.listSendMail[_idMail];
            
        },
        
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        convertStatusBank (value) {
            return (value == "1")? "済み" : "";
        },
        convertTaxPlace (value) {
            return (value == "0")? "" : value;
        },
        parseMoney (value) {
            value = (isNaN(value)) ? 0 : value;
            const formatter = new Intl.NumberFormat('ja-JP', {
                style: 'currency',
                currency: 'JPY'
            });
            return formatter.format(value);
        },
        parseMoneyMinus(value) {
            value = this.parseMoney(value);
            return (value == 0)? value : (S_HYPEN + " " +value);
        },
        parseBank (itemBank) {
            var value = itemBank["name_bank"];
            return value;
        },
        parseName (value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parseTime (date1, date2) {
            var fromTime = new Date(date1).getTime()
            var toTime = new Date(date2).getTime()
            var Ms = toTime-fromTime

            var h = ''
            var m = ''

            h = Ms/3600000
            m = (Ms-h*3600000)/6000
            var time = h+m;
            return time;
        },
        parseAddr(value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parsePhone(value) {
            if (this.isNull(value)) return S_HYPEN;

            value = (new String(value)).replaceAll(S_HYPEN, '').replaceAll(' ', ''); 
            var vLength = value.length;
            if (vLength == 11) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(7, 4);
            } else if (vLength == 10) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(7, 3);
            }
            return value;
        },
        submitSendMail() {
            var body = { 
                _token: CSRF_TOKEN ,
                mail_cc : this.objSendMail.mail_cc,
                title : this.objSendMail.title,
                body : this.objSendMail.body,
                userId : this.userCustomerId
            };
            $.ajax({
                type: 'POST',
                url: '/admin/company/send-mail-template',
                data: body,
                success: function(data) {
                    if (data.code == 200) {
                        Swal.fire({
                            title: "Đã gửi Email!",
                            type: "success",

                        });
                    } else {
                        Swal.fire({
                            title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                            type: "warning",

                        });
                    }
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                        type: "warning",

                    });
                }
            });
            
        },
        onSendEmail() {
            let arrSendMail = [];
            this.list.map(item => {
                if (item.send_mail == 1) {
                    if (!arrSendMail.includes(item.id)) {
                        arrSendMail.push(item.id);
                    }
                }
            });
            if (arrSendMail.length > 0) {
                let listId = arrSendMail.join(',');
                $.ajax({
                    type: 'GET',
                    url: "/admin/company/send-mail?id={{$id}}&list=" + listId,
                    success: function(data) {
                        if (data.code == 200) {
                            Swal.fire({
                                title: "Đã gửi Email!",
                                type: "success",

                            });
                        } else {
                            Swal.fire({
                                title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                                type: "warning",

                            });
                        }
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                            type: "warning",

                        });
                    }
                });
            }
        },
        cancleEdit() {
            this.edit_form = 0;
        },
        openEdit() {
            this.edit_form = 1;
        },
        onOpenLoction() {
            window.open("http://maps.google.com/maps?q="+this.ga_gannhat, '_blank');
        },
        onOpenLoctionAddress() {
            window.open("http://maps.google.com/maps?q="+this.address_pd, '_blank');
        },
        onGetSales() {
            this.pageSales = 1;
            this.loadingTableSale = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSale != '') {
                conditionSearch += '&name=' + this.conditionNameSale;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCtvJobs')}}?page=" + this.pageSales  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countSales = data.pageTotal;
                        that.listSales = data.data;
                    } else {
                        that.countSales = 0;
                        that.listSales = [];
                    }
                    that.loadingTableSale = 0;
                    let pageArr = [];
                    if (that.pageSales - 2 > 0) {
                        pageArr.push(that.pageSales - 2);
                    }
                    if (that.pageSales - 1 > 0) {
                        pageArr.push(that.pageSales - 1);
                    }
                    pageArr.push(that.pageSales);
                    if (that.pageSales + 1 <= that.count) {
                        pageArr.push(that.pageSales + 1);
                    }
                    if (that.pageSales + 2 <= that.countSales) {
                        pageArr.push(that.pageSales + 2);
                    }
                    that.listPageSales = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onGetCustomer() {
            this.pageCustomer = 1;
            this.loadingTableCustomer = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSCustomer != '') {
                conditionSearch += '&name=' + this.conditionNameCustomer;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.pageCustomer  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countCustomer = data.pageTotal;
                        that.listCustomer = data.data;
                    } else {
                        that.countCustomer = 0;
                        that.listCustomer = [];
                    }
                    that.loadingTableCustomer = 0;
                    let pageArr = [];
                    // if (that.pageCustomer - 2 > 0) {
                    //     pageArr.push(that.pageCustomer - 2);
                    // }
                    // if (that.pageCustomer - 1 > 0) {
                    //     pageArr.push(that.pageCustomer - 1);
                    // }
                    // pageArr.push(that.pageCustomer);
                    // if (that.pageCustomer + 1 <= that.count) {
                    //     pageArr.push(that.pageCustomer + 1);
                    // }
                    // if (that.pageCustomer + 2 <= that.countCustomer) {
                    //     pageArr.push(that.pageCustomer + 2);
                    // }
                    for (let index = 1; index <= data.pageTotal; index++) {
                        pageArr.push(index);
                        
                    }
                    that.listPageCustomer = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onGetByAddress() {
            this.page = 1;
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.jplt != '') {
                conditionSearch += '&jplt=' + this.jplt;
            }
            if (this.male != '') {
                conditionSearch += '&male=' + this.male;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/collaborators/get-list?" + conditionSearch,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                    } else {
                        that.count = 0;
                        that.list = [];
                    }
                    that.loadingTable = 0;
                    let pageArr = [];
                    if (that.page - 2 > 0) {
                        pageArr.push(that.page - 2);
                    }
                    if (that.page - 1 > 0) {
                        pageArr.push(that.page - 1);
                    }
                    pageArr.push(that.page);
                    if (that.page + 1 <= that.count) {
                        pageArr.push(that.page + 1);
                    }
                    if (that.page + 2 <= that.count) {
                        pageArr.push(that.page + 2);
                    }
                    that.listPage = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        addListRecord(i) {
            
            i.dateList.push({
                id: 'new',
                type: 'add',
                ngay_phien_dich: '',
                gio_phien_dich: '',
                gio_ket_thuc: '',
                gio_tang_ca: '',
                note: '',
                phi_phien_dich: '',
                phi_giao_thong: '',
                // file_bao_cao: '',
                file_hoa_don: ''
            });
        },
        removeListRecord(i) {
            i.type = 'delete';
        },
        removeRecordSales(i) {
            i.type = 'delete';
        },
        removeRecordCustomer(i) {
            i.type = 'delete';
        },
        addRecordSale(i) {
            this.listAcountSale.push({
                id: 'new',
                type: 'add',
                ctv_jobs_id: i.id,
                price_total: '',
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                payplace: 0,
                status: '',
                info: i
            });
        },
        addRecordCustomer(i) {
            this.listAcountCustomer.push({
                id: 'new',
                type: 'add',
                cus_jobs_id: i.id,
                price_total: '',
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                status: '',
                contact_user_id: '',
                info: i
            });
        },
        addRecord(i) {
            let listDatePd = $('#listDate').val();
            let dateListCheck = [];
            if (listDatePd != '') {
                listDatePd = listDatePd.split(",");
                listDatePd.map(itemMap => {
                    dateListCheck.push({
                        id: 'new',
                        type: 'add',
                        ngay_phien_dich: itemMap,
                        gio_phien_dich: '',
                        gio_ket_thuc: '',
                        gio_tang_ca: '',
                        note: '',
                        phi_phien_dich: '',
                        phi_giao_thong: '',
                        // file_bao_cao: '',
                        file_hoa_don: ''
                    });
                });
            }
            this.listBankAccount.push({
                id: 'new',
                type: 'add',
                collaborators_id: i.id,
                price_total: '',
                bank_id: '',
                listBank: i.bank,
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                dateList: dateListCheck,
                paytaxplace: 0,
                info: i
            });
        },
        removeRecord(i) {
            i.type = 'delete';
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        promoteCheck(_i) {
            const that = this;
            that.loadingTable = 1;
            $.ajax({
                url: "/admin/projectcheck/" + _i,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    Swal.fire({
                        title: "更新しました!"
                    });
                    location.href = "/admin/projectview/" + _i;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "エラーが発生しました!",
                        type: "warning",
                    });
                }
            });
        },
        promoteApprove(_i) {
            const that = this;
            Swal.fire({
                title: "\承認でよろしいでしょうか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/projectapprove/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "更新しました!"
                        });
                        location.href = "/admin/projectview/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        deleteRecore(_i) {
            const that = this;
            Swal.fire({
                title: "確認メッセージ",
                text: "案件を削除すると、復元できません。\n該当の案件を削除してもよろしいでしょうか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/projectdelete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "削除しました!"
                        });
                        location.href = "/admin/project";
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCollaborators')}}?page=" + this.page + "&name=" + this
                    .conditionName,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                            item.send_mail = 0;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                    } else {
                        that.count = 0;
                        that.list = [];
                    }
                    that.loadingTable = 0;
                    let pageArr = [];
                    if (that.page - 2 > 0) {
                        pageArr.push(that.page - 2);
                    }
                    if (that.page - 1 > 0) {
                        pageArr.push(that.page - 1);
                    }
                    pageArr.push(that.page);
                    if (that.page + 1 <= that.count) {
                        pageArr.push(that.page + 1);
                    }
                    if (that.page + 2 <= that.count) {
                        pageArr.push(that.page + 2);
                    }
                    that.listPage = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onPrePage() {
            if (this.page > 1) {
                this.page = this.page - 1;
            }
            this.onLoadPagination();
        },
        onNextPage() {
            if (this.page < this.count) {
                this.page = this.page + 1;
            }
            this.onLoadPagination();
        },
        onPrePageSales() {
            if (this.pageSales > 1) {
                this.pageSales = this.pageSales - 1;
            }
            this.onGetSalesPage();
        },
        onNextPageSales() {
            if (this.pageSales < this.countSales) {
                this.pageSales = this.pageSales + 1;
            }
            this.onGetSalesPage();
        },
        
        onPageChangeSales(_p) {
            this.pageSales = _p;
            this.onGetSalesPage();
        },
        onGetSalesPage() {
            this.loadingTableSale = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSale != '') {
                conditionSearch += '&name=' + this.conditionNameSale;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCtvJobs')}}?page=" + this.pageSales  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countSales = data.pageTotal;
                        that.listSales = data.data;
                    } else {
                        that.countSales = 0;
                        that.listSales = [];
                    }
                    that.loadingTableSale = 0;
                    let pageArr = [];
                    if (that.pageSales - 2 > 0) {
                        pageArr.push(that.pageSales - 2);
                    }
                    if (that.pageSales - 1 > 0) {
                        pageArr.push(that.pageSales - 1);
                    }
                    pageArr.push(that.pageSales);
                    if (that.pageSales + 1 <= that.count) {
                        pageArr.push(that.pageSales + 1);
                    }
                    if (that.pageSales + 2 <= that.countSales) {
                        pageArr.push(that.pageSales + 2);
                    }
                    that.listPageSales = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        
        onPrePageCustomer() {
            if (this.pageCustomer > 1) {
                this.pageCustomer = this.pageCustomer - 1;
            }
            this.onGetCustomerPage();
        },
        onNextPageCustomer() {
            if (this.pageCustomer < this.countCustomer) {
                this.pageCustomer = this.pageCustomer + 1;
            }
            this.onGetCustomerPage();
        },
        
        onPageChangeCustomer(_p) {
            this.pageCustomer = _p; 
            this.onGetCustomerPage();
        },
        onGetCustomerPage() {
            this.loadingTableCustomer = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSCustomer != '') {
                conditionSearch += '&name=' + this.conditionNameCustomer;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.pageCustomer  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countCustomer = data.pageTotal;
                        that.listCustomer = data.data;
                    } else {
                        that.countCustomer = 0;
                        that.listCustomer = [];
                    }
                    that.loadingTableCustomer = 0;
                    let pageArr = [];
                    // if (that.pageCustomer - 2 > 0) {
                    //     pageArr.push(that.pageCustomer - 2);
                    // }
                    // if (that.pageCustomer - 1 > 0) {
                    //     pageArr.push(that.pageCustomer - 1);
                    // }
                    // pageArr.push(that.pageCustomer);
                    // if (that.pageCustomer + 1 <= that.count) {
                    //     pageArr.push(that.pageCustomer + 1);
                    // }
                    // if (that.pageCustomer + 2 <= that.countCustomer) {
                    //     pageArr.push(that.pageCustomer + 2);
                    // }
                    for (let index = 1; index <= data.pageTotal; index++) {
                        pageArr.push(index);
                        
                    }
                    that.listPageCustomer = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        }


    },
});
</script>

@stop
