@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref">
            <div class="overflow-hidden banner">
                <div class="banner-welcome">
                    <div class="title mb-4">欢迎使用autosub</div>
                    <div class="font-size1">在这里您可以借助人工智能更高效的完成您的工作</div>
                </div>
                <img src="/images/banner.jpg">
            </div>
            <div class="mt-5">
                <h1 class="strong">
                    简单、强大的在线字幕生成工具
                </h1>
                <div class="mt-5">autosub.cn是一款在线音视频字幕生成工具，</div>
            </div>
            <div class="text-center w-100 ">
                <div class="d-flex mt-4 mb-4">
                    <div class="flex-grow-1">
                        <hr>
                    </div>
                    <div class="pt-1 px-3 _display_none">
                        <h3 class="h6">应用列表:</h3>
                    </div>
                    <div class="flex-grow-1">
                        <hr>
                    </div>
                </div>
                <div class="row homelist">
                    <div class="col-md-6">
                        <a href="/image-tools/inpainting-image">
                            <div>
                                <i class="iconfont icon-image-inpainting font-size5" style="color: rgb(171, 105, 147);"></i>
                            </div>
                            <div style="line-height: 1.5;">
                                <p>
                                    图片修复/去水印
                                </p>
                            </div></a>
                    </div>


                    <div class="col-md-6">
                        <a href="/image-tools/watermark-removal-auto">
                        <div>
                            <i class="iconfont icon-watermark-repeat font-size5" style="color: rgb(143, 188, 93);"></i>
                        </div>
                        <div style="line-height: 1.5;">
                            <p>
                                自动水印清除
                            </p>
                        </div></a>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
