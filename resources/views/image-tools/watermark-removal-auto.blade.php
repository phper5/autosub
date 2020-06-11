@extends('layouts.app')
@section('app_title', config('app.name').'-自动水印清除工具')

@section('app_title', config('app.name').'-自动水印清除工具')
@section('app_description', '在线自动清除水印，无需下载，可以方地在线处理，借助人工智能，更便捷的去除图片水印。')
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
                            <div class="col-md-12 mb-4 mt-5 row">
                                <div class="ml-3 line_height_35">选择您的音视频语言</div>
                                <select class="ml-3" id="_language_id">
                                    <?php foreach (config('lan.site') as $key=>$val) {
                                       ?><option value="<?php echo $key;?>"><?php echo $val;?></option><?php
                                    }?>
                                </select>
                                <input type="radio" value="0" name="compress_type" class="ml-5 _display_none">
                                <div class="ml-3 line_height_35 _display_none">压缩到(kb)</div>
                                <input class="input_100 _display_none" id="compress_target_size">
                            </div>
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
    <div  class="download-modal" style="display: none">
        <div  class="download-modal-backdrop"></div>
        <div class="download-modal-inner">
            <div class="download-modal-content" >
                <h2>
                    下载图片
                </h2>
                <div class="row">
                    <div class="col-md-8">
                        <div class="img-wrapper d-block mx-auto">
                            <img id="_download_preview" src="">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex " style="flex-direction: column; flex-direction: column; justify-content: flex-end; ">
{{--                        <p class="text-primary h3 mt-2 mb-0">--}}
{{--                            1 点滴豆/图--}}
{{--                        </p>--}}
{{--                        <p>--}}
{{--                            <span class="hover-tooltip" >--}}
{{--                                <a class="text-muted small" target="_blank" >--}}
{{--                                    点滴豆是什么?--}}
{{--                                </a>--}}
{{--                            </span>--}}
{{--                        </p>--}}
                        <div class="price_info"><span class="original-price"><i>￥</i>5</span>
                            <span><i>￥</i>1</span></div>
                    </div>
                </div>
                <div class="text-muted small mt-2">
                    图像大小
                    <span id="_download_image_info">1600 × 1600</span>
                </div>

                <hr>

                <div class="text-center">

                    <div class="mb-4" id="_download_id_box">
                        <a onclick="closeDownload();return true" class="btn btn-primary" href="" target="_blank" id="_download_id">下载文件</a>
                    </div>
                    <div class="mb-4" id="_pay_box" style="display: none">
                        <div class="col-md-12" id="_pay_qrcode">

                        </div>
                        <div class="col-md-12 mt-4" >
                            <span class="alipay">支付宝</span>
                        </div>

                    </div>
                    <hr>

                    <div class="mt-2 small _display_none ">
                        注册用户，最高优惠至<span><i>￥</i>0.10</span> <a href="#">登录</a>
                    </div>
                </div>
                <button title="Close (Esc)" onclick="closeDownload(this)" type="button" class="mfp-close">×</button>
            </div>
        </div>
    </div>
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
    <input type="hidden" class="_display_none" value="watermark-long-text" id="_services_id">
    <style>
        ._workBox{
            display: none;
        }
        #save{
            display: none;
        }
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

        .color-group{
            margin-left: 10px;
            /*position:fixed;width: 30px;left: 30px;top:50%;transform: translate(0,-150px)*/
        }
        .color-group ul{list-style: none;display: flex;}
        .color-group ul li{width: 30px;height: 30px;margin: 10px 0;border-radius: 50%;box-sizing: border-box;border:3px solid white;box-shadow: 0 0 8px rgba(0,0,0,0.2);cursor: pointer;transition: 0.3s;}
        .color-group ul li.active{box-shadow:0 0 15px #00CCFF;}

        .tools{
            /**position: fixed;left:0;bottom: 30px; width:100%;**/
            display: flex;justify-content: center;text-align: center
        }
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
        .toolinfo{
            vertical-align: bottom;
            width:4rem;
        }
        #drawTools {
            display: flex;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        #drawTools {
            display: flex;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        .toolbox {
            display: flex;
            margin: 0 10px;
            flex-direction: column;
        }
        .toolbox ul {
            margin: 0 auto;
            padding: 0;
        }
        #drawing-board{
            /**background: #999999;**/
            display: block;cursor: crosshair;
            width: 300px;
            height: 150px;
            background-size: 100%;
        }
    </style>
    <script type="application/javascript">
        let canvas = document.getElementById("drawing-board");
        let ctx = canvas.getContext("2d");
        let eraser = document.getElementById("eraser");
        let brush = document.getElementById("brush");
        let reSetCanvas = document.getElementById("clear");
        let aColorBtn = document.getElementsByClassName("color-item");
        let save = document.getElementById("save");
        let undo = document.getElementById("undo");
        let range = document.getElementById("range");
        let clear = false;
        let activeColor = 'black';
        let lWidth = document.getElementById("range").value;
        // canvas.width = '700';
        // canvas.height = '700';
        setCanvasBg('white');
        listenToUser(canvas);
        getColor();
        function setCanvasBg(color) {
            return ;
            ctx.fillStyle = color;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "black";
        }

        function getXy(e) {

            let x = e.clientX;
            let y = e.clientY;
            let l = canvas.getBoundingClientRect().left;
            let t = canvas.getBoundingClientRect().top;
            point = {"x": x-l, "y": y-t};
            // point = {"x": x+0, "y": y+0};
            return point;
        }

        function listenToUser(canvas) {
            let painting = false;
            let lastPoint = {x: undefined, y: undefined};

            if (document.body.ontouchstart !== undefined) {
                canvas.ontouchstart = function (e) {
                    this.firstDot = ctx.getImageData(0, 0, canvas.width, canvas.height);//在这里储存绘图表面
                    saveData(this.firstDot);
                    painting = true;
                    // let x = e.touches[0].clientX;
                    // let y = e.touches[0].clientY;
                    lastPoint=getXy(e.touches[0]);
                    // lastPoint = {"x": x, "y": y};
                    ctx.save();
                    drawCircle(lastPoint.x, lastPoint.y, 0);
                };
                canvas.onwheel = function(event){
                    event.preventDefault();
                };
                canvas.onmousewheel = function(event){
                    event.preventDefault();
                };
                canvas.ontouchmove = function (e) {
                    if (painting) {
                        // let x = e.touches[0].clientX;
                        // let y = e.touches[0].clientY;
                        // let newPoint = {"x": x, "y": y};
                        let newPoint=getXy(e.touches[0]);
                        drawLine(lastPoint.x, lastPoint.y, newPoint.x, newPoint.y);
                        lastPoint = newPoint;
                    }
                    e.preventDefault();
                };

                canvas.ontouchend = function (e) {
                    painting = false;
                    e.preventDefault();
                }
            } else {
                canvas.onmousedown = function (e) {
                    this.firstDot = ctx.getImageData(0, 0, canvas.width, canvas.height);//在这里储存绘图表面
                    saveData(this.firstDot);
                    painting = true;
                    // let x = e.clientX;
                    // let y = e.clientY;
                    let point=getXy(e);
                    ctx.save();
                    drawCircle(point.x, point.y, 0);
                };
                canvas.onmousemove = function (e) {
                    //console.log('move'+painting);

                    if (painting) {
                        // let x = e.clientX;
                        // let y = e.clientY;
                        // let newPoint = {"x": x, "y": y};
                        let newPoint=getXy(e);
                        drawLine(lastPoint.x, lastPoint.y, newPoint.x, newPoint.y,clear);
                        lastPoint = newPoint;
                    }
                };

                canvas.onmouseup = function () {
                    painting = false;
                    //console.log('up'+painting);
                    lastPoint =  {x: undefined, y: undefined};;
                };

                canvas.mouseleave = function () {
                    painting = false;
                }
            }
        }

        function drawCircle(x, y, radius) {
            ctx.save();
            ctx.beginPath();
            ctx.arc(x, y, radius, 0, Math.PI * 2);
            ctx.fill();
            if (clear) {
                ctx.clip();
                ctx.clearRect(0,0,canvas.width,canvas.height);
                ctx.restore();
            }
        }

        function drawLine(x1, y1, x2, y2) {
            ctx.lineWidth = lWidth;
            ctx.lineCap = "round";
            ctx.lineJoin = "round";
            if (clear) {
                ctx.save();
                ctx.globalCompositeOperation = "destination-out";
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.closePath();
                ctx.clip();
                ctx.clearRect(0,0,canvas.width,canvas.height);
                ctx.restore();
            }else{
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.closePath();
            }
        }

        range.onchange = function(){
            lWidth = this.value;
        };

        eraser.onclick = function () {
            clear = true;
            this.classList.add("active");
            brush.classList.remove("active");
        };

        brush.onclick = function () {
            clear = false;
            this.classList.add("active");
            eraser.classList.remove("active");
        };

        reSetCanvas.onclick = function () {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            //setCanvasBg('white');
        };

        save.onclick = function () {
            let imgUrl = canvas.toDataURL("image/png");
            let saveA = document.createElement("a");
            document.body.appendChild(saveA);
            saveA.href = imgUrl;
            saveA.download = "zspic" + (new Date).getTime();
            saveA.target = "_blank";
            saveA.click();
        };

        function getColor(){
            for (let i = 0; i < aColorBtn.length; i++) {
                aColorBtn[i].onclick = function () {
                    $(brush).click();
                    for (let i = 0; i < aColorBtn.length; i++) {
                        aColorBtn[i].classList.remove("active");
                        this.classList.add("active");
                        activeColor = this.style.backgroundColor;
                        ctx.fillStyle = activeColor;
                        ctx.strokeStyle = activeColor;
                    }
                }
            }
        }

        let historyDeta = [];

        function saveData (data) {
            (historyDeta.length === 10) && (historyDeta.shift());// 上限为储存10步，太多了怕挂掉
            historyDeta.push(data);
        }

        undo.onclick = function(){
            if(historyDeta.length < 1) return false;
            ctx.putImageData(historyDeta[historyDeta.length - 1], 0, 0);
            historyDeta.pop()
        };
    </script>
@endsection
