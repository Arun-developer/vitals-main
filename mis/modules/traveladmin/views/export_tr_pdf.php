<html>
<head>
    <style>
        body {font-family: Helvetica, Arial, sans-serif; color:#333; font-size:10px;}
        .pdf-page {height:100%; margin:10px -13px -20px -10px; padding:30px;}
        .pdf-page p {width:100%; margin:0 0 20px 0;}
        .front-page {height:100%; margin:0px 0px 0px 0px;}
        h1 {color: #FFFFFF; background-color: #014c67; font-weight:100; font-size:18px; padding:5px;}
        h2 {color: #c41030; font-weight:100; font-size:16px;}
        h3 {color: #014c67; font-size:12px}
        h4 {color: #014c67; background-color: #e5edf0; font-size:12px; font-weight:normal; padding:3px 3px 4px 5px; margin-bottom:3px; padding-bottom:4px;}
        h5 {color: #c41030;}
        table, th, td { padding: 0px; border: 1px solid black; text-align: left}
        th, td {font-size: 14px; padding: 10px; text-align: left;}
        .bold-text { font-weight: bold;}
        .page_break { page-break-before: always; }
        .title_text{font-weight:100; font-size:18px; padding:5px;text-align: center;color: #c41030;}
        img{width:150px;}
        .logo{text-align: right;}
    </style>
</head>
<body>
    <div class="logo">
        <img src="https://vitals.villgroapps.org/app/uploads/partner_logo/villgro_india_logo.jpg" alt="Villgro Logo" height="110" width="259"/>
    </div> 
       
		<div>
            <p class="title_text">Travel Request</p>
            <table width="100%">
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Villgro Employee </td>
                    <td style="width:70%;"><?php echo ucfirst($get_travel_request[0]['default_employee_type']); ?></td>
                </tr>
				 <tr bgcolor="#f9f9f9">
                    <td class="bold-text">RO Name </td>
                    <td style="width:70%;"><?php echo ucfirst($ROName); ?></td>
                </tr>
				 <tr bgcolor="#f9f9f9">
                    <td class="bold-text">RO Status </td>
                    <td style="width:70%;"><?php      if (php72_cmp($get_travel_request[0]['ro_status']) == 1) {
															$status = 'Pending';
														} else if (php72_cmp($get_travel_request[0]['ro_status']) == 2) {
															$status = 'Cancel';
														} else if (php72_cmp($get_travel_request[0]['ro_status']) ==3) {
															$status = 'Confirm';
														} else if (php72_cmp($get_travel_request[0]['ro_status']) == 4) {
															$status = 'Reject';
														}

														echo $status; 
														
														?></td>
                </tr>
            </table>
            <div class="page_break"></div>
            <h1>Personal Information</h1>
            <table width="100%">
                <?php
                $m = 1;
                foreach ($get_travel_personal_details as $member) {
                    ?>
                    <tr>
                        <td style="width:100%">
                            <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:30%;"><b>Name</b></td>
                                    <td style="width:70%;"><?php echo $member['user_name']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Mobile number</b></td>
                                    <td style="width:70%;"><?php echo $member['mobile_number']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Dob</b></td>
                                    <td style="width:70%;"><?php echo date('d-m-Y',strtotime($member['dob']));  ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Nationality</b></td>
                                    <td style="width:70%;"><?php echo $nationality[$member['nationality']]; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $m++;
                }
                ?>
            </table>
			<?php if($get_travel_request[0]['purpose_of_travel']) { ?>
				<div class="page_break"></div>
				<h1>Travel Information</h1>
				<table width="100%">
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Purpose of Travel </td>
						<td style="width:70%;"><?php echo ucfirst($get_travel_request[0]['purpose_of_travel']); ?></td>
					</tr> 
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Sector</td>
						<td style="width:70%;"><?php echo ucfirst($get_travel_request[0]['sector']); ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Programme</td>
						<td style="width:70%;"><?php echo ucfirst($program_list[0]['programme']); ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Donor</td>
						<td style="width:70%;"><?php echo $donorData[$get_travel_request[0]['donor']]; ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Budget     </td>
						<td style="width:70%;"><?php echo $BudjectData[$get_travel_request[0]['budget']];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Line Item     </td>
						<td style="width:70%;"><?php echo $lineItemData[$get_travel_request[0]['line_item']]; ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Mode of Transport</td>
						<td style="width:70%;"><?php echo ucfirst($get_travel_request[0]['mode_of_transport']); ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Do you require stay</td>
						<td style="width:70%;"><?php echo ucfirst($get_travel_request[0]['require_stay']); ?></td>
					</tr>
				</table>
				</div>
			<?php } ?>
			
			<?php if (!empty($get_travel_request[0]) && $get_travel_request[0]['require_stay'] === 'Yes') { ?>
			<div class="page_break"></div>
				<h1>Hotel Information</h1>
<table width="100%">
           
                <tr>
                    <td style="width:30%;"><b>Hotel Details</b></td>
                    <td style="width:70%;"><?php echo $get_travel_request[0]['hotel_details']; ?></td>
                </tr>

                <tr>
                    <td><b>City</b></td>
                    <td><?php echo $get_travel_request[0]['city']; ?></td>
                </tr>

                <tr>
                    <td><b>No. of Nights</b></td>
                    <td><?php echo $get_travel_request[0]['no_of_nights']; ?></td>
                </tr>

                <tr>
                    <td><b>Check-in Date</b></td>
                    <td>
                        <?php
                        echo !empty($get_travel_request[0]['check_in_date'])
                            ? date('d-m-Y', strtotime($get_travel_request[0]['check_in_date']))
                            : '-'; 
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Check-out Date</b></td>
                    <td>
                        <?php
                      echo !empty($get_travel_request[0]['check_out_date'])
                            ? date('d-m-Y', strtotime($get_travel_request[0]['check_out_date']))
                            : '-';
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Booking Instructions</b></td>
                    <td><?php echo $get_travel_request[0]['booking_instructions']; ?></td>
                </tr>

                <tr>
                    <td><b>Occupancy</b></td>
                    <td><?php echo $get_travel_request[0]['occupancy']; ?></td>
                </tr>

                <tr>
                    <td><b>Comments</b></td>
                    <td><?php echo $get_travel_request[0]['additional_comments']; ?></td>
                </tr>
          
	  </table>

<?php } ?>



				<?php if(!empty($get_travel_bus_details)) { ?>
			
			 <div class="page_break"></div>
            <h1>Bus Information</h1>
            <table width="100%">
                <?php
                $m = 1;
                foreach ($get_travel_bus_details as $data) {
                    ?>
                    <tr>
                        <td style="width:100%">
                            <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:30%;"><b>Bus details</b></td>
                                    <td style="width:70%;"><?php echo $data['bus_details']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>From /To</b></td>
                                    <td style="width:70%;"><?php echo $data['bus_from_to_type']; ?></td>
                                </tr>
								<tr>
                                    <td style="width:30%;"><b>Travel date</b></td>
                                    <td style="width:70%;"><?php echo date('d-m-Y',strtotime($data['travel_from_date']));  ?></td>
                                </tr>
								
                                <tr>
                                    <td style="width:30%;"><b>comments</b></td>
                                    <td style="width:70%;"><?php echo $data['comments']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $m++;
                }
				
				
                ?>
            </table>
			
			 <?php
                  
                }
				
				
                ?>
				
				
				
				<?php if(!empty($get_travel_train_details)) { ?>
			
			 <div class="page_break"></div>
            <h1>Train Information</h1>
            <table width="100%">
                <?php
                $m = 1;
                foreach ($get_travel_train_details as $data) {
                    ?>
                    <tr>
                        <td style="width:100%">
                            <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:30%;"><b>Bus details</b></td>
                                    <td style="width:70%;"><?php echo $data['train_name']; ?></td>
                                </tr>
                                
                                <tr>
                                    <td style="width:30%;"><b>From /To</b></td>
                                    <td style="width:70%;"><?php echo $data['train_from_to_type']; ?></td>
                                </tr>
								<tr>
                                    <td style="width:30%;"><b>Travel Date</b></td>
                                    <td style="width:70%;"><?php echo date('d-m-Y',strtotime($data['train_travel_from_date']));  ?></td>
                                </tr>
								
								<tr>
                                    <td style="width:30%;"><b>Class</b></td>
                                    <td style="width:70%;"><?php echo $data['train_class']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>comments</b></td>
                                    <td style="width:70%;"><?php echo $data['comments']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $m++;
                }
				
				
                ?>
            </table>
			
			 <?php
                  
                }
				
				
                ?>
				
				
				<?php if(!empty($get_travel_flight_details)) { 
				
			
				
				?>
			
			 <div class="page_break"></div>
            <h1>Flight Information</h1>
            <table width="100%">
                <?php
                $m = 1;
                foreach ($get_travel_flight_details as $data) {
                    ?>
                    <tr>
                        <td style="width:100%">
                            <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:30%;"><b>Flight details</b></td>
                                    <td style="width:70%;"><?php echo $data['flight_name']; ?></td>
                                </tr>
                               
                                <tr>
                                    <td style="width:30%;"><b>From /To </b></td>
                                    <td style="width:70%;"><?php echo $data['flight_from_to_type']; ?></td>
                                </tr>
								<tr>
                                    <td style="width:30%;"><b> Travel Date</b></td>
                                    <td style="width:70%;"><?php echo date('d-m-Y',strtotime($data['flight_travel_from_date']));  ?></td>
                                </tr>
								
								
                                <tr>
                                    <td style="width:30%;"><b>comments</b></td>
                                   
                                    <td style="width:70%;"><?php echo $data['comments']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $m++;
                }
				
				
                ?>
            </table>
			
			 <?php
                  
                }
				
				
                ?>
			
			
     </body>
    </html>
