@extends('layout.layout')
@section('title', '添加管理员')
@section('cssImport')
    <style type="text/css">
        .layui-form-item .layui-inline{ width:33.333%; float:left; margin-right:0; }
        @media(max-width:1240px){
            .layui-form-item .layui-inline{ width:100%; float:none; }
        }
    </style>
@endsection

@section('content')
    <form class="layui-form" >
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" value="{{$member->username}}" {{isset($member->id) ? 'disabled' : 'name=username'}} v-length="0,18" lay-verify="required|username|length" class="layui-input {{!isset($member->id) ? '' : 'layui-disabled'}}" placeholder="请输入账号">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="text" name="password" value="" class="layui-input" v-length="8,16" placeholder="{{isset($member->id) ? '不填则不修改' : '初次请设置密码'}}" {{isset($member->id) ? '' : 'lay-verify=required|length'}}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" value="{{$member->nickname}}" placeholder="请输入真实姓名" v-length="0,20" lay-verify="required|length" class="layui-input realName">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-block">
                <img src="{{isset($member->avatar) ? asset($member->avatar) : asset('images/avatar.png')}}" class="layui-circle" id="userFace" height="120px">
                <br/><br/>
                <input type="file" name="userFace" class="layui-upload-file" lay-title="更换头像">
                <input type="hidden" name="avatar" value="{{$member->avatar or 'images/avatar.png'}}">
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户组</label>
            <div class="layui-input-block">
                @foreach($roles as $role)
                <input type="checkbox" name="role[{{$role['id']}}]" title="{{$role['name']}}" {{$role['checked'] == 1 ? 'checked' : ''}}>
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">出生年月</label>
            <div class="layui-input-block">
                <input type="text" name="birthday" value="{{$member->birthday}}" placeholder="请输入出生年月" lay-verify="date" onclick="layui.laydate({elem: this,max: laydate.now()})" class="layui-input userBirthday">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block userSex">
                <input type="radio" name="sex" value="1" title="男" {{$member->sex == 1 ? 'checked=""' : ''}}>
                <input type="radio" name="sex" value="2" title="女" {{$member->sex == 2 ? 'checked=""' : ''}}>
                <input type="radio" name="sex" value="0" title="保密" {{$member->sex == 0 ? 'checked=""' : ''}}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-block">
                <input type="tel" name="tel" value="{{$member->tel}}" placeholder="请输入手机号码" lay-verify="phone" class="layui-input userPhone">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="mail" value="{{$member->mail}}" placeholder="请输入邮箱" lay-verify="email" class="layui-input userEmail">
            </div>
        </div>



        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="submit" data-url="{{route('member@submit',['id'=>$id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@endsection

@section('jsImport')
    @jsimport(member/edit)
@endsection