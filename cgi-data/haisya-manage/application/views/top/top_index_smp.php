<!-- {{{ CSS -->
<style type="text/css">
#today_date {
    width: 100%;
    text-align: center;
    padding-bottom: 20px;
}
</style>
<!-- }}} -->


<!-- メイン -->
<div class="container">
<div class="main">

<?php if ($this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN) : ?>
<form action="?" method="GET">
    <input type="hidden" name="date" value="<?php echo $this->given_date_ymd; ?>" />
    <select name="staff_id">
<?php foreach($this->staff_array as $staff_id => $staff_name): ?>
            <option value="<?php echo $staff_id; ?>" <?php if ($staff_id == $this->selected_staff_id){ echo "selected='selected'"; }?>><?php echo $staff_name; ?></option>
<?php endforeach; ?>
        </select>
    <input type="submit" value="表示" class="btn btn-warning" />
</form>
<br />
<?php endif; ?>

<div id="today_date">
<a href="?act=haisha_list&date=<?php echo $this->prev_day; ?>&staff_id=<?php echo $this->selected_staff_id; ?>"><i class="icon-chevron-left"></i></a> <?php echo $this->given_date_ja; ?> <a href="?act=haisha_list&date=<?php echo $this->next_day; ?>&staff_id=<?php echo $this->selected_staff_id; ?>"><i class="icon-chevron-right"></i></a><br />
</div>

<div id="time-table">
<table class="timetable_smf">


<?php foreach( $this->schedules as $staff_id => $data ): //時間のループ ?>
<?php foreach( $data["cell_data"] as $cell_data ): //時間のループ ?>

<tr height="22px">
    <?php if( $cell_data["is_time_header"] ): ?>
    <th rowspan="2" style="width:100px;"><?php echo $cell_data["time_string"]; ?></th>
    <?php endif; ?>

    <?php if( $cell_data["in_rowspan"] == false ) : ?>
    <td 
        class="<?php echo $cell_data["class"]; ?>"
        id="<?php echo $cell_data["id"]; ?>"
        <?php if( $cell_data["rowspan"] > 1 ){ echo "rowspan=\"".$cell_data["rowspan"]."\";"; } ?>
        <?php foreach($cell_data["mouse_event"] as $event => $call_func): ?>
        <?php echo $event.'="'.$call_func.'" '; ?>
        <?php endforeach; ?>
        style="<?php foreach($cell_data["style"] as $css_name => $css_val){ echo $css_name.":".$css_val.";"; } ?>"
    ><a href="<?php echo $cell_data["link_url"]; ?>" title="<?php echo $cell_data["memo"]; ?>"><?php echo $cell_data["title"]; ?></a></td>

    <?php endif; ?>

</tr>

<?php endforeach; ?>
<?php endforeach; ?>


</table>
</div><!-- /time-table -->
</div><!-- /main -->
</div><!-- /container -->
