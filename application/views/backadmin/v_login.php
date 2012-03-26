<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php #$this->load->view('includes/backadmin/header.php');?>

    <div id="header">
        <h1 id="logo"><a href="<?php echo $admin_link;?>">HuntDrop</a></h1>
    </div>

	<div id="content" class="login">
		
        <div id="main_section" class="login_section">
        
                <h1>Log in</h1>
				<?php
                    $log = $this->session->flashdata('log');
                    if( ! empty($log) ) {
                ?>
                <div class="log">
                    <?=$log?>
                </div><!-- .section -->
                <?
                    }
                ?>
                <?=form_open('backadmin/login/login_exec', array('id'=>'login', 'class'=>''))?>
                    <p>
                        <label for="user_name">username</label>
                        <input type="text" name="user_name" id="user_name" />
                    </p>
                    <p>
                        <label for="pass">password</label>
                        <input type="password" name="pass" id="pass" />
                    </p>
                    <p>
                        <input type="submit" class="btn" name="login" value="Sign in" />
                    </p>
                <?=form_close()?>
                    
                

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>