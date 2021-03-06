<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatable/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/tablecloth/assets/css/tablecloth.css">
<script src="<?php echo base_url(); ?>assets/tablecloth/assets/js/jquery.tablesorter.js"></script>
<script src="<?php echo base_url(); ?>assets/tablecloth/assets/js/jquery.metadata.js"></script>
<script src="<?php echo base_url(); ?>assets/tablecloth/assets/js/jquery.tablecloth.js"></script>

<style>
    @import "<?php echo base_url(); ?>assets/datatable/media2/css/jquery.dataTables.css";
</style>
<style>
.user{
	width:70px;
	background : none;
	border : none;
	text-align: center;
	}
	.user2{
	width:70px;
	
	text-align: center;
	}
	.col5{background:#D8D8D8;}
	input{display: block;width: 100%;height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
	table{
        font-size: 11px;
    }
	</style>
	<script type="text/javascript">
	$(function() {
		function compute_losses(row){
		    var tests_done = $('#tests_done_'+row).val();                
		    var quantity_used = $('#q_used_'+row).val();
		    //alert(tests_done)
		    var loss = quantity_used - tests_done;
		    if(loss <0){
		        alert('Please Enter a valid number for Quantity Used and Tests Done.');
		        $('#losses_'+row).val('0');
		        $('#tests_done_'+row).val('0');
		        $('#q_used_'+row).val('0');
		    }else{
		        $('#losses_'+row).val(loss);
		    }
		}
	function compute_end(row) {
	    var bal = $('#b_balance_' + row).val();
	    var num_bal = parseInt(bal);
		 //alert(num_bal);

		var qty_rcvd = $('#q_received_' + row).val();
		var num_qty_rcvd = parseInt(qty_rcvd);
		// alert(num_qty_rcvd);

		var q_used = $('#q_used_' + row).val();
		var num_q_used = parseInt(q_used);
		//  alert(num_q_used);

		var tests_done = $('#tests_done_' + row).val();
		var num_tests_done = parseInt(tests_done);
		                //  alert(num_tests_done);

        var loses = $('#losses_' + row).val();
        var num_loses = parseInt(loses);
		//  alert(num_loses);

		var pos_adj = $('#pos_adj_' + row).val();
		var num_pos_adj = parseInt(pos_adj);
		 // alert(num_pos_adj);

		var neg_adj = $('#neg_adj_' + row).val();
		var num_neg_adj = parseInt(neg_adj);
		 // alert(num_neg_adj);

        num_final = num_bal + num_qty_rcvd - num_q_used + num_pos_adj - num_neg_adj;

        //Validate Quantity Used
        var sum_bbal_q_rec_pos_adj = num_bal + num_qty_rcvd + num_pos_adj - num_neg_adj;
        if((num_q_used>sum_bbal_q_rec_pos_adj)&&(row!=0)){
            $('#losses_' + row).attr("value",0);                    
            $('#tests_done_' + row).attr("value",0);                    
            $('#q_used_'+row).css("border-color","red");
            $('#physical_count_' + row).attr("value",sum_bbal_q_rec_pos_adj);

        }else if((num_final<0)&&(row!=0)){
            $('#losses_' + row).attr("value",6);                    
            $('#tests_done_' + row).attr("value",0);
            $('#q_used_' +row).attr("value",0);
            $('#physical_count_' + row).attr("value",sum_bbal_q_rec_pos_adj);
            $('#neg_adj_' +row).attr("value",0);
            $('#pos_adj_' + row).attr("value",0);
            //$('#physical_count_' + row).attr("color","red");

        }else{
            $('#physical_count_' + row).val(num_final);

        }
    }
            $('.b_balance').keyup(function() {
                row_id = $(this).closest("tr");
                number = row_id.attr("commodity_id");
                num = parseInt(number);
                //compute_end(num);
                //validateEnd(num);
            })
            $('.q_received').keyup(function() {
                row_id = $(this).closest("tr");
                number = row_id.attr("commodity_id");
                num = parseInt(number);
                compute_end(num);
                validateEnd(num);
            })
            
			$('.q_used').keyup(function() {
                row_id = $(this).closest("tr");
                number = row_id.attr("commodity_id");
                num = parseInt(number);
                // validate_quantity_used(num);
                compute_end(num);
                compute_losses(num);
                //validateEnd(num);
                
            });
            $('.tests_done').keyup(function() {
                 row_id = $(this).closest("tr");
                 number = row_id.attr("commodity_id");
                 num = parseInt(number);
                 //validate_quantity_used(num);
                 compute_end(num);
               compute_losses(num);
                //validateEnd(num);
                      
            });
                      
            $('.pos_adj').keyup(function() {
                row_id = $(this).closest("tr");
                number = row_id.attr("commodity_id");
                num = parseInt(number);
                compute_end(num);
                //validateEnd(num);
            })
            $('.neg_adj').keyup(function() {
                row_id = $(this).closest("tr");
                number = row_id.attr("commodity_id");
                num = parseInt(number);
                compute_end(num);
               // validateEnd(num);
            })


	jQuery(document).ready(function() {

		$("#begin_date").datepicker({
				defaultDate : "",
				changeMonth : true,
				changeYear : true,
				numberOfMonths : 1,
				// onClose : function(selectedDate) {
				// 	$("#end_date").datepicker("option", "minDate", selectedDate);
				// }
			});
        $("#end_date").datepicker({
				defaultDate : "",
				changeMonth : true,
				changeYear : true,
				numberOfMonths : 1,
				// onClose : function(selectedDate) {
				// 	$("#begin_date").datepicker("option", "minDate", selectedDate);
				// }
			});
            });


					var $myDialog = $('<div></div>')
    .html('Please confirm the values before saving')
    .dialog({
        autoOpen: false,
        title: 'Confirmation',
        buttons: { "Cancel": function() {
                      $(this).dialog("close");
                      return false;
                },
                "OK": function() { 
                	// var checker=0;
                	// $("input[name^=expiry_date]").each(function() {
                	// 	checker=checker+1;
                		
                	// });
                	// //alert(checker);
                	// if(checker<2){
                	// 	alert("Cannot submit an empty form");
                	// 	$(this).dialog("close"); 
                	// }
                	// else{
                	$(this).dialog("close"); 
                      $('#myform').submit();
                      return true;	
                 }
        }
});

		$('#save1')
		.button()
			.click(function() {
				
//			return $myDialog.dialog('open');
		});
			$( "#dialog" ).dialog({
			height: 140,
			modal: true
		});

});


</script>

<?php 
$orderid = $order_id;
 
foreach ($all_details as $detail) {
    $id = $detail['id'];
    $facility_name = $detail['facility_name'];
    $facility_code = $detail['facility_code'];
    $district_id = $detail['district_id'];
    $district = $detail['district'];
    $county = $detail['county'];
    $owner = $detail['owner'];
    $vct = $detail['vct'];
    $pitc = $detail['pitc'];
    $pmtct = $detail['pmtct'];
    $b_screening = $detail['b_screening'];
    $other = $detail['other'];
    $specification = $detail['specification'];
    $rdt_under_tests = $detail['rdt_under_tests'];
    $rdt_under_pos = $detail['rdt_under_pos'];
    $rdt_btwn_tests = $detail['rdt_btwn_tests'];
    $rdt_btwn_pos = $detail['rdt_btwn_pos'];
    $rdt_over_tests = $detail['rdt_over_tests'];
    $rdt_over_pos = $detail['rdt_over_pos'];
    $micro_under_tests = $detail['micro_under_tests'];
    $micro_under_pos = $detail['micro_under_pos'];
    $micro_btwn_tests = $detail['micro_btwn_tests'];
    $micro_btwn_pos = $detail['micro_btwn_pos'];
    $micro_over_tests = $detail['micro_over_tests'];
    $micro_over_pos = $detail['micro_over_pos'];
    $beg_date = $detail['beg_date'];
    $end_date = $detail['end_date'];
    $explanation = $detail['explanation'];
    $moh_642 = $detail['moh_642'];
    $moh_643 = $detail['moh_643'];
    $compiled_by = $detail['compiled_by'];
    $order_date = $detail['order_date'];
//    $phone_no = $detail['telephone'];
    $designation = $this->session->userdata('full_name');
}
	$attributes = array( 'name' => 'myform', 'id'=>'myform');
	echo form_open('rtk_management/update_lab_commodity_orders',$attributes); 
		?>
<div id="dialog-form" title="Lab Commodities Order Report">

	<table id="user_order" width="90%" class="data-table">
		<input type="hidden" name="facility_name" colspan = "3" style = "color:#000; border:none" value="<?php echo $facility_name?>"></td>
		<input type="hidden" name="order_id" colspan = "3" style = "color:#000; border:none" value="<?php echo $order_id?>"></td>
		<input type="hidden" name="facility_code" colspan = "2" style = "color:#000; border:none" value="<?php echo $facility_code?>"></td>
		<input type="hidden" name="district_name" colspan = "2" style = "color:#000; border:none" value="<?php echo $district?>"></td>
		<input type="hidden" name="county" colspan = "3" style = "color:#000; border:none" value="<?php echo $county?>"></td>
		
					<tr><td style = "text-align:left"><b>Name of Facility:</b></td>
						<td colspan = "2"><?php echo $facility_name?></td>
						<td colspan = "3" rowspan = "8" style="background: #fff;"></td>
						<td colspan = "3"><b>Applicable to HIV Test Kits Only</b></td>
						<td colspan = "3" rowspan = "8" style="background: #fff;"></td>
						<td colspan = "4" style="text-align:center"><b>Applicable to Malaria Testing Only</b></td>

					</tr>
					<tr ><td colspan = "2" style = "text-align:left"><b>MFL Code:</b></td>
						<td><?php echo $facility_code?></td>
						<td colspan = "2" style="text-align:center"><b>Type of Service</b></td>
						<td colspan = "1" style="text-align:center"><b>No. of Tests Done</b></td>					
						<td colspan = "1"><b>Test</b></td>
						<td colspan = "1"><b>Category</b></td>
						<td colspan = "1"><b>No. of Tests Performed</b></td>
						<td colspan = "1"><b>No. Positive</b></td>							
					</tr>
					<tr><td colspan = "2" style = "text-align:left"><b>District:</b></td>
						<td><?php echo $district?></td>
						<td colspan = "2"><b>VCT</b></td>
						<td><input class='user2'class='user2' id="vct" name="vct" colspan = "2" style = "color:#000" value="<?php echo $vct?>"/></td>					
						<td rowspan = "3">RDT</td>
						<td style = "text-align:left">Patients&nbsp;<u>under</u> 5&nbsp;years</td>
						<td><input class='user2'id="rdt_under_tests" name="rdt_under_tests" size="10" type="text" value="<?php echo $rdt_under_tests?>"/></td>
						<td><input class='user2'id="rdt_under_positive" name="rdt_under_positive" size="10" type="text" value="<?php echo $rdt_under_pos?>"/></td>							
					
						</tr>
					<tr><td colspan = "2" style = "text-align:left"><b>County:</b></td>						
						<td><?php echo $county?></td>
						<td colspan = "2"><b>PITC</b></td>
						<td><input class='user2'class='user2' id="pitc" name="pitc" colspan = "2" style = "color:#000" value="<?php echo $pitc?>"/></td>					
						<td style = "text-align:left">Patients&nbsp;aged 5-14&nbsp;yrs</td>
						<td><input class='user2'id="rdt_to_tests" name="rdt_to_tests" size="10" type="text" value="<?php echo $rdt_btwn_tests?>"/></td>
						<td><input class='user2'id="rdt_to_positive" name="rdt_to_positive" size="10" type="text" value="<?php echo $rdt_btwn_pos?>"/></td>
						</tr>
					<tr><td colspan = "2" style = "text-align:left"><b>Affiliation:</b></td>	
						<td><?php echo $owner?></td>
						<td colspan = "2"><b>PMTCT</b></td>
						<td><input class='user2'class='user2' id="pmtct" name="pmtct" colspan = "2" style = "color:#000" value="<?php echo $pmtct?>"/></td>					
						<td style = "text-align:left">Patients&nbsp;<u>over</u> 14&nbsp;years</td>
						<td><input class='user2'id="rdt_over_tests" name="rdt_over_tests" size="10" type="text" value="<?php echo $rdt_over_tests?>"/></td>
						<td><input class='user2'id="rdt_over_positive" name="rdt_over_positive" size="10" type="text" value="<?php echo $rdt_over_pos?>"/></td>
						
						</tr>
					<tr><td colspan = "2" style = "text-align:right"><b>Beginning:</b></td>	
						<td><input class='my_date'id="begin_date" name="begin_date" colspan = "2" size="10" type="text" value="<?php echo $beg_date?>"/></td>
						<td colspan = "2"><b>Blood&nbsp;Screening</b></td>
						<td><input class='user2'class='user2' id="blood_screening" name="blood_screening" colspan = "2" style = "color:#000" value="<?php echo $b_screening?>"/></td>					
						<td rowspan = "3">Microscopy</td>
						<td style = "text-align:left">Patients&nbsp;<u>under</u> 5&nbsp;years</td>
						<td><input class='user2'id="micro_under_tests" name="micro_under_tests" size="10" type="text" value="<?php echo $micro_under_tests?>"/></td>
						<td><input class='user2'id="micro_under_positive" name="micro_under_positive" size="10" type="text" value="<?php echo $micro_under_pos?>"/></td>							
					</tr>
					<tr><td colspan = "2" style = "text-align:right"><b>Ending:</b></td>
						<td><input class='my_date'id="end_date" name="end_date" colspan = "2" size="10" type="text" value="<?php echo $end_date?>"/></td>
						<td colspan = "2"><b>Other&nbsp;(Please&nbsp;Specify)</b></td>
						<td><input class='user2'class='user2' id="other2" name="other2" colspan = "2" style = "color:#000" value="<?php echo $other?>"/></td>						
						<td style = "text-align:left">Patients&nbsp;aged 5-14&nbsp;yrs</td>
						<td><input class='user2'id="micro_to_tests" name="micro_to_tests" size="10" type="text" value="<?php echo $micro_btwn_tests?>"/></td>
						<td><input class='user2'id="micro_to_positive" name="micro_to_positive" size="10" type="text" value="<?php echo $micro_btwn_pos?>"/></td>
						</tr>
					<tr><td colspan = "3"></td>
							<td colspan = "2"><b>Specify&nbsp;Here:</b></td>
							<td><input class='user2'class='user2' id="specification" name="specification" colspan = "2" style = "color:#000" value="<?php echo $specification?>"/></td>							
							<td style = "text-align:left">Patients&nbsp;<u>over</u> 14&nbsp;years</td>
							<td><input class='user2'id="micro_over_tests" name="micro_over_tests" size="10" type="text" value="<?php echo $micro_over_tests?>"/></td>
							<td><input class='user2'id="micro_over_positive" name="micro_over_positive" size="10" type="text" value="<?php echo $micro_over_pos?>"/></td>
						</tr>
			
					<tr></tr>
	<tr > 				<th rowspan = "2" colspan = "2" style = "text-align:center;font-size:12"><b>Category Name</b></th>
						<th rowspan = "2" colspan = "2" style = "text-align:center;font-size:12"><b>Commodity Name</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Unit of Issue (e.g. Test)</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Beginning Balance</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Quantity Received</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Quantity Used</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Number of Tests Done</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Losses</b></th>
						<th colspan = "2" style = "text-align:center;font-size:12"><b>Adjustments [indicate if (+) or (-)]</b></th>	
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>End of Month Physical Count</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Quantity Expiring in <u>less than</u> 6 Months</b></th>
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Days out of Stock</b></th>	
						<th rowspan = "2" style = "text-align:center;font-size:12"><b>Quantity Requested for&nbsp;Re-Supply</b></th>
					</tr>
					<tr>
							<th style = "text-align:center">Positive</th>
							<th style = "text-align:center">Negative</th>
						</tr>
					<?php $checker=0;
					foreach ($all_details as $detail) {?>
					<tr commodity_id="<?php echo $checker ?>"><input type="hidden" id="commodity_id[<?php echo $checker?>]" name="commodity_id[<?php echo $checker?>]" value="<?php echo $detail['commodity_id']; ?>" >
						<input type="hidden" id="facilityCode" name="facilityCode">
						<input type="hidden" id="district" name="district" value="<?php echo $district_id; ?>">
						<input type="hidden" id="unit_of_issue[<?php echo $checker?>]" name = "unit_of_issue[<?php echo $checker?>]" value="<?php echo $detail['unit_of_issue']; ?>">
						<input type="hidden" id="detail_id[<?php echo $checker?>]" name = "detail_id[<?php echo $checker?>]" value="<?php echo $detail['id']; ?>">
						<td colspan = "2" style = "text-align:left"><b><?php echo $detail['category_name']; ?></b></td>		    
						<td colspan = "2" style = "text-align:left"></b><?php echo $detail['commodity_name']; ?></td>
						<td style = "text-align:center" readonly="readonly"><?php echo $detail['unit_of_issue']; ?></td>
						<td><input id="b_balance_<?php echo $checker?>" name = "b_balance[<?php echo $checker?>]" class='user2 b_balance' size="10" type="text" style = "text-align:center" value="<?php echo $detail['beginning_bal']; ?>"/></td>
						<td><input id="q_received_<?php echo $checker?>" name = "q_received[<?php echo $checker?>]" class='user2 q_received' size="10" type="text" style = "text-align:center" value="<?php echo $detail['q_received']; ?>"/></td>
						<td><input id="q_used_<?php echo $checker ?>" name = "q_used[<?php echo $checker?>]" class='user2 q_used' size="10" type="text" style = "text-align:center" value="<?php echo $detail['q_used']; ?>"/></td>
						<td><input id="tests_done_<?php echo $checker?>" name = "tests_done[<?php echo $checker?>]" class='user2 tests_done' size="10" type="text" style = "text-align:center" value="<?php echo $detail['no_of_tests_done']; ?>"/></td>
						<td><input id="losses_<?php echo $checker ?>" name = "losses[<?php echo $checker?>]" class='user2 losses' size="10" type="text" style = "text-align:center" value="<?php echo $detail['losses']; ?>" disabled/></td>
						<td><input id="pos_adj_<?php echo $checker?>" name = "pos_adj[<?php echo $checker?>]" class='user2 pos_adj' size="10" type="text" style = "text-align:center" value="<?php echo $detail['positive_adj']; ?>"/></td>
						<td><input id="neg_adj_<?php echo $checker?>" name = "neg_adj[<?php echo $checker?>]" class='user2 neg_adj' size="10" type="text" style = "text-align:center" value="<?php echo $detail['negative_adj']; ?>"/></td>
						<td><input id="physical_count_<?php echo $checker?>"  name = "physical_count[<?php echo $checker?>]" class='user2' size="10" type="text" style = "text-align:center" value="<?php echo $detail['closing_stock']; ?>"/></td>
						<td><input id="q_expiring[<?php echo $checker?>]" name = "q_expiring[<?php echo $checker?>]" class='user2' size="10" type="text" style = "text-align:center" value="<?php echo $detail['q_expiring']; ?>"/></td>
						<td><input id="days_out_of_stock[<?php echo $checker?>]" name = "days_out_of_stock[<?php echo $checker?>]" class='user2' size="10" type="text" style = "text-align:center" value="<?php echo $detail['days_out_of_stock']; ?>"/></td>	
						<td><input id="q_requested[<?php echo $checker?>]" name = "q_requested[<?php echo $checker?>]" class='user2' size="10" type="text" style = "text-align:center" value="<?php echo $detail['q_requested']; ?>"/></td>
					</tr>
					<?php $checker++;
					
				}?>
					<tr>
						<td colspan = "16"><br/></td>
					</tr>
<tr>					
						<td colspan = "16" style = "text-align:left">Explain Losses and Adjustments:</td>
					</tr>
<tr>					
						<td colspan = "16"><input colspan = "16" id="explanation" name="explanation" size="210" type="text" value="<?php echo $explanation?>" style=" width: 90%;"/></td>
					
					</tr>
					<tr></tr>
<tr>
						
						<td colspan = "4" style = "text-align:left"><b>Order for Extra LMIS tools:<br/> To be requested only when your data collection or reporting tools are nearly full. Indicate quantity required for each tool type.</b></td>
						<td colspan = "4"><b>(1) Daily Activity Register for Laboratory Reagents and Consumables (MOH 642):</b></td>
						<td colspan = "2"><input class='user2' id="moh_642" name="moh_642" size="10" type="text" value="<?php echo $moh_642?>"/></td>
						<td colspan = "4"><b>(2) F-CDRR for Laboratory Commodities (MOH 643):</b></td>
						<td colspan = "2"><input class='user2' id="moh_643" name="moh_643" size="10" type="text" value="<?php echo $moh_643?>"/></td>
					</tr>
<tr>					<td colspan = "4" style = "text-align:left">Compiled by: <?php echo $compiled_by?><input name="compiled_by" value ="<?php echo $compiled_by;?>" /></td>
						<td colspan = "3" style = "text-align:left">Tel: <?php //echo $phone_no?><input name="tel" value ="<?php // cho $phone_no;?>" /></td>
						<td colspan = "3" style = "text-align:left">Designation: <?php //echo $full_name;?><input name="designation" value ="<?php // echo $full_name;?>" /></td>
						<td colspan = "3" style = "text-align:left">Sign:</td>
						<td colspan = "3" style = "text-align:left">Date: <?php echo $order_date?></td>
					</tr>

<tr>					<td colspan = "4" style = "text-align:left">Approved by:</td>
						<td colspan = "3" style = "text-align:left">Tel:</td>
						<td colspan = "3" style = "text-align:left">Designation:</td>
						<td colspan = "3" style = "text-align:left">Sign:</td>
						<td colspan = "3" style = "text-align:left">Date:</td>
					</tr>


</table>
<input  class="btn btn-primary" type="submit" id="" name="save1"  value="Update Order" style="margin-left: 0%; width:100px">
</form>
<?php form_close();?>
</div>
<br />
<br />
<br />
<br />
<br />

<br />
<br />
<script type="text/javascript">
$("table").tablecloth({
            bordered: true,
            condensed: true,
            striped: true,            
            clean: false,            
        });
</script>