<?php
class MySmarty extends Smarty {

	function MySmarty( $type ) {

		// グローバル変数
		global $_HTML_HEADER_DEFAULT;
		global $_HTML_HEADER;
		global $_ADMIN;
		global $_FRONT;

		// 設定
		parent::__construct();
		$this->force_compile = 0;
		$this->compile_check = true;
		$this->template_dir = "../template/";
		$this->compile_dir  = _DOCUMENT_ROOT . "/..". _CGI_PATH. "/smarty/templates_c/";

		// 共通配列
		$this->assign( "arr_post", $_POST    );
		$this->assign( "arr_get" , $_GET     );
		$this->assign( "_SERVER" , $_SERVER  );
		$this->assign( "_SESSION", $_SESSION );
		$this->assign( "_COOKIE" , $_COOKIE  );

		$this->assign( "_ADMIN", $_ADMIN ); // 詳しくはadmin.iniに記載
		$this->assign( "_FRONT", $_FRONT ); // 詳しくはfront.iniに記載

		// メタ設定
		$this->assign( "_HTML_HEADER_DEFAULT", $_HTML_HEADER_DEFAULT );  // デフォルト
		$this->assign( "_HTML_HEADER"        , $_HTML_HEADER         );  // ページ別の設定

		// 共通変数
		$this->assign( "_DOCUMENT_ROOT" , _DOCUMENT_ROOT  );
		$this->assign( "_UPLOADFULLPATH", _UPLOADFULLPATH );
		$this->assign( "_UPLOADPATH"    , _UPLOADPATH     );
		$this->assign( "_IMAGEFULLPATH" , _IMAGEFULLPATH  );
		$this->assign( "_IMAGEPATH"     , _IMAGEPATH      );
		$this->assign( "_IMAGEROOTPATH" , _IMAGEROOTPATH  );

		// 各種設定
		switch( $type ) {
			case "admin":
				$this->admin();
			break;
			case "front":
				$this->front();
			break;
		}

	}


	function admin(){

		global $_ADMIN; // 必須
		global $OptionInfoCategory;

		// ディレクトリ
		$this->compile_dir  = _DOCUMENT_ROOT . "/..". _CGI_PATH. "/smarty/templates_c/admin/";
		$this->template_dir = "../template/";

		// 変数
		$this->assign( "_CLIENT_NAME"       , _CLIENT_NAME        );
		$this->assign( "_CONTENTS_CONF_PATH", _CONTENTS_CONF_PATH );
		$this->assign( "_CONTENTS_DIR"      , _CONTENTS_DIR       ); // ディレクトリ名
		$this->assign( "_CONTENTS_ID"       , _CONTENTS_ID        ); // 当該データベースのID名
		$this->assign( "_CONTENTS_NAME"     , _CONTENTS_NAME      ); //

		// オプション
		$this->assign( "OptionInfoCategory" , $OptionInfoCategory );

		// テンプレート変数
		$this->assign( "template_header"    , _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/header.tpl"     );
		$this->assign( "template_secondary" , _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/secondary.tpl"  );
		$this->assign( "template_javascript", _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/javascript.tpl" );
		$this->assign( "template_image"     , _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/image.tpl"      );
		$this->assign( "template_image2"    , _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/image2.tpl"     );
		$this->assign( "template_file"      , _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/file.tpl"       );
		$this->assign( "template_pagenavi"  , _DOCUMENT_ROOT. $_ADMIN["home"]. "/common/inc/pagenavi.tpl"   );

	}


	function front() {

		global $_FRONT; // 必須
		global $_INFO;
		global $OptionInfoCategory;
		global $mst_siteconf;

		// ディレクトリ
		$this->compile_dir  = _DOCUMENT_ROOT . "/..". _CGI_PATH. "/smarty/templates_c/";
		$this->template_dir = "./";

		// 汎用配列
		$this->assign( "_INFO" , $_INFO  ); // 詳しくはfront.iniに記載
		// オプション
		$this->assign( "OptionInfoCategory" , $OptionInfoCategory );

		// 変数
		$this->assign( "mst_siteconf"        , $mst_siteconf       );



		// 変数 - インクルードパス
		$this->assign( "template_meta"       , _DOCUMENT_ROOT. $_FRONT["include"]. "/meta.tpl"       );
		$this->assign( "template_header"     , _DOCUMENT_ROOT. $_FRONT["include"]. "/header.tpl"     );
		$this->assign( "template_footer"     , _DOCUMENT_ROOT. $_FRONT["include"]. "/footer.tpl"     );
		$this->assign( "template_secondary"  , _DOCUMENT_ROOT. $_FRONT["include"]. "/secondary.tpl"  );
		$this->assign( "template_javascript" , _DOCUMENT_ROOT. $_FRONT["include"]. "/javascript.tpl" );

	}

}
?>
