<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>add product</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <!--calendar-->
    <script type="text/javascript" src="/Public/Admin/time/calendar.js"></script>
	<link rel="stylesheet" href="/Public/Admin/time/calendar.css">
    <!--editor-->
     <script type="text/javascript" charset="utf-8" src="/Public/Editor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Editor/ueditor.all.min.js"> </script>
        <script type="text/javascript" charset="utf-8" src="/Public/Editor/lang/zh-cn/zh-cn.js"></script>


<style>
   .forminfo li label{
        width: 150px;
    }
    .formtitle span{
        position:static;
        margin-right:5px;
        border-bottom:none;
        cursor:pointer;

    }
    .formtitle span.current{
        border-bottom:3px solid blue;
    }

    .forminfo{
        display:none;
    }

    .forminfo:first-child{
        display:block;
    }
    /*resolve conflict of css style*/
    .calendar .nav{
        float:none;
    }
    /*editor style*/
    .textinput2{
        width: 800px;
        height: 300px;
        border:none;
    }
    .add{
        cursor:pointer;
    }
</style>
</head>
<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span class="current">基本信息</span><span>商品描述</span><span>商品屬性</span></div>
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>product name</label>
                    <input name="product_name" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>product price</label>
                    <input name="product_price" placeholder="请输入商品价格" type="text" class="dfinput" value="99" /><i></i></li>
                <li>
                    <label>product quantity</label>
                    <input name="product_number" placeholder="请输入商品数量" type="text" class="dfinput" value="99" />
                </li>
                <li>
                    <label>create time</label>
                    <input id="update" name="created_time" placeholder="请输入添加時間" type="text" class="dfinput" />
                </li>
                <li>
                    <label>product weight</label>
                    <input name="product_weight"  type="text" class="dfinput" placeholder="请输入商品重量" value="50"/>
                </li>
                <li>
                    <label>product logo</label>
                    <input name="product_big_logo[]" type="file"  />
                </li>

                <li><label>put on shelf?</label><cite><input name="is_show" type="radio" value="1" checked="checked" />onshelf&nbsp;&nbsp;&nbsp;&nbsp;<input name="is_show" type="radio" value="0" />offshelf</cite>
                </li>



            </ul>
            <ul class="forminfo">
                <li>
                    <label>product description</label>
                    <textarea name="product_desc" placeholder="请输入商品描述" id='product_desc' cols="" rows="" class="textinput textinput2"></textarea>
                </li>
            </ul>
            <ul class="forminfo product_attr_cate">
                <li>
                    <label>product type list</label>
                    <select name="type_id" class="dfinput">
                        <option value="0">--请选择--</option>
                        <?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["type_id"]); ?>" /><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
            </ul>
            <ul class="btn">
                <li>
                    <input id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>

</html>
<script>
   //tab selection and section hidding------------------
    $('.formtitle span').click(function(){
//add underline to current tab
       $(this).addClass('current').siblings().removeClass('current');
 //show only the corresponding section
        $('.forminfo').eq($(this).index()).show(500).siblings('.forminfo').hide();
    });
//calender plugin -----------------------
     Calendar.setup({
        inputField     :    "update",
        ifFormat       :    "%Y-%m-%d %H:%M:%S",
        showsTime      :    true,
        timeFormat     :    "12"
    });
//ueditor plugin----------------
    var ue=UE.getEditor('product_desc',{
       initialFrameWidth:800,
       initialFrameHeight:200,
         toolbars: [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|'
        ]]
    });
//ajax linking product type with product attribute categories form
    $('select[name=type_id]').change(function () {
        var current = $(this).val();
        //prevent from sending request via ajax if current value ==0
        if (current ==0){
            return false;
        }
        //remove old attribute items
        $('.newItem').remove();
        //save select tab obj for appending new items after li
        var _this =$(this);
        //send ajax request by get
        $.get('<?php echo U("Products/getAttrCateById");?>',{'type_id':current},function (data) {
            //group li string together
            var html='';
            //for each object items  from json, traversate using foreach
            $(data).each(function (key,value) {
            html+="<li class='newItem'>";
            html+='<label><span class="add">[ + ]</span>'+value.attr_cate_name+'</label>';
                //if cate expression =0 -->it is a text input, if its 1 it is a list
                if (value.attr_cate_exp == 0){
//                    add a hidden input that saves attribute category id and name in 2 arrays, from the index we can traversate it
            html+='<input type="hidden" name="attr_cate_ids[]" value="'+value.attr_cate_id+'">';
            html+='<input name="attr_values[]" placeholder="please enter'+value.attr_cate_name+'" type="text" class="dfinput" /><i></i>';
                }else{
             //split the string of category values into individual element
            var vals = value.attr_cate_val.split(',');
             html+='<input type="hidden" name="attr_cate_ids[]" value="'+value.attr_cate_id+'">';
            html+='<select name="attr_values[]" class="dfinput">';
            //loop each attribute value in the category
            for(var i=0;i<vals.length;i++ ){
                //i as the index in the array startying from 0,  vals[i] is the actual value string
            html+='<option value="'+vals[i]+'">'+vals[i]+'</option>';
            }
            html+='</select>';
                }
            html+='</li>';
            });
            _this.parent().after(html);
        });
    });
    //add new product attr cate--------------------------------------
    $('.product_attr_cate').on('click','.add',function () {
        var newLi =$(this).parents('.newItem').clone().find('span').html('[ - ]').removeClass('add').addClass('div').parents('.newItem');
        //add new cloned li after current item
        $(this).parents('.newItem').after(newLi);
    });
    //remove product attr cate-------------------------------------
    $('.product_attr_cate').on('click','.div',function () {
        $(this).parents('li').remove();
    });

</script>