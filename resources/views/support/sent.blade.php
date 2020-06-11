@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref">
            <div class="overflow-hidden banner">
                <div class="banner-welcome">
                    <div class="title mb-4">欢迎使用autosub-在线自动字幕生成</div>
                    <div class="font-size1">在这里您可以借助人工智能更高效的完成您的工作</div>
                </div>
                <img src="/images/banner.jpg">
            </div>
            <div class="mt-5">
                <div class="container" style="max-width: 480px; min-height: 250px">
                    <div class="alert alert-success lead ">
                        <p>
                            <strong>非常感谢您的反馈!</strong>
                        </p>

                        <p>
                            我们会尽快和您联系.
                        </p>
                    </div>

                    <div class="position-relative text-center">
                        <a style="color: #333;" href="/">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span class="semibold">回到首页</span>
                        </a>  </div>
                </div>

            </div>
        </div>
    </div>
@endsection
