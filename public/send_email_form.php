<?php
/**
 * The template to display the email form
 *
 * @package WordPress
 * @subpackage Map List Search 1.0
 * @since 1.0
 */

get_header(); ?>

<section id="primary" class="content-area">
<div id="content" class="site-content" role="main">


<header class="entry-header"><h1 class="entry-title">Send Claim to this attorney</h1></header><!-- .entry-header -->

<?php

///////////////////////////////////////////////////////////////////////
// init vars
$action = $_POST["action"];
$sent   = $_POST["sent"];
$myfields = get_post_meta($_GET['mls_id'], 'contact_information')[0];

$name     = $myfields['name'];
$street   = $myfields['street'];
$city     = $myfields['city'];
$county   = $myfields['county'];
$stateprovince  = $myfields['stateprovince'];
$postalco = $myfields['postalcode'];
$country  = $myfields['country'];
$phone    = $myfields['phone'];
$fax      = $myfields['fax'];
$email    = $myfields['email']; 
$url      = $myfields['url'];
$contact  = $myfields['contact']; 
$areas    = $myfields['areas' ];

?>

	<script language="JavaScript" src="js/string.js"></script>
		<script language="JavaScript" src="js/js_CheckFunctions.js"></script>
		<script>
			function checkForm(){
				var msg = "";
				var yourPhone = document.getElementById("txtPhone").value;
				var yourFax = document.getElementById("txtFax").value;
				var debtorPhone = document.getElementById("txtDebtorPhone").value;
				var fileupload = document.getElementById("flUpload").value;
				var fileupload2 = document.getElementById("flUpload2").value;
				var fileupload3 = document.getElementById("flUpload3").value;
				var fileupload4 = document.getElementById("flUpload4").value;
				var fileupload5 = document.getElementById("flUpload5").value;
				
				var hasFileUpload = false;
				if(fileupload != ""){
					hasFileUpload = true;
				}
				if(fileupload2 != ""){
					hasFileUpload = true;
				}
				if(fileupload3 != ""){
					hasFileUpload = true;
				}
				if(fileupload4 != ""){
					hasFileUpload = true;
				}
				if(fileupload5 != ""){
					hasFileUpload = true;
				}
				
				
				if(!(StringFunctions.isBlank(yourPhone))){
					if(!(StringFunctions.checkPhone(yourPhone))){
						msg = "Please enter the correct format for Your Phone, exampe: 123-456-7890.\n"; 
					}
				}
				
				if(!(StringFunctions.isBlank(yourFax))){
					if(!(StringFunctions.checkPhone(yourFax))){
						msg = "Please enter the correct format for Your Fax, exampe: 123-456-7890.\n"; 
					}
				}
				
				if(!(StringFunctions.isBlank(debtorPhone))){
					if(!(StringFunctions.checkPhone(debtorPhone))){
						msg += "Please enter the correct format for Debtor Phone, exampe: 123-456-7890."; 
					}
				}
				
				if(msg != ""){
					alert(msg);
					return false;
				}
				else if(!hasFileUpload){
					return confirm("You currently do not have a file attached to this claim.  Would you still like to continue?")
				}
				else{
					return true;
				}
			}
		
		
			function submitKey(evt) {
				var evt = (evt) ? evt : ((event) ? event : null);
			  
				if (evt.keyCode == 13) {
					return false;
				}
			}
			
			document.onkeypress = submitKey;
		</script>
		<div id="divContent">
			<?php if($sent){
				print "Your email has been sent.  Thank you.<br/>";
				print "<a href='javascript:history.go(-2);'>back</a>";
			}
			else {?>
				<form method="post" id="frmConfirm" action="" enctype="multipart/form-data">
				<input type="hidden" name="mls_id" value="<?php echo $_REQUEST["mls_id"] ?>"/>
				<table cellpadding=4 cellspacing=0 border=0>
					<?php if($action == "submit"){?>
					
					
						<script>
							function submitForm(act){
								//var form = document.getElementById("frmConfirm");
								var action = document.getElementById("action");
								
								action.value = act;
								//form.submit();
							}
						</script>
					
					
					
						<input type="hidden" name="submit" value="1"/>
						<input type="hidden" name="action" id="action" value=""/>
						<input type="hidden" name="txtName" value="<?=$txtName?>"/>
						<input type="hidden" name="txtTitle" value="<?=$txtTitle?>"/>
						<input type="hidden" name="txtEmail" value="<?=$txtEmail?>"/>
						<input type="hidden" name="txtCompanyName" value="<?=$txtCompanyName?>"/>
						<input type="hidden" name="txtAddress" value="<?=$txtAddress?>"/>
						<input type="hidden" name="txtCity" value="<?=$txtCity?>"/>
						<input type="hidden" name="txtStateProvince" value="<?=$txtStateProvince?>"/>
						<input type="hidden" name="txtPostalCode" value="<?=$txtPostalCode?>"/>
						<input type="hidden" name="txtCountry" value="<?=$txtCountry?>"/>
						<input type="hidden" name="txtPhone" value="<?=$txtPhone?>"/>
						<input type="hidden" name="txtFax" value="<?=$txtFax?>" />
						<input type="hidden" name="txtCreditorName" value="<?=$txtCreditorName?>"/>
						<input type="hidden" name="txtDebtorName" value="<?=$txtDebtorName?>"/>
						<input type="hidden" name="txtDebtorContact" value="<?=$txtDebtorContact?>"/>
						<input type="hidden" name="txtDebtorEmail" value="<?=$txtDebtorEmail?>"/>
						<input type="hidden" name="txtDebtorAddress" value="<?=$txtDebtorAddress?>"/>
						<input type="hidden" name="txtDebtorCity" value="<?=$txtDebtorCity?>"/>
						<input type="hidden" name="txtDebtorStateProvince" value="<?=$txtDebtorStateProvince?>"/>
						<input type="hidden" name="txtDebtorPostalCode" value="<?=$txtDebtorPostalCode?>"/>
						<input type="hidden" name="txtDebtorCountry" value="<?=$txtDebtorCountry?>">
						<input type="hidden" name="txtDebtorPhone" value="<?=$txtDebtorPhone?>"/>
						<input type="hidden" name="txtDebtorAmount" value="<?=$txtDebtorAmount?>"/>
						<input type="hidden" name="txtDebtorAgencyFileNumber" value="<?=$txtDebtorAgencyFileNumber?>"/>
						<input type="hidden" name="newname" value="<?=$newname?>"/>
						<input type="hidden" name="newname2" value="<?=$newname2?>"/>
						<input type="hidden" name="newname3" value="<?=$newname3?>"/>
						<input type="hidden" name="newname4" value="<?=$newname4?>"/>
						<input type="hidden" name="newname5" value="<?=$newname5?>"/>
						<input type="hidden" name="name" value="<?=$_FILES['flUpload']['name']?>"/>
						<input type="hidden" name="name2" value="<?=$_FILES['flUpload2']['name']?>"/>
						<input type="hidden" name="name3" value="<?=$_FILES['flUpload3']['name']?>"/>
						<input type="hidden" name="name4" value="<?=$_FILES['flUpload4']['name']?>"/>
						<input type="hidden" name="name5" value="<?=$_FILES['flUpload5']['name']?>"/>
						<input type="hidden" name="uploadurl" value="<?=$uploadurl?>"/>
						<input type="hidden" name="uploadurl2" value="<?=$uploadurl2?>"/>
						<input type="hidden" name="uploadurl3" value="<?=$uploadurl3?>"/>
						<input type="hidden" name="uploadurl4" value="<?=$uploadurl4?>"/>	
						<input type="hidden" name="uploadurl5" value="<?=$uploadurl5?>"/>				
						<input type="hidden" name="txtComments" value="<?=$txtComments?>"/>
						<input type="hidden" name="txtCollectionRates" value="<?=$txtCollectionRates?>" />
						
						<tr>
							<td style="font-size:8pt;">
								Date: <?php echo date('m/d/Y', time())?>
								<br/><br/>
								<b><?php echo $txtLawFrimName?></b>
								<br/><?php echo $txtLawFrimStreet?>
								<br/><?php echo $txtLawFrimCity?>, <?=$txtLawFrimStateProvince?>, <?=$txtLawFrimStatePostalCode?>
								<br/><br/>
								File #: <?php echo $txtDebtorAgencyFileNumber?>
								<br/><br/>
								RE: <?php echo $txtCreditorName?> VS <?php echo $txtDebtorName?>, <?php echo $txtDebtorAddress?>, <?php echo $txtDebtorCity?>, <?php echo $txtDebtorPostalCode?>, <?php echo $txtDebtorPhone?>
								<br/><br/>
								Claim Amount: $<?php echo $txtDebtorAmount?>
								<br/><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upon the recommendation of <b>Wright Holmes</b>, we offer to you the above account for collection. 
								If the following rates, terms and conditions are not acceptable, do not proceed until your fees and terms have 
								been mutually agreed upon. This claim is forwarded at the following rates, terms and conditions:
								<br/><br/>
								<?php if($txtCollectionRates == "Our rates are as follows:"){?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									20% on the first $300 collected, 18% on the next $1,700 collected, and 13% on the balance collected in excess of $2,000 
									on commercial claims. The rate for retail/consumer claims is 33 1/3%.    
								<?php }else{?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$txtCollectionRates?>
								<?php }?>
								<br/><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorization is required before instituting any proceeding, incurring any expenses, 
								making any compromise or granting any extension. Partial collections should be remitted as received. All 
								correspondence should be conducted through our office.
								<br/><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you accept this account, kindly acknowledge receipt. Please advise promptly of the 
								prospects of settlement and report to us as to the progress made on a regular basis. If you do not accept this account, 
								please return the papers to us immediately stating your reasons.
								<br/><br/>
								Additional Information:<br/>
								<?php echo $txtComments?>
								<br/><br/>
								<b>Forwarded by:</b>
								<br/><?php echo $txtCompanyName?>
								<br/><?php echo $txtName?>
								<br/><?php echo $txtAddress?>
								<br/><?php echo $txtCity?>, <?php echo $txtStateProvince?>, <?php echo $txtPostalCode?>
								<br/><br/>
								<br/>Phone: <?php echo $txtPhone?>
								<br/>Fax: <?php echo $txtFax?>
								<br/>Email: <?php echo $txtEmail?>
								<br/><br/>
								<br/>cc  Wright Holmes
								<br/>45 Kensico Drive, 2nd floor
								<br/>Mount Kisco,  NY 10549
								<br/>Fax: (914) 241-3326
								<br/>claims@collectioncenter.com
							</td>
						</tr>
						<tr>
							<td align="right">
								<input type="submit" value="Back" onclick="submitForm('back')"/>&nbsp;&nbsp;<input type="submit" value="Confirm" onClick="submitForm('confirm')"/>
							</td>
						</tr>
					<?php } else { ?>
						<tr valign="top">
							<input type="hidden" name="action" value="submit"/>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;"><b>To:</b></td>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;">


<p><b><?php echo $name?></b>
<p><?php echo $street?> 
<br><?php echo $city?>, <?php echo $stateprovince ?>
<?php echo $postalcode ?>
									<input type="hidden" name="txtLawFrimName" value="<?php echo $name?>" />
									<input type="hidden" name="txtLawFrimStreet" value="<?php echo $street?>" />
									<input type="hidden" name="txtLawFrimCity" value="<?php echo $city?>" />
									<input type="hidden" name="txtLawFrimStateProvince" value="<?php echo $stateprovince ?>" />
									<input type="hidden" name="txtLawFrimStatePostalCode" value="<?php echo $postalcode ?>" />
									<div>
								</div>
									
							</td>
						</tr>
						<tr valign="top">
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;"><b>Your:</b></td>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;">
								<table cellpadding=2 cellspacing=0 border=0>
								<tr>
									<td><b>Name</b></td>
									<td colspan="3"><input type="text" name="txtName" size="50" value="<?php echo $txtName?>"/></td>
								</tr>
								<tr>
									<td><b>Title</b></td>
									<td colspan="3"><input type="text" name="txtTitle" size="50" value="<?php echo $txtTitle?>"/></td>
								</tr>
								<tr>
									<td><b>Email</b></td>
									<td colspan="3"><input type="text" name="txtEmail" size="50" value="<?php echo $txtEmail?>"/></td>
								</tr>
								<tr>
									<td><b>Company Name</b></td>
									<td colspan="3"><input type="text" name="txtCompanyName" size="50" value="<?php echo $txtCompanyName?>"/></td>
								</tr>
								<tr>
									<td><b>Address</b></td>
									<td colspan="3"><input type="text" name="txtAddress" value="<?php echo $txtAddress?>" size="50"/></td>
								</tr>
								<tr>
									<td><b>City</b></td>
									<td><input type="text" name="txtCity" value="<?php echo $txtCity?>" Size="15"/></td>
									<td><b>State/Province</b></td>
									<td><input type="text" name="txtStateProvince" value="<?php echo $txtStateProvince?>" Size="2" maxlength="2"/></td>
								</tr>
								<tr>
									<td><b>Postal/Zip Code</b></td>
									<td><input type="text" name="txtPostalCode" value="<?php echo $txtPostalCode?>" Size="10" maxlength="10"/></td>
									<td><b>Country</b></td>
									<td>
										<select name="txtCountry">
									</select>
									</td>
								</tr>
								<tr>
									<td><b>Phone</b></td>
									<td colspan="3"><input type="text" name="txtPhone" id="txtPhone" size="15" maxlength="15" value="<?php echo $txtPhone?>"/></td>
								</tr>
								<tr>
									<td><b>Fax</b></td>
									<td colspan="3"><input type="text" name="txtFax" id="txtFax" size="15" maxlength="15" value="<?php echo $txtFax?>"/></td>
								</tr>
								</table>
							</td>
						</tr>				
						<tr>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;"><b>Creditor:
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;">
								<table cellpadding=2 cellspacing=0 border=0>
								<tr>
									<td style="width:100px;"><b>Name</b></td>
									<td><input type="text" name="txtCreditorName" size="50" value="<?php echo $txtCreditorName?>"/></td>
								</tr>
								</table>
							</td>
						</tr>
						<tr valign="top">
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;"><b>Debtor:</b></td>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;">
								<table cellpadding=2 cellspacing=0 border=0>
								<tr>
									<td><b>Company</b></td>
									<td colspan="3"><input type="text" name="txtDebtorName" size="50" value="<?php echo $txtDebtorName?>"/></td>
								</tr>
								<tr>
									<td><b>Contact</b></td>
									<td colspan="3"><input type="text" name="txtDebtorContact" size="50" value="<?php echo $txtDebtorContact?>"/></td>
								</tr>
								<tr>
									<td><b>Email</b></td>
									<td colspan="3"><input type="text" name="txtDebtorEmail" size="50" value="<?php echo $txtDebtorEmail?>"/></td>
								</tr>
								<tr>
									<td><b>Address</b></td>
										<td colspan="3"><input type="text" name="txtDebtorAddress" value="<?=$txtDebtorAddress?>" size="50"/></td>
								</tr>
								<tr>
									<td><b>City</b></td>
										<td><input type="text" name="txtDebtorCity" value="<?=$txtDebtorCity?>" Size="15"/></td>
									<td><b>State/Province</b></td>
										<td><input type="text" name="txtDebtorStateProvince" value="<?php echo $txtDebtorStateProvince?>" Size="2" maxlength="2"/></td>
								</tr>
								<tr>
									<td><b>Postal/Zip Code</b></td>
										<td><input type="text" name="txtDebtorPostalCode" value="<?php echo $txtDebtorPostalCode?>" Size="10" maxlength="10"/></td>
									<td><b>Country</b></td>
									<td>
										<select name="txtDebtorCountry">
									</select>
									</td>
								</tr>
								<tr>
									<td><b>Phone</b></td>
									<td colspan="3"><input type="text" name="txtDebtorPhone" id="txtDebtorPhone" size="15" maxlength="15" value="<?=$txtDebtorPhone?>"/></td>
								</tr>
								<tr>
									<td><b>Amount</b></td>
									<td colspan="3">$<input type="text" name="txtDebtorAmount" size="15" maxlength="255" value="<?=$txtDebtorAmount?>"/></td>
								</tr>
								<tr>
									<td><b>Agency File Number</b></td>
									<td colspan="3"><input type="text" name="txtDebtorAgencyFileNumber" size="15" maxlength="255" value="<?php echo $txtDebtorAgencyFileNumber?>"/></td>
								</tr>
								</table>
							</td>
						</tr>
						<tr valign="top">
							<td><b>Comments:</b></td>
							<td>				
								<textarea name="txtComments" rows="5" cols="75"><?php echo $txtComments?></textarea>
							</td>			
						</tr>
						<tr>
							<td nowrap><b>Attachment 1</b></td>
							<td><input name="flUpload" id="flUpload" type="file" /></td>
						</tr>
						<tr>
							<td nowrap><b>Attachment 2</b></td>
							<td><input name="flUpload2" id="flUpload2" type="file" /></td>
						</tr>
						<tr>
							<td nowrap><b>Attachment 3</b></td>
							<td><input name="flUpload3" id="flUpload3" type="file" /></td>
						</tr>
						<tr>
							<td nowrap><b>Attachment 4</b></td>
							<td><input name="flUpload4" id="flUpload4" type="file" /></td>
						</tr>
						<tr>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;" nowrap><b>Attachment 5</b></td>
							<td style="padding:2px; border-bottom:1px dashed #e0e0e0;" nowrap><input name="flUpload5" id="flUpload5" type="file" /></td>
						</tr>
						<tr valign="top">
							<td><b>Collection Rates:</b></td>
							<td>
								<table cellpadding=2 cellspacing=0 border=0>
									<tr>
										<td>
											Please enter your company's contingency fee rates in the field below. Use the example as a guide for 
											entering your rates.<br/>
										</td>
									</tr>
									<tr>
										<td>
											<b>Note:</b><br/>
											if no contingency fee rates are entered, they will default to normal, 
											commercial and retail rates, as shown in the example below.
										</td>
									</tr>
									<tr>
										<td>
											<b>Example:</b><br/>
											20% on the first $300 collected, 18% on the next $1,700 collected, and 13% on the balance collected 
											in excess of $2,000 on commercial claims. The rate for retail/consumer claims is 33 1/3%.
										</td>
									</tr>
									<tr>
										<td>
											<?php if($txtCollectionRates == ""){?>
												<textarea name="txtCollectionRates" rows="5" cols="75">Our rates are as follows:</textarea>
											<?php }else{?>
												<textarea name="txtCollectionRates" rows="5" cols="75"><?php echo $txtCollectionRates?></textarea>
											<?php }?>
										</td>
									</tr>
								</table>
							</td>
						</tr>	
						<tr>
							<td colspan="2" align="right">
								<input type="submit" value="Send" onClick="return checkForm()"/>
							</td>			
						</tr>
					<?php }?>
				</table>
				</form>
			<?php }?>
		</div>

<?php


///////////////////////////////////////////////////////////////////////////
?>






</div><!--content -->
</section>
<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
exit();
?>


