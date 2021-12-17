<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Incidence;
use Illuminate\Support\Facades\Session;
use App\Models\Risk_internalcontrol;
use App\Models\Risk_internalcontrol_sub;
use App\Models\Risk_internalcontrol_subsub;
use App\Models\Riskrep;
use App\Models\Risk_setupincidence_level;
use App\Models\Risk_internalcontrol_subsub_detail;
use App\Models\Risk_notify_repeat_sub;
use App\Models\Risk_notify_accept_sub;
use App\Models\Risk_notify_repeat_sub_infer;
use App\Models\Risk_notify_repeat_sub_inferlist;
use App\Models\Risk_notify_repeat_sub_board;
use App\Models\Risk_notify_repeat_sub_board_out;
use App\Models\Risk_notify_repeat_sub_topic_infer;
use App\Models\Risk_internalcontrol_subsub_detail_sub;
use App\Models\Risk_internalcontrol_subsub_detail_make;
use App\Models\Risk_internalcontrol_subsub_detail_risk;
use App\Models\Risk_internalcontrol_pk5_depart;
use App\Models\Risk_internalcontrol_pk5_depart_sub;
use App\Models\Risk_internalcontrol_pk5_depart_subsub;
use App\Models\Risk_internalcontrol_pk5_depart_subsub_detail;
use App\Models\Risk_internalcontrol_pk5;
use App\Models\Risk_internalcontrol_pk5_sub;
use App\Models\Risk_internalcontrol_organi;
use App\Models\Risk_internalcontrol_organi_sub;
use App\Models\Risk_rep_time;
use App\Models\Risk_rep_location;
use App\Models\Risk_rep_group;
use App\Models\Risk_rep_groupsub;
use App\Models\Risk_rep_groupsubsub;
use App\Models\Risk_rep_detail;
use App\Models\Risk_rep_items;
use App\Models\Env_parameter_sub;
use App\Models\Informrepair_openform;
use PDF;
use Alert;
use Brian2694\Toastr\Facades\Toastr;
class FormpdfController extends Controller
{
    //---------------------------ฟังชั่น------------------------------
    function pdfcongrat_10999(Request $request,$id)
    {       
            $infocongrat = DB::table('donation_person_sub')
            ->leftjoin('donation_person','donation_person.DONATE_PERSON_ID','=','donation_person_sub.DONATE_PERSON_ID')
            ->leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_UNIT_ID','=','donation_unit.DONATIONUNIT_ID')
            ->where('PERSON_DONATE_SUB_ID','=',$id)->first();
            
            $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

            $infoorg = DB::table('info_org')->where('ORG_ID','=','1')
            ->leftjoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
            ->first();

            $orgname =  DB::table('info_org')
              ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
              ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
              ->first();

            $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

            if($sigin !== null){
              $sig =  $sigin->FILE_NAME;
          }else{ $sig = '';}

          $pdf = PDF::loadView('formpdf.pdfcongrat_10999',[
                'infocongrat' => $infocongrat,
                'infoorg' => $infoorg,
                'sig' => $sig,
                'checksig' => $checksig,
                'orgname' => $orgname,
          ]);
        
          $pdf->setPaper('a4','landscape');
        
          return @$pdf->stream();   
    }

   
    function pdf3_10999(Request $request,$id)
    {
                   $orgname =  DB::table('info_org')
                  ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                  ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->first();

                  
                  $inforcar = DB::table('vehicle_car_reserve')
                  ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                  ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                  ->where('RESERVE_ID','=',$id)->first();
                  
                  
                  $iduser = $inforcar->RESERVE_PERSON_ID;
                  $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                  ->where('hrd_person.ID','=',$iduser)->first();

                  $idcon = $inforcar->LEADER_PERSON_ID;
                  $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                  ->where('hrd_person.ID','=',$idcon)->first();

                  $indexperson = DB::table('vehicle_car_index_person')
                  ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                  ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                  ->where('RESERVE_ID','=',$id)->get();

                  $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                  $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
                  $orgname =  DB::table('info_org')
                  ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                  ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->first();

                  $debsub =  DB::table('hrd_department_sub')
                  ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                  ->first();

                  $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                  $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                  $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                  $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                  if($siginper !== null){
                      $sigper =  $siginper->FILE_NAME;
                  }else{ $sigper = '';}

                  if($siginsub !== null){
                      $sigsub =  $siginsub->FILE_NAME;
                  }else{ $sigsub = '';}

                  if($sigin !== null){
                      $sig =  $sigin->FILE_NAME;
                  }else{ $sig = '';}

                  if($sigincardriver !== null){
                      $sigdriver =  $sigincardriver->FILE_NAME;
                  }else{ $sigdriver = '';}

                  $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                  $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();
                //   dd($funcgleave);

                  if ($func == null || $func == '') {
                      $f = 'ใบขออนุญาตใช้รถยนต์';
                  } else {
                      $f = $func->CAR_FUNCTION_NAME;
                  }

                  $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                  if ($funccheck == null || $funccheck == '') {
                    $funch = 'Notopen';
                  } else {
                      $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                  }

                  // dd($f);
                  $infoper =  Person::get();

                  $pdf = PDF::loadView('formpdf.pdf3_10999',[
                      'orgname' => $orgname,
                      'inforcar' => $inforcar,
                      'inforperson' => $inforperson,
                      'infocon' => $infocon,
                      'indexpersons' => $indexperson,
                      'indexpersoncount' => $indexpersoncount,
                      'sig' => $sig,
                      'sigper' => $sigper,
                      'sigsub' => $sigsub,
                      'checksig' => $checksig,
                      'sigdriver' => $sigdriver,
                      'func' => $func,
                      'f' => $f,
                      'funch' => $funch,
                      'infoper' => $infoper,
                      'funcgleave' => $funcgleave,
                      ]);
                      return @$pdf->stream();
    }

 //====================== ฝั่ง User =============================//
    function pdf3_general_10999(Request $request,$id) 
    {
                   $orgname =  DB::table('info_org')
                  ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                  ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->first();

                  
                  $inforcar = DB::table('vehicle_car_reserve')
                  ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                  ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                  ->where('RESERVE_ID','=',$id)->first();
                  
                  
                  $iduser = $inforcar->RESERVE_PERSON_ID;
                  $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                  ->where('hrd_person.ID','=',$iduser)->first();

                  $idcon = $inforcar->LEADER_PERSON_ID;
                  $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                  ->where('hrd_person.ID','=',$idcon)->first();

                  $indexperson = DB::table('vehicle_car_index_person')
                  ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                  ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                  ->where('RESERVE_ID','=',$id)->get();

                  $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                  $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
                  $orgname =  DB::table('info_org')
                  ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                  ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->first();

                  $debsub =  DB::table('hrd_department_sub')
                  ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                  ->first();

                  $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                  $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                  $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                  $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                  if($siginper !== null){
                      $sigper =  $siginper->FILE_NAME;
                  }else{ $sigper = '';}

                  if($siginsub !== null){
                      $sigsub =  $siginsub->FILE_NAME;
                  }else{ $sigsub = '';}

                  if($sigin !== null){
                      $sig =  $sigin->FILE_NAME;
                  }else{ $sig = '';}

                  if($sigincardriver !== null){
                      $sigdriver =  $sigincardriver->FILE_NAME;
                  }else{ $sigdriver = '';}

                  $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                  $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();
                //   dd($funcgleave);

                  if ($func == null || $func == '') {
                      $f = 'ใบขออนุญาตใช้รถยนต์';
                  } else {
                      $f = $func->CAR_FUNCTION_NAME;
                  }

                  $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                  if ($funccheck == null || $funccheck == '') {
                    $funch = 'Notopen';
                  } else {
                      $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                  }

                  // dd($f);
                  $infoper =  Person::get();

                  $pdf = PDF::loadView('formpdf.pdf3_general_10999',[
                      'orgname' => $orgname,
                      'inforcar' => $inforcar,
                      'inforperson' => $inforperson,
                      'infocon' => $infocon,
                      'indexpersons' => $indexperson,
                      'indexpersoncount' => $indexpersoncount,
                      'sig' => $sig,
                      'sigper' => $sigper,
                      'sigsub' => $sigsub,
                      'checksig' => $checksig,
                      'sigdriver' => $sigdriver,
                      'func' => $func,
                      'f' => $f,
                      'funch' => $funch,
                      'infoper' => $infoper,
                      'funcgleave' => $funcgleave,
                      ]);
                      return @$pdf->stream();
    }

    function personperdev_10999(Request $request,$id)
    {
                //    $orgname =  DB::table('info_org')
                //   ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                //   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                //   ->first();

                  
                //   $inforcar = DB::table('vehicle_car_reserve')
                //   ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                //   ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                //   ->where('RESERVE_ID','=',$id)->first();
                  
                  
                //   $iduser = $inforcar->RESERVE_PERSON_ID;
                //   $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                //   ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                //   ->where('hrd_person.ID','=',$iduser)->first();


                //   $index_person = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->get();

                //   $idcon = $inforcar->LEADER_PERSON_ID;
                //   $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                //   ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                //   ->where('hrd_person.ID','=',$idcon)->first();

                //   $indexperson = DB::table('vehicle_car_index_person')
                //   ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                //   ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                //   ->where('RESERVE_ID','=',$id)->get();

                //   $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                //   $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
                //   $orgname =  DB::table('info_org')
                //   ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                //   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                //   ->first();

                //   $debsub =  DB::table('hrd_department_sub')
                //   ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                //   ->first();

                //   $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                //   $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                //   $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                //   $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                //   if($siginper !== null){
                //       $sigper =  $siginper->FILE_NAME;
                //   }else{ $sigper = '';}

                //   if($siginsub !== null){
                //       $sigsub =  $siginsub->FILE_NAME;
                //   }else{ $sigsub = '';}

                //   if($sigin !== null){
                //       $sig =  $sigin->FILE_NAME;
                //   }else{ $sig = '';}

                //   if($sigincardriver !== null){
                //       $sigdriver =  $sigincardriver->FILE_NAME;
                //   }else{ $sigdriver = '';}

                //   $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                  $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();
                // //   dd($funcgleave);

                //   if ($func == null || $func == '') {
                //       $f = 'ใบขออนุญาตใช้รถยนต์';
                //   } else {
                //       $f = $func->CAR_FUNCTION_NAME;
                //   }

                  $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                  if ($funccheck == null || $funccheck == '') {
                    $funch = 'Notopen';
                  } else {
                      $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                  }

                //   // dd($f);
                //   $infoper =  Person::get();
                $infoorg = DB::table('info_org')
                ->leftjoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('ORG_ID','=',1)->first();
            
                $infopredev = DB::table('grecord_index')
                ->select('grecord_index.created_at','RECORD_HEAD_USE','LOCATION_ORG_NAME','hrd_province.PROVINCE_NAME','DISTANCE','DATE_GO','DATE_BACK','DATE_TRAVEL_GO','FROM_TIME','DATE_TRAVEL_BACK','BACK_TIME','RECORD_VEHICLE_ID','CAR_REG','OFFER_WORK_HR_NAME','USER_POST_NAME','POSITION_IN_WORK','HR_LEVEL_NAME','OFFER_WORK_HR_NAME','STATUS','DR_PROVINCE_USE')
                ->leftjoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->leftjoin('grecord_org','grecord_index.RECORD_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftjoin('hrd_province','hrd_province.ID','=','grecord_index.PROVINCE_ID')
                ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                ->where('grecord_index.ID','=',$id)->first();
            
                
                $index_person = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->get();
                
                $check = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->count();
                $inforesive = DB::table('grecord_index')
                ->leftjoin('hrd_person','grecord_index.RECEIVE_BY_ID','=','hrd_person.ID')
                ->where('grecord_index.ID','=',$id)->first();
            
                $infooffer = DB::table('grecord_index')
                ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
                ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->where('grecord_index.ID','=',$id)->first();
            
                $indexpersonwork = DB::table('grecord_index')
                ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
                ->where('grecord_index.ID','=',$id)->first();
            
                $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

                  $pdf = PDF::loadView('formpdf.personperdev_10999',[
                    //   'orgname' => $orgname,
                    //   'inforcar' => $inforcar,
                    //   'inforperson' => $inforperson,
                    //   'infocon' => $infocon,
                    //   'indexpersons' => $indexperson,
                    //   'indexpersoncount' => $indexpersoncount,
                    //   'sig' => $sig,
                    //   'sigper' => $sigper,
                    //   'sigsub' => $sigsub,
                    //   'checksig' => $checksig,
                    //   'sigdriver' => $sigdriver,
                    //   'func' => $func,
                    //   'f' => $f,
                      'funch' => $funch,
                    //   'infoper' => $infoper,
                      'funcgleave' => $funcgleave,
                    'id'=>$id,
                    'hrddepartment'=>$hrddepartment,
                    'infoorg'=>$infoorg,
                    'infopredev'=>$infopredev,
                    'indexpersonwork'=>$indexpersonwork,
                    'inforesive'=>$inforesive,
                    'infooffer'=>$infooffer,
                    'check'=>$check,
                    'index_persons'=>$index_person
                      ]);
                      return @$pdf->stream();
    }

//============ เปิดฟังก์ชันฟอร์มต่างฯ ======================//
public function formrepairnormal()
{   
    $openform = Informrepair_openform::orderBy('OPENFORM_ID', 'asc')->get();                                 
   
    return view('formpdf.formrepairnormal',[
        'openforms' => $openform
    ]);
}

function formrepairnormal_switchactive(Request $request)
{  
    $id = $request->idfunc;
    $active = Informrepair_openform::find($id);
    $active->OPENFORMCAR_STATUS = $request->onoff;
    $active->save();
}

}
