<!-- {{{ CSS -->
<style type="text/css">
/*  メイン
-------------------------------------------------------------------*/
table {
    width:100%;
    border-top:1px solid #ccc;
}

table.main {
    border-top:1px solid #ccc;
    border-left:0px none;
    border-right:0px none;
    border-bottom:0px none;
    border-collapse:collapse;
    border-spacing:0;
}

th,
td {
    font-size:12px;
    padding:5px;
    text-align:center;
}

th {
    border-bottom:1px solid #ccc;
    border-right : 0px none;
    background:#F3F3F3;
}

td {
    border-bottom:1px solid #ccc;
    border-left : 1px solid #eee;
    text-align:left;
}

th.header1 {
    text-align:center;
    font-weight : bold;
}

th.header2 {
    font-weight : bold;
}

th.header3 {
    font-weight : bold;
}

th.header4 {
    font-weight : bold;
}

th.header5 {
    font-weight : bold;
}

td.detail1 {
    background : #fff none;
    white-space:normal;
}

td.detail2 {
    white-space:normal;
    text-align:right;
}

td.detail3 {
    white-space:normal;
    text-align:center;
}

td.detail4 {
    white-space:normal;
    vertical-align:middle;
    text-align:left;
}

td.detail5 {
    white-space:normal;
}
</style>
<!-- }}} -->
<!-- {{{ Calendar JavaScript -->
<script type="text/javascript">
<!--

var startTime, startDate,  startRoom;

var timetableDrug        = false;
var timetableFilledDrug  = false;
var timetableFilledStart = null;
var timetableFilledEnd   = null;

var num_rooms = 6;

var given_page = <?php echo date("Ymd"); ?>;

function mouseClickTimetable(date, room, time) { // {{{
    return location.href="<?php echo site_url('/reserve/reserve_register/');?>?given_date=" + date + "&time=" + time + "&staff_id="+room;
}
// }}}
function mouseDownTimetable(date,room,time){ // {{{

    document.getElementById("timetableSelecter").style.visibility = "hidden";
    
    clearTimetable();
    
    if(document.getElementById("timetable" + date + "_" + room + "_" + time )){
        document.getElementById("timetable" + date + "_" + room + "_" + time ).style.backgroundColor = "#ffcc00";
    }

    location.href="<?php echo site_url('/reserve/reserve_register/');?>?given_date=" + date + "&time=" + time + "&staff_id="+room;
    return true;
    
    startDate = date;
    startTime = time;
    startRoom = room;
    timetableDrug = true;
    
} // }}}
function mouseUpTimetable(event, date, staff_id, start_new){ // {{{
    

    if(timetableFilledDrug){
        
        var time_diff = timetableFilledEnd - timetableFilledStart;
        var end_new = start_new + time_diff;

        document.body.style.cursor = "default";

        submit_haisha_update(timetableFilledDrug, date, staff_id,  start_new, end_new, "", "", "");

        timetableFilledDrug  = false;
        timetableFilledStart = false;
        timetableFilledEnd   = false;
        
        return false;
        
    }
    
    if(startTime > time){
        timetableDrug = false;
        return false;
    }
    
    var X,Y;
    
    //マウスX位置取得
    if(document.all){X=document.body.scrollLeft+window.event.clientX;}
    else if(document.layers || document.getElementById){X=event.pageX;}
    
    //マウスY位置取得
    if(document.all){Y=(document.documentElement.scrollTop || document.body.scrollTop)+window.event.clientY;}
    else if(document.layers || document.getElementById){Y=event.pageY;}
    
    
    var doc_width = document.documentElement.scrollWidth || document.body.scrollWidth;
    if(doc_width <= X + 300){
        document.getElementById("timetableSelecter").style.left = doc_width - 320 + "px";
    }else{
        document.getElementById("timetableSelecter").style.left = X + 2 + "px";
    }

    var doc_height = document.documentElement.scrollHeight || document.body.scrollHeight;//表示領域のサイズ
    if(doc_height <= Y + 500){
        document.getElementById("timetableSelecter").style.top = doc_height - 520 + "px";
    }else{
        document.getElementById("timetableSelecter").style.top = Y + 2 + "px";
    }
    
//    document.getElementById("timetableSelecter").style.visibility = "visible";
    
    document.getElementById("reserve_id").value = "";
    document.getElementById("date").value = startDate;
    document.getElementById("room").value = startRoom;
    document.getElementById("start_time").value = startTime;
    document.getElementById("end_time").value = time + 5;
    
    
    document.getElementById("kouji_id").value = "";
    change_kouji_id();
    
    document.getElementById("sharyo_id").value = "";
    
    document.getElementById("konsai1_koushu_id").value = "";
    document.getElementById("konsai1_shubetsu_id").value = "";
    document.getElementById("konsai1_number").value = "";
    document.getElementById("konsai2_koushu_id").value = "";
    document.getElementById("konsai2_shubetsu_id").value = "";
    document.getElementById("konsai2_number").value = "";
    document.getElementById("konsai3_koushu_id").value = "";
    document.getElementById("konsai3_shubetsu_id").value = "";
    document.getElementById("konsai3_number").value = "";
    
    document.getElementById("memo").value = "";
    
    document.getElementById("status").value = 0;

    document.getElementById("record_konsai1_count").value = "";
    document.getElementById("record_konsai2_count").value = "";
    document.getElementById("record_konsai3_count").value = "";
    
    
    document.getElementById("upd_info").innerHTML = "";
    
    timetableDrug = false;
} // }}}
function mouseMoveTimetable(time, endRoom){ // {{{
    
    if(timetableDrug){
        var start_time = <?php echo Reserve_const::CALENDAR_START_TIME; ?>;
        var end_time   = <?php echo Reserve_const::CALENDAR_END_TIME; ?>;
        
        for(var i = start_time; i < end_time; i = i + 5){
            if(document.getElementById("timetable" + startDate + "_" + startRoom + "_" + i )){
                if(i >= startTime && i <= end_time){
                    document.getElementById("timetable" + startDate + "_" + startRoom + "_" + i ).style.backgroundColor = "#ffcc00";
                }else{
                    document.getElementById("timetable" + startDate + "_" + startRoom + "_" + i ).style.backgroundColor = "";
                }
            }
        }
        
    }
    
} // }}}
function clearTimetable(){ // {{{
    
    var start_time = <?php echo Reserve_const::CALENDAR_START_TIME; ?>;
    var end_time   = <?php echo Reserve_const::CALENDAR_END_TIME; ?>;

    for(var i = start_time;i < end_time; i = i + 5){
        if(document.getElementById("timetable" + startDate + "_" + startRoom + "_" + i )){
            document.getElementById("timetable" + startDate + "_" + startRoom + "_" + i ).style.backgroundColor = "";
        }
    }   
} // }}}
function mouseClickTimetable_filled( // {{{
    event,
    reserve_id,
    date,
    room,
    startTime,
    endtime,
    kouji_id,
    sharyo_id,
    konsai1_koushu_id,
    konsai1_shubetsu_id,
    konsai1_number,
    konsai1_shorijo_id,
    konsai2_koushu_id,
    konsai2_shubetsu_id,
    konsai2_number,
    konsai2_shorijo_id,
    konsai3_koushu_id,
    konsai3_shubetsu_id,
    konsai3_number,
    konsai3_shorijo_id,
    memo,
    status,
    record_start_time,
    record_end_time,
    record_konsai1_count,
    record_konsai2_count,
    record_konsai3_count,
    upd_info,
    user_id
){
    
    timetableFilledDrug = false;
    document.body.style.cursor = "default";

    //イベントの伝播を止める
    if(event.stopPropagation){
        event.stopPropagation();
    }else{
        event.cancelBubble = true;
    }
    return location.href="<?php echo site_url('/reserve/reserve_detail/index');?>/" + reserve_id;
    
    /*
    var X,Y;
    
    //マウスX位置取得
    if(document.all){X=document.body.scrollLeft+window.event.clientX;}
    else if(document.layers || document.getElementById){X=event.pageX;}
    
    //マウスY位置取得
    if(document.all){Y=(document.documentElement.scrollTop || document.body.scrollTop)+window.event.clientY;}
    else if(document.layers || document.getElementById){Y=event.pageY;}
    
    
    var doc_width = document.documentElement.scrollWidth || document.body.scrollWidth;
    if(doc_width <= X + 300){
        document.getElementById("timetableSelecter").style.left = doc_width - 320 + "px";
    }else{
        document.getElementById("timetableSelecter").style.left = X + 2 + "px";
    }
    
    var doc_height = document.documentElement.scrollHeight || document.body.scrollHeight;//表示領域のサイズ
    if(doc_height <= Y + 500){
        document.getElementById("timetableSelecter").style.top = doc_height - 520 + "px";
    }else{
        document.getElementById("timetableSelecter").style.top = Y + 2 + "px";
    }
    
    
    document.getElementById("timetableSelecter").style.visibility = "visible";
    
    document.getElementById("reserve_id").value = reserve_id;
    document.getElementById("date").value = date;
    document.getElementById("room").value = room;
    document.getElementById("start_time").value = startTime;
    document.getElementById("end_time").value = endtime;
    
    
    //▽▽▽▽▽工事ID処理（工事IDが終了している場合もある）▽▽▽▽▽▽▽▽▽
    var kouji_id_option = document.getElementById("kouji_id").getElementsByTagName("option");
    var kouji_id_option_find = false;
    for(i=0; i<kouji_id_option.length;i++){
        if(kouji_id_option[i].value == kouji_id){
            kouji_id_option[i].selected = true;
            change_kouji_id();
            kouji_id_option_find = true;//見つかった
            break;
        }
    }
    if(kouji_id_option_find==false){//見つからなかった場合
        kouji_id_option[0].selected = true;
        document.getElementById("kokyaku").innerHTML = '<span style="color:#f00;">※工事ID(' + kouji_id + ')は終了しました</span>';
        document.getElementById("genba").innerHTML = "--終了--";
        document.getElementById("basho").innerHTML = "--終了--";

    }
    //△△△△△△△△△△△△△△△△△△△△△△△△△△△△△△△△△△△
    
    document.getElementById("sharyo_id").value = sharyo_id;
    
    document.getElementById("konsai1_koushu_id").value = konsai1_koushu_id;
    document.getElementById("konsai1_shubetsu_id").value = konsai1_shubetsu_id;
    document.getElementById("konsai1_number").value = konsai1_number;
    document.getElementById("konsai1_shorijo_id").value = konsai1_shorijo_id;
    
    document.getElementById("konsai2_koushu_id").value = konsai2_koushu_id;
    document.getElementById("konsai2_shubetsu_id").value = konsai2_shubetsu_id;
    document.getElementById("konsai2_number").value = konsai2_number;
    document.getElementById("konsai2_shorijo_id").value = konsai2_shorijo_id;
    
    document.getElementById("konsai3_koushu_id").value = konsai3_koushu_id;
    document.getElementById("konsai3_shubetsu_id").value = konsai3_shubetsu_id;
    document.getElementById("konsai3_number").value = konsai3_number;
    document.getElementById("konsai3_shorijo_id").value = konsai3_shorijo_id;
    
    document.getElementById("memo").value = memo;
    
    document.getElementById("status").value = status;


    document.getElementById("record_konsai1_count").value = record_konsai1_count;
    document.getElementById("record_konsai2_count").value = record_konsai2_count;
    document.getElementById("record_konsai3_count").value = record_konsai3_count;
            
    document.getElementById("upd_info").innerHTML = upd_info;
    
    //イベントの伝播を止める
    if(event.stopPropagation){
        event.stopPropagation();
    }else{
        event.cancelBubble = true;
    }
     */
} // }}}
function mouseDownTimetable_filled(reserve_id, start_time, end_time){ // {{{

    timetableFilledDrug  = reserve_id;
    timetableFilledStart = start_time;
    timetableFilledEnd   = end_time;
    document.body.style.cursor = "move";
    
} // }}}
function submit_contact(jump){ // {{{
    
    document.getElementById('timetable').innerHTML = "読み込んでいます";
    
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "<?php echo site_url("/top/top/haisha_list/?date="); ?>" +  jump, true);
    xmlhttp.onreadystatechange = function(){
    
        if(xmlhttp.readyState == 4  && xmlhttp.status == 200){
            timetable_html = xmlhttp.responseText;
            console.log(timetable_html);
            document.getElementById('timetable').innerHTML = timetable_html;
        }

    }
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");

    //xmlhttp.send();
    var parameter = "&staff_id=" + encodeURIComponent(<?php echo $this->input->get('staff_id'); ?>);
    xmlhttp.send(parameter);
    
} // }}}

//初期化
window.onload=function(){
    
    submit_contact(<?php echo $this->date; ?>);
    
}

-->
</script><!-- }}} -->

<!-- {{{ メイン画面 -->
<div class="main">

<div id="message" style="clear:both;"></div>

<div id="timetable">読み込んでいます...</div>

</div><!-- }}}main -->

