<?php
function EvonaBackgroundSettings2(){
	$request_uri_array = explode("/", $_SERVER['REQUEST_URI']);
	$currenturl = htmlentities(get_site_url(NULL, "/". $request_uri_array[count($request_uri_array)-2]."/" .end($request_uri_array)));
	if(isset($_GET['editcss']) && $_GET['editcss']=='true'){
		$cssfile = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig'.DIRECTORY_SEPARATOR.'evonabackground.css';
		?>
		<div class="wrap">
        <h2>Edit Random background CSS</h2>
		<?php
		if(isset($_POST['css'])){
			if($csswritehandle = fopen($cssfile, 'w')){
				fwrite($csswritehandle, stripslashes_deep($_POST['css']));
				fclose($csswritehandle);
				echo "<p>Succesfully edited ".$cssfile."!</p>";
			}else{echo "Error writing CSS to ".$cssfile.". Is this file writable?";}
		}
		if($csshandle = fopen($cssfile, 'r')){
			$css = fread($csshandle, filesize($cssfile));
			fclose($csshandle);
			?>
			<form method="post" action="<?php echo $currenturl; ?>">
			<textarea style="white-space:pre; width:80%; min-width:600px; height:300px;" name="css"><?php echo $css ?></textarea>
			<?php
			submit_button();
		}else{echo "Failed reading CSS file".$cssfile.". Is the file readable?";}
		echo "</form></div>";
	}else{
	  $backgroundfile = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig'.DIRECTORY_SEPARATOR.'backgrounds.txt';
	  $backgrounds = file($backgroundfile, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	  if(isset($_POST['submit'])):
		  $strippedpost = stripslashes_deep($_POST);
		  foreach($strippedpost as $key => $value){
			  if(is_numeric($key)){
				  $selected = 'select'.$key;
				  if($value == "%DELETE%"){
					  unset($backgrounds[$key]);
				  }elseif($_POST[$selected] == 'stretched'){
					  $value = "<img src=\"".$value."\" class=\"evonabackground\" alt=\"background\" />";				
				  }elseif($_POST[$selected] == 'tiled'){
					  $value = "<div class=\"evonabackground\" style=\"background:url('".$value."') repeat;\"></div>";				
				  }
				  if($value != "%DELETE%"){
					  $backgrounds[$key] = html_entity_decode($value);
				  }
			  }
		  }
		  if($backgroundhandle = fopen($backgroundfile, 'w')){
			  $write = implode("\n", $backgrounds);
			  fwrite($backgroundhandle, $write);
			  fclose($backgroundhandle);
			  unset($backgrounds);
			  $backgrounds = explode("\n", $write);
			  $message = "Entries succesfully updated";
		  }else{
				$message = "Failed updating entries. Is ".$backgroundfile." writable?";
			}
		endif;
			?>
			<div class="wrap">
			<?php screen_icon(); ?>
			<h2>Set your random backgrounds</h2>
			<h3>Backgrounds (in HTML)</h3>
			<?php if(isset($message)){echo $message;} ?>
			<form method="post" action="<?php echo $currenturl; ?>"> 
			<?php
			echo "<ul id=\"evonainputfields\">";
			foreach($backgrounds as $number => $background){
				echo "<li><input class=\"evonainput\" type=\"text\" id=\"".$number."\" name=\"".$number."\" value=\"". htmlentities($background) ."\" />
				<select id=\"select".$number."\" name=\"select".$number."\">
					<option value=\"stretched\">Stretched image file</option>
					<option value=\"tiled\">Tiled pattern</option>
					<option selected=\"selected\" value=\"custom\">Custom HTML</option>
				</select>
				<br />
				<div class=\"evonademo\" id=\"demo".$number."\">".$background."</div><br />
				<a onclick=\"delete_field(".$number.")\" id=\"delete".$number."\" class=\"deletebutton\">[X] delete this entry</a></li>";
			}?>
			</ul>
			<a id='newfield' onclick="create_field()">+ New background</a>
			<?php
				submit_button(); 
			?>
			</form>
			<a href="<?php echo $currenturl.'&amp;editcss=true';?>">Edit the CSS file</a>
            </div>
			<script type="text/javascript">
			var backgroundcount = <?php echo count($backgrounds); ?>;
			function create_field(){
				var newlist = document.createElement('li');
				newlist.innerHTML = "<input class=\"newform evonainput\" type=\"text\" name=\"" + backgroundcount + "\" id=\"" + backgroundcount + "\" value = \"\" /><select id=\"select"+backgroundcount+"\" name=\"select"+backgroundcount+"\"><option selected=\"selected\" value=\"stretched\">Stretched image file</option><option value=\"tiled\">Tiled pattern</option><option value=\"custom\">Custom HTML</option></select><br /><a onclick=\"delete_field("+ backgroundcount +")\" id=\"delete" + backgroundcount + "\" class=\"deletebutton\">[X] delete this entry</a>";
				var evonainputfields = document.getElementById('evonainputfields');
				evonainputfields.appendChild(newlist);
				
				backgroundcount++
			}
			
			function delete_field(fieldid){
				var buttonid = 'delete'+fieldid;
				var selectedid = 'select'+fieldid;
				var demoid = 'demo'+fieldid;
				var button = document.getElementById(buttonid);
				var demo = document.getElementById(demoid);
				var selected = document.getElementById(selectedid);
				var todelete = document.getElementById(fieldid);
				
				todelete.value="%DELETE%";
				todelete.style.display="none";
				button.style.display="none";
				selected.style.display="none";
				if (demo != null){demo.style.display="none";}
				
				
			}
		</script>
		<script type="text/javascript">
		jQuery(document).ready(function($){
		  var custom_uploader;
		  $('body').on('click','.evonainput',(function(e) {
			  var eventid = e.target.id;
			  var eventoption = document.getElementById('select'+e.target.id);
			  if(eventoption.options[eventoption.selectedIndex].value == 'custom'){
				  //do nothing
			  }else{
				e.preventDefault();
				//If the uploader object has already been created, reopen the dialog
				if (custom_uploader) {
					custom_uploader.open();
					return;
				}
				//Extend the wp.media object
				custom_uploader = wp.media.frames.file_frame = wp.media({
					title: 'Choose Image',
					button: {
						text: 'Choose Image'
					},
					multiple: false
				});
		 
				//When a file is selected, grab the URL and set it as the text field's value
				custom_uploader.on('select', function() {
					attachment = custom_uploader.state().get('selection').first().toJSON();
					$('#'+eventid).val(attachment.url);
				});
				//Open the uploader dialog
				custom_uploader.open();
			  }
		  }));
	   
	  });
		</script>		
		<?php
	}
}
?>