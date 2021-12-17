@extends('layouts.mpay')
@section('css_after')
<style>
    #table td{
        padding-top:2px;
        padding-bottom:2px;
    }
    #table thead tr th{
        vertical-align:middle;
    }
</style>
@endsection
@section('content')
<div class="block block-rounded block-bordered" style="width: 95%;margin:auto">
    <div class="block-header block-header-default">
        <div class="block-title fs-18 fw-7">ข้อมูลเครื่องนึ่ง/อบ</div>
        <div class="block-options fs-18 fw-7">
            <a class="btn btn-sm btn-success f-kanit" href="{{route('mpay.mpay_setting_cleanmachine_add')}}"><i
                    class="fa fa-plus"></i> เพิ่มเครื่องนึ่ง/อบ</a>
        </div>
    </div>
    <div class="block-content py-3">
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-vcenter" id="table">
            <thead class="bg-sl2-b2 text-white">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">ชื่อภายใน (เลขครุภัณฑ์)</th>
                    <th class="text-center d-none d-sm-table-cell">ชื่อไทย</th>
                    <th class="text-center d-none d-sm-table-cell">ชื่ออังกฤษ</th>
                    <th class="text-center d-none d-sm-table-cell">ลำดับเครื่อง</th>
                    <th class="text-center">ประเภทเครื่องมือ</th>
                    <th class="text-center d-none d-sm-table-cell">รายละเอียด</th>
                    <th class="text-center">ใช้งาน</th>
                    <th class="text-center">คำสั่ง</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $number = 1;
                @endphp
                @foreach($machine as $row)
                <tr>
                    <td class="text-center">{{$number++}}</td>
                    <td>{{$row->CPAY_MACH_NAME_INSIDE}} <span style="color:#f73636" class="fs-14">({{$row->ARTICLE_NUM}})</span></td>
                    <td class="d-none d-sm-table-cell">{{$row->CPAY_MACH_NAME_TH}}</td>
                    <td class="d-none d-sm-table-cell">{{$row->CPAY_MACH_NAME_EN}}</td>
                    <td class="text-center d-none d-sm-table-cell">{{$row->CPAY_MACH_NUMBER}}</td>
                    <td>{{$row->CPAY_TYPEMACH_NAME}}</td>
                    <td>{{$row->CPAY_MACH_DETAIL}}</td>
                    <td class="text-center" width="90px">
                        <div class="custom-control custom-switch custom-control-success mb-1">
                            <input type="checkbox" class="custom-control-input" id="active{{$row->CPAY_MACH_ID}}"
                                onclick="update_active({{$row->CPAY_MACH_ID}})" <?=($row->ACTIVE)?'checked':'';?>>
                            <label class="custom-control-label" for="active{{$row->CPAY_MACH_ID}}"></label>
                        </div>
                    </td>
                    <td width="10%" class="text-center">
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle f-kanit fw-2"
                                id="dropdown-align-primary" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">ทำรายการ</button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-align-primary"
                                x-placement="bottom-end"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-67px, 38px, 0px);">
                                <a class="dropdown-item" href="{{route('mpay.mpay_setting_cleanmachine_edit',$row->CPAY_MACH_ID)}}">แก้ไข</a>
                                <a onclick="return confirm('ต้องการลบจริงหรือไม่?')" class="dropdown-item" href="{{route('mpay.mpay_setting_cleanmachine_delete',$row->CPAY_MACH_ID)}}">ลบ</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    @if(Session('scc'))
        Swal.fire("{{session('scc')}}",'','success')
    @endif
    @if(session('err'))
        Swal.fire("{{session('err')}}", '', "error")
    @endif
    const token = $('meta[name="csrf-token"]').attr('content')
    function update_active(id) {
        var check = document.getElementById('active' + id).checked;
        $.ajax({
            url: "{{route('mpay.ajax_mpay_setting_cleanmachine_update_active')}}",
            method: "POST",
            data: {
                onoff: check,
                id: id,
                _token: token
            },
            success:function name(result) {
                console.log(result);
            }
        })
    }
    $('#table').DataTable();
</script>

@endsection