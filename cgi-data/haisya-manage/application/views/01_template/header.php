<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
            <a href="<?php echo site_url('top/top'); ?>" class="brand">ServiceName</a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
			<?php //ログイン済の場合 ?>
            <div class="collapse nav-collapse">
			<?php if (($this->login_user !== FALSE) && is_not_blank($this->login_user->user_code)): ?>
				<ul class="nav">
                <!-- ▼配車 -->
				<?php if ($this->login_user->is_admin() || !$this->smartphone): ?>
				<li class="<?php echo ($this->current_main_menu === 'reserve' || $this->current_main_menu === 'reserve_detail') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('reserve'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('reserve/reserve_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('reserve'.'_package_name_label'); ?>を検索する</a></li>
				        <?php if ($this->login_user->is_admin()): ?>
						<li><a href="<?php echo site_url('reserve/reserve_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('reserve'.'_package_name_label'); ?>を新規登録する</a></li>
				        <?php endif; ?>
					</ul>
				</li>
		        <?php endif; ?>
                <!-- ▼管理者 -->
				<?php if ($this->login_user->is_admin()): ?>
                <!-- ▼車輌扱い -->
				<li class="<?php echo ($this->current_main_menu === 'car_class') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('car_class'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('car_class/car_class_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('car_class'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('car_class/car_class_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('car_class'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼車輌情報 -->
				<li class="<?php echo ($this->current_main_menu === 'car_profile') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('car_profile'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('car_profile/car_profile_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('car_profile'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('car_profile/car_profile_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('car_profile'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼顧客 -->
				<li class="<?php echo ($this->current_main_menu === 'customer') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('customer'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('customer/customer_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('customer'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('customer/customer_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('customer'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼処理場 -->
				<li class="<?php echo ($this->current_main_menu === 'disposal') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('disposal'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('disposal/disposal_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('disposal'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('disposal/disposal_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('disposal'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼工種 -->
				<li class="<?php echo ($this->current_main_menu === 'construction_type') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('construction_type'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('construction_type/construction_type_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('construction_type'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('construction_type/construction_type_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('construction_type'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼種別 -->
				<li class="<?php echo ($this->current_main_menu === 'construction_detail') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('construction_detail'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('construction_detail/construction_detail_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('construction_detail'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('construction_detail/construction_detail_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('construction_detail'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼単価 -->
				<li class="<?php echo ($this->current_main_menu === 'unit_price') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('unit_price'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('unit_price/unit_price_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('unit_price'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('unit_price/unit_price_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('unit_price'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼工事 -->
				<li class="<?php echo ($this->current_main_menu === 'construction') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('construction'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('construction/construction_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('construction'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('construction/construction_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('construction'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
                <!-- ▼勤怠 -->
				<li class="<?php echo ($this->current_main_menu === 'attendance') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('attendance'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('attendance/attendance_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('attendance'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('attendance/attendance_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('attendance'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
				<?php endif; ?>
                <!-- ▲管理者 -->

				<li class="<?php echo ($this->current_main_menu === 'user' or $this->current_main_menu === 'password') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> <?php echo config_item('user'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
				        <!-- 以下管理 -->
						<?php if ($this->login_user->is_admin()): ?>
						<li><a href="<?php echo site_url('user/user_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('user'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('user/user_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('user'.'_package_name_label'); ?>を新規登録する</a></li>
						<?php endif; ?>
						<li><a href="<?php echo site_url('password/password_edit/'); ?>"><i class="icon-home"></i> パスワード変更</a></li>
					</ul>
				</li>
				<?php if ($this->login_user->is_nds_root() && Account_type::is_system_admin($this->login_user->account_type)): ?>
                <!-- ▼分類 -->
				<li class="<?php echo ($this->current_main_menu === 'construction_category') ? 'active' : ''; ?> dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> <?php echo config_item('construction_category'.'_package_name_label'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('construction_category/construction_category_search/'); ?>"><i class="icon-search"></i> <?php echo config_item('construction_category'.'_package_name_label'); ?>を検索する</a></li>
						<li><a href="<?php echo site_url('construction_category/construction_category_register/'); ?>"><i class="icon-plus"></i> <?php echo config_item('construction_category'.'_package_name_label'); ?>を新規登録する</a></li>
					</ul>
				</li>
				<?php endif; ?>
		    	</ul>
        		<?php if (($this->login_user !== FALSE) && is_not_blank($this->login_user->user_code)): ?>
                <ul class="nav pull-right">
                <li class-"dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		        	    <i class="icon-user icon-white"></i> <?php echo $this->login_user->user_name; ?><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
			        <li><a href="<?php echo site_url('login/login/logout/'); ?>">ログアウト</a></li>
                    </ul>
                </li>
                </ul>
		        <?php endif; ?>
			<?php endif; ?>

		    </div><!--/.collapse -->
		</div><!--/.container-fluid -->
	</div><!--/.navbar-inner -->
</div><!--/.navbar -->
