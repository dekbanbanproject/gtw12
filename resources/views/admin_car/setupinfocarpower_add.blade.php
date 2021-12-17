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
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><i class="fas fa-plus"></i> เพิ่มข้อมูลเชื้อเพลิง</h2>    

    
        <form  method="post" action="{{ route('admin.savecarpower') }}" enctype="multipart/form-data">
        @csrf
        <div class="row push">
       
    <div class="col-lg-2">
    <label >ชื่อย่อ</label>
      </div>
      <div class="col-lg-3">
      <input  name = "CAR_POWER_ID_NAME"  id="CAR_POWER_ID_NAME" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" onkeyup="check_car_power_id_name();">
      <div style="color: red; font-size: 16px;" id="car_power_id_name"></div>
    </div>

      <div class="col-lg-2">
      <label >เชื้อเพลิง</label>
      </div>
      <div class="col-lg-3">
      <input  name = "CAR_POWER_NAME"  id="CAR_POWER_NAME" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" onkeyup="check_car_power_name();" >
      <div style="color: red; font-size: 16px;" id="car_power_name"></div>
    </div>
     

      </div></div>
        <div class="modal-footer">
        <div align="right">
        <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกข้อมูล</button>
         <a href="{{ url('admin_car/setupcarpower')  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')" >ยกเลิก</a> 
         </div>    
       
        </div>
        </form>  
           
      
        
                  
      
                      

@endsection

@section('footer')

<script>
   
    function check_car_power_id_name()
    {                         
        car_power_id_name = document.getElementById("CAR_POWER_ID_NAME").value;             
            if (car_power_id_name==null || car_power_id_name==''){
            document.getElementById("car_power_id_name").style.display = "";     
            text_car_power_id_name = "*กรุณาระบุชื่อย่อ";
            document.getElementById("car_power_id_name").innerHTML = text_car_power_id_name;
            }else{
            document.getElementById("car_power_id_name").style.display = "none";
            }
    }
    function check_car_power_name()
    {                         
        car_power_name = document.getElementById("CAR_POWER_NAME").value;             
            if (car_power_name==null || car_power_name==''){
            document.getElementById("car_power_name").style.display = "";     
            text_car_power_name = "*กรุณาระบุเชื้อเพลิง";
            document.getElementById("car_power_name").innerHTML = text_car_power_name;
            }else{
            document.getElementById("car_power_name").style.display = "none";
            }
    }
   
   
   </script>
   <script>      
    $('form').submit(function () {
     
      var car_power_id_name,text_car_power_id_name;
      var car_power_name,text_car_power_name;      
     
      car_power_id_name = document.getElementById("CAR_POWER_ID_NAME").value;  
      car_power_name = document.getElementById("CAR_POWER_NAME").value;  
                
      if (car_power_id_name==null || car_power_id_name==''){
      document.getElementById("car_power_id_name").style.display = "";     
      text_car_power_id_name= "*กรุณาระบุชื่อย่อ";
      document.getElementById("car_power_id_name").innerHTML = text_car_power_id_name;
      }else{
      document.getElementById("car_power_id_name").style.display = "none";
      }
      if (car_power_name==null || car_power_name==''){
      document.getElementById("car_power_name").style.display = "";     
      text_car_power_name= "*กรุณาระบุเชื้อเพลิง";
      document.getElementById("car_power_name").innerHTML = text_car_power_name;
      }else{
      document.getElementById("car_power_name").style.display = "none";
      }
     
        
      if(car_power_id_name==null || car_power_id_name==''||
      car_power_name==null || car_power_name==''
       )
    {
    alert("กรุณาตรวจสอบความถูกต้องของข้อมูล");      
    return false;   
    }
    }); 
  </script>


<script>



@endsection