<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CSV出力用のロジック
 * 
 */
class Csv_logic extends Base_post_Model
{

	/**
	 * 
	 */
	public function convert_for_csv($list, $package_name)
	{

		// ヘッダをセット
		$header = $this->_setHeader($package_name);

		$ret = array();
		$content = array();

		//CSVの1行ループ
		foreach ($list as $entity)
		{
			$content[] = $this->_create_line($entity);
		}

		$ret = array();
		$ret['header'] = $header;
		$ret['content'] = $content;

		return $ret;
	}

	/**
	 * CSVの1行分の配列を作成する。
	 * 
	 * @param unknown_type $entity
	 */
//	private function _create_line($entity)
	protected function _create_line($entity)
	{
		$tmp = array(); 
		foreach ($entity as $value)
		{
			$tmp[] = $value;
		}

		return $tmp;
	}

	/**
	 * ヘッダを返す。
	 * 
	 * @param string $package_name パッケージ名
	 * @return array csv用ヘッダーの配列
	 */
    private function _setHeader($package_name)
    {
        switch ($package_name)
        {
            case 'construction_category': // 分類
                $header = array(
                     'ID'
                    ,'分類コード'
                    ,'分類名'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'user': // 社員
                $header = array(
                     'ID'
                    ,'ユーザーコード'
                    ,'パスワード'
                    ,'ユーザー名'
                    ,'ユーザー名（フリガナ）'
                    ,'アカウント種別'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'attendance': // 勤怠
                $header = array(
                     'ID'
                    ,'スタッフID'
                    ,'出勤日時'
                    ,'残土(2tDT)'
                    ,'残土(4tDT)'
                    ,'残土(P)'
                    ,'セメント(高炉)'
                    ,'セメント(GS200)'
                    ,'セメント(P)'
                    ,'その他(P)'
                    ,'合計(P)'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'construction': // 工事
                $header = array(
                     'ID'
                    ,'状態'
                    ,'工事コード'
                    ,'顧客ID'
                    ,'現場名'
                    ,'住所'
                    ,'緯度'
                    ,'経度'
                    ,'終了フラグ'
                    ,'終了日'
                    ,'終了ユーザー'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'unit_price': // 単価
                $header = array(
                     'ID'
                    ,'工種ID'
                    ,'種別ID'
                    ,'処理場ID'
                    ,'車輌扱いID'
                    ,'単価'
                    ,'ポイント'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'construction_detail': // 種別
                $header = array(
                     'ID'
                    ,'種別コード'
                    ,'種別'
                    ,'重量'
                    ,'単位'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'construction_type': // 工種
                $header = array(
                     'ID'
                    ,'分類ID'
                    ,'工種コード'
                    ,'工種名'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'disposal': // 処理場
                $header = array(
                     'ID'
                    ,'処理場'
                    ,'処理場（フリガナ）'
                    ,'電話番号'
                    ,'FAX番号'
                    ,'郵便番号'
                    ,'住所'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'customer': // 顧客
                $header = array(
                     'ID'
                    ,'会社名'
                    ,'会社名（フリガナ）'
                    ,'担当者'
                    ,'担当者（フリガナ）'
                    ,'役職等'
                    ,'メールアドレス'
                    ,'電話番号'
                    ,'FAX番号'
                    ,'郵便番号'
                    ,'住所'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'car_profile': // 車輌
                $header = array(
                     'ID'
                    ,'ナンバープレート'
                    ,'許可番号'
                    ,'車輌扱いID'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'car_class': // 扱い
                $header = array(
                     'ID'
                    ,'車輌扱い名'
                    ,'削除フラグ'
                    ,'登録ユーザー'
                    ,'登録日時'
                    ,'更新ユーザー'
                    ,'更新日時'
                );
                break;

            case 'reserve': // 配車
        		$header = array(
                     '計画ID'           //t_reserve->id
                    ,'スタッフID'       //t_reserve->staff_id
                    ,'スタッフ名'       //m_user->user_name
                    ,'日付'             //t_reserve->reserve_date
                    ,'計画開始時間'     //t_reserve->reserve_time_start
                    ,'計画終了時間'     //t_reserve->reserve_time_end
                    ,'実績開始時間'     //t_reserve->time_start
                    ,'実績終了時間'     //t_reserve->time_end
                    ,'工事コード'       //t_reserve->construction_code
                    ,'顧客ID'           //m_construction->customer_id
                    ,'顧客名'           //m_customer->company_name
                    ,'現場名'           //m_construction->construction_name
                    ,'住所'             //m_construction->construction_address
                    ,'車輌扱いID'       //t_reserve_detail->car_class_id
                    ,'ナンバープレート' //m_car_profile->number_plate
                    ,'車輌扱い'         //m_car_class->car_class_name
                    ,'作業-工種コード'  //m_construction_type->construction_type_code
                    ,'作業-分類'        //m_construction_category->construction_category_name
                    ,'作業-工種名'      //m_construction_type->construction_type_name
                    ,'作業-種別コード'  //m_construction_detail->construction_detail_code
                    ,'作業-種別'        //m_construction_detail->construction_detail_name
                    ,'作業-重量'        //m_construction_detail->weight
                    ,'作業-単位'        //m_construction_detail->unit
                    ,'作業-予定数量'    //t_reserve_detail->count_estimate
                    ,'作業-実績数量'    //t_reserve_detail->count_actual
                    ,'作業-処理場ID'    //t_reserve_detail->disposal_id
                    ,'作業-処理場'      //m_disposal->disposal_name
                    ,'備考'             //t_reserve->memo
                    ,'ポイント単価'     //m_unit_price->point
                    ,'ポイント計'       //m_unit_price->point * t_reserve_detail->count_actual
                    ,'請求単価'         //m_unit_price->unit_price
                    ,'請求計'           //m_unit_price->unit_price * t_reserve_detail->count_actual
		        );
                break;

            default:
                break;

        }

        return $header;
    }

}
