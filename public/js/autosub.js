
$(document).ready(function(){
    $(".close-button").on('click',function (e) {
        $(".editor-modal").hide();
        $("main section").hide();
        $("#_upload_file_box").show()
    });
    function updateProcess($dom,num) {
        if (num == -1){
            $dom.attr("aria-valuenow",0)
            $dom[0].style.width="0%";
            return ;
        }
        $current = $dom.attr("aria-valuenow")
        if(num>0 && num >$current)
        {
            $current = num;
        }else{
            if ($current<20)
            {
                $current+=1;
            }
        }
        if ($current >=100){
            $current = 99
        }
        $dom.attr("aria-valuenow",$current)
        $dom[0].style.width=$current+"%";
    }
    var progressTick;
    var callback = {
        upload_before:function (a,file) {
            $("._process_info").html('上传中……');
            $("main section").hide()
            $("#_upload_file_box").show()
            updateProcess($(".progress-bar"),-1)
            $(" ._resource_file").removeAttr('src')
            $("._resource_file").removeAttr('data_id')
            showSource();
            progressTick = setInterval( function () {
                updateProcess($(".progress-bar"),0)
            },2000);
        } ,
        upload_process:function (a,file,p) {
            console.log(p)
            updateProcess($(".progress-bar"),p*100)
        },
        upload_after:function (a,file,result) {
            if (progressTick)
            {
                clearInterval(progressTick);
            }
            $("._process_info").html('上传完毕');
            $resource_id = result.data.data.resource_id;
            $("#_resource_id").val(result.data.data.resource_id);
            $("._source_file_box ._update_url").each(function(){
                $(this).attr('href',$(this).attr('data-url')+$resource_id)
            });

            console.log(result)
            $url = result.data.data.image_preview_url;
            $("._source_file_box ._resource_file").attr('src',$url)
            $("._source_file_box ._resource_file").attr('data_id',result.data.data.resource_id)
            getSub();

        },
        upload_error:function (e) {
            if (progressTick)
            {
                clearInterval(progressTick);
            }
            $("._process_info").html('上传失败');
            console.log(e)
        }
    };



    $("#btn_upload").on('change',function(e){
        upload(e.target.files[0],callback,{})
    });
    $(".inpaint-demo-drop_area").on('drop',function (e) {
        if (e.originalEvent)
            e = e.originalEvent
        console.log(e);
        fff = e
        // if (e.originalEvent) {
        //     e = e.originalEvent
        // }
        var fileList = e.dataTransfer.files; //获取文件对象
        //return ;
        //检测是否是拖拽文件到页面的操作
        if(fileList.length == 0){
            return false;
        }
        upload(fileList[0],callback,{'is_inpainting':1})
    });
    var last_time =0;
    var last_convert_id = 0;
    function getSub() {
        var timestamp = new Date().getTime();
        if (timestamp - last_time<3000)
        {
            alert("请求频繁，请等待"+(timestamp - last_time)+"毫秒");
            return;
        }
        last_time = timestamp;
        $resource_id = $("#_resource_id").val();
        $language = $("#_language_id").val();
        if (typeof($resource_id) == 'undefined' || !$resource_id) {
            alert("请先上传文件");
            return;
        }
        $("._target_file_box ._resource_file").removeAttr('src')
        $("._target_file_box ._resource_file").removeAttr('data_id')
        $("._process_info").html('处理中…');
        updateProcess($(".progress-bar"),-1)
        $("main section").hide()
        $("#_upload_file_box").show()
        let _token = getToken();
        //修复中
        $service_type = $("#_services_id").val();
        $data = {"api_token": _token,'service':$service_type,'resource_id':$resource_id,'language':$language};
        if (task_queue[last_convert_id])
        {
            clearInterval(task_queue[last_convert_id] );
        }
        progressTick = setInterval( function () {
            updateProcess($(".progress-bar"),0)
        },3000);

        apiRequest('/api/tasks','post',$data,{
            'success':function ($data) {
                //开始监听
                console.log($data);
                last_convert_id = $data.task_id;
                task_queue[last_convert_id] = setInterval( function () {
                    taskQueue($data.task_id,{
                        'success':function ($result) {
                            if (progressTick)
                            {
                                clearInterval(progressTick);
                            }
                            $("._process_info").html('处理成功');
                            $url =  $result.target_file[0].image_preview_url;
                            $("._target_file_box ._resource_file").attr('src',$url)
                            $("._target_file_box ._resource_file").attr('data_id',$result.target_file[0].resource_id)
                            $("._target_file_box ._update_url").each(function(){
                                $(this).attr('href',$(this).attr('data-url')+$result.target_file[0].resource_id)
                            });
                            showTarget();
                            console.log($url)
                        }
                    })
                },2000);

            }
        });
        console.log('start');
    }
    $query_resource_id = getQueryVariable("resource_id");
    if ($query_resource_id) {
        editResourceById($query_resource_id);
    }
});
/**inpating*******/
