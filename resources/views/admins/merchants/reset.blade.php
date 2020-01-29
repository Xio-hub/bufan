@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">              
                @include ('errors.list') {{-- 引入错误文件 --}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content">
                    <form method="post" action="{{route('admin.merchant.password.update', $merchant->id)}}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">新密码</label>
                            <div class="col-sm-5"><input type="password" class="form-control" name='password'></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">确认密码</label>
                            <div class="col-sm-5"><input type="password" class="form-control" name='password_confirmation'></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white btn-lg" type="submit">Cancel</button>
                                <button class="btn btn-primary btn-lg" type="submit">确认</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
