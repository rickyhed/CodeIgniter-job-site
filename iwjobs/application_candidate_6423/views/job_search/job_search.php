<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('include/meta'); ?>
    <script src="<?php echo base_url(); ?>js/jquery.cycle.all.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.scrollTo-1.4.2-min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/user.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery-ui-1.8.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/autocomplete.css" />
<style>
	.ui-autocomplete-loading { background: white url('<?php echo base_url();?>image/loading.gif') right center no-repeat; }
</style>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript">
			$(function(){
				function split( val ) {
                                return val.split( /,\s*/ );
                                }
                                function extractLast( term ) {
                                        return split( term ).pop();
                                }
                                
				//attach autocomplete
				$("#skills")
                                        // don't navigate away from the field on tab when selecting an item
                                .bind( "keydown", function( event ) {
                                        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
                                                event.preventDefault();
                                        }
                                })
                                .autocomplete({
					//define callback to format results
					source: function(request, response ){
                                                var term=extractLast( request.term );
                                                if(term!='')
                                                    {
                                                        //pass request to server
                                                        $.getJSON("ajax-get-key-skill?callback=?", {term: term} , function(data) {

                                                                //create array for response objects
                                                                var suggestions = [];
                                                                //process response
                                                                $.each(data, function(i, val){

                                                                        suggestions.push(val.Name);
                                                                });

                                                                //pass array to callback
                                                                response(suggestions);
                                                        });
                                                    }
                                                    
                                                // delegate back to autocomplete, but extract the last term
					},
					search: function() {
                                            // custom minLength
                                            var term = extractLast( this.value );
                                            if ( term.length < 0 ) {
                                                    return false;
                                            }
                                        },
                                        focus: function() {
                                                // prevent value inserted on focus
                                                return false;
                                        },
					//define select handler
					select: function(e, ui) {
						var terms = split( this.value );
                                                // remove the current input
                                                terms.pop();
                                                var val=$("#key_skills").val();
                                                if(String(val).search (ui.item.value+",") == -1)
                                                    {
                                                        //create formatted skill
                                                        var skill = ui.item.value,
                                                            span = $("<span>").text(skill).attr({id:skill}),
                                                            a = $("<a>").addClass("remove").attr({
                                                                    href: "javascript:",
                                                                    title: "Remove " + skill
                                                            }).text("x").appendTo(span);

                                                        //add skill to skill contener div
                                                        span.insertBefore("#skills");
                                                        // add the selected item
                                                        terms.push(ui.item.value);
                                                    }
                                                // add placeholder to get the comma-and-space at the end
                                                terms.push( "" );
                                                $("#key_skills").val(val+terms.join( "," ));
                                                return false;
					},
					//define select handler
					change: function() {
						
						//prevent 'to' field being updated and correct position
						$("#skills").val("").css("top", 2);
					}
				});
				
				//add click handler to skill contener div
				$("#skills_contener").click(function(){
					
					//focus 'skill' field
					$("#skills").focus();
				});
				
				//add live handler for clicks on remove links
				$(".remove", document.getElementById("skills_contener")).live("click", function(){
				
                                var id=$(this).parent().attr('id');    
                                
                                        //fetch value...
					var val=$("#key_skills").val();
                                        if(String(val).search (id+",") != -1)
                                                    {
                                                        var term=val.split(",");
                                                        var idx=$.inArray(id, term);
                                                        if(idx!=-1)
                                                            {
                                                                term.splice(idx, 1);
                                                                $("#key_skills").val(term.join( "," ));
                                                                //remove current skill
                                                                $(this).parent().remove();
                                                            }
                                                    }
					//correct 'key_skills' field position
					if($("#skills_contener span").length === 0) {
						$("#skills").css("top", 0);
					}				
				});				
			});
		</script>
</head>

<body>
<div class="maincontent">
<!--Header Part Start-->
<?php $this->load->view('include/header'); ?>

<!--Header Part End-->



<!--main Content Start-->
<div style="padding-top:15px;">
<div class="searcharea" id="searcharea" style="width:900px; margin:0 auto;">
                            <form id="job_search" method="post" >			
                            <div class="sr_category">
                                <div class="succeswrap">
                                    <div class="successbox" id="succ_container" style="<?php if(isset($success_msg) && $success_msg  != "") echo 'display:block;'; else echo 'display:none;'; ?>">

                                        <div class="errordesc" id="succ_txt"><?php if(isset($success_msg) && $success_msg  != "") echo $success_msg; ?></div>
                                        <br class="clr" />
                                    </div>

                                    <div class="errorbox" id="err_container" style="<?php if(isset($error_msg) && $error_msg  != "") echo 'display:block;'; else echo 'display:none;'; ?>">

                                        <div class="errordesc" id="err_txt"><?php if(isset($error_msg) && $error_msg  != "") echo $error_msg; ?></div>
                                        <br class="clr" />

                                    </div>

                                </div>
                            </div>
                                <br class="clr"/><br class="clr"/>
                            <div class="sr_category">
                                <div>Keyword :</div>
                                <div class="conRgt">
                                    <div><input type="text" id="keyword" name="keyword" value="<?php if(isset ($keyword)): echo $keyword; endif; ?>"/>
                                    </div></div>

                            </div>
                            <div class="sr_category">
                                <div>Location :</div>
                                <div class="conRgt">
                                    <select name="location" id="location">
                                        <option value="">----- Select city -----</option>
                                        <?php foreach($city_list as $v): ?>
                                        <option value="<?php echo $v['CityId']; ?>" <?php if( isset($location) && $v['CityId'] == $location) echo 'selected="selected"'; ?>><?php echo $v['CityName'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <br class="clr"/>
                            </div>

                            <div class="sr_category">
                                <div>Key skills :</div>
                                <div class="conRgt">
                                    <div>
                                        <div id="skills_contener" class="ui-helper-clearfix"><?php if(isset($key_skill_array)) { foreach($key_skill_array as $key => $val):?><span id="<?php echo $val; ?>" ><?php echo $val; ?><a class="remove" href="javascript:" title="Remove <?php echo $val; ?>">x</a></span><?php endforeach; } ?><input type="hidden" name="key_skills" id="key_skills" value="<?php if(isset ($key_skills) && $key_skills!='') echo $key_skills; ?>" /><input type="text" name="skills" id="skills" value="" size="10"/></div>
                                    </div>
                                </div>
                            </div>
                            <br class="clr"/>
                            <div class="sr_category">
                                <div>Experience :</div>
                                <div class="conRgt">
                                    <select name="experience" id="experience">
                                    <option value="">----- Select experience -----</option>
                                    <?php for($exp=1; $exp<=15; $exp++): ?>
                                    <option value="<?php echo $exp; ?>" <?php if( isset($experience) && $exp == $experience) echo 'selected="selected"'; ?>><?php echo $exp ?></option>
                                    <?php endfor; ?>
                                    <option value="15+" <?php if( isset($experience) && $exp == $experience) echo 'selected="selected"'; ?>>15+</option>
                                    </select>
                                </div>
                                <br class="clr"/>
                            </div>
                            <div class="sr_category">
                                <div>Salary :</div>
                                <div class="conRgt">
                                    <div><input type="text" id="salary" name="salary" value="<?php if(isset ($salary) ): echo $salary; endif;?>" />
                                    </div></div>

                            </div>
                            <div class="sr_category">
                                <div>Functional Expertise :</div>
                                <div class="conRgt">
                                    <select name="expertise[]" id="expertise" multiple="multiple" style="height: 150px;width: 330px;">
                                    <option value="">----- Select expertise -----</option>
                                    <?php foreach($expertise_list as $v): ?>
                                    <option value="<?php echo $v['Name']; ?>" <?php if( isset($expertise)): $i=0;$count=count($expertise); while($i<$count){ if($v['Name'] == $expertise[$i]) echo 'selected="selected"'; $i++;} endif ?> > <?php echo $v['Name'] ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                                <br class="clr"/>
                            </div>		
                             <br class="clr"/>

                             <div class="sr_category">
                                <div class="searchbtntopev" title="padding-top:10px;">
                                    <div class="hcardmempictsbmas">
                                        <div class="btn_lnkgraynew1 button2" id="signup_btn_container"><span><input type="submit" name="btn_jobsearch" class="btn_submitgray" value="Search" /></span></div>
                                        
                                    </div>

                                </div>
                                    <br class="clr"/>
                            </div>
                            
                             </form>	
                            <br class="clr"/>
                            
                            
                        </div>
</div>
				
<div class="contentmain">

<!--Top Caption Start-->
<div class="mainarea">

<div>

<div><h2>Search Area </h2></div>

						
<br class="clr" />
<div class="body_txt" style="width:900px; margin:0 auto;">
    
</div>

<div style="width:900px; margin:0 auto; padding:0 0 15px 0;">
    
    <?php if(isset ($search_result) && $search_result!=''): ?>
<table width="900" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
  <tr style="background:#000; padding:5px 0; color:#fff;">
    <td>Company</td>
    <td>Job Title</td>
    <td>Description</td>
    <td>Location</td>
    <td>Salary</td>
    <td>Experience</td>
    <td>Action</td>
  </tr>
    <?php $i=0; $count=count($search_result); while($i<$count):?>
  <tr>
      <td><img src="<?php echo SHOW_MEDIA_BASEFOLDER.'showcase/company_logo/'.$search_result[$i]['CompanyLogo']; ?>" title="<?php echo $search_result[$i]['Organization']; ?>" /></td>
    <td><?php echo $search_result[$i]['JobName']; ?></td>
    <td><?php echo $search_result[$i]['JobDescription']; ?></td>
    <td><?php echo $search_result[$i]['JobLocation']; ?></td>
    <td><?php echo $search_result[$i]['Salary']; ?></td>
    <td><?php echo $search_result[$i]['Experience']; ?></td>
    <td><a href="<?php if(strpos($search_result[$i]['CompanyLink'], "http://")===false):echo "http://".$search_result[$i]['CompanyLink']; else: echo $search_result[$i]['CompanyLink']; endif; ?>" target="_blank" ><b>Apply</b></a></td>
  </tr>
    <?php $i++; endwhile;?>
</table>
<?php else: ?>
No Records
<?php endif;?>

</div>
</div>
</div>
</div>
<!--Left Content End-->

<!--Right Content Start-->

<!--Right Content End-->
</div>

</div>
<!--main Content End-->

</div>

<!--Footer Start-->
<?php $this->load->view('include/footer'); ?>
<!--Footer End-->


</body>
</html>

