<!-- {{{ CSS -->
<style type="text/css">
/*  メイン
-------------------------------------------------------------------*/

div.main {
    width: 100%;
}

/* フロート回り込み解除
----------------------------------------------- */
.clearfix:after {
    display: block;
    clear: both;
    height: 0px;
    line-height: 0px;
    visibility: hidden;
    content: ".";
}
.clearfix {
    display: block; /* for IE8 */
}

/* ナビ 
-------------------------------------------------------------------*/
#checkbox label {
    float: left; 
    margin-right: 3em;
}
#month_calendar {
    float: left;
    width: 13%;
}
#time_schedule {
    float: right;
    width: 85%;
}

/*  テーブル
-------------------------------------------------------------------*/
table.main {
    margin:20px 0;
    width: 100%;
}

#calendar th,
#calendar td {
    padding:2px;
    white-space:nowrap;
    vertical-align:top;
    text-align: center;
}
/*
#calendar td {
    border: 1px solid #CCC;
}
*/
#timetableSelecter th,
#timetableSelecter td {
    padding: 1px 7px;
}

th {
    /*border-bottom:1px solid #CCC;*/
    border-right:0px none;
    text-align:left;
    font-size:12px;
    line-height:1.5em;
}

td {
    border-bottom:1px solid #CCC;
    border-left:1px dotted #CCC;
    font-size:12px;
    line-height:1.5em;
}

/*
th.header1 {
    background:#F2F2F2;
    text-align:center;
    font-weight:bold;
}
*/

/*
th.header1 {
th.header2 {
    background:#F2F2F2;
    font-weight:bold;
}
*/

th.header3 {
    background-color:#fff;
    font-weight:bold;
}

th.header4 {
    background-color:#fff;
    font-weight:bold;
}

th.header5 {
    background-color:#fff;
    font-weight:bold;
    width:250px;
}

td.detail1 {
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
    width:660px;
}

td.timetable {
    /*width: 17px;*/
    width: 3.5%;
    height: 85px;
}

td.timetable_filled {
    padding: 5px 1px;
    
}
/*
td.attend {
    width: 3%;
    background-color: #6ff;
    text-align: center;
}
td.no-attend {
    width: 3%;
    background-color: #f80;
    text-align: center;
}
*/

tr.no_schedule {
    display: none;
}
</style>
<!-- }}} -->
<!-- {{{ Calendar JavaScript -->
<script type="text/javascript">
<!--

var startTime, startDate,  startRoom;

var timetableDrag        = false;
var timetableFilledDrag  = false;
var timetableFilledStart = null;
var timetableFilledEnd   = null;

var num_rooms = 6;

var given_page = <?php echo date("Ymd"); ?>;
var schedule_sticky_flag = true; // 固定: true, 解除: false

function sticky(no_display_flag) // {{{
{
    if( $("#sticky:checked").val() ){
        schedule_sticky_flag = true;
        if(false == no_display_flag){
            alert("スケジュールを固定しました");
        }
    } else {
        schedule_sticky_flag = false;
        if(false == no_display_flag){
            alert("スケジュールの固定を解除しました。\nドラッグ＆ドロップでスケジュールの移動が可能です。");
        }
    }

    save_checkbox_status_in_cookie();
} // }}}
function toggle_staff_table() // {{{
{
    $('.no_schedule').toggle();
    save_checkbox_status_in_cookie();
} // }}}
function changeDateSearch(){ // {{{
    if( schedule_sticky_flag == true ){
        return false;
    }
    
    var val1 = document.getElementById("date_search").value;
    
    var dt = new Date(Number(val1.slice(0,4)),Number(val1.slice(4,6))-1,Number(val1.slice(6,8)));
    
    var td = new Date();
    
    var diffDay = Math.ceil((dt - td) / 86400000);//1日は86400000ミリ秒
    
    given_page = diffDay;
    
    submit_contact(given_page);
    
} // }}}
function mouseClickTimetable(date, room, time) { // {{{
    return location.href="<?php echo site_url('/reserve/reserve_register/');?>?given_date=" + date + "&time=" + time + "&staff_id="+room;
}
// }}}
function mouseDownTimetable(date,room,time){ // {{{

    if( schedule_sticky_flag == true ){
        return false;
    }
    
    clearTimetable();
    
    if(document.getElementById("timetable" + date + "_" + room + "_" + time )){
        document.getElementById("timetable" + date + "_" + room + "_" + time ).style.backgroundColor = "#ffcc00";
    }

    location.href="<?php echo site_url('/reserve/reserve_register/');?>?given_date=" + date + "&time=" + time + "&staff_id="+room;
    return true;
    
    startDate = date;
    startTime = time;
    startRoom = room;
    timetableDrag = true;
    
} // }}}
function mouseUpTimetable(event, date, staff_id, start_new){ // {{{

    if( schedule_sticky_flag == true ){
        return false;
    }

    if(timetableFilledDrag){
        
        var time_diff = timetableFilledEnd - timetableFilledStart;
        var end_new = start_new + time_diff;

        document.body.style.cursor = "default";

        submit_haisha_update(timetableFilledDrag, date, staff_id,  start_new, end_new, "", "", "");

        timetableFilledDrag  = false;
        timetableFilledStart = false;
        timetableFilledEnd   = false;
        
        return false;
    }

} // }}}
function mouseMoveTimetable(time, endRoom){ // {{{
    
    if( schedule_sticky_flag == true ){
        return false;
    }
    if(timetableDrag){
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
    
    if( schedule_sticky_flag == true ){
        return false;
    }
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
    
    timetableFilledDrag = false;
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

    if( schedule_sticky_flag == true ){
        return false;
    }

    timetableFilledDrag  = reserve_id;
    timetableFilledStart = start_time;
    timetableFilledEnd   = end_time;
    document.body.style.cursor = "move";
    
} // }}}
function submit_haisha_update(reserve_id, date, staff_id, start_time, end_time) // {{{
{

    if( schedule_sticky_flag == true ){
        return false;
    }
    document.getElementById("message").innerHTML = "予約情報の送信中です...";

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "<?php echo site_url('/reserve/reserve_edit/haisha_update/'); ?>", true);
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4  && xmlhttp.status == 200){
            //document.getElementById("timetableSelecter").style.visibility = "hidden";
            document.getElementById("message").innerHTML = xmlhttp.responseText;
            
            if(date!==""){
                submit_contact(date);
            }else{
                submit_contact(given_page);
            }
        }
    }
    
    var parameter = "reserve_id=" + encodeURIComponent(reserve_id)
    + "&date=" + encodeURIComponent(date)
    + "&staff_id=" + encodeURIComponent(staff_id)
    + "&start_time=" + encodeURIComponent(start_time)
    + "&end_time=" + encodeURIComponent(end_time)
    ;
    
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
    xmlhttp.send(parameter);
    
} // }}}
function submit_contact(jump){ // {{{
    
    document.getElementById('timetable').innerHTML = "読み込んでいます";
    
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "<?php echo site_url("/top/top/haisha_table/?date="); ?>" +  jump, true);
    xmlhttp.onreadystatechange = function(){
    
        if(xmlhttp.readyState == 4  && xmlhttp.status == 200){
            
            timetable_html = xmlhttp.responseText;
            //console.log(timetable_html);
            document.getElementById('timetable').innerHTML = timetable_html;
            // 全員表示にチェックが付いていたらスケジュール無しの行も表示
            if( $("#view_staff_all").attr("checked") ){
                $(".no_schedule").show();
            }
            // スケジュール固定フラグのチェック（完了メッセージは非表示）
            sticky(true);
            //$( ".tooltips" ).tooltip();
            $('[title]').qtip();
        }
    }
    
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
    xmlhttp.send();//xmlhttp.send(parameter);
    
} // }}}

function view_calendar(check_cookie) { // {{{
    //$('#calendar').toggle();
    if ($("#view_calendar").attr("checked") == 'checked') {
        $('#month_calendar').css("width","13%");
        $('#time_schedule').css("width","85%");
        $('#calendar').show();
    } else {
        $('#month_calendar').css("width","0");
        $('#time_schedule').css("width","100%");
        $('#calendar').hide();
    }
    if( !check_cookie ){
        save_checkbox_status_in_cookie();
    }
} // }}}
function save_checkbox_status_in_cookie() //  {{{
{
    if( $("#view_calendar").prop("checked") ){
        $.cookie('cookie_view_calendar',  1);
    } else {
        $.cookie('cookie_view_calendar',  0);
    }
    if( $("#view_staff_all").prop("checked") ){
        $.cookie('cookie_view_staff_all', 1);
    } else {
        $.cookie('cookie_view_staff_all', 0);
    }
    if( $("#sticky").prop("checked") ){
        $.cookie('cookie_sticky_flag',    1);
    } else {
        $.cookie('cookie_sticky_flag',    0);
    }
} // }}}

//初期化
window.onload=function(){
    
    submit_contact(<?php echo $this->date; ?>);
    view_calendar(1);
    
}
-->
</script><!-- }}} -->

<!-- {{{ メイン画面 -->
<div class="main">
    
<h2></h2>

<div id="checkbox" class="clearfix">
    <label class="checkbox">
    <input id="view_calendar" type="checkbox" type="checkbox" value="1" <?php if($this->cookie_view_calendar === 1) { echo "checked='checked' "; }?>onclick="view_calendar();"> カレンダー表示
    </label>
    <?php if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN ): ?>
    <label class="checkbox">
    <input id="view_staff_all" type="checkbox" type="checkbox" value="1" <?php if($this->cookie_view_staff_all === 1) { echo "checked='checked' "; }?>onclick="toggle_staff_table();"> 全スタッフ表示
    </label>
    <label class="checkbox">
    <input type="checkbox" type="checkbox" id="sticky" name="sticky" value="1" <?php if($this->cookie_sticky_flag === 1) { echo "checked='checked' "; }?>onclick="sticky();"> スケジュール固定
    </label>
    <?php endif; ?>
</div>

<!-- {{{ カレンダー -->
<div id="month_calendar" class="clearfix">
    <table id="calendar" class="main">
        <tr> 
            <th class="header1 year" colspan="7">
                <a href="<?php echo site_url('/top/top/?date='.$this->cal_data['prev_month']); ?>"><i class="icon-backward"></i></a>
                <?php echo $this->cal_data['given_month_ja']; ?>
                <a href="<?php echo site_url('/top/top/?date='.$this->cal_data['next_month']); ?>"><i class="icon-forward"></i></a>
            </th>
        </tr>
    
        <tr> 
            <th class="header1" style="color:#FF0000">日</th>
            <th class="header1">月</th>
            <th class="header1">火</th>
            <th class="header1">水</th>
            <th class="header1">木</th>
            <th class="header1">金</th>
            <th class="header1" style="color:#0000FF">土</th>
        </tr>
        <?php foreach( $this->cal_data["calender"] as $data ): ?>
        <tr>
            <td><?php echo $data[0]; ?></td>
            <td><?php echo $data[1]; ?></td>
            <td><?php echo $data[2]; ?></td>
            <td><?php echo $data[3]; ?></td>
            <td><?php echo $data[4]; ?></td>
            <td><?php echo $data[5]; ?></td>
            <td><?php echo $data[6]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<!-- }}} /カレンダー -->

<div id="time_schedule">
    <div id="message" style="clear:both;"></div>
    <div id="timetable">読み込んでいます...</div>
</div>
</div><!-- }}}main -->

