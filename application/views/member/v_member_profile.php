<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">Edit Profile</span></h1>
                    </div>
        
                    <div class="content_container box-content">
 

        				<?php if($this->session->flashdata('log')){ ?>
                        <div class="log">
                            <?=$this->session->flashdata('log')?>
                        </div>
                        <?php } ?>

                        <?=form_open_multipart('member/profile/update_exec');?>
                        
                        <?=form_hidden('account_id', $this->session->userdata('user_id'))?>
                
                        <label for="first_name">First name</label>
                        <p><input type="text" id="first_name" name="first_name" value="<?=$bio->first_name?>" ></p>
                
                        <label for="middle_name">Middle name</label>
                        <p><input type="text" id="middle_name" name="middle_name" value="<?=$bio->middle_name?>" ></p>
                
                        <label for="last_name">Last name</label>
                        <p><input type="text" id="last_name" name="last_name" value="<?=$bio->last_name?>" ></p>
                
                        <label for="dob">DOB</label>
                        <p>
                        <select class="dobselect" name="bdate" id="bdate">
                            <option value="">--Day--</option>
                        <?php
                            for($day=1;$day<=31;$day++){
                                echo '<option value="'. $day .'"';
                                if($day == clean_date($bio->dob, 'j')) { //in case I forget, clean_date is a function from pretty_date helper
                                    echo ' selected="selected"';
                                }
                                echo '>'. $day .'</option>';
                            }
                        ?>
                        </select> -
                        <select class="dobselect" name="bmonth" id="bmonth">
                            <option value="">--Month--</option>
                        <?php
                            $months = array(
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December');
                            for($month=1;$month<=12;$month++){
                                $i = substr($bio->dob,5,2); //in case I forget, this is the function to strip only the month from the bios.dob 
                                if ($month == $i){
                                    echo "<option value='$i' selected=\"selected\">".$months[$month]."</option>";
                                }else{
                                echo "<option value=\"$month\">".$months[$month]."</option>";
                                }
                            }
                         ?>
                         </select>
                         -
                        <select class="dobselect" name="byear" id="byear">
                            <option value="">--Year--</option>
                        <?php
                            $year = date("Y");
                            while($year >=1930){
                                    echo '<option value="'. $year .'"';
                                    if($year == clean_date($bio->dob, 'Y')) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>'. $year .'</option>';
                                $year--;
                            }
                        ?>
                        </select>
                        </p>
                
                        <label for="address">Address</label>
                        <p><textarea id="address" name="address"><?=nl2br($bio->address)?></textarea></p>
                
                        <label for="location">Location</label>
                        <p><input type="text" id="location" name="location" value="<?=$bio->location?>" ></p>
                
                        <label for="website">Website</label>
                        <p><input type="text" id="website" name="website" value="<?=$bio->website?>" ></p>
                
                        <label for="about_me">About Me</label>
                        <p><textarea id="about_me" name="about_me"><?=nl2br($bio->about_me)?></textarea></p>
                
                        <label for="occupation">Occupation</label>
                        <p><input type="text" id="occupation" name="occupation" value="<?=$bio->occupation?>" ></p>
                
                        <label for="hobby">Hobby</label>
                        <p><input type="text" id="hobby" name="hobby" value="<?=$bio->hobby?>" ></p>
                
                        <label for="interest">Interest</label>
                        <p><input type="text" id="interest" name="interest" value="<?=$bio->interest?>" ></p>
                
                        <label for="photo">Photo</label>
                        <?php if(!empty($bio->photo)){ ?><p><img src="<?php echo base_url(); ?>assets/avatar/<?php echo $bio->photo;?>" /></p><?php } ?>

                        <label>&nbsp;</label>
                        <p><small>Note : Max size <strong>100KB</strong>; Max dimension <strong>500px</strong>; Your photo will be resized so as not being wider than <strong>150px</strong></small></p>

                        <label>&nbsp;</label>
                        <p><input type="file" id="photo" name="photo" /></p>
                        
                        
                        <input class="btn" type="submit" name="submit" value="update" /> 
                        <a class="btn" href="<?php echo base_url();?>member">Cancel</a>
                        
                        <?=form_close()?>
        
                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

            <?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
