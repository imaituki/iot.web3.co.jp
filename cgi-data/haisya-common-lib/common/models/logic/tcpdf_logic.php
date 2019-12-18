<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TCPDF用のロジック
 * 
 */
class Tcpdf_logic extends Base_post_Model
{

    const CEMENT_1 = '201'; //高炉
    const CEMENT_2 = '200'; //GS200

    private $staff_id;
    private $reserve_date;
    private $staff_names; //氏名
    private $number_plates;
    public  $datetime;
    private $works;
    private $plate; //車番

    //残土
    private $soil_total;
    private $soil_point;
    private $soil_2t;
    private $soil_4t;
    //セメント
    private $cement_total;
    private $cement_point;
    private $cement_1; //高炉
    private $cement_2; //GS200
    private $weight_cement_1;
    private $weight_cement_2;
    //その他
    private $other_total;
    private $other_point;
    //社内
    private $private_total;
    private $private_point;
    //本日
    private $view_cement_1;
    private $view_cement_2;
    private $today_point;
    private $today_data;
    //累計
    private $monthly_total;
    private $view_total_cement_1;
    private $view_total_cement_2;
    private $average_point;

    public function set_pdf($data)
    {
        foreach ($data as $val)
        {
            $this->staff_id[] = $val->staff_id;
            $this->reserve_date[] = $val->reserve_date;
            $this->staff_names[] = $val->user_name;
            $this->number_plates[] = $val->number_plate;
            $this->datetime[] = $val->datetime;
        }
        //分類IDを取得
        $construction_category_ids = array();
        foreach ($data as $val)
        {
            $construction_category_ids[] = $val->construction_category_id;
        }
        $construction_category_ids = array_unique($construction_category_ids);
        //分類IDをkeyに作業を配列に入れる
        $work = array();
        foreach ($construction_category_ids as $val1)
        {
            foreach ($data as $val2)
            {
                if ($val1 == $val2->construction_category_id)
                {
                    $this->works[$val1][] = $val2;
                }
            }
        }

        //担当
        $this->staff_names = array_unique($this->staff_names);
        //点呼
        $this->datetime = array_unique($this->datetime);
        //車番を成形
        $this->number_plates = array_unique($this->number_plates);
        foreach ($this->number_plates as $val)
        {
            $this->plate .= $val . ',';
        }
        $this->plate = rtrim($this->plate, ',');

        // PDFライブラリ呼出
        $this->load->library('pdf');
        $pdf = new FPDI();
 
        //header,footerを使用しない
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);
        //ページ準備
        $pdf->AddPage();
        //template読み込み
        $pdf->setSourceFile(COMMON_LIB_PATH . 'common/third_party/pdf/daily_report.pdf');
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);

        //font設定
        $pdf->SetFont('kozgopromedium', '', 9);
        $pdf->Text(22, 11, $this->staff_names[0]);
        $pdf->Text(22, 18, date('Y年m月d日 H:i', strtotime($this->datetime[0])));
        $pdf->Text(22, 25, $this->plate);

        //残土
        if (!empty($this->works[1]))
        {
            $y = 36;

            foreach ($this->works[1] as $val)
            {
                $pdf->SetFont('kozgopromedium', '', 6);
                $pdf->Text(23, $y+=3, substr($val->time_start, 0, 5));
                $pdf->Text(23, $y+=3, substr($val->time_end, 0, 5));
                $pdf->SetFont('kozgopromedium', '', 8);
                $pdf->SetXY(32.5, $y-=3.5);
                $pdf->Cell(15, 6.5, $val->construction_code, 0, 0, 'L', 0, '', 1);      //工番
                $pdf->Cell(35, 6.5, $val->construction_name, 0, 0, 'L', 0, '', 1);      //現場名
                $pdf->Cell(29.5, 6.5, $val->construction_address, 0, 0, 'L', 0, '', 1); //住所
                $pdf->Cell(27, 6.5, $val->disposal_name, 0, 0, 'L', 0, '', 1);          //処理場
                $pdf->Cell(17, 6.5, $val->car_class_name, 0, 0, 'C', 0, '', 1);         //車輌扱い
                $num = ($val->weight > 0) ? $val->weight.'×'.$val->count_actual : $val->count_actual;
                $pdf->Cell(22, 6.5, rtrim($num, '0.'), 0, 0, 'C', 0, '', 1);                            //数量
                $pdf->Cell(22, 6.5, rtrim($val->point*$val->count_actual, '0.'), 0, 0, 'C', 0, '', 1);  //ポイント
                $y+=4;
                $this->soil_total += ($val->weight > 0) ? $val->weight*$val->count_actual : $val->count_actual;
                $this->soil_point += $val->count_actual * $val->point;
                if (preg_match('/^2t/', $val->car_class_name)) $this->soil_2t += ($val->weight > 0) ? $val->weight*$val->count_actual : $val->count_actual;
                if (preg_match('/^4t/', $val->car_class_name)) $this->soil_4t += ($val->weight > 0) ? $val->weight*$val->count_actual : $val->count_actual;
            }
            $pdf->SetXY(156, 84);
            $pdf->Cell(22, 6.5, rtrim($this->soil_total, '0.'), 0, 0, 'C', 0, '', 1);   //数量
            $pdf->Cell(22, 6.5, rtrim($this->soil_point, '0.'), 0, 0, 'C', 0, '', 1);   //ポイント
        }

        //セメント
        if (!empty($this->works[2]))
        {
            $y = 94.5;
            foreach ($this->works[2] as $val)
            {
                $pdf->SetFont('kozgopromedium', '', 6);
                $pdf->Text(23, $y+=3, substr($val->time_start, 0, 5));
                $pdf->Text(23, $y+=3, substr($val->time_end, 0, 5));
                $pdf->SetFont('kozgopromedium', '', 8);
                $pdf->SetXY(32.5, $y-=3.5);
                $pdf->Cell(15, 6.5, $val->construction_code, 0, 0, 'L', 0, '', 1);      //工番
                $pdf->Cell(35, 6.5, $val->construction_name, 0, 0, 'L', 0, '', 1);      //現場名
                $pdf->Cell(29.5, 6.5, $val->construction_address, 0, 0, 'L', 0, '', 1); //住所
                $type_name = $val->construction_type_name.'・'.$val->construction_detail_name;
                $pdf->Cell(27, 6.5, $type_name, 0, 0, 'L', 0, '', 1);                   //工種・種別
                $pdf->Cell(17, 6.5, $val->car_class_name, 0, 0, 'C', 0, '', 1);         //車輌扱い
                $pdf->Cell(22, 6.5, rtrim($val->count_actual, '0.'), 0, 0, 'C', 0, '', 1);              //数量
                $pdf->Cell(22, 6.5, rtrim($val->point*$val->count_actual, '0.'), 0, 0, 'C', 0, '', 1);  //ポイント
                $y+=4;
                $this->cement_total += $val->count_actual;
                $this->cement_point += $val->count_actual * $val->point;
                if ($val->construction_type_code == self::CEMENT_1) $this->cement_1 += $val->count_actual;
                if ($val->construction_type_code == self::CEMENT_2) $this->cement_2 += $val->count_actual;
                if ($val->construction_type_code == self::CEMENT_1) $this->weight_cement_1 += ($val->weight > 0) ? $val->weight * $val->count_actual : $val->count_actual;
                if ($val->construction_type_code == self::CEMENT_2) $this->weight_cement_2 += ($val->weight > 0) ? $val->weight * $val->count_actual : $val->count_actual;
            }
            $pdf->SetXY(156, 142.5);
            $pdf->Cell(22, 6.5, rtrim($this->cement_total, '0.'), 0, 0, 'C', 0, '', 1);   //数量
            $pdf->Cell(22, 6.5, rtrim($this->cement_point, '0.'), 0, 0, 'C', 0, '', 1);   //ポイント
        }

        //その他
        if (!empty($this->works[3]))
        {
            $y = 153;

            foreach ($this->works[3] as $val)
            {
                $pdf->SetFont('kozgopromedium', '', 6);
                $pdf->Text(23, $y+=3, substr($val->time_start, 0, 5));
                $pdf->Text(23, $y+=3, substr($val->time_end, 0, 5));
                $pdf->SetFont('kozgopromedium', '', 8);
                $pdf->SetXY(32.5, $y-=3.5);
                $pdf->Cell(15, 6.5, $val->construction_code, 0, 0, 'L', 0, '', 1);      //工番
                $pdf->Cell(35, 6.5, $val->construction_name, 0, 0, 'L', 0, '', 1);      //現場名
                $pdf->Cell(29.5, 6.5, $val->construction_address, 0, 0, 'L', 0, '', 1); //住所
                $pdf->Cell(27, 6.5, $val->construction_type_name, 0, 0, 'L', 0, '', 1); //工種
                $pdf->Cell(17, 6.5, $val->car_class_name, 0, 0, 'C', 0, '', 1);         //車輌扱い
                $num = ($val->weight > 0) ? $val->weight.'×'.$val->count_actual : $val->count_actual;
                $pdf->Cell(22, 6.5, rtrim($num, '0.'), 0, 0, 'C', 0, '', 1);                           //数量
                $pdf->Cell(22, 6.5, rtrim($val->point*$val->count_actual, '0.'), 0, 0, 'C', 0, '', 1); //ポイント
                $y+=4;
                $this->other_total += ($val->weight > 0) ? $val->weight*$val->count_actual : $val->count_actual;
                $this->other_point += $val->count_actual * $val->point;
            }
            $pdf->SetXY(156, 188);
            $pdf->Cell(22, 6.5, rtrim($this->other_total, '0.'), 0, 0, 'C', 0, '', 1);         //数量
            $pdf->Cell(22, 6.5, rtrim($this->other_point, '0.'), 0, 0, 'C', 0, '', 1);         //ポイント
        }

        //社内（倉出・応援）
        if (!empty($this->works[4]))
        {
            $y = 198.5;
            foreach ($this->works[4] as $val)
            {
                $pdf->SetFont('kozgopromedium', '', 6);
                $pdf->Text(23, $y+=3, substr($val->time_start, 0, 5));
                $pdf->Text(23, $y+=3, substr($val->time_end, 0, 5));
                $pdf->SetFont('kozgopromedium', '', 8);
                $pdf->SetXY(32.5, $y-=3.5);
                $pdf->Cell(15, 6.5, $val->construction_code, 0, 0, 'L', 0, '', 1);            //工番
                $pdf->Cell(35, 6.5, $val->construction_type_name, 0, 0, 'L', 0, '', 1);       //工種
                $pdf->Cell(29.5, 6.5, $val->construction_detail_name, 0, 0, 'L', 0, '', 1);   //種別
                $pdf->Cell(27, 6.5, $val->disposal_name, 0, 0, 'L', 0, '', 1);                //処理場
                $pdf->Cell(17, 6.5, $val->car_class_name, 0, 0, 'C', 0, '', 1);               //車輌扱い
                $num = ($val->weight > 0) ? $val->weight.'×'.$val->count_actual : $val->count_actual;
                $pdf->Cell(22, 6.5, rtrim($num, '0.'), 0, 0, 'C', 0, '', 1);                  //数量
                $pdf->Cell(22, 6.5, rtrim($val->point*$val->count_actual, '0.'), 0, 0, 'C', 0, '', 1); //ポイント
                $y+=4;
                $this->private_total += ($val->weight > 0) ? $val->weight*$val->count_actual : $val->count_actual;
                $this->private_point += $val->count_actual * $val->point;
            }
            $pdf->SetXY(156, 233.5);
            $pdf->Cell(22, 6.5, rtrim($this->private_total, '0.'), 0, 0, 'C', 0, '', 1);  //数量
            $pdf->Cell(22, 6.5, rtrim($this->private_point, '0.'), 0, 0, 'C', 0, '', 1);  //ポイント
        }

        // ▼以下本日
        // 残土
        $pdf->SetXY(18, 248);
        $pdf->Cell(34.5, 6.5, $this->soil_2t, 0, 2, 'C', 0, '', 1);  //2tDT
        $pdf->Cell(34.5, 6.5, $this->soil_4t, 0, 2, 'C', 0, '', 1);  //4tDT
        $pdf->Cell(34.5, 6.5, $this->soil_point, 0, 2, 'C', 0, '', 1);  //P
        // セメント
        $pdf->SetXY(52.5, 248);
        $this->view_cement_1 = ($this->weight_cement_1 > 0) ? $this->weight_cement_1/1000 : "";
        $pdf->Cell(34.5, 6.5, rtrim($this->view_cement_1, '0.'), 0, 2, 'C', 0, '', 1);  //高炉
        $this->view_cement_2 = ($this->weight_cement_2 > 0) ? $this->weight_cement_2/1000 : "";
        $pdf->Cell(34.5, 6.5, rtrim($this->view_cement_2, '0.'), 0, 2, 'C', 0, '', 1);  //GS200
        $pdf->Cell(34.5, 6.5, $this->cement_point, 0, 2, 'C', 0, '', 1);  //P

        $pdf->SetFont('kozgopromedium', '', 16);
        // その他
        $pdf->SetXY(87, 248);
        $pdf->Cell(34.5, 19.5, $this->other_point, 0, 2, 'C', 0, '', 1);  //P
        // 合計
        $pdf->SetXY(121.5, 248);
        $this->today_point = rtrim($this->soil_point + $this->cement_point + $this->other_point, '0.');
        $pdf->Cell(34.5, 19.5, $this->today_point, 0, 2, 'C', 0, '', 1);  //P

        //当日の数量、ポイントを登録する
        $this->today_data = array(
                    	    'soil_2t'      => ($this->soil_2t == '') ? 0 : $this->soil_2t,
	                        'soil_4t'      => ($this->soil_4t == '') ? 0 : $this->soil_4t,
	                        'soil_point'   => ($this->soil_point == '') ? 0 : $this->soil_point,
	                        'cement_1'     => ($this->view_cement_1 == '') ? 0 : $this->view_cement_1,
	                        'cement_2'     => ($this->view_cement_2 == '') ? 0 : $this->view_cement_2,
	                        'cement_point' => ($this->cement_point == '') ? 0 : $this->cement_point,
	                        'other_point'  => ($this->other_point == '') ? 0 : $this->other_point,
	                        'today_point'  => ($this->today_point == '') ? 0 : $this->today_point
                           );

        //当月の累計値を取得する
        $this->monthly_total = $this->T_reserve->update_num_and_point($this->today_data, array_unique($this->staff_id), array_unique($this->reserve_date));

        // ▼以下累計
        $pdf->SetFont('kozgopromedium', '', 8);
        // 残土
        $pdf->SetXY(18, 267.5);
        $pdf->Cell(34.5, 6.5, $this->_empty_value($this->monthly_total->total_soil_2t), 0, 2, 'C', 0, '', 1);  //2tDT
        $pdf->Cell(34.5, 6.5, $this->_empty_value($this->monthly_total->total_soil_4t), 0, 2, 'C', 0, '', 1);  //4tDT
        $pdf->Cell(34.5, 6.5, $this->_empty_value(rtrim($this->monthly_total->total_soil_point, '0.')), 0, 2, 'C', 0, '', 1);  //P
        // セメント
        $pdf->SetXY(52.5, 267.5);
        $this->view_total_cement_1 = ($this->monthly_total->total_cement_1 > 0) ? $this->monthly_total->total_cement_1 : "";
        $pdf->Cell(34.5, 6.5, rtrim($this->_empty_value($this->view_total_cement_1), '0.'), 0, 2, 'C', 0, '', 1);  //高炉
        $this->view_total_cement_2 = ($this->monthly_total->total_cement_2 > 0) ? $this->monthly_total->total_cement_2 : "";
        $pdf->Cell(34.5, 6.5, rtrim($this->_empty_value($this->view_total_cement_2), '0.'), 0, 2, 'C', 0, '', 1);  //GS200
        $pdf->Cell(34.5, 6.5, $this->_empty_value(rtrim($this->monthly_total->total_cement_point, '0.')), 0, 2, 'C', 0, '', 1);  //P
        
        $pdf->SetFont('kozgopromedium', '', 16);
        // その他
        $pdf->SetXY(87, 267.5);
        $pdf->Cell(34.5, 19.5, $this->_empty_value(rtrim($this->monthly_total->total_other_point, '0.')), 0, 2, 'C', 0, '', 1);
        // 合計
        $pdf->SetXY(121.5, 267.5);
        $pdf->Cell(34.5, 19.5, $this->_empty_value(rtrim($this->monthly_total->total_today_point, '0.')), 0, 2, 'C', 0, '', 1);
        // 出勤日数
        $pdf->SetXY(158, 267.5);
        $pdf->Cell(21, 19.5, $this->monthly_total->total_count, 0, 2, 'C', 0, '', 1);
        // 平均P/日
        $pdf->SetXY(179, 267.5);
        if ($this->monthly_total->total_today_point > 0 && $this->monthly_total->total_count > 0)
        {
            $this->average_point = round(rtrim($this->monthly_total->total_today_point / $this->monthly_total->total_count, '0.'), 6);
        }
        $pdf->Cell(21, 19.5, $this->_empty_value($this->average_point), 0, 2, 'C', 0, '', 1);

        //PDF出力
        $pdf->Output($this->login_user->user_code.'_'.date('YmdHis').'.pdf','D');

    }

    private function _empty_value($value)
    {
        return ($value == 0) ? '' : $value; 
    }

}
