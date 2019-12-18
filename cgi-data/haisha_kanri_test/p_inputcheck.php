<?php
// ���̓`�F�b�N�N���X
// ����OK����""�i�󕶎��j��Ԃ�
// $s_data�͓��͕�����
// $n_minimumlength    0 : �����͉A$n_minimumlength = 1�ȏ� : �K�{���͂ōŒጅ���w��

class p_inputcheck
{
	//�����̂�
	function p_inputcheck_p_n($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//�Œጅ���`�F�b�N
		{
			return "���p�̐����œ��͂��Ă��������B";
		//����OK�̏ꍇ�ꍇ
		}else{
			if(is_numeric($s_data) or $s_data=="")
			{
				return "";
			}else{
				return "���p�̐����œ��͂��Ă��������B";
			}
		}
	}

	//���p�p���i�召�j�̂�
	function p_inputcheck_p_a($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//�Œጅ���`�F�b�N
		{
			return "���p�̉p���œ��͂��Ă��������B";
		//����OK�̏ꍇ�ꍇ
		}else{
			if(ctype_alpha($s_data))
			{
				return "";
			}else{
				return "���p�̉p���œ��͂��Ă��������B";
			}
		}
	}

	//���p�p���i�召�j�Ɛ����̂�
	function p_inputcheck_p_an($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//�Œጅ���`�F�b�N
		{
			return "���p�̐������p���œ��͂��Ă��������B";
		//����OK�̏ꍇ�ꍇ
		}else{
			if(ctype_alnum($s_data))
			{
				return "";
			}else{
				return "���p�̐������p���œ��͂��Ă��������B";
			}
		}
	}
	

	//�����`�F�b�N���[�`��
	function p_inputcheck_p_japanese($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//�Œጅ���`�F�b�N
		{
			return "�S�p�̓��{��œ��͂��Ă��������B";
		//����OK�̏ꍇ�ꍇ
		}else{
//			if(ereg("[\x41-\x5A|\x61-\x7A|\x30-\x39]+$", $s_data))
//			if(ereg("^[^\x01-\x7E\xA1-\xDF]+$", $s_data))
//			{
//				return "";
//			}else{
//				return "�S�p�̓��{��œ��͂��Ă��������B";
//			}
			if( preg_match('/^(?:[\x81-\x9F\xE0-\xFC][\x40-\x7E\x80-\xFC])*$/', $s_data) )
			{
				return "";
			} else {
				return "�S�p�̓��{��œ��͂��Ă��������B";
			}
		}
	}


	//�d�b�ԍ��i���p�����ƃn�C�t���j
	function p_inputcheck_p_tel($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//�Œጅ���`�F�b�N
		{
			return "�擪�������ŁA���p�̐�����-(�n�C�t��)�œ��͂��Ă��������B";
		//����OK�Ő擪��-�̏ꍇ
		}else if(substr($s_data,0,1) == "-"){
			return "�擪�������ŁA���p�̐�����-(�n�C�t��)�œ��͂��Ă��������B";
		//��̓n�C�t���������đS���������ǂ����H
		}else{
			if(is_numeric(str_replace("-", "", $s_data)) or $s_data =="")
			{
				return "";
			}else{
				return "�擪�������ŁA���p�̐�����-(�n�C�t��)�œ��͂��Ă��������B";
			}
		}
	}


	//���t�i���p������/�Ƒ��݃`�F�b�N�j
	//$n_type=0 : /�t���̓��t�@n_type=1 : ���������̓��t�i�W���ȊO�̓��͂̓G���[�j
	function p_inputcheck_p_date($s_data, $n_type)
	{
		if($n_type==0){//�����ƃX���b�V���̓��t�̏ꍇ�i�P�O���j
			
			if(strlen($s_data)==0){
				return "";
			}else{
				
				$a_date = explode('/',$s_data);
				
				if(count($a_date)!=3){
					return "���t�̓��͌`���Ɍ���Ă��邩���݂��Ȃ����t�ł��B";
				}
				
				if(checkdate($a_date[1],$a_date[2],$a_date[0])){
					return "";
				}else{
					return "���t�̓��͌`���Ɍ���Ă��邩���݂��Ȃ����t�ł��B";
				}//*/
				
			}

		}else{//���������̓��t�̏ꍇ�i�W���j
			
			if(strlen($s_data)==8){
			
				if(checkdate(substr($s_data,4,2),substr($s_data,6,2),substr($s_data,0,4))){
					return "";
				}else{
					return "���t�̓��͌`���Ɍ���Ă��邩���݂��Ȃ����t�ł��B";
				}//*/
				
			}else{
			
				return "���t�̓��͌`���Ɍ�肪����܂��B";
				
			}
		
		}
	}	
	
	//���ԁi���p������:�Ƒ���HH:MM�`���j
	function p_inputcheck_p_time($s_data)
	{
		
		if(strlen($s_data)==5 or strlen($s_data)==4){
		
			$pat = "^([0-1][0-9]|[2][0-3]|[0-9]):[0-5][0-9]$";
			if(ereg($pat,$s_data)){
				return "";
			}else{
				return "�����̓��͌`���Ɍ�肪����܂��B";
			}//*/
			
		}elseif(strlen($s_data)==0){
			
			return "";
			
		}else{
			
			return "�����̓��͌`���Ɍ�肪����܂��B";
			
		}

	}

	//�J���[�R�[�h
	function p_inputcheck_p_color($s_data)
	{
		$pat = "^#[a-fA-F0-9][a-fA-F0-9][a-fA-F0-9][a-fA-F0-9][a-fA-F0-9][a-fA-F0-9]$";
		if(ereg($pat,$s_data)){
			return "";
		}else{
			return "�J���[�R�[�h�̓��͌`���Ɍ�肪����܂��B";
		}//*/
		

	}

	//���[���i���[���`���i�g���镶���ɒ��ӂ��āI�j�j
	function p_inputcheck_p_mail($s_data, $n_minimumlength)
	{

		
		if (strlen($s_data) < $n_minimumlength)
		//�Œጅ���`�F�b�N
		{
			return "���[���A�h���X�̌`���Ɍ�肪����܂��B";
		}else if($s_data == ""){
			return "";
		}else{
		
			$pat = "^[a-z0-9][a-z0-9._-]*@[a-z0-9_-]+\.[a-z0-9._-]*[a-z]$";
			if(ereg($pat,$s_data)){
				return "";
			}else{
				return "���[���A�h���X�̌`���Ɍ�肪����܂��B";
			}
		}
	}	

}
?>