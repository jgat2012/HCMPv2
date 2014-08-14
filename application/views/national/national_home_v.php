<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">   
    <!-- Bootstrap core CSS -->  
    <link rel="icon" href="<?php echo base_url().'assets/img/coat_of_arms.png'?>" type="image/x-icon" />
    <link href="<?php echo base_url().'assets/css/style.css'?>" type="text/css" rel="stylesheet"/> 
    <link href="<?php echo base_url().'assets/css/normalize.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/css/dashboard.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/css/jquery-ui-1.10.4.custom.min.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/boot-strap3/css/bootstrap.min.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/boot-strap3/css/bootstrap-responsive.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/css/font-awesome.min.css'?>" type="text/css" rel="stylesheet"/>
    <script src="<?php echo base_url().'assets/scripts/jquery.js'?>" type="text/javascript"></script>
    <link href="<?php echo base_url().'assets/datatable/TableTools.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/datatable/dataTables.bootstrap.css'?>" type="text/css" rel="stylesheet"/>
    <script src="<?php echo base_url('assets/scripts/county_sub_county_functions.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/FusionCharts/FusionCharts.js" type="text/javascript"></script>
     <script src="<?php echo base_url().'assets/scripts/pace.js'?>" type="text/javascript"></script>
    <title>HCMP | National</title>
<script>
   paceOptions = {
  ajax: false, // disabled
  document: true, // 
  eventLag: true,
  restartOnPushState: false,
  elements:{
  	selectors:['body']
  } // 
  
};
 
    function load(time){
      var x = new XMLHttpRequest()
      x.open('GET', document.URL , true);
      x.send();
    };
    setTimeout(function(){
      Pace.ignore(function(){
        load(3100);
      });
    },4500);

    Pace.on('hide', function(){
   //   console.log('done');
    });

    var url="<?php echo base_url(); ?>";
    </script>
<style>
	.active-panel{
    	border-left: 6px solid #36BB24;
    }
    body {
padding-top: 4.5%;
}

.modal-content,.form-control
{
  border-radius: 0 !important;
}
#overview{
	padding-right:0;
}
h4{
	
	padding:4px;
	color:white;
	background:#528f42;
	text-align:center;
	margin:0;
	
	font-size:15px;
}
/*state overview*/

.state-overview .symbol, .state-overview .value {
    display: inline-block;
    text-align: center;
}

.state-overview .value  {
    float: right;

}

.state-overview .value h1, .state-overview .value p  {
    margin: 0;
    padding: 0;
    color: #c6cad6;
}

.state-overview .value h1 {
    font-weight: 300;
    font-size:30px;
}

.state-overview .symbol i {
    color: #fff;
    font-size: 50px;
}

.state-overview .symbol {
    width: 35%;
    padding: 25px 15px;
    -webkit-border-radius: 4px 0px 0px 4px;
    border-radius: 4px 0px 0px 4px;
}

.state-overview .value {
    width: 58%;
    padding-top: 0;
}

.state-overview .terques {
    background: #6ccac9;
}

.state-overview .red {
    background: #ff6c60;
}

.state-overview .yellow {
    background: #f8d347;
}

.state-overview .blue {
    background: #a7cfdf;
}
.state-overview .purple {
    background: #e7b7dd;
}
.state-overview .seagreen {
    background: #39b7ac;
}
.state-overview .b {
    background: #8075c4;
}
.state-overview .b2 {
    background: #fd7998;
}

</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </script></head>
  <body screen_capture_injected="true" style="">
<div class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color:white">
        <div class="container-fluid">
            <div class="navbar-header" id="st-trigger-effects">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand " href="<?php echo base_url().'national';?>" >HCMP</a>

        </div>
        <div class="navbar-header" >
  
            <a href="<?php echo base_url().'national';?>">   
            <img style="display:inline-block;"  src="<?php echo base_url();?>assets/img/coat_of_arms_dash.png" class="img-responsive " alt="Responsive image" id="logo" ></a>
            
        </div>
        
        <div class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="<?php echo base_url().'national';?>">Home</a></li>
            <li class=""><a href="<?php echo base_url().'national/reports';?>">Reports</a></li>
            <li class=""><a href="<?php echo base_url().'national/search';?>">Search</a></li>

            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Welcome, Guest</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>"><span class="glyphicon glyphicon-log-in" style="margin-right: 2%;"></span> Login</a></li>
                            
                            <li class="divider"></li>
                        </ul>
                    </li>
          </ul>
          
                                        
        </div><!--/.nav-collapse -->

      </div>
    </div>
	
	<div class="container-fluid" style="" id="main-content">
	<div class="row">
		
		<div class="col-md-4">
			
			<div class="row">
				<div class="col-md-12" style="/*border: 1px solid #000;*/height: 620px">
					<div style="/*border: 1px solid #000;*/height: 500px"><div id="map" ></div></div>
					<div style="width:130px;margin-left:30%;padding:2%">
            <div style="display:inline-block;width:10px;height:10px;background:#FFCC99">
                
            </div>
            <div style="width:80px;display:inline-block;margin-left:5px;font-size:120%">Using HCMP</div></div>
					<script>
					var map= new FusionMaps ("assets/FusionMaps/FCMap_KenyaCounty.swf","KenyaMap","100%","100%","0","0");
					map.setJSONData(<?php echo $maps; ?>);
					
    				map.render("map");
    				
                    </script>
				
					</div>
				
			</div>
			
			</div>
		<div class="col-md-8">
			
			<div class="row">
				<div class="col-md-12" style="/*border: 1px solid #000;*/height: 200px" id="overview">
					
					<div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                          	<span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Health Workers Trained</p>
                              <h1 class="count" id="hcw_trained"></h1>
                              
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Facilities Rolled Out</p>
                              <h1 class=" count2" id="facilities_rolled_out"></h1>
                              
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Total facilities</p>
                              <h1 class=" count3">328</h1>
                              
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Public health facilities	</p>
                              <h1 class=" count4">10328</h1>
                              
                          </div>
                      </section>
                  </div>
              </div>
              
              <div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol purple">
                          	<span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Private health facilities</p>
                              <h1 class="count">495</h1>
                              
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol b">
                              <span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Faith-based Facilities</p>
                              <h1 class=" count2">947</h1>
                              
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol seagreen">
                              <span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Other Facilities</p>
                              <h1 class=" count3">328</h1>
                              
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol b2">
                              <span class="glyphicon glyphicon-user"></span>
                          </div>
                          <div class="value">
                          	<p>Facilities Using HCMP</p>
                              <h1 class=" count4">10328</h1>
                              
                          </div>
                      </section>
                  </div>
              </div>
				</div>
				
			</div>

			<div class="row">
				<div class="col-md-12" style="border: 1px solid #000;height: 420px">
					
					<div class="panel panel-success">
       <div class="panel-heading">
       <h3 class="panel-title" style="display:inline-block;"><div class="county-name" style="display:inline-block"></div>Expiries</h3>
       </div>
       
        <div class="row" style="margin-left: 2px">

       <div class="col-md-6" style="border: 1px solid #DDD;height: 530px; ">

      
       <div class="panel-heading">
       <h4 class="panel-title">Actual Expiries </h4>
       </div>
        <div class="panel-body" style="margin-left: 2px">
      <ul class='nav nav-tabs' id="actual_">
      <li class="active"><a href="#acounty" data-toggle="tab">County View</a></li>
      <li class=""><a href="#asubcounty" data-toggle="tab">Sub County View</a></li>
       </ul>
       <div id="myTabContent" class="tab-content ">
            <div  id="acounty" class="tab-pane active fade in">
       <div class="filter row" style="margin-left: 2px;">
<form class="form-inline" role="form">
<select id="ecounty_filter" class="form-control col-md-2 county">
<option value="NULL">Select County</option>
<?php
foreach($counties as $data):
    foreach($data as $key=>$name):
      echo "<option value='$key'>$name</option>";
    endforeach;
       
endforeach;
?>
</select>   
<select id="eyear" class="form-control col-md-2">
<option selected="selected" value="NULL">Select Year</option>
<option  value="2014">2014</option>
<option  value="2013">2013</option>
</select> 
<div class="col-md-2">
<button class="btn btn-sm btn-success ecounty-filter"><span class="glyphicon glyphicon-filter"></span>Filter</button> 
</div>

</form>
</div>
       </div> 
        <div  id="asubcounty" class="tab-pane fade in">
            <!-- -->
<div class="filter row" style="margin-left: 2px;">
<form class="form-inline" role="form">
<select id="asubcounty_filter" class="form-control col-md-2 subcounty">
<option value="NULL">Select Sub-County</option>
</select>
<select id="asubcounty_facility_filter" class="form-control col-md-3 facility">
<option value="NULL">Select facility</option>
</select>   
<select id="asubcountyyear" class="form-control col-md-2">
<option selected="selected" value="NULL">Select Year</option>
<option  value="2014">2014</option>
<option  value="2013">2013</option>
</select> 
<div class="col-md-2">
<button class="btn btn-sm btn-success asubcounty-filter"><span class="glyphicon glyphicon-filter"></span>Filter</button> 
</div>

</form>
</div>
       </div>   
      </div>
       <div id="actual">test</div>
       </div> 
        </div> 
       <div class="col-md-6" style="border: 1px solid #DDD;height: 530px;" >

      
       <div class="panel-heading">
       <h4 class="panel-title">Potential Expiries </h4>
       </div>
        <div class="panel-body">
        <ul class='nav nav-tabs' id="potential_">
      <li class="active"><a href="#pcounty" data-toggle="tab">County View</a></li>
      <li class=""><a href="#psubcounty" data-toggle="tab">Sub County View</a></li>
       </ul>
       <div id="myTabContent" class="tab-content">
            <div  id="pcounty" class="tab-pane active fade in">
       <div class="filter row" style="margin-left: 2px;">
<form class="form-inline" role="form">
<select id="pcounty_filter" class="form-control col-md-2 county">
<option value="NULL">Select County</option>
<?php
foreach($counties as $data):
    foreach($data as $key=>$name):
      echo "<option value='$key'>$name</option>";
    endforeach;
       
endforeach;
?>
</select>   
<div class="col-md-2">
<button class="btn btn-sm btn-success pcounty-filter"><span class="glyphicon glyphicon-filter"></span>Filter</button> 
</div>

</form>
</div>
       </div> 
        <div  id="psubcounty" class="tab-pane fade in">
                        <!-- -->
<div class="filter row" >
<form class="form-inline" role="form">
<select id="psubcounty_filter" class="form-control col-md-2 subcounty">
<option value="NULL">Select Sub-County</option>
</select> 
<select id="psubcounty_facility_filter" class="form-control col-md-3 facility">
<option value="NULL">Select facility</option>
</select>   
<div class="col-md-2">
<button class="btn btn-sm btn-success psubcounty-filter"><span class="glyphicon glyphicon-filter"></span>Filter</button> 
</div>
<div class="col-md-1">
<button class="btn btn-sm btn-success psubcounty-download"><span class="glyphicon glyphicon-save"></span>Download</button> 
</div>
</form>
</div>
            </div>   
      </div>
      <div id="potential">test</div>
       </div>    
      
       </div> 
        </div>
          
       </div> 

			<div class="row" style="margin-bottom: 5.5%;">
				<div class="col-md-12" style="/*border: 1px solid #000;*/height: 420px" id="expiries">
					
					<h4>National  Expiries</h4>
       
       <div class="col-md-6" style="border: 1px solid #DDD; ">
      
       <div class="panel-heading">
       <h5 class="panel-title">Actual Expiries </h5>
       </div>

       
       <div id="actual" style=""></div>
       
        </div> 
        
        <div class="col-md-6" style="border: 1px solid #DDD;" >
      
       <div class="panel-heading">
       <h5 class="panel-title">Potential Expiries </h5>
       </div>
        
      <div id="potential"></div>
          
      
       </div> 
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="container-fluid">
			
    <div class="row">
                <div class="col-md-6">
       <h4>Stock Level in Months of Stock (MOS)</h4>
      
      <ul class='nav nav-tabs'style="margin-top: 1%">
      <li class="active"><a href="#stracer" data-toggle="tab">Tracer Items</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
      <div  id="stracer" class="tab-pane fade active in">
<br>
<div class="col-md-1">
    <a href="national/search" target="_blank">
    <button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-filter"></span>More</button> 
</a>

</div>
      </div>
       </div>
        <div id="mos" style="width: "></div> <!--- MOS -->
        
        
      			 </div>
       <div class="col-md-6">
       <h4>Consumption</h4>
       
       <ul class='nav nav-tabs' style="margin-top: 1%">
      <li class="active"><a href="#tracer" data-toggle="tab">Tracer Items</a></li>
       </ul>
   <div id="myTabContent" class="tab-content">
                <div  id="tracer" class="tab-pane fade active in">
<br>
<div class="col-md-1">
    <a href="national/search" target="_blank">
    <button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-filter"></span>More</button> 
</a>

</div>

        
      </div>
      </div>
      <div id="consumption"></div> <!-- consumption -->
       
       </div>
 </div><!--- row 2 -->
 
 <div class="row">
                <div class="col-md-6">
       <div class="">
       
       <h4 class=""><div class="county-name" style="display:inline-block"></div>Cost of Orders</h4>
       
        <div class="" style="height:500px;">
        <ul class='nav nav-tabs'>
      <li class="active"><a href="#corders" data-toggle="tab">Year</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
      <div  id="corders" class="tab-pane fade active in">
<br>
<div class="col-md-1">
    <a href="national/search" target="_blank">
    <button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-filter"></span>More</button> 
</a>

</div>
      </div>
       </div>
        <div id="orders"></div> <!--- MOS -->
       </div>
       
       </div>
      
       </div>
       <div class="col-md-6">
       <div class="">
       
       <h4 class=""><div class="county-name" style="display:inline-block"></div>Order Lead Time</h4>
       
        <div class="" style="height: 500px;">
  <hr />
    <a href="national/search" target="_blank">
    <button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-filter"></span>More</button> 
</a>
      <div class="row">
          <div class="col-md-12">
       <div class="panel-heading">
       <h3 class="panel-title">Fill Rate</h3>
       </div>
       <div id="fill_rate">
            <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
        80%
    </div>
      </div>
       </div>
       </div>  
       <div class="col-md-12">
       <div class="panel-heading">
       <h3 class="panel-title">Order Lead Time</h3>
       </div>
       <div id="lead_infor">
         


       </div>
       </div>  
      </div>
    
       </div>    
       </div>
       </div>
     </div>
     </div>
    </div> <!-- /container -->
    <input type="hidden" name="county_id" id="county_id" />
    

    
   <script>
         //auto run
         var url ='<?php echo base_url()?>';
         $('#potential_').on('shown.bs.tab', function (e) {
         $('#potential').html('');
         });
         $('#actual_').on('shown.bs.tab', function (e) {
         $('#actual').html('');
         });

      $('.county-name').html("National "+" &nbsp;");
      ajax_request_replace_div_content('national/expiry/NULL/NULL/NULL/NULL/NULL',"#actual"); 
      ajax_request_replace_div_content('national/potential/NULL/NULL/NULL/NULL/NULL',"#potential"); 
      ajax_request_replace_div_content('national/facility_over_view/',"#facilities_rolled_out");
      ajax_request_replace_div_content('national/hcw/',"#hcw_trained");
      ajax_request_replace_div_content('national/stock_level_mos/NULL/NULL/NULL/NULL',"#mos");
      ajax_request_replace_div_content('national/consumption/NULL/NULL/NULL/NULL',"#consumption");
      ajax_request_replace_div_content('national/get_facility_infor/NULL/NULL/NULL/NULL',"#facilities");
      ajax_request_replace_div_content('national/order/NULL/NULL/NULL/NULL/NULL',"#orders");
      ajax_request_replace_div_content('national/get_lead_infor/NULL/NULL/NULL/NULL/NULL',"#lead_infor");
      
        $(".ecounty-filter").button().click(function(e) {
        e.preventDefault(); 
        var year = $("#eyear").val();
        var county = $("#ecounty_filter").val();
       // var district=$(this).closest("tr").find("#ecounty_filter").val();
       // var facility=$(this).closest("tr").find("#ecounty_filter").val();
           ajax_request_replace_div_content('national/expiry/'+year+'/'+county+'/NULL/NULL/NULL',"#actual");
        });
        
        $(".asubcounty-filter").button().click(function(e) {
        e.preventDefault(); 
        var year=$("#asubcountyyear").val();
        var county_id=$('#county_id').val();
        var district=$("#asubcounty_filter").val();
        var facility=$("#asubcounty_facility_filter").val();
        ajax_request_replace_div_content('national/expiry/'+year+'/'+county_id+'/'+district+'/'+facility+'/NULL',"#actual");
        });
        /////potential
        $(".pcounty-filter").button().click(function(e) {
        e.preventDefault(); 
        var county=$("#pcounty_filter").val();
        ajax_request_replace_div_content('national/potential/'+county+'/NULL/NULL/NULL',"#potential");
        });
        
        $(".psubcounty-filter").button().click(function(e) {
        e.preventDefault(); 
        var county_id=$('#county_id').val();
        var district=$("#psubcounty_filter").val();
        var facility=$("#psubcounty_facility_filter").val();
        ajax_request_replace_div_content('national/potential/'+county_id+'/'+district+'/'+facility+'/NULL',"#potential");
        });
     
         $(".subcounty").click(function(){
            /*
             * when clicked, this object should populate facility names to facility dropdown list.
             * Initially it sets a default value to the facility drop down list then ajax is used 
             * is to retrieve the district names using the 'dropdown()' method used above.
             */
            json_obj = {"url":"<?php echo site_url("orders/getFacilities");?>",}
            var baseUrl = json_obj.url;
            var id = $(this).attr("value");
            $('.subcounty').val(id);
            dropdown(baseUrl,"district="+id,".facility");
 
          
        });

      
    function run(data){
        var county_data=data.split('^');
        $('.county-name').html(county_data[1]+"&nbsp;County &nbsp;");
        ajax_request_replace_div_content('national/facility_over_view/'+county_data[0],"#facilities_rolled_out");
        ajax_request_replace_div_content('national/hcw/'+county_data[0],"#hcw_trained");
        $('.county').val(county_data[0]);
        $('#county_id').val(county_data[0]);
        json_obj={"url":"<?php echo site_url("orders/getDistrict");?>",}
        var baseUrl=json_obj.url;
        dropdown(baseUrl,"county="+county_data[0],".subcounty");
        ajax_request_replace_div_content('national/expiry/NULL/'+county_data[0]+'/NULL/NULL/NULL',"#actual");
        ajax_request_replace_div_content('national/potential/'+county_data[0]+'/NULL/NULL/NULL/NULL',"#potential"); 
        ajax_request_replace_div_content('national/stock_level_mos/'+county_data[0]+'/NULL/NULL/NULL/ALL',"#mos");
        ajax_request_replace_div_content('national/consumption/'+county_data[0]+'/NULL/NULL/NULL',"#consumption");
        ajax_request_replace_div_content('national/get_facility_infor/'+county_data[0]+'/NULL/NULL/NULL',"#facilities");
        ajax_request_replace_div_content('national/order/NULL/'+county_data[0]+'/NULL/NULL/NULL',"#orders");
        ajax_request_replace_div_content('national/get_lead_infor/NULL/'+county_data[0]+'/NULL/NULL/NULL',"#lead_infor");
    }
            function dropdown(baseUrl,post,identifier){
            /*
             * ajax is used here to retrieve values from the server side and set them in dropdown list.
             * the 'baseUrl' is the target ajax url, 'post' contains the a POST varible with data and
             * 'identifier' is the id of the dropdown list to be populated by values from the server side
             */
            $.ajax({
              type: "POST",
              url: baseUrl,
              data: post,
              success: function(msg){
                    var values=msg.split("_")
                    var dropdown="<option value='NULL'>All</option>";
                    for (var i=0; i < values.length-1; i++) {
                        var id_value=values[i].split("*")
                        dropdown+="<option value="+id_value[0]+">";
                        dropdown+=id_value[1];
                        dropdown+="</option>";
                    };
                    $(identifier).html(dropdown);
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                   if(textStatus == 'timeout') {}
               }
            }).done(function( msg ) {
            });
        }
       function ajax_request_replace_div_content(function_url,div){
        var function_url =url+function_url;
        var loading_icon=url+"assets/img/loader2.gif";
        $.ajax({
        type: "POST",
        url: function_url,
        beforeSend: function() {
        $(div).html("<img style='margin-left:20%;' src="+loading_icon+">");
        },
        success: function(msg) {
        $(div).html(msg);
        }
        });
        }   
</script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>
    var url='<?php echo base_url(); ?>';
    </script>
    	 <script src="<?php echo base_url().'assets/boot-strap3/js/bootstrap.min.js'?>" type="text/javascript"></script>
    <!-- Bootstrap core JavaScript===================== --> 
  <script src="<?php echo base_url().'assets/scripts/jquery-ui-1.10.4.custom.min.js'?>" type="text/javascript"></script>
 
  <script src="<?php echo base_url().'assets/scripts/highcharts.js'?>" type="text/javascript"></script>
   <script src="<?php echo base_url().'assets/scripts/exporting.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/scripts/jquery.floatThead.min.js'?>" type="text/javascript"></script>  
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo base_url().'assets/scripts/hcmp_shared_functions.js'?>" type="text/javascript"></script>
    <!--Datatables==========================  -->
  <script src="<?php echo base_url().'assets/datatable/jquery.dataTables.min.js'?>" type="text/javascript"></script>    
  <script src="<?php echo base_url().'assets/datatable/dataTables.bootstrap.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/datatable/TableTools.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/datatable/ZeroClipboard.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/datatable/dataTables.bootstrapPagination.js'?>" type="text/javascript"></script>
  <!-- validation ===================== -->
  <script src="<?php echo base_url().'assets/scripts/jquery.validate.min.js'?>" type="text/javascript"></script>
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/loadingbar.css'?>" />
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/elusive-webfont.css'?>" />
<div id="window-resizer-tooltip" style="display: none;"><a href="#" title="Edit settings" style="background-image: url(chrome-extension://kkelicaakdanhinjdeammmilcgefonfh/images/icon_19.png);"></a><span class="tooltipTitle">Window size: </span><span class="tooltipWidth" id="winWidth">1366</span> x <span class="tooltipHeight" id="winHeight">768</span><br><span class="tooltipTitle">Viewport size: </span><span class="tooltipWidth" id="vpWidth">1366</span> x <span class="tooltipHeight" id="vpHeight">449</span></div></body></html>