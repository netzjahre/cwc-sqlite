






























































































































































<?php
//Cookieless Web Counter by Lucio Marinelli, modified by JF to meet own requirements
//Please see attached GNU GENERAL PUBLIC LICENSE version 3

error_reporting(E_ALL);

echo "<div class='flex-container'>";
echo "<div class='within-flex'><a href='cwclite.php'>$back</a></div>";
echo "<div class='within-flex'><a href='sort_by_ip_lite.php'>Sort list by IP</a></div>";
echo "<div class='within-flex'><a href='sort_by_uri_lite.php'>Sort list by URL</a></div>";
echo "<div class='within-flex'><a href='sort_by_referrer_lite.php'>Sort list by referrer</a></div>";
echo "<div class='within-flex'><a href='count_all_uri_lite.php'>Archive of exported visit data</a></div>";
echo "<div class='within-flex'><a href='prepare_export_cbox.php'>Export by checkboxes</a></div>";
echo "</div>";


echo "<div class='flex-container'>";																 																																			   
echo "<div class='within-flex'><input type='submit' name='rubber' value='Delete checked rows'/></div>";
echo "</form>";
echo "<form action = 'delete_me_lite.php' method = 'POST'>";
echo "<div class='within-flex'><input type='submit' name='selfrubber' value='Delete own visits'></div>";
echo "</form>";

echo "<form action = 'delete_all_bots_lite.php' method = 'POST'>";
//echo "<div class='within-flex'><input type='hidden' name='useragent' value='.com'>";  
echo "<div class='within-flex'><input type='submit' name='botrubber' value='Delete most bots'></div>";
echo "</form>";
echo "</div>";
echo "</div>";



echo "<form action = 'delete_timestamp_lite.php' method = 'POST'>";
echo "<p align='center'>or insert left-aligned a part of   <input type='text' name='timestamp' value='Timestamp' maxlength='18' size='18'>";
echo " and <input type='submit' name='timerubber' value='delete rows'></p>";
echo "</form>";

echo "<form action = 'delete_remotehost_lite.php' method = 'POST'>";
echo "<p align='center'>or insert left-aligned a part of   <input type='text' name='remotehost' value='Remote-Host' maxlength='30' size='30'>";
echo " and <input type='submit' name='remhostrubber' value='delete rows'></p>";
echo "</form>";

echo "<form action = 'delete_ip_lite.php' method = 'POST'>";
echo "<p align='center'>or insert left-aligned a part of   <input type='text' name='ip' value='IP' maxlength='15' size='15'>";
echo " and <input type='submit' name='iprubber' value='delete rows'></p>";
echo "</form>";
echo "</div>";
############################################################################################
echo "<div class='flex-container'>";
echo "<div class='within-flex'>";
echo "<form action = 'delete_url_lite.php' method = 'POST'>";
echo "<p align='center'>or insert left-aligned a part of <input type='text' name='url' value='URL, part next to domain/' maxlength='30' size='30'>";
echo " and <input type='submit' name='urlrubber' value='delete rows'></p>";
echo "</form>";
echo "</div>";

echo "<div class='within-flex'>";
echo "<form action = 'delete_url_exact_lite.php' method = 'POST'>";
echo "<p align='center'>or insert <input type='text' name='urlexact' value='exact URL next to domain/' maxlength='30' size='30'>
and <input type='submit' name='urlexactrubber' value='delete rows'></p>";
echo "</form>";
echo "</div>";
echo "</div>";
##############################################################################################
echo "<div class='flex-container'>";
echo "<div class='within-flex'>";
echo "<form action = 'delete_referrer_lite.php' method = 'POST'>";
echo "<p align='center'>or insert left-aligned a part of   <input type='text' name='referrer' value='referrer' maxlength='30' size='30'> and <input type='submit' name='referrubber' value='delete rows'></p>";
echo "</form>";
echo "</div>";

echo "<div class='within-flex'>";
echo "<form action = 'delete_referrer_exact_lite.php' method = 'POST'>";
echo "<p align='center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or insert left-aligned a part of   <input type='text' name='referexact' value='exact referrer or dot . for empty' maxlength='50' size='30'> and <input type='submit' name='referrubexact' value='delete rows'></p>";
echo "</form>";
echo "</div>";
echo "</div>";
#############################################################################################
echo "<div>";
echo "<form action = 'delete_useragent_lite.php' method = 'POST'>";
echo "<p align='center'>or insert left-aligned a part of   <input type='text' name='useragent' value='User Agent' maxlength='50' size='20'> and <input type='submit' name='agentrubber' value='delete rows'></p>";
//echo " and <input type='submit' name='agentrubber' value='delete rows'></p>";
echo "</form>";


echo "</div>";
 
?> 
										  
 
																							
   
   
   
															 
																																																				   

 
													 
																	   
 
											  
						  
												   
					   

								  
																						
											  
				   

							   
	  
						   
								  
		  
				 
   
			  

												
						  
						   
								  
																												  
											  
				   
							   
	  
							   
								  
		  
				 
   
  
			  

												  
						  
												   
					
								  
																						
												  
				   

							   
	  
						
								  
		  
				 
   
			  
   
													
						  
												   
						
								  
																												  
												  
				   
							   
	  
							
								   
		  
				 
   
			   
																			
			   
				
								  
														 
								 
	  
					
									
		  
				 
   
  
			  
											  
							  
						   
							   
						
							
																						  
																						 
																						 
																							  
																	   
				   
																						 
  
	   
	   

