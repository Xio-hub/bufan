@extends('layouts.app')

@section('title','權限列表')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>權限列表</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>权限</th>
                            <th>guard</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $i => $permission)
                            <tr>
                                <td scope="row">{{$i+1}}</td>
                                <td><span class="line">{{$permission->name}}</span></td>
                                <td><span class="line">{{$permission->guard_name}}</span></td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection