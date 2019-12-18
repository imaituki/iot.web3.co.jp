<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (COMMON_LIB_PATH . "system/libraries/User_agent.php");

class MY_User_agent extends CI_User_agent
{

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * スマートフォン(iPhone/iPod/iPad/Android)の判別
     * 
     * @return type boolean
     */
    public function is_smartphone()
    {

        $ua = $this->agent_string();
        
        if(preg_match('/iPhone|iPod|iPad|Android/i', $ua ))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
}
