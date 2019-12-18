<?php
/* 配車スケジュール一覧表示 ( for PC )
 *
 */
?>


<table class="main" cellpadding="0" onselectstart="return false;" onMouseDown="return false;">
<thead>
  <tr>
    <th class="header1"><?php echo $this->cal_header[0]; ?></th>

    <?php if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN ): ?>
    <th class="header1">出勤</th>
    <?php endif; ?>

    <?php for( $i = 1; $i < count($this->cal_header); $i++ ): ?>
    <th class="header2"><?php echo $this->cal_header[ $i ]; ?></th>
    <th class="header2">&nbsp;</th>
    <?php endfor; ?>

  </tr>
</thead>

<tbody>
  <?php if( $this->schedules ): ?>
  <?php foreach( $this->schedules as $staff_id => $line): ?>
  <tr <?php if(!$line["schedule"]){ echo "class='no_schedule'"; } ?>>

    <th class="name">
        <?php if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN ): ?>
            <a href="<?php echo site_url("/user/user_edit/index/".$staff_id);?>"><?php echo $line["staff_name"]; ?></a>
        <?php else: ?>
            <?php // 一般ユーザはクリックしたら日報画面に飛ばす？ ?>
            <a href="<?php echo site_url("/password/password_edit");?>"><?php echo $line["staff_name"]; ?></a>
        <?php endif; ?>
    </th>

    <?php if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN ): ?>
        <?php if ( $line["attend"] ): ?>
        <td class="attend"> 出 </td>
        <?php else: ?>
        <td class="no-attend"> 未 </td>
        <?php endif; ?>
    <?php endif; ?>

    <?php foreach($line["cell_data"] as $cell_data): ?>
    <td
        colspan="<?php echo $cell_data['colspan']; ?>"
        id="timetable<?php echo $cell_data['id'];?>"
        class="<?php echo $cell_data['class']; ?>"
        <?php foreach($cell_data["mouse_event"] as $event => $call_func): ?>
        <?php echo $event.'="'.$call_func.'" '; ?>
        <?php endforeach; ?>
        style="<?php foreach($cell_data["style"] as $css_name => $css_val){ echo $css_name.":".$css_val.";"; } ?>">
        <?php if( $cell_data["link_url"] ): ?>
            <a href="<?php echo $cell_data["link_url"]; ?>" title="<?php echo $cell_data["tooltip"]; ?>" class="tooltips">
                <?php echo $cell_data["inner_html"]; ?>
            </a><br />
            <?php echo $cell_data["memo"]; ?>
        <?php else: ?>
            <?php echo $cell_data["inner_html"]; ?>
        <?php endif; ?>
    </td>
    <?php endforeach; ?>
  </tr>
  <?php endforeach; ?>
  <?php endif; ?>
</tbody>
</table>
