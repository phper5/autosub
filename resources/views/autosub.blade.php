@extends('layouts.app')
@section('app_title', config('app.name').'-在线水印自动生成')

@section('app_description', '音视频在线自动生成字幕，通过语音识别自动为用户生成音视频字幕，进行字幕翻译，字幕压制。')
@section('content')
    <script src="/ali-oss/dist/aliyun-oss-sdk.min.js"  defer="true" ></script>
    <script src="/js/autosub.js" defer="true"></script>
    <script src="/js/qrcode.min.js" defer="true"></script>
    <section class="home-section home-section-first" style="position: relative;">
        <div class="container">
            <div class="flex-center position-ref">
                <div class="mt-5">
                    <h1 class="strong text-center">
                        简单、强大的在线字幕生成工具
                    </h1>
                    <div class="mt-5 col-7" style="margin: 0 auto">autosub.cn是一款在线音视频字幕生成工具,
                        可自动通过语音识别生成字幕文件，支持所有常见的音视频格式，
                        支持SRT、ASS等字幕格式，您只需要简单上传视频，便可以自动进行语音识别生成字幕，进行字幕翻译，压制字幕文件。简单方便。</div>
                </div>
            </div>
            <div class="flex-center mt-8 mb-8">

                        <div class="home-upload-widget-wrapper">
                            <div  class="card card-with-shadow card-rounded-max card-without-border upload-widget-card">
                                <div  class="card-body text-center inpaint-demo-drop_area">
                                    <div  class="mt-5 mb-4 d-none d-md-block">
                                        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 16" height="16mm" width="22mm">
                                            <path  d="M.787 6.411l10.012 5.222a.437.437 0 0 0 .402 0l10.01-5.222a.434.434 0 0 0 .186-.585.45.45 0 0 0-.186-.187L11.2.417a.441.441 0 0 0-.404 0L.787 5.639a.439.439 0 0 0-.184.588.453.453 0 0 0 .184.184z" fill="#DDDFE1"></path><path  d="M21.21 9.589l-1.655-.864-7.953 4.148a1.31 1.31 0 0 1-1.202 0L2.444 8.725l-1.657.864a.437.437 0 0 0-.184.583.427.427 0 0 0 .184.187l10.012 5.224a.437.437 0 0 0 .402 0l10.01-5.224a.434.434 0 0 0 .186-.586.444.444 0 0 0-.186-.184z" fill="#EDEFF0"></path>
                                        </svg>
                                    </div>
                                    <div >
                                        <input type="file" id="btn_upload" name="pic" accept="audio/*,video/*" class="_file_upload _display_none">
                                        <input id="_resource_id" class="_display_none">
                                        <button  class="btn btn-primary btn-lg" style="max-width: 225px;" onclick="javascript:$('#btn_upload').click();">
                                            <i class="iconfont icon-upload font-size1 ml-1"></i>
                                            上传音视频
                                        </button>
                                    </div>
                                    <div class="mt-2 mb-4 d-none d-md-block">
                                        请点击按钮上传，或将文件拖拽到此
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container" id="_choose_language" style="display: none">
        <div class="container">

            <div class="flex-center position-ref">
                    <i class="iconfont icon-meiti font-size15 ml-1"></i>
            </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">您的文件已成功上传，请选择音视频语音</div>
                                <div class="card-body">
                                    <form method="POST" action="/autosub">
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">视频语音</label>
                                            <div class="col-md-6">
                                                <select id="_language">
                                                    <?php
                                                    foreach (config('lan.site') as $key =>$val) {
                                                        ?>
                                                        <option value="<?php echo $key;?>" ><?php echo $val;?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">翻译为</label>
                                            <div class="col-md-6">
                                                <select id="is_need_trans" onchange="toggle_trans_box()">
                                                    <option value="0" selected = "selected">不需要翻译</option>
                                                    <?php
                                                    foreach (config('lan.site') as $key =>$val) {
                                                    ?>
                                                    <option value="<?php echo $key;?>" ><?php echo $val;?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="trans_box">
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">多语言字幕是否合并</label>
                                                <div class="col-md-6">
                                                    <input type="radio" name="is_sub_merge" value="0" onclick="toggle_sub_order();">不合并
                                                    <input type="radio" name="is_sub_merge" value="1" onclick="toggle_sub_order();" checked="checked" >合并
                                                </div>
                                            </div>
                                            <div class="form-group row" id="_sub_order">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">字幕合并顺序</label>
                                                <div class="col-md-6">
                                                    <input type="radio" name="sub_order" value="0" checked="checked">源语言在前
                                                    <input type="radio" name="sub_order" value="1">翻译语言在前
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="button" class="btn btn-primary" onclick="start_task();return false;">
                                                    开始生成字幕
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


        </div>
    </section>
    <section class="container" id="_upload_file_box" style="display: none">
        <div  class="text-center pt-3 pt-md-4 inpaint-demo-drop_area">
            <button  class="btn btn-primary btn-lg "  onclick="javascript:$('#btn_upload').click();">
                <i class="iconfont icon-upload font-size1 ml-1"></i>
                重新上传音视频
            </button>
            <hr>
        </div>
        <div  class="row" style="height: 100%;">
            <div  class="col-md-8">
                <div  class="upload-tabs">
                    <div  class="upload-tab _upload_process_box active">
                        <div  class="d-inline-flex img-wrapper" style="background: rgb(221, 223, 225) none repeat scroll 0% 0%; max-width: 100%; align-items: center; justify-content: center; flex-direction: column; min-width: 100%; min-height: 260px;">
                            <div  class="progress-details"><!----> <!---->
                                <div  class="h3 text-center mb-3 _process_info" style="opacity: 0.7;">上传中...</div> <!---->
                                <div  class="progress" style="">
                                    <div  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="progress-bar" style="width: 0%;"></div>
                                </div> <!---->
                            </div> <!---->
                            <div  style="position: absolute; z-index: 10; top: 0px; left: 0px; right: 0px; bottom: 0px;">
                                <div  class="ph-item" style="border: 0px none; padding: 0px; margin: 0px; width: 100%; height: 100%; background: transparent none repeat scroll 0% 0%;">
                                    <div  class="ph-picture" style="height: 100%; background: transparent none repeat scroll 0% 0%;"></div>
                                </div>
                            </div>
                            <span ><img  ondragstart="return false;" data-hj-suppress="true" class="img-fluid"></span>
                        </div>
                    </div>
                    <div  class="upload-tab upload-tab-second _source_file_box">
                        <div  class="img-wrapper">
                            <a  href="" target="_blank" rel="noopener">
                                <img class="_resource_file" src="">
                            </a>
                            <div  class="btn-group" style="position: absolute; right: 10px; top: 10px; z-index: 20;">
                                <a href="#" data-url="/image-tools/inpainting-image?resource_id=" class="_update_url">
                                <button  type="button" class="btn btn-outline-secondary btn-sm edit-btn">
                                    <i  class="iconfont icon-qianbi"></i>
                                    图片修复工具
                                </button>
                                </a>
                                <button  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split edit-btn">
                                    <span  class="sr-only">Toggle dropdown</span>
                                </button>
                                <div  class="dropdown-menu dropdown-menu-right py-1 " style="min-width: 5rem;">
                                    <a  href="#" class="dropdown-item small px-2 _display_none _update_url">长条水印处理</a>
                                    <a  href="#"  data-url="/image-tools/watermark-removal-repeat?resource_id=" class="_update_url dropdown-item small px-2">平铺水印处理</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="upload-tab upload-tab-second _target_file_box">
                        <div  class="img-wrapper">
                            <a  href="" target="_blank" rel="noopener">
                                <img class="_resource_file " src="">
                            </a>
                            <div  class="btn-group" style="position: absolute; right: 10px; top: 10px; z-index: 20;">
                                <button  type="button" class="btn btn-primary mr-3" onclick="downloadFile(this)">
                                    <i  class="iconfont icon-download"></i>
                                    下载图片
                                </button>
                                <a href="#" data-url="/image-tools/inpainting-image?resource_id=" class="_update_url">
                                <button  type="button" class="btn btn-outline-secondary btn-sm edit-btn" onclick="editResource(this)">
                                    <i  class="iconfont icon-qianbi"></i>
                                    图片修复工具
                                </button>
                                </a>
                                <button  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split edit-btn">
                                    <span  class="sr-only">Toggle dropdown</span>
                                </button>
                                <div  class="dropdown-menu dropdown-menu-right py-1 " style="min-width: 5rem;">
                                    <a  href="#" class="dropdown-item small px-2 _display_none">长条水印处理</a>
                                    <a  href="#" class="dropdown-item small px-2 _update_url" data-url="/image-tools/watermark-removal-repeat?resource_id=">平铺水印处理</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-4 d-flex align-items-center  text-center fade-in-on-render" style="flex-direction: column;">
                <div  class="d-flex align-items-center mt-5 " style="flex: 1 1 0%; flex-direction: column;width: 100%">
                    <div  class="my-3" style="width: 100%">
                        <div  class="mb-1">
                            <div  class="ph-item" style="border: 0px none; padding: 0px; margin: 0px;">
                                <div  class="ph-row" style="margin: 0px;"><div  class="center-block" style="width: 80%; height: 40px;"></div>
                                </div>
                            </div>
                        </div>
                        <div  class="text-muted small">
                            <div  class="ph-item" style="border: 0px none; padding: 0px; margin: 0px;">
                                <div  class="ph-row" style="margin: 0px;">
                                    <div  class="center-block" style="width: 60%; height: 19px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="mb-3" style="width: 100%">
                        <div  class="mb-1">
                            <div  class="ph-item" style="border: 0px none; padding: 0px; margin: 0px;">
                                <div  class="ph-row" style="margin: 0px;">
                                    <div  class="center-block" style="width: 80%; height: 40px;"></div>
                                </div>
                            </div>
                        </div>
                        <div  class="text-muted small">
                            <div  class="ph-item" style="border: 0px none; padding: 0px; margin: 0px;">
                                <div  class="ph-row" style="margin: 0px;">
                                    <div  class="center-block" style="width: 40%; height: 19px;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!---->
            </div>
        </div>
    </section>
    <section class="container" id="_process_success" style="display: none">
        <div class="flex-center position-ref">
            <div class="mt-5">
                <h2 class="strong text-center">
                    字幕生成完毕
                </h2>
                <div class="card mt-3">
                    <div  class="card-header">字幕下载</div>
                    <div class="card-body row" id="_sub_list_box">
                        <div class="m-2"><a href="">中文字幕</a></div>
                        <div class="m-2"><a href="">中文字幕</a></div>
                    </div>
                </div>
                <div class="strong text-center mt-5">
                    <a href="#" class="btn btn-primary" id="_online_check_link">在线校验字幕</a>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" class="_display_none" value="autosub" id="_services_id">
    <style>

        #range-wrap input{
            /**transform: rotate(-90deg);**/
            width: 150px;height: 20px;transform-origin: 75px 75px;    border-radius: 15px;outline: none;position: relative;
            /**-webkit-appearance: none;**/
            margin: 15px;
            background: #cccccc;
        }
        #range-wrap input::after{display: block;content:"";width:0;height: 0;border:5px solid transparent;
            border-right:150px solid #00CCFF;border-left-width:0;position: absolute;left: 0;top: 5px;border-radius:15px; z-index: 0; }
        #range-wrap input[type=range]::-webkit-slider-thumb,#range-wrap input[type=range]::-moz-range-thumb{-webkit-appearance: none;}
        #range-wrap input[type=range]::-webkit-slider-runnable-track,#range-wrap input[type=range]::-moz-range-track {height: 10px;border-radius: 10px;box-shadow: none;}
        #range-wrap input[type=range]::-webkit-slider-thumb{-webkit-appearance: none;height: 20px;width: 20px;margin-top: -1px;
            background: #ffffff;border-radius: 50%;box-shadow: 0 0 8px #00CCFF;position: relative;z-index: 999;}


        .color-group ul{list-style: none;display: flex;}
        .color-group ul li{width: 30px;height: 30px;margin: 10px 0;border-radius: 50%;box-sizing: border-box;border:3px solid white;box-shadow: 0 0 8px rgba(0,0,0,0.2);cursor: pointer;transition: 0.3s;}
        .color-group ul li.active{box-shadow:0 0 15px #00CCFF;}

        .tools button{border-radius: 50%;width: 50px;height: 50px; background-color: rgba(255,255,255,0.7);border: 1px solid #eee;outline: none;cursor: pointer;box-sizing: border-box;margin: 0 10px;text-align: center;color:#ccc;line-height: 50px;box-shadow:0 0 8px rgba(0,0,0,0.1); transition: 0.3s;}
        .tools button.active,.tools button:active{box-shadow: 0 0 15px #00CCFF; color:#00CCFF;}
        .tools button i{font-size: 24px;}
        @media screen and (max-width: 768px) {
            .tools{bottom:auto;top:20px;}
            .tools button{width: 35px;height: 35px;line-height: 35px;margin-bottom: 15px;box-shadow:0 0 5px rgba(0,0,0,0.1);}
            .tools button.active,.tools button:active{box-shadow: 0 0 5px #00CCFF;}
            .tools button i{font-size: 18px;}
            .tools #swatches{display: none}
            .color-group{left: 0;top:auto;bottom: 20px;display: flex;
                /**width:100%;**/
                justify-content: center;text-align: center;transform: translate(0,0)}
            .color-group ul li{display: inline-block;margin:0 5px;}
            .color-group ul li.active{box-shadow:0 0 10px #00CCFF;}
            #range-wrap{right:auto;left: 20px;}
        }

    </style>

@endsection
