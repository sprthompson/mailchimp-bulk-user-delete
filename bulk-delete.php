<?
include 'header.php';
?>
<?php
// Functions to do actions

function pleasedelete($email) {
/**
This Example shows how to pull the Info for a Member of a List using the MCAPI.php 
class and do some basic error checking.
**/
require_once 'inc/MCAPI.class.php';
require_once 'inc/config.inc.php'; //contains apikey

$api = new MCAPI($_REQUEST["apikey"]);

$retval = $api->listUnsubscribe( $_REQUEST["listid"],$email,true,false,false);
if ($api->errorCode){
    echo "Unable to load listUnsubscribe()!\n";
	echo "\tCode=".$api->errorCode."\n";
	echo "\tMsg=".$api->errorMessage."\n";
} else {
    echo "Returned: ".$retval."\n";
}

}




// Upload a file with 2 columns, full number, status
if ($_GET["mcboogie"] == "woogie") { //  form was submitted
	

if ($_FILES["file"]["error"] > 0) // I got this code somewhere ...
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />"; 
  }
else
  {

 if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) { // $Data = row data

		// Get the email address
		$email = $data[0];
		
		if ($_REQUEST["delete"] == "true") {
		
		pleasedelete($email);
		
		}
		
		echo $email . " - deleted <br />";
		
		$row++;
    }
	

  }

	
}
	
	} else {
// Show form for uploading
	
	?>


<h1>MailChimp tools - Bulk Delete</h1>
<p>Import a list of email addresses (in a text file) - then click 'delete' and this will delete the whole batch of email users from your mailchimp list.<br/><br/><strong>There will be no 'are you sure' screen, and no 'undo' button. Once you delete these users they will be gone completely from your list. - As will their unsubscribe data, and activity history etc. Make sure this is the right action to take before you do this! Mailchimp offers a bulk unsubscribe feature which is safer. Also it might be worth <a href="http://kb.mailchimp.com/article/does-mailchimp-backup-my-data">backing up your data first</a>.</strong></p>
<p><form action="bulk-delete.php?mcboogie=woogie" method="post"
enctype="multipart/form-data">
<label for="file">List of email addresses:</label>
<input type="file" name="file" id="file" />
<br />
<label for="delete">Tick to acknowledge DELETION:</label><input type="checkbox" name="delete" value="true" /> - by ticking here you agree that you realise what you're doing.<br>
<br />
<label for="apikey">API Key to use</label><input type="text" name="apikey" />.<br>
<br />
<label for="listid">Unique ID for the list</label><input type="text" name="listid" />.<br>
<br />
<input type="submit" name="submit" value="DELETE" />
</form></p>

<?

}
// end form for uploading if nothing is uploaded

?>
<?
include 'footer.php';
?>