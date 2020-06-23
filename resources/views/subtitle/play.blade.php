@extends('layouts.app')

@section('content')
    <style>
        video{
            background: #0b0b0b;
            width: 80%;
            height:500px;
        }
        #zmlist{
            font-size: 2.25rem;
            min-height: 80px;
            background: #000;
            color: #fff;
        }
        #zmlist .zmtext{
            padding: 10px;
        }
        #_zm_edit_text_box textarea{
            min-height: 300px;
        }
    </style>
    <link href="https://vjs.zencdn.net/7.8.2/video-js.css" rel="stylesheet" />

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="/js/myvtt.js"></script>


    <div class="container">
        <div class="flex-center position-ref">
            <div class="mt-5">
                <h1 class="strong text-center">
                    在线校验字幕
                </h1>
                <div class="mt-5 col-7 mb-5" style="margin: 0 auto">
                    在线校验字幕可以对语音生成的字幕据进行试听预览,编辑,删除,插入等操作。修复语音识别中的错误,制作成完整正确的字幕</div>
            </div>
        </div>
        <div class="flex-center position-ref">
            <div class="overflow-hidden" style="background: #000;padding: 5px;">

                <video id="my_video_1" class="video-js vjs-default-skin"
                       controls preload="auto"  poster="my_video_poster.png" data-setup="{}" autoplay="true">
                    {{--                    <source src="http://demo.mimvp.com/html5/take_you_fly.ogg" />--}}
{{--                    <source src="http://127.0.0.1/1.mp3" />--}}
                    <source src="http://127.0.0.1/2.mp4" type="video/mp4"  />
{{--                    <source src="http://demo.mimvp.com/html5/take_you_fly.wav" />--}}
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank"
                        >supports HTML5 video</a
                        >
                    </p>
                </video>
                <div id="zmlist" class="flex-center"></div>


            </div>
        </div>
        <div style="display: flex;flex-direction: row;text-align: center;justify-content:space-around" class="mt-5">


                    <button class="g-recaptcha btn btn-primary" type="submit" id="_insert_new_text">插入新字幕</button>


                <button class="g-recaptcha btn btn-primary" type="submit" id="_edit_current_text">编辑当前字幕</button>


                    <button class="g-recaptcha btn btn-primary" type="submit" id="_delete_current_text">删除当前字幕</button>



                    <button class="g-recaptcha btn btn-primary" type="submit" id="_edit_raw">修改字幕文件</button>

                <button class="g-recaptcha btn btn-primary" type="submit" id="_save_text">保存修改</button>


            </div>

    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">字幕下载</div>

                <div class="card-body">
                    如有修改,请先保存
                    <div  style="display: flex;flex-direction: row;text-align: center;justify-content:space-around" >
                        <a href="#">vtt格式</a>
                        <a href="#">srt格式</a>
                        <a href="#">ass格式</a>
                        <a href="#">ssa格式</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="deleteTextModal" tabindex="-1" role="dialog" aria-labelledby="deleteTextModalable">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <div class="modal-header">

                    <h2>是否确认删除?</h2>

                </div>
                <div class="modal-body flex-center">
                    <div  id="_zm_del_text_box">

                    </div>
                    <div class="form-group row mb-0">
                        <div >
                            <button type="button" id="_delete_btn" class="btn btn-danger">
                                确定
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="modal fade " id="rawTextModal" tabindex="-1" role="dialog" aria-labelledby="rawTextModalable">
        <div class="modal-dialog" role="document" >
            <div class="modal-content"  style="width: 700px;">
                <div class="modal-header">

                    <h2>字幕内容</h2>
                    <span class="text-red">请注意格式,谨慎修改</span>
                </div>
                <div class="modal-body flex-center">
                    <div  id="_zm_raw_text_box" style="min-height: 500px;width: 100%;">
                        <textarea  id="raw_text" class="form-control " name="zm_text"  required=""  style="min-height: 600px;width: 100%;"></textarea>
                    </div>
                    <div class="form-group row mb-0">
                        <div >
                            <button type="button" id="_raw_btn" class="btn btn-primary">
                                确定
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="modal fade " id="editTextModal" tabindex="-1" role="dialog" aria-labelledby="editTextModalable">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">

                <div class="modal-body flex-center">
                    <div  id="_zm_edit_text_box">

                    </div>
                    <div class="form-group row mb-0">
                        <div >
                            <button type="button" id="_edit_btn" class="btn btn-primary">
                                确定
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="modal fade " id="insertTextModal" tabindex="-1" role="dialog" aria-labelledby="insertTextModalable">


        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <div class="modal-header">

                    <h2>请输入字幕</h2>

                </div>
                <div class="modal-body flex-center" >

                        <div class="form-group row" >
                            <label for="zm_start_time" class="col-md-4 col-form-label text-md-right">字幕开始时间(秒)</label>

                            <div class="col-md-6" style="width: 400px;">
                                <input id="_zm_start_time" type="text" class="form-control " name="zm_start_time" value="0" required="" >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zm_text" class="col-md-4 col-form-label text-md-right">字幕内容</label>

                            <div class="col-md-6" style="width: 400px;">
                                <textarea id="_zm_text" class="form-control " name="zm_text" value="" required="" ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="zm_duration" class="col-md-4 col-form-label text-md-right">字幕持续时长(秒)</label>

                            <div class="col-md-6" style="width: 400px;">
                                <input id="_zm_duration" type="text" class="form-control " name="zm_duration" value="1.0" >

                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div >
                                <button type="button" id="_insert_btn" class="btn btn-primary">
                                    插入
                                </button>
                            </div>
                        </div>

                </div>

            </div>
        </div>
    </div>
{{--    <script src="https://vjs.zencdn.net/7.8.2/video.js"></script>--}}



    <script>
        var vid = document.getElementById("my_video_1");

        var v = new Vtt('');
        vid.addEventListener("timeupdate", function () {
            v.playTo(vid.currentTime)
            $("#_zm_start_time").val(vid.currentTime)
            console.log(vid.currentTime);
        }, false);
        $(document).ready(function(){
            //add
            $("#_insert_new_text").on('click',function (e) {
                vid.pause();
                $('#_zm_text').val('');
                $('#insertTextModal').modal()
            });

            $("#_insert_btn").on('click',function (e) {

                start = $('#_zm_start_time').val();
                text = $('#_zm_text').val();
                end =  parseFloat($('#_zm_duration').val())+ parseFloat(start);
                v.insertCue(start,end,text);
                $('#insertTextModal').modal("hide");
                vid.play();
            });
            //edit
            $("#_edit_current_text").on('click',function (e) {
                vid.pause();
                var str ='';
                if(v.showedCueList.length>0){
                    for(i=0;i<v.showedCueList.length;i++){
                        cue = v.showedCueList[i];
                        str +='<textarea  class="form-control " name="zm_text"  required="" >'+cue.text+'</textarea>';
                    }
                }else{
                    str = "当前位置没有字幕";
                }

                $('#_zm_edit_text_box').html(str);
                $('#editTextModal').modal()
            });
            $("#_edit_btn").on('click',function (e) {
                list = $('#_zm_edit_text_box textarea');
                for(i=0;i<list.size();i++)
                {
                    v.showedCueList[i].text = list.eq(i).val()
                }
                $('#editTextModal').modal("hide");
                vid.play();
            });
            //del
            $("#_delete_current_text").on('click',function (e) {
                $('#deleteTextModal').modal();
                var str ='<div class="mb-4">字幕内容:</div>';
                if(v.showedCueList.length>0){
                    for(i=0;i<v.showedCueList.length;i++){
                        cue = v.showedCueList[i];
                        str +='<div  >'+cue.text+'</div>';
                    }
                }else{
                    str = "当前位置没有字幕";
                }

                $('#_zm_del_text_box').html(str);
                vid.pause();
            });
            $("#_delete_btn").on('click',function (e) {
                v.deleteCurrentText();
                $('#deleteTextModal').modal("hide");
                vid.play();
            });
            $("#_save_text").on('click',function (e) {
                let _token = getToken();
                $param_data = {'token':_token,'subtitle':v.getRawText()};
                apiRequest('/api/subtitles/resource/'+$resource_id,'put',$param_data,{
                    'success':function ($data) {
                        alert("更新成功");
                    }
                });
                console.log('start');

            });

            //raw
            $("#_edit_raw").on('click',function (e) {
                vid.pause();
                $("#raw_text").val(v.getRawText());
                $('#rawTextModal').modal()
            });
            $("#_raw_btn").on('click',function (e) {
                str = $("#raw_text").val();
                str = str.trim()+"\n\n";
                v2 = new Vtt(str);
                v2.parse();
                if(v2.cueList.length>0){
                    v.cleanShow();
                    v = v2;
                    $('#rawTextModal').modal("hide")
                    vid.play();
                }else{
                    alert('格式错误,或者没有字幕请检查');
                }

            });


        });

        //读取字幕
        function getzm($resource_id) {
            let _token = getToken();
            $param_data = {'token':_token};
            apiRequest('/api/subtitles/resource/'+$resource_id,'get',$param_data,{
                'success':function ($data) {
                    v = new Vtt($data);
                    v.parse();
                }
            },'text');
            console.log('start');
        }
        function getResourceId()
        {
            var query = window.location.toString();
            var vars = query.split("/");
            var last = vars[vars.length-1].split("?");
            return last[0];
        }
        getzm(getResourceId())


    </script>
    <div id="overlay" style="position: relative; width: 300px; height: 150px"></div>
@endsection
