@extends('layouts.backend_admin')
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />


@section('content')
<style>
    .center {
    margin: auto;
    width: 100%;
    padding: 10px;
    }
    body {
        font-family: 'Kanit', sans-serif;
        font-size: 13px;
      
        }

    label{
                font-family: 'Kanit', sans-serif;
                font-size: 13px;
              
        } 
</style>
<script>
    function checklogin(){
    window.location.href = '{{route("index")}}'; 
    }
</script>
<?php

    if(Auth::check()){
        $status = Auth::user()->status;
        $id_user = Auth::user()->PERSON_ID;   
    }else{
        
        echo "<body onload=\"checklogin()\"></body>";
        exit();
    } 
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $user_id = substr($url, $pos); 

    if($status=='USER' and $user_id != $id_user  ){
        echo "You do not have access to data.";
        exit();
    }
?>          
                    <!-- Advanced Tables -->               
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content"> 
            <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">แก้ไขคณะกรรมการจัดการ</h2> 
    <form  method="post" action="{{ route('admin.updateassetpaardocleader') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row push">
                            <div class="col-lg-2">
                                    <label >ชื่อ-นามสกุล</label>
                                </div>
                            <div class="col-lg-4">
                                <select name="HR_ID" id="HR_ID" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;font-size: 13px;" onchange="check_hrid();">
                                    <option value="">--เลือกชื่อ-นามสกุล--</option>
                                        @foreach ($personuserT as $personuser)  
                                            @if($infoassetpaardocleaderT -> HR_ID == $personuser-> ID )                                                    
                                                <option value="{{$personuser->ID}}" selected>{{ $personuser->HR_FNAME }} {{ $personuser->HR_LNAME }}</option> 
                                            @else
                                                <option value="{{$personuser->ID}}" >{{ $personuser->HR_FNAME }} {{ $personuser->HR_LNAME }}</option> 
                                            @endif
                                        @endforeach 
                                </select> 
                                <div style="color: red; font-size: 16px;" id="hrid"></div>
                            </div>
                            <div class="col-lg-2">
                                    <label >ตำแหน่ง</label>
                                </div>
                            <div class="col-lg-4">
                                <select name="HR_POSITION" id="HR_POSITION" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;font-size: 13px;" onchange="check_hrposition();" >
                                    <option value="">--เลือกตำแหน่ง-</option>
                                        @foreach ($positionT as $position) 
                                            @if($infoassetpaardocleaderT -> HR_POSITION == $position-> HR_POSITION_NAME )                                                     
                                                <option value="{{$position->HR_POSITION_NAME}}" selected>{{ $position->HR_POSITION_NAME }} </option>
                                            @else
                                                <option value="{{$position->HR_POSITION_NAME}}">{{ $position->HR_POSITION_NAME }} </option>
                                            @endif
                                        @endforeach 
                                </select> 
                                <div style="color: red; font-size: 16px;" id="hrposition"></div> 
                            </div>                  
                        <input type="hidden"  name = "DOCLEADER_ID"  id="DOCLEADER_ID" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" value="{{$infoassetpaardocleaderT->DOCLEADER_ID}}">
                    </div>
            <div class="modal-footer">
                <div align="right">
                    <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกข้อมูล</button>
                        <a href="{{ url('admin_repair/Setupassetpaardocleader')  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')" >ยกเลิก</a> 
                </div>  
            </div>
    </form>  
 
@endsection

@section('footer')

<script>   
    function check_hrid()
    {                         
        hrid = document.getElementById("HR_ID").value;             
            if (hrid==null || hrid==''){
            document.getElementById("hrid").style.display = "";     
            text_hrid = "*เลือกชื่อ-นามสกุล";
            document.getElementById("hrid").innerHTML = text_hrid;
            }else{
            document.getElementById("hrid").style.display = "none";
            }
    }
    function check_hrposition()
    {                         
        hrposition = document.getElementById("HR_POSITION").value;             
            if (hrposition==null || hrposition==''){
            document.getElementById("hrposition").style.display = "";     
            text_hrposition = "*เลือกตำแหน่ง";
            document.getElementById("hrposition").innerHTML = text_hrposition;
            }else{
            document.getElementById("hrposition").style.display = "none";
            }
    }
 

   </script>
    <script>      
    $('form').submit(function () {
     
      var hrid,text_hrid;
      var hrposition,text_hrposition;
     
      hrid = document.getElementById("HR_ID").value;      
      hrposition = document.getElementById("HR_POSITION").value;  
                     
      if (hrid==null || hrid==''){
      document.getElementById("hrid").style.display = "";     
      text_hrid = "*เลือกชื่อ-นามสกุล";
      document.getElementById("hrid").innerHTML = text_hrid;
      }else{
      document.getElementById("hrid").style.display = "none";
      }

      if (hrposition==null || hrposition==''){
      document.getElementById("hrposition").style.display = "";     
      text_hrposition = "*เลือกตำแหน่ง";
      document.getElementById("hrposition").innerHTML = text_hrposition;
      }else{
      document.getElementById("hrposition").style.display = "none";
      }
      
  
      if(hrid==null || hrid=='' ||
      hrposition==null || hrposition==''
         
       )
    {
    alert("กรุณาตรวจสอบความถูกต้องของข้อมูล");      
    return false;   
    }
    }); 
</script>

@endsection