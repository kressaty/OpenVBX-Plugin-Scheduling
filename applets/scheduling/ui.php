<?php
$defaultNumberOfChoices = 1;
$timestart = AppletInstance::getValue('timestart[]', array('--') );
$timefinish = AppletInstance::getValue('timefinish[]', array('--') );
$sunday = AppletInstance::getValue('sunday[]');
$monday = AppletInstance::getValue('monday[]');
$tuesday = AppletInstance::getValue('tuesday[]');
$wednesday = AppletInstance::getValue('wednesday[]');
$thursday = AppletInstance::getValue('thursday[]');
$friday = AppletInstance::getValue('friday[]');
$saturday = AppletInstance::getValue('saturday[]');
$ci_timezone = AppletInstance::getValue('timezones');
$choices = AppletInstance::getDropZoneValue('choices[]');

$days = AppletInstance::getValue('days');

function day_check($day, $key){
	
	$value = AppletInstance::getValue($day);
			
	if (count($value) > 1)
	{		
		if($value[$key] == "true")
		{
			return "selected";
		}
	}
	elseif (count($value) == "true")
	{
		if($value == 1)
		{
			return "selected";
		}
	}
	else
	{
		return "failed";
	}

}

$ci = & get_instance();

if(!isset($ci_timezone))
{
	$ci_timezone = "UM8";
}

$ci->config->set_item('time_reference', 'local');
$ci->load->helper('date');
$now = now();

$offset = (int)timezones($ci_timezone);

$hour = date("G") + $offset;

$server_time = mktime($hour, date("i"), date("s"));

?>
<div class="vbx-applet scheduling">

<h2 class="settings-title">Scheduling Options</h2>
<div class="vbx-applet-fieldset">
	<p>Reminder: overlapping times can/will cause issues with the way the flow progresses. Keep track of your time periods, and always test before putting into production use.</p>
	<p>According to your current time zone setting, it is <?php echo date("g:i A", $server_time);?>.</p>
	<label class="large">Timezone</label><?php echo timezone_menu($ci_timezone);?>
</div>
<table class="vbx-menu-grid options-table">
	<thead>
		<tr>
			<td>Between</td>
			<td>On Days</td>
			<td>Run Applet</td>
			<td>Add &amp; Remove</td>
		</tr>
	</thead>
	<tfoot>
		<tr class="hide">
			<td>
				<fieldset class="openvbx-input-container vbx-applet-fieldset">
				
				<label for="new-timestart[]">Starting Time</label>
				<select class="timestart sel" style="width: auto;!important" name="new-timestart[]">
					<option value="">--</option>
					<option value="00:00">Midnight</option>
					<option value="00:15">12:15 AM</option>
					<option value="00:30">12:30 AM</option>
					<option value="00:45">12:45 AM</option>
					<?php $i = 1;?>
					<?php while($i < 12):?>
					<option value="<?php echo $i.':00';?>"><?php echo $i.':00';?> AM</option>
					<option value="<?php echo $i.':15';?>"><?php echo $i.':15';?> AM</option>
					<option value="<?php echo $i.':30';?>"><?php echo$i.':30';?> AM</option>
					<option value="<?php echo $i.':45';?>"><?php echo $i.':45';?> AM</option>
					<?php $i++;?>
					<?php endwhile?>
					<option value="12:00">Noon</option>
					<option value="12:15">12:15 PM</option>
					<option value="12:30">12:30 PM</option>
					<option value="12:45">12:45 PM</option>
					<?php $i = 1;?>
					<?php while($i <= 12):?>
					<option value="<?php echo ($i+12).':00';?>"><?php echo $i.':00';?> PM</option>
					<option value="<?php echo ($i+12).':15';?>"><?php echo $i.':15';?> PM</option>
					<option value="<?php echo ($i+12).':30';?>"><?php echo $i.':30';?> PM</option>
					<option value="<?php echo ($i+12).':45';?>"><?php echo $i.':45';?> PM</option>
					<?php $i++;?>
					<?php endwhile?>
				</select>
				
				<br />
				<label for="new-timefinish[]">Ending Time</label>
				<select class="timefinish sel" style="width: auto;!important"  name="new-timefinish[]">
					<option value="">--</option>
					<option value="00:00">Midnight</option>
					<option value="00:15">12:15 AM</option>
					<option value="00:30">12:30 AM</option>
					<option value="00:45">12:45 AM</option>
					<?php $i = 1;?>
					<?php while($i < 12):?>
					<option value="<?php echo $i.':00';?>"><?php echo $i.':00';?> AM</option>
					<option value="<?php echo $i.':15';?>"><?php echo $i.':15';?> AM</option>
					<option value="<?php echo $i.':30';?>"><?php echo$i.':30';?> AM</option>
					<option value="<?php echo $i.':45';?>"><?php echo $i.':45';?> AM</option>
					<?php $i++;?>
					<?php endwhile?>
					<option value="12:00">Noon</option>
					<option value="12:15">12:15 PM</option>
					<option value="12:30">12:30 PM</option>
					<option value="12:45">12:45 PM</option>
					<?php $i = 1;?>
					<?php while($i <= 12):?>
					<option value="<?php echo ($i+12).':00';?>"><?php echo $i.':00';?> PM</option>
					<option value="<?php echo ($i+12).':15';?>"><?php echo $i.':15';?> PM</option>
					<option value="<?php echo ($i+12).':30';?>"><?php echo $i.':30';?> PM</option>
					<option value="<?php echo ($i+12).':45';?>"><?php echo $i.':45';?> PM</option>
					<?php $i++;?>
				<?php endwhile?>
				</select>
				
				</fieldset>
			</td>
			<td>
				<div class="day">
					<label>Sun</label>
					<select class="day_check sunday" name="new-sunday[]">
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Mon</label>
					<select class="day_check monday" name="new-monday[]">
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Tue</label>
					<select class="day_check tuesday" name="new-tuesday[]" >
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Wed</label>
					<select class="day_check wednesday" name="new-wednesday[]">
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Thu</label>
					<select class="day_check thursday" name="new-thursday[]">
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Fri</label>
					<select class="day_check friday" name="new-friday[]">
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Sat</label>
					<select class="day_check saturday" name="new-saturday[]">
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
				</div>
			</td>
			<td>
                <?php echo AppletUI::dropZone('new-choices[]', 'Drop item here'); ?>
			</td>
			<td>
				<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php if(count($timestart)>1):?>
        <?php foreach($timestart as $b=>$time): ?>
		<tr>
			<td>
				<fieldset class="openvbx-input-container vbx-applet-fieldset">
					<label for="timestart[]">Starting Time</label>					
                    <select class="timestart sel" style="width: auto;!important"  name="timestart[]">
	                    <option <?php if ($time == '--'){echo "selected";}?> value="--">--</option>
	                    <option <?php if ($time == '00:00'){echo "selected";}?> value="00:00">Midnight</option>
	                    <option <?php if ($time == '00:15'){echo "selected";}?>  value="00:15">12:15 AM</option>
	                    <option <?php if ($time == '00:30'){echo "selected";}?>  value="00:30">12:30 AM</option>
	                    <option <?php if ($time == '00:45'){echo "selected";}?>  value="00:45">12:45 AM</option>
	                    <?php $i = 1;?>
	                    <?php while($i < 12):?>
	                    <option <?php if ($time == $i.':00'){echo "selected";}?> value="<?php echo $i.':00';?>"><?php echo $i.':00';?> AM</option>
	                    <option <?php if ($time == $i.':15'){echo "selected";}?> value="<?php echo $i.':15';?>"><?php echo $i.':15';?> AM</option>
	                    <option <?php if ($time == $i.':30'){echo "selected";}?> value="<?php echo $i.':30';?>"><?php echo$i.':30';?> AM</option>
	                    <option <?php if ($time == $i.':45'){echo "selected";}?> value="<?php echo $i.':45';?>"><?php echo $i.':45';?> AM</option>
	                    <?php $i++;?>
	                    <?php endwhile?>
	                    <option <?php if ($time == '12:00'){echo "selected";}?>  value="12:00">Noon</option>
	                    <option <?php if ($time == '12:15'){echo "selected";}?>  value="12:15">12:15 PM</option>
	                    <option <?php if ($time == '12:30'){echo "selected";}?>  value="12:30">12:30 PM</option>
	                    <option <?php if ($time == '12:45'){echo "selected";}?>  value="12:45">12:45 PM</option>
	                    <?php $i = 1;?>
	                    <?php while($i < 12):?>
	                    <option <?php if ($time == ($i+12).':00'){echo "selected";}?> value="<?php echo ($i+12).':00';?>"><?php echo $i.':00';?> PM</option>
	                    <option <?php if ($time == ($i+12).':15'){echo "selected";}?> value="<?php echo ($i+12).':15';?>"><?php echo $i.':15';?> PM</option>
	                    <option <?php if ($time == ($i+12).':30'){echo "selected";}?> value="<?php echo ($i+12).':30';?>"><?php echo $i.':30';?> PM</option>
	                    <option <?php if ($time == ($i+12).':45'){echo "selected";}?> value="<?php echo ($i+12).':45';?>"><?php echo $i.':45';?> PM</option>
	                    <?php $i++;?>
	                    <?php endwhile?>
	                    
                    </select>
                    
                    <br />
                    <label for="timefinish[]">Ending Time</label>
                    <select class="timefinish sel" style="width: auto;!important"  name="timefinish[]">
                    <option <?php if ($timefinish[$b]  == '--'){echo "selected";}?> value="--">--</option>
                    <option <?php if ($timefinish[$b] == '00:00'){echo "selected";}?> value="00:00">Midnight</option>
                    <option <?php if ($timefinish[$b] == '00:15'){echo "selected";}?>  value="00:15">12:15 AM</option>
                    <option <?php if ($timefinish[$b] == '00:30'){echo "selected";}?>  value="00:30">12:30 AM</option>
                    <option <?php if ($timefinish[$b] == '00:45'){echo "selected";}?>  value="00:45">12:45 AM</option>
                    <?php $i = 1;?>
                    <?php while($i < 12):?>
                    <option <?php if ($timefinish[$b] == ($i.':00')){echo "selected";}?> value="<?php echo $i.':00';?>"><?php echo $i.':00';?> AM</option>
                    <option <?php if ($timefinish[$b] == ($i.':15')){echo "selected";}?> value="<?php echo $i.':15';?>"><?php echo $i.':15';?> AM</option>
                    <option <?php if ($timefinish[$b] == ($i.':30')){echo "selected";}?> value="<?php echo $i.':30';?>"><?php echo$i.':30';?> AM</option>
                    <option <?php if ($timefinish[$b] == ($i.':45')){echo "selected";}?> value="<?php echo $i.':45';?>"><?php echo $i.':45';?> AM</option>
                    <?php $i++;?>
                    <?php endwhile?>
                    <option <?php if ($timefinish[$b] == '12:00'){echo "selected";}?>  value="12:00">Noon</option>
                    <option <?php if ($timefinish[$b] == '12:15'){echo "selected";}?>  value="12:15">12:15 PM</option>
                    <option <?php if ($timefinish[$b] == '12:30'){echo "selected";}?>  value="12:30">12:30 PM</option>
                    <option <?php if ($timefinish[$b] == '12:45'){echo "selected";}?>  value="12:45">12:45 PM</option>
                    <?php $i = 1;?>
                    <?php while($i < 12):?>
                    <option <?php if ($timefinish[$b] == ($i+12).':00'){echo "selected";}?> value="<?php echo ($i+12).':00';?>"><?php echo $i.':00';?> PM</option>
                    <option <?php if ($timefinish[$b] == ($i+12).':15'){echo "selected";}?> value="<?php echo ($i+12).':15';?>"><?php echo $i.':15';?> PM</option>
                    <option <?php if ($timefinish[$b] == ($i+12).':30'){echo "selected";}?> value="<?php echo ($i+12).':30';?>"><?php echo $i.':30';?> PM</option>
                    <option <?php if ($timefinish[$b] == ($i+12).':45'){echo "selected";}?> value="<?php echo ($i+12).':45';?>"><?php echo $i.':45';?> PM</option>
                    <?php $i++;?>
                    <?php endwhile?>
                    </select>
                    
				</fieldset>
			</td>
			<td>
				<div class="day">
					<label>Sun</label>
					<select name="sunday[]">
						<option name="sunday[]" value="false">Off</option>
						<option <?php echo day_check('sunday[]', $b);?> name="sunday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Mon</label>
					<select name="monday[]">
						<option name="monday[]" value="false">Off</option>
						<option <?php echo day_check('monday[]', $b);?> name="monday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Tue</label>
					<select name="tuesday[]">
						<option name="tuesday[]" value="false">Off</option>
						<option <?php echo day_check('tuesday[]', $b);?> name="tuesday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Wed</label>
					<select name="wednesday[]">
						<option name="wednesday[]" value="false">Off</option>
						<option <?php echo day_check('wednesday[]', $b);?> name="wednesday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Thu</label>
					<select name="thursday[]">
						<option name="thursday[]" value="false">Off</option>
						<option <?php echo day_check('thursday[]', $b);?> name="thursday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Fri</label>
					<select name="friday[]">
						<option name="friday[]" value="false">Off</option>
						<option <?php echo day_check('friday[]', $b);?> name="friday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Sat</label>
					<select name="saturday[]">
						<option name="saturday[]" value="false">Off</option>
						<option <?php echo day_check('saturday[]', $b);?> name="saturday[]" value="true">On</option>
					</select>
				</div>
			</td>
			<td>
				<?php echo AppletUI::dropZone('choices['.($b).']', 'Drop item here'); ?>
			</td>
			<td>
				<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php else:?>
		<?php $b = 0;?>
		<tr>
			<td>
				<fieldset class="openvbx-input-container vbx-applet-fieldset">
					<label for="timestart[]">Starting Time</label>
					
		            <select class="timestart sel" style="width: auto;!important"  name="timestart[]">
		            <option <?php if ($timestart == '--'){echo "selected";}?> value="--">--</option>
		            <option <?php if ($timestart == '00:00'){echo "selected";}?> value="00:00">Midnight</option>
		            <option <?php if ($timestart == '00:15'){echo "selected";}?>  value="00:15">12:15 AM</option>
		            <option <?php if ($timestart == '00:30'){echo "selected";}?>  value="00:30">12:30 AM</option>
		            <option <?php if ($timestart == '00:45'){echo "selected";}?>  value="00:45">12:45 AM</option>
		            <?php $i = 1;?>
		            <?php while($i < 12):?>
		            <option <?php if ($timestart == $i.':00'){echo "selected";}?> value="<?php echo $i.':00';?>"><?php echo $i.':00';?> AM</option>
		            <option <?php if ($timestart == $i.':15'){echo "selected";}?> value="<?php echo $i.':15';?>"><?php echo $i.':15';?> AM</option>
		            <option <?php if ($timestart == $i.':30'){echo "selected";}?> value="<?php echo $i.':30';?>"><?php echo$i.':30';?> AM</option>
		            <option <?php if ($timestart == $i.':45'){echo "selected";}?> value="<?php echo $i.':45';?>"><?php echo $i.':45';?> AM</option>
		            <?php $i++;?>
		            <?php endwhile?>
		            <option <?php if ($timestart == '12:00'){echo "selected";}?>  value="12:00">Noon</option>
		            <option <?php if ($timestart == '12:15'){echo "selected";}?>  value="12:15">12:15 PM</option>
		            <option <?php if ($timestart == '12:30'){echo "selected";}?>  value="12:30">12:30 PM</option>
		            <option <?php if ($timestart == '12:45'){echo "selected";}?>  value="12:45">12:45 PM</option>
		            <?php $i = 1;?>
		            <?php while($i < 12):?>
		            <option <?php if ($timestart == ($i+12).':00'){echo "selected";}?> value="<?php echo ($i+12).':00';?>"><?php echo $i.':00';?> PM</option>
		            <option <?php if ($timestart == ($i+12).':15'){echo "selected";}?> value="<?php echo ($i+12).':15';?>"><?php echo $i.':15';?> PM</option>
		            <option <?php if ($timestart == ($i+12).':30'){echo "selected";}?> value="<?php echo ($i+12).':30';?>"><?php echo $i.':30';?> PM</option>
		            <option <?php if ($timestart == ($i+12).':45'){echo "selected";}?> value="<?php echo ($i+12).':45';?>"><?php echo $i.':45';?> PM</option>
		            <?php $i++;?>
		            <?php endwhile?>
		            
		            </select>
		            
		            <br />
		            <label for="timefinish[]">Ending Time</label>
		            <select class="timefinish sel" style="width: auto;!important"  name="timefinish[]">
		            <option <?php if ($timefinish  == '--'){echo "selected";}?> value="--">--</option>
		            <option <?php if ($timefinish == '00:00'){echo "selected";}?> value="00:00">Midnight</option>
		            <option <?php if ($timefinish == '00:15'){echo "selected";}?>  value="00:15">12:15 AM</option>
		            <option <?php if ($timefinish == '00:30'){echo "selected";}?>  value="00:30">12:30 AM</option>
		            <option <?php if ($timefinish == '00:45'){echo "selected";}?>  value="00:45">12:45 AM</option>
		            <?php $i = 1;?>
		            <?php while($i < 12):?>
		            <option <?php if ($timefinish == ($i.':00')){echo "selected";}?> value="<?php echo $i.':00';?>"><?php echo $i.':00';?> AM</option>
		            <option <?php if ($timefinish == ($i.':15')){echo "selected";}?> value="<?php echo $i.':15';?>"><?php echo $i.':15';?> AM</option>
		            <option <?php if ($timefinish == ($i.':30')){echo "selected";}?> value="<?php echo $i.':30';?>"><?php echo$i.':30';?> AM</option>
		            <option <?php if ($timefinish == ($i.':45')){echo "selected";}?> value="<?php echo $i.':45';?>"><?php echo $i.':45';?> AM</option>
		            <?php $i++;?>
		            <?php endwhile?>
		            <option <?php if ($timefinish == '12:00'){echo "selected";}?>  value="12:00">Noon</option>
		            <option <?php if ($timefinish == '12:15'){echo "selected";}?>  value="12:15">12:15 PM</option>
		            <option <?php if ($timefinish == '12:30'){echo "selected";}?>  value="12:30">12:30 PM</option>
		            <option <?php if ($timefinish == '12:45'){echo "selected";}?>  value="12:45">12:45 PM</option>
		            <?php $i = 1;?>
		            <?php while($i < 12):?>
		            <option <?php if ($timefinish == ($i+12).':00'){echo "selected";}?> value="<?php echo ($i+12).':00';?>"><?php echo $i.':00';?> PM</option>
		            <option <?php if ($timefinish == ($i+12).':15'){echo "selected";}?> value="<?php echo ($i+12).':15';?>"><?php echo $i.':15';?> PM</option>
		            <option <?php if ($timefinish == ($i+12).':30'){echo "selected";}?> value="<?php echo ($i+12).':30';?>"><?php echo $i.':30';?> PM</option>
		            <option <?php if ($timefinish == ($i+12).':45'){echo "selected";}?> value="<?php echo ($i+12).':45';?>"><?php echo $i.':45';?> PM</option>
		            <?php $i++;?>
		            <?php endwhile?>
		            </select>
		            
				</fieldset>
			</td>
			<td>
				<div class="day">
					<label>Sun</label>
					<select name="sunday[]">
						<option name="sunday[]" value="false">Off</option>
						<option <?php if($sunday == "true"){echo "selected";}?> name="sunday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Mon</label>
					<select name="monday[]">
						<option name="monday[]" value="false">Off</option>
						<option <?php if($monday == "true"){echo "selected";}?> name="monday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Tue</label>
					<select name="tuesday[]" >
						<option name="tuesday[]" value="false">Off</option>
						<option <?php if($tuesday == "true"){echo "selected";}?> name="tuesday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Wed</label>
					<select name="wednesday[]">
						<option name="wednesday[]" value="false">Off</option>
						<option <?php if($wednesday == "true"){echo "selected";}?> name="wednesday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Thu</label>
					<select name="thursday[]">
						<option name="thursday[]" value="false">Off</option>
						<option <?php if($thursday == "true"){echo "selected";}?> name="thursday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Fri</label>
					<select name="friday[]">
						<option name="friday[]" value="false">Off</option>
						<option <?php if($friday == "true"){echo "selected";}?> name="friday[]" value="true">On</option>
					</select>
				</div>
				<div class="day">
					<label>Sat</label>
					<select name="saturday[]">
						<option name="saturday[]" value="false">Off</option>
						<option <?php if($saturday == "true"){echo "selected";}?> name="saturday[]" value="true">On</option>
					</select>
				</div>
			</td>
			<td>
				<?php echo AppletUI::dropZone('choices['.($b).']', 'Drop item here'); ?>
			</td>
			<td>
				<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
			</td>
		</tr>		
		<?php endif;?>
	</tbody>
</table>


<div class="more-settings">
	<h3>More settings</h3>
    <br />
	<p class="setting-desc">If your time window is not listed above, or if there is a conflict...</p>
	<div class="invalid-option">
        <?php echo AppletUI::DropZone('fallback'); ?>
	</div>
</div>
</div>