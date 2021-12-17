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
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">แก้ไขประเภทสินค้าที่รับ</h2>    

    
        <form  method="post" action="{{ route('admin.updatesuppliescontypelist') }}" enctype="multipart/form-data">
        @csrf
        <div class="row push">
       
    <div class="col-lg-2">
      <label >ประเภทสินค้าที่รับ</label>
      </div>
      <div class="col-lg-3">
      <input  name = "LIST_TYPE_NAME"  id="LIST_TYPE_NAME" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" value="{{$infosuppliescontypelistT->LIST_TYPE_NAME}}" onkeyup="check_listtypename();">
      <div style="color: red; font-size: 16px;" id="listtypename"></div> 
    </div>
    
      <input  type="hidden" name = "LIST_TYPE_ID"  id="LIST_TYPE_ID" class="form-control input-lg" value="{{$infosuppliescontypelistT->LIST_TYPE_ID}}">
      </div></div>
        <div class="modal-footer">
        <div align="right">
        <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกแก้ไขข้อมูล</button>
         <a href="{{ url('admin_asset_supplies/setupsuppliescontypelist')  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการแก้ไขข้อมูล ?')" >ยกเลิก</a> 
         </div>    
       
        </div>
        </form>  
           
      
        
                  
      
                      

@endsection

@section('footer')

<script>   
    function check_listtypename()
    {                         
        listtypename = document.getElementById("LIST_TYPE_NAME").value;             
            if (listtypename==null || listtypename==''){
            document.getElementById("listtypename").style.display = "";     
            text_listtypename = "*กรุณาระบุประเภทสินค้าที่รับ";
            document.getElementById("listtypename").innerHTML = text_listtypename;
            }else{
            document.getElementById("listtypename").style.display = "none";
            }
    }
    

   </script>
    <script>      
    $('form').submit(function () {
     
      var listtypename,text_listtypename; 
     
      listtypename = document.getElementById("LIST_TYPE_NAME").value; 
   
                     
      if (listtypename==null || listtypename==''){
      document.getElementById("listtypename").style.display = "";     
      text_listtypename = "*กรุณาระบุประเภทสินค้าที่รับ";
      document.getElementById("listtypename").innerHTML = text_listtypename;
      }else{
      document.getElementById("listtypename").style.display = "none";
      }
  
  
      if(listtypename==null || listtypename==''     
       )
    {
    alert("กรุณาตรวจสอบความถูกต้องของข้อมูล");      
    return false;   
    }
    }); 
</script>



@endsection