@extends('layouts.backend_admin')
  
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

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


@section('content')
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
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">แก้ไขข้อมูลหลักฐานการรับ</h2>    

    
        <form  method="post" action="{{ route('admin.updatesuppliesconpremise') }}" enctype="multipart/form-data">
        @csrf
        <div class="row push">
       
    <div class="col-lg-2">
      <label >หลักฐานการรับ</label>
      </div>
      <div class="col-lg-3">
      <input  name = "PERMISE_NAME"  id="PERMISE_NAME" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" value="{{$infosuppliesconpremiseT->PERMISE_NAME}}" onkeyup="check_permisename();">
      <div style="color: red; font-size: 16px;" id="permisename"></div>    
    </div>
    
      <input  type="hidden" name = "PERMISE_ID"  id="PERMISE_ID" class="form-control input-lg" value="{{$infosuppliesconpremiseT->PERMISE_ID}}">
      </div></div>
        <div class="modal-footer">
        <div align="right">
        <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกแก้ไขข้อมูล</button>
         <a href="{{ url('admin_asset_supplies/setupsuppliesconpremise')  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการแก้ไขข้อมูล ?')" >ยกเลิก</a> 
         </div>    
       
        </div>
        </form>  
           
      
        
                  
      
                      

@endsection

@section('footer')

<script>   
    function check_permisename()
    {                         
        permisename = document.getElementById("PERMISE_NAME").value;             
            if (permisename==null || permisename==''){
            document.getElementById("permisename").style.display = "";     
            text_permisename = "*กรุณาระบุหลักฐานการรับ";
            document.getElementById("permisename").innerHTML = text_permisename;
            }else{
            document.getElementById("permisename").style.display = "none";
            }
    }
    

   </script>
    <script>      
    $('form').submit(function () {
     
      var permisename,text_permisename; 
     
      permisename = document.getElementById("PERMISE_NAME").value; 
   
                     
      if (permisename==null || permisename==''){
      document.getElementById("permisename").style.display = "";     
      text_permisename = "*กรุณาระบุหลักฐานการรับ";
      document.getElementById("permisename").innerHTML = text_permisename;
      }else{
      document.getElementById("permisename").style.display = "none";
      }
  
  
      if(permisename==null || permisename==''     
       )
    {
    alert("กรุณาตรวจสอบความถูกต้องของข้อมูล");      
    return false;   
    }
    }); 
</script>



@endsection