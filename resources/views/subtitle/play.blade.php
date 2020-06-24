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
        .card-body input.time{
            width: 80px;
        }
        .card-body input.zm{
            width: 540px;
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
        <div class="form-group row">
            <div class="col-md-2">预览方式 <input type="checkbox" name="smsenable" id="smsenable" /></div>
            <div class="col-md-10 " id="_text-info"> 提示信息</div>
        </div>
        <div class=" position-ref">
            <div class="overflow-hidden" style="background: #000;padding: 5px;">
                <div id="_video_box" class="flex-center">
                    <video id="my_video_1" class="video-js vjs-default-skin"
                           controls preload="auto"   data-setup="{}" autoplay="flase">
                        {{--                    <source src="http://demo.mimvp.com/html5/take_you_fly.ogg" />--}}
                        {{--                    <source src="http://127.0.0.1/1.mp3" />--}}
{{--                        <source src="http://127.0.0.1/2.mp4" type="video/mp4"  />--}}
                        {{--                    <source src="http://demo.mimvp.com/html5/take_you_fly.wav" />--}}
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank"
                            >supports HTML5 video</a
                            >
                        </p>
                    </video>
                </div>

                <div id="zmlist" class="flex-center"></div>


            </div>
        </div>
        <div style="display: flex;flex-direction: row;text-align: center;justify-content:space-around" class="mt-5">


                    <button class="g-recaptcha btn btn-primary" type="submit" id="_insert_new_text">编辑字幕</button>




                    <button class="g-recaptcha btn btn-primary" type="submit" id="_edit_raw">修改字幕源文件</button>

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
                        <a href="#" id="vtt_download" target="_blank">vtt格式</a>
                        <a href="#" id="srt_download" target="_blank">srt格式</a>
{{--                        <a href="#" id="ass_download" target="_blank">ass格式</a>--}}
{{--                        <a href="#" id="ssa_download" target="_blank">ssa格式</a>--}}
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

    <div class="modal fade " id="insertTextModal" tabindex="-1" role="dialog" aria-labelledby="insertTextModalable">


        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <div class="modal-header">

                    <h2>编辑字幕</h2>

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
                                <input id="_zm_id" type="hidden" value="0">
                                <textarea id="_zm_text" class="form-control " name="zm_text" value="" required="" ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="zm_duration" class="col-md-4 col-form-label text-md-right">字幕结束时间(秒)</label>

                            <div class="col-md-6" style="width: 400px;">
                                <input id="_zm_end_time" type="text" class="form-control " name="zm_end_time" value="1.0" >

                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div >
                                <button type="button" id="_edit_btn" class="btn btn-primary">
                                    确定
                                </button>
                                <button type="button" id="_delete_btn" class="btn btn-danger">
                                    删除
                                </button>
                            </div>
                        </div>

                </div>

            </div>
        </div>
    </div>

{{--    <script src="https://vjs.zencdn.net/7.8.2/video.js"></script>--}}


    <script src="/js/bootstrap-switch.min.js" defer></script>

    <link href="/css/bootstrap-switch.min.css" rel="stylesheet" />

    <script>
        $(function(){
            $('[name="smsenable"]').bootstrapSwitch({
                onText:"视频",
                offText:"音频",
                onColor:"success",
                offColor:"info",
                size:"small",
                onSwitchChange:function(event,state){
                    if(state==true){
                        switchToVideo();
                    }else{
                        switchToAudio();
                    }
                }
            })
        })



        var v = new Vtt('');
        var vid = document.getElementById("my_video_1");
        vid.addEventListener("timeupdate", function () {
            v.playTo(vid.currentTime)
        }, false);
        $(document).ready(function(){
            //add
            $("#_insert_new_text").on('click',function (e) {
                vid.pause();
                if(v.showedCueList.length>0){
                    cue = v.showedCueList[0];
                    text = cue.text;
                    start_time = cue.startTime;
                    end_time = cue.endTime;
                    id = cue.id;
                }else{
                    text = '';
                    start_time = vid.currentTime;
                    end_time = parseFloat(vid.currentTime)+1;
                    id=0;
                }
                $('#_zm_id').val(id);
                $('#_zm_text').val(text);
                $('#_zm_start_time').val(start_time);
                $('#_zm_end_time').val(end_time);
                $('#insertTextModal').modal()
            });

            $("#_edit_btn").on('click',function (e) {

                start = parseFloat($('#_zm_start_time').val());
                end = parseFloat($('#_zm_end_time').val());
                text = $('#_zm_text').val();
                id = $('#_zm_id').val();
                if(id==0 || id=="0") {
                    if (text)
                    v.insertCue(start,end,text);
                }else{
                    v.updateCue(id,start,end,text);
                }
                $('#insertTextModal').modal("hide");
                vid.play();
            });

            $("#_delete_btn").on('click',function (e) {
                v.deleteCurrentText();
                $('#insertTextModal').modal("hide");
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
                error =0;
                try{
                    v2 = new Vtt(str,1);
                    v2.parse();
                }catch (e) {
                    error = 1;
                }

                if(!error && v2.cueList.length>0){
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
        $resource_id =getResourceId();
        $("#vtt_download").attr('href','/api/subtitles/resource/'+$resource_id);
        $("#srt_download").attr('href','/api/subtitles/srt/resource/'+$resource_id);
        $("#ass_download").attr('href','/api/subtitles/ass/resource/'+$resource_id);
        $("#ssa_download").attr('href','/api/subtitles/ssa/resource/'+$resource_id);

        var mp4 = null;
        var audio = [];
        getResource($resource_id,{
            'success':function (result) {
                if (result.mp4){
                    mp4 = result.mp4.url;
                }
                if (result.ogg){
                    audio.push(result.ogg.url);
                }
                if (result.mp3){
                    audio.push(result.ogg.mp3);
                }
                if (result.wav){
                    audio.push(result.ogg.wav);
                }
                getzm($resource_id);
                play();
            }
        },{'preview':1});
        function getVideoDom($urls) {

                $source ="";
                for(i=0;i<$urls.length;i++){
                    $source = $source+'<source src="'+$urls[i]+'" />';
                }
            $html ='<video id="my_video_1" class="video-js vjs-default-skin"\n' +
                '                           controls preload="auto"   data-setup="{}" autoplay="flase">\n' +
                '                        {{--                    <source src="http://demo.mimvp.com/html5/take_you_fly.ogg" />--}}\n' +
                '                        {{--                    <source src="http://127.0.0.1/1.mp3" />--}}\n' +
                $source +
                '                        {{--                    <source src="http://demo.mimvp.com/html5/take_you_fly.wav" />--}}\n' +
                '                        <p class="vjs-no-js">\n' +
                '                            To view this video please enable JavaScript, and consider upgrading to a\n' +
                '                            web browser that\n' +
                '                            <a href="https://videojs.com/html5-video-support/" target="_blank"\n' +
                '                            >supports HTML5 video</a\n' +
                '                            >\n' +
                '                        </p>\n' +
                '                    </video>';
                return $html;
        }
        function switchToAudio() {
            if (audio.length<=0){
                alert("没有音频数据");
                return ;
            }
            $("#_video_box").html(getVideoDom(audio));
            vid = document.getElementById("my_video_1");
            vid.addEventListener("timeupdate", function () {
                v.playTo(vid.currentTime)
                $("#_zm_start_time").val(vid.currentTime)
                console.log(vid.currentTime);
            }, false);
        }
        function switchToVideo() {
            if (!mp4){
                alert("没有视频数据");
                return ;
            }
            $("#_video_box").html(getVideoDom([mp4]));
            vid = document.getElementById("my_video_1");
            vid.addEventListener("timeupdate", function () {
                v.playTo(vid.currentTime)
                $("#_zm_start_time").val(vid.currentTime)
                console.log(vid.currentTime);
            }, false);
        }
        function play() {
            $info ="";
            if (!mp4 && audio.length<=0){
                info = "没有对应的音视频数据,请等待处理,或者联系管理员";
            }
            if (!mp4 && audio.length>0){
                info = "没有视频或正在解析中,请使用音频校对";
            }
            $("#_text-info").html(info);

            if(mp4){
                $('[name="smsenable"]').bootstrapSwitch('state', true);
                // $("#_video_box").html(getVideoDom([mp4]));
            }else if(audio.length>0){
                $("#_video_box").html(getVideoDom(audio));
                $('[name="smsenable"]').bootstrapSwitch('state', false);
            }
            vid = document.getElementById("my_video_1");
            vid.addEventListener("timeupdate", function () {
                v.playTo(vid.currentTime)
                $("#_zm_start_time").val(vid.currentTime)
                console.log(vid.currentTime);
            }, false);
        }



    </script>
    <div id="overlay" style="position: relative; width: 300px; height: 150px"></div>
@endsection
