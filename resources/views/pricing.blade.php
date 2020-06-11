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
            <div class="mt-5 mb-5 text-center">
                <legend class="strong">
                    充值点滴豆
                </legend>
                <div style="color: #707070">每次下载1张图片，需要1点滴豆</div>
            </div>
            <div class="text-center w-100 ">
            <div style="max-width: 1140px;margin: 0 auto;">
                <div class="pricing-overview">
                    <div class="row pricing-row">
                        <div class="pricing-column pricing-left text-center pricing-normal">
                            <div class="upper">
                                <h2 class="mb-3" style="font-size: 2rem; font-weight: 400; ">
                                    1 点滴豆
                                </h2>

                                <div style="font-size: 90%; margin-top: 27px;">
                                    <div style="text-align: center; color: #2699FB; line-height: 1; margin-bottom: 15px;">
                                        <span class="h3" style="font-size: 40px; font-weight: 400; display: inline-block; vertical-align: middle;">
                                            ¥ 1.00
                                        </span>
                                    </div>

                                    <div style="margin-bottom: 18px;">
                                        <div>
                                            <i class="fal fa-code fa-2x" style="color: #54616C;"></i>
                                        </div>
                                        <div><strong>¥ 1.00 / image</strong></div>
{{--                                        <div style="font-size: 90%;">--}}
{{--                                            无需预先购买，可在每次处理完毕后，下载时实时购买--}}
{{--                                        </div>--}}
                                    </div>

                                </div>

                                <div class="_pricing-btn">
                                    <button name="button" type="submit" class="btn btn-primary" style="min-width: 170px;" >
                                        Buy now
                                    </button>
                                </div>
                            </div>
                            <div class="lower">
                                <strong>有效期:</strong> 永久
                            </div>
                        </div>
                        <div class="pricing-column pricing-center pricing-choose">
                            <div class="best-value-ribbon" style="transform: rotate(45deg); color: #fff; font-weight: bold; text-align: center; font-size: 20px; line-height: 1; position: absolute; right: -48px; top: 20px;">
                                <div style="float: left; width: 0; height: 0;  border-left: 28px solid transparent; border-right: 28px solid transparent;  border-bottom:28px solid #ff7272; margin-right: -28px; position: relative; z-index: 15;">
                                </div>
                                <div style="float: left; background: #ff7272; width: 108px; padding: 5px 0 3px 0; height: 28px; position: relative; z-index: 20;">
                                    Best Value
                                </div>
                                <div style="float: left; width: 0;  height: 0;  border-left: 28px solid transparent; border-right: 28px solid transparent;  border-bottom:28px solid #ff7272; margin-left: -28px; position: relative; z-index: 15;"></div>
                                <div style="position: absolute; left: 0; top: 28px; z-index: 10; width: 0;  height: 0;  border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid #a54c4c;"></div>
                                <div style="position: absolute; right: 0; top: 28px; z-index: 10; width: 0;  height: 0;  border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid #a54c4c;"></div>
                            </div>

                            <div class="upper">
                                <h2 class="mb-3" style="font-size: 2rem; font-weight: 400;">
                                    40 点滴豆
                                </h2>

                                <div >
                                    <div style="text-align: center; color: #2699FB; line-height: 1; margin-bottom: 15px;">
                                        <span class="h3" style="font-size: 40px; font-weight: 400; display: inline-block; vertical-align: middle;">
                                            ¥ 20.00
                                        </span>
                                    </div>

                                    <div style="margin-bottom: 18px;">
                                        <div><i class="fal fa-code fa-2x" style="color: #54616C;"></i></div>
                                        <div><strong>¥ 0.50 / image</strong></div>
                                    </div>

                                    <div class="plan-interval-select">
                                       <a href="#">

                                            <span style="color: #FF7272;">
                                            优惠 50%
                                            </span>
                                        </a>
                                    </div>

                                    <div class="text-center _pricing-btn">
                                        <button name="button" type="submit" class="btn btn-primary" style="min-width: 170px;" >
                                            Buy now
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="lower">
                                <strong>有效期:</strong> 永久
                            </div>
                        </div>
                        <div class="pricing-column pricing-right pricing-normal">
                            <div class="upper">
                                <h2 class="mb-3" style="font-size: 2rem; ">500点滴豆</h2>
                                <div >
                                    <div style="text-align: center; color: #2699FB; line-height: 1; margin-bottom: 15px;">
                                    <span class="h3" style="font-size: 40px; font-weight: 400; display: inline-block; vertical-align: middle;" >
                                        ¥ 50.00
                                    </span>

                                    </div>

                                    <div style="margin-bottom: 18px;">
                                        <div><i class="fal fa-code fa-2x" style="color: #54616C;"></i></div>
                                        <div><strong>¥ 0.10 / image</strong></div>
                                    </div>
                                    <div class="plan-interval-select">
                                        <a href="#">

                                            <span style="color: #FF7272;">
                                            优惠 90%
                                          </span>
                                        </a>
                                    </div>

                                    <div class="text-center _pricing-btn">
                                        <button name="button" type="submit" class="btn btn-primary" style="min-width: 170px;" >
                                            Buy now
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <div class="lower">
                                <strong>有效期:</strong> 30天
                                <strong>风险:</strong> 30天后点滴豆过期，需重新购买
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script>
        var fff;
        $(document).ready(function(){
            $(".pricing-column").on("click",function (e) {
                $current = $(this);
                $p = $current.parent();
                $list = $(".pricing-column",$p);
                for ($i=0;$i<$list.size();$i++){
                    $col = $list.get($i);
                    if($col == $current.get(0)){
                        $($col).removeClass('pricing-normal');
                        $($col).addClass('pricing-choose');
                    }else{
                        $($col).removeClass('pricing-choose');
                        $($col).addClass('pricing-normal');
                    }
                }
            })
        });
    </script>
@endsection
