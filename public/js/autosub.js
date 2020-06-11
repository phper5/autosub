
$(document).ready(function(){
    $(".close-button").on('click',function (e) {
        $(".editor-modal").hide();
        $("main section").hide();
        $("#_upload_file_box").show()
    });

    var progressTick;
    var callback = {
        upload_before:function (a,file) {
            $("._process_info").html('上传中……');
            $("main section").hide()
            $("#_upload_file_box").show()
            updateProcess($(".progress-bar"),-1)
            $(" ._resource_file").removeAttr('src')
            $("._resource_file").removeAttr('data_id')
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
            console.log(result);
            show_language_box();


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

ery_resource_id = getQueryVariable("resource_id");
    if ($query_resource_id) {
        editResourceById($query_resource_id);
    }
});
/**inpating*******/
