@extends('layouts.backend_admin')

<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />

@section('content')
<style>
  body {
      font-family: 'Kanit', sans-serif;
      font-size: 14px;
    
      }
      .form-control {
      font-family: 'Kanit', sans-serif;
      font-size: 14px;
      }
</style>

<style>
  .dataTables_wrapper   .dataTables_filter{
    float: right 
    }

.dataTables_wrapper  .dataTables_length{
        float: left 
    }
    .dataTables_info {
        float: left;
    }
    .dataTables_paginate{
        float: right
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
  
  <center>
    <!-- Dynamic Table Simple -->
    <div class="block shadow-lg  mt-4" style="width: 95%;">
        <div class="block-header block-header-default" >
            <h3 class="block-title text-left" style="font-family: 'Kanit', sans-serif;"><B>กำหนดสิทธิ์การใช้งาน</B></h3>
            </div>
        <div class="block-content block-content-full">

          <form  method="GET" action="{{ route('setup.setupinfopermis_addsearch') }}" >
            @csrf

          <div class="row">
              <div class="col-md-4 text-right">
                <label >ชื่อ-นามสกุล</label>
              </div>
              <div class="col-md-3">
                <select  name="USE_ID" id="USE_ID" class="form-control input-sm " required>
                  <option value="" >-- กรุณาเลือกชื่อเจ้าหน้าที่ --</option>
                      @foreach ($inforpersons as $inforperson)
                              <option value="{{ $inforperson->ID}}">{{$inforperson->HR_FNAME}} {{$inforperson->HR_LNAME}}</option>    
                      @endforeach 
                </select>
              </div>
              <div class="col-md-2">
                {{-- <button type="submit"  class="btn btn-hero-sm btn-hero-info" > <i class="fas fa-search mr-2"></i> กำหนดสิทธิ์</button> --}}
                <button type="submit"  class="btn btn-hero-sm btn-hero-info" > <i class="fas fa-plus mr-2"></i> กำหนดสิทธิ์</button>
              </div>
          </div>
          </form>
          <hr>

          <div class="mt-3">
            <div class="table-responsive">          
                  <table class="gwt-table table-striped table-vcenter js-dataTable-full" width="100%">
                        <thead style="background-color: #FFEBCD;">                  
                            <tr height="40">
                              <th class="text-font" width="5%" style="border-color:#F0FFFF;text-align: center;">รหัส</th>
                              <th class="text-font" style="border-color:#F0FFFF;text-align: center;">ชื่อ นามสกุล</th>
                              <th class="text-font" style="border-color:#F0FFFF;text-align: center;">ตำแหน่ง</th> 
                              <th class="text-font" width="10%" style="border-color:#F0FFFF;text-align: center;">สิทธิ์</th>        
                              <th class="text-font" width="5%" style="border-color:#F0FFFF;text-align: center;">ลบ</th>
                            </tr>                  
                        </thead>
                      <tbody id="myTable">
                        <?php $number = 0; ?>
                        @foreach ($infopermiss as $infopermis)
                        <?php $number++;  ?>
                            <tr height="40">
                                <td class="text-font" align="center">{{ $number}}</td>                 
                                <td class="text-font text-pedding">{{ $infopermis->HR_PREFIX_NAME}}{{$infopermis->HR_FNAME}} {{$infopermis->HR_LNAME}}</td> 
                                <td class="text-font text-pedding">{{ $infopermis-> POSITION_IN_WORK }}</td>
                                <td class="text-font" align="center">
                                    <a href="{{ url('admin_permis/setupinfopermis/permis/'. $infopermis-> PERSON_ID)  }}" class="btn btn-success"><i class="fas fa-user-cog"></i></a>  
                                </td>                  
                                <td align="center">
                                    <a href="{{ url('admin_permis/setupinfopermis/destroy/'. $infopermis-> PERSON_ID)  }}" class="btn btn-danger" onclick="return confirm('ต้องการที่จะลบข้อมูลรหัส {{ $infopermis-> PERSON_ID }}?')"><i class="fas fa-times"></i></a>
                                </td> 
                            </tr> 
                        @endforeach 
                      </tbody>
                </table>

            </div>               
          </div>  
@endsection

@section('footer')

<script src="{{ asset('select2/select2.min.js') }}"></script>

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>


<script>


$(document).ready(function() {
    $('select').select2({
    width: '100%'
});

    });

  function check_use_id()
  {                         
    use_id = document.getElementById("USE_ID").value;             
          if (use_id==null || use_id==''){
          document.getElementById("use_id").style.display = "";     
          text_use_id = "*กรุณาเลือกชื่อเจ้าหน้าที่";
          document.getElementById("use_id").innerHTML = text_use_id;
          }else{
          document.getElementById("use_id").style.display = "none";
          }
  }
  function check_permis_id()
  {                         
    permis_id = document.getElementById("PERMIS_ID").value;             
          if (permis_id==null || permis_id==''){
          document.getElementById("permis_id").style.display = "";     
          text_permis_id = "*กรุณาเลือกสิทธิ์เจ้าหน้าที่";
          document.getElementById("permis_id").innerHTML = text_permis_id;
          }else{
          document.getElementById("permis_id").style.display = "none";
          }
  }

</script>
<script>      
  $('form').submit(function () {
    var use_id,text_use_id;
    var permis_id,text_permis_id;

    use_id = document.getElementById("USE_ID").value;
    permis_id = document.getElementById("PERMIS_ID").value;

    if (use_id==null || use_id==''){
    document.getElementById("use_id").style.display = "";     
    text_use_id= "*กรุณาเลือกชื่อเจ้าหน้าที่";
    document.getElementById("use_id").innerHTML = text_use_id;
    }else{
    document.getElementById("use_id").style.display = "none";
    }
    if (permis_id==null || permis_id==''){
    document.getElementById("permis_id").style.display = "";     
    text_permis_id= "*กรุณาเลือกสิทธิ์เจ้าหน้าที่";
    document.getElementById("permis_id").innerHTML = text_permis_id;
    }else{
    document.getElementById("permis_id").style.display = "none";
    }

    if(use_id==null || use_id==''||
    permis_id==null || permis_id==''          
    )
{
alert("กรุณาตรวจสอบความถูกต้องของข้อมูล");      
return false;   
}
}); 

</script>


<script>
  $('#edit_modal').on('show.bs.modal', function(e) {
    var Id = $(e.relatedTarget).data('id');
    var VUTId = $(e.relatedTarget).data('vutid');
    $(e.currentTarget).find('input[name="ID"]').val(Id);
    $(e.currentTarget).find('select[id="VUT_ID_edit[]"]').val(VUTId);

});

</script>

<script>
   $(document).ready(function () {
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true              //Set เป็นปี พ.ศ.
            }).datepicker("setDate", 0);  //กำหนดเป็นวันปัจุบัน
    });

    $(document).ready(function () {
            
            $('.datepicker2').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true              //Set เป็นปี พ.ศ.
            }).datepicker("setDate", 0);  //กำหนดเป็นวันปัจุบัน
    });

    $(document).ready(function () {
            
            $('.datepicker3').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true              //Set เป็นปี พ.ศ.
            });  //กำหนดเป็นวันปัจุบัน
    });

    function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
    

    $('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});

  
</script>

<script src="{{ asset('asset/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
   

        <!-- Page JS Code -->
        <script src="{{ asset('asset/js/pages/be_tables_datatables.min.js') }}"></script>

        <script>
            $(document).ready(function(){
              $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
              });
            });
        </script>
@endsection