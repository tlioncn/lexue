<!--
 *
 *
 *   ______                        _____           __
 *  /_  __/__  ____ _____ ___     / ___/__  ______/ /___
 *   / / / _ \/ __ `/ __ `__ \    \__ \/ / / / __  / __ \
 *  / / /  __/ /_/ / / / / / /   ___/ / /_/ / /_/ / /_/ /
 * /_/  \___/\__,_/_/ /_/ /_/   /____/\__,_/\__,_/\____/
 *
 *
 *
 * Filename->show.blade.php
 * Project->lexue
 * Description->view to show a lecture
 *
 * Created by DM on 16/9/5 下午2:08.
 * Copyright 2016 Team Sudo. All rights reserved.
 *
-->
@extends('backend.layouts.app')

@section('content')
    <div class="ibox">
        <div class="ibox-content">
            <a href="{{ route('admins::lectures.index') }}" class="btn btn-default">
                <i class="fa fa-long-arrow-left"></i> 直播课列表
            </a>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5 class="no-margins vertical-middle">直播课信息</h5>
            <div class="ibox-tools ibox-tools-buttons">
                <?php
                $enabled = $lecture->enabled;
                $routeAction = $enabled ? 'disable' : 'enable';
                $buttonText = $enabled ? '下线' : '上线';
                $buttonClass = $enabled ? 'warning' : 'primary';
                $faClass = $enabled ? 'arrow-down' : 'arrow-up';
                ?>
                <form action="{{ route('admins::lectures.' . $routeAction, $lecture->id) }}" class="inline" method="post">
                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    <button class="btn btn-{{ $buttonClass }} btn-xs"><i class="fa fa-{{ $faClass }}"></i> {{ $buttonText }}</button>
                </form>
                <button type="button" class="btn btn-danger btn-xs"  data-toggle="modal" data-target="#lecture-delete-modal">
                    <i class="fa fa-trash"></i> 删除
                </button>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-thumb">
                            <i class="fa fa-photo"></i> 修改图片
                        </button>
                        <a href="{{ route('admins::lectures.edit', $lecture->id) }}" class="btn btn-default btn-sm">
                            <i class="fa fa-wrench"></i> 修改信息
                        </a>
                    </div>
                </div>
            </div>
            <div class="row m-t-lg">
                <div class="col-md-6">
                    <div class="lecture-image">
                        <img src="{{ $lecture->thumb->url('small') }}" alt="{{ $lecture->name }}" class="lecture-admin-thumb">
                    </div>
                    <div class="lecture-info">
                        <div class="m-b-sm">
                            <h3 class="no-margins">
                                {{ $lecture->name }}
                            </h3>
                        </div>
                        <p>
                            {{ $lecture->description }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table m-b-xs vertical-middle">
                        <tbody>
                        <tr>
                            <td>
                                <strong>教师姓名</strong>
                            </td>
                            <td>
                                <span>
                                    <a href="{{ route('students::teachers.show', $lecture->teacher_id) }}">{{ $lecture->teacher->name }}</a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>开课时间</strong>
                            </td>
                            <td>
                                <span>
                                    {{ $lecture->start_time->toDateTimeString() }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>课程时长</strong>
                            </td>
                            <td>
                                <span>
                                    {{ $lecture->length }} 分钟
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>已报名人数</strong>
                            </td>
                            <td>
                                <span>
                                    {{ $lecture->orders()->count() }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>课程费用</strong>
                            </td>
                            <td>
                                <span>
                                    {{ number_format($lecture->price, 2) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>课程状态</strong>
                            </td>
                            <td>
                                @if($lecture->finished)
                                    <span class="label label-default">已结束</span>
                                @else
                                    @if(isset($lecture->room_id))
                                        <span class="label label-success">教室已开通</span>
                                    @else
                                        <span class="label label-danger">教室未开通</span>
                                    @endif
                                @endif

                                @if($lecture->enabled)
                                        <span class="label label-primary">已上线</span>
                                    @else
                                        <span class="label label-warning">未上线</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row m-t-xs">
                <div class="col-md-6">
                    <div class="m-b-xs">
                        <strong>主讲人登录</strong> <a href="http://xue.duobeiyun.com/" target="_blank">点击登录</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><strong>邀请码</strong></span>
                        <input type="text" id="host-code" class="form-control" value="{!! $lecture->host_code !!}">
                        <span class="btn btn-info input-group-addon clipboard" data-clipboard-target="#host-code">复制</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="m-b-xs">
                        <strong>微信直播房间地址</strong>
                    </div>
                    <div class="input-group">
                        <input type="text" id="wechat-link" class="form-control" value="{{ 'http://weixin.duobeiyun.com/room/'.$lecture->room_id }}">
                        <span class="btn btn-info input-group-addon clipboard" data-clipboard-target="#wechat-link">复制</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-footer">

            <!-- TODO Add orders management -->

            <a href="#" class="btn btn-default">
                <i class="fa fa-cny"></i> 课程订单
            </a>

        </div>
    </div>

    <div class="modal inmodal fade" id="lecture-delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">删除直播课</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i> 删除后将无法恢复
                    </div>
                    即将删除课程：<br />
                    <p class="delete-info">
                        <strong>名称：</strong>{{ $lecture->name }}<br />
                        <strong>老师：</strong>{{ $lecture->teacher->name }}<br />
                        <strong>创建时间：</strong>{{ $lecture->created_at }}
                    </p>
                </div>
                <form action="{{ route('admins::lectures.destroy', $lecture->id) }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">确认删除</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="modal-thumb" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title">{{ $lecture->name }} 课程小图</h4>
                </div>
                <div class="modal-body" id="settings">
                    <div id="thumb-upload" thumb="{{ $lecture->thumb_file_name }}">
                        <div>
                            <img class="img-responsive" v-if="image" :src="image" />
                            <h4 v-else>还没有小图</h4>
                            <hr>
                            <button v-if="!added" :class="buttonClass" @click="selectFile">@{{ buttonText }}</button>
                            <button v-show="added" :disabled="uploading" class="btn btn-primary btn-sm" @click="uploadImage" data-style="zoom-in">
                            <i class="fa fa-spinner fa-spin fa-fw" v-show="uploading"></i> 确认
                            </button>
                            <button v-if="added && !uploading" class="btn btn-danger btn-sm" @click="cancelImage">取消</button>
                            <form action="{{ route('admins::lectures.thumb.upload', $lecture->id) }}" method="post" enctype="multipart/form-data">
                                <input type="file" name="thumb" class="hide" @change="onFileChange">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script type="text/javascript">
        $(function() {
            var clipboard = new Clipboard('.clipboard');

            clipboard.on('success', function() {
                toastr.success('已复制')
            });
        });
    </script>

    <script>

        new Vue({
            el: '#modal-thumb',
            props: ['thumb'],
            data() {
                return {
                    image: '',
                    added: false,
                    uploading: false
                };
            },
            computed: {
                buttonText: function() {
                    return this.thumb ? "修改" : "上传";
                },
                buttonClass: function() {
                    return this.thumb ? "btn btn-warning btn-sm" : "btn btn-primary btn-sm";
                }
            },
            ready() {
                this.image = this.thumb;
            },
            methods: {
                selectFile(e) {
                    $(e.target).siblings('form').find('input[type=file]').first().click();
                },
                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage(file) {
                    this.added = true;
                    var reader = new FileReader();
                    var vm = this;

                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                cancelImage (e) {
                    this.added = false;
                    this.image = this.thumb;
                    $('#thumb-upload').find('input[name=thumb]').val('');
                },
                uploadImage(e) {
                    var vm = this;

                    var form = $('#thumb-upload').find('form')[0];

                    this.uploading = true;

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: new FormData(form),
                        cache: false,
                        contentType: false,
                        processData: false, // Don't process the files
                        success: function(data)
                        {
                            console.log(data);
                            location.reload();
                        },
                        error: function(jqXHR, textStatus, error)
                        {
                            vm.uploading = false;
                            console.log('ERRORS: ' + textStatus + ' - ' + error);
                            toastr['error']("图片上传失败...");
                        }
                    });
                }
            }
        });

    </script>
@endsection