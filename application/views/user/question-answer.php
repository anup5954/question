<!--start here meta section-->
<?php include('include/meta.php'); ?>
<style>
  .loader {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 9;
    text-align: center;
    background: #33333373;
}
.loader img {
    width: 60px;
    position: absolute;
    left: 50%;
    margin-left: -30px;
    top: 50%;
    margin-top: -30px;
}
</style>
<!--start here end meta  section-->
<div class="loader"><img src="<?php echo base_url('assets/img/loader.gif'); ?>"></div>
<div id="wrapper">
  <!-- Sidebar -->
  <?php include('include/user-sidebar.php'); ?>
  <!-- Sidebar -->

  <!-- Header -->
  <?php include('include/header.php'); ?>
  <!-- Header -->

  <!-- Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
     <!--<div class="progress">
                            <div class="bar" style="width:35%">
                                <p class="percent">35% <span>Complete</span></p>
                            </div>
                        </div>-->
                       
    <div id="resultData"></div>

    <div class="bg-white mt-3 rounded questionanswer">
       

      <?php 
      $c = 0;
      $sectionPageLength = 1;
      $catLength = count($categories);

      if(!empty($categories)){ 
        foreach($categories as $cat){
        ?>

      

      <div class="card shadow mb-4 activeDiv <?php echo ($c == 0)?'first current':''; ?> <?php echo ($c == $catLength-1)?'last':''; ?>" style="<?php echo ($c != 0)?'display: none;':''; ?>" id="<?php echo $cat->cat_id; ?>">

        <?php echo form_open('',['id' => 'catForm_'.$cat->cat_id]); ?>

        <div class="card-header py-3 d-flex">
          <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">  Question </h6>
          <h6 class="ml-auto m-0 font-weight-bold  d-flex align-items-center"> (<?php echo $sectionPageLength++; ?>/<?php echo count($categories); ?>) Section <span class="text-success ml-2">(<?php echo $cat->cat_name; ?>)</span>  </h6>
        </div>
        <input type="hidden" name="cat_id" value="<?php echo $cat->cat_id; ?>">
        <?php 
        $i = 1;
        if(!empty($cat->questions)){ 
          foreach($cat->questions as $ques){

        ?>
        <div class="card-body border-bottom" id="<?php echo $ques->id; ?>">
          <div class="wdinput form-group">
            <label class=" font-weight-bold">Question <span class="text-danger"><?php echo $i++; ?>*</span></label>
            <p><?php echo $ques->question; ?></p>
          </div>
          <input type="hidden" name="question_id[]" value="<?php echo $ques->id; ?>">
          <input type="hidden" name="answer_id_<?php echo $ques->id; ?>" value="<?php echo !empty($ques->answers->id)?$ques->answers->id:''; ?>">
          <div class="wdinput form-group p-3">

          <?php if($ques->question_type == 'binary'){ ?>

              <?php if(!empty($ques->options)){ 
                foreach($ques->options as $option){
              ?>
                <label class="radio-btn"><?php echo ucfirst($option->options); ?>
                  <input type="radio" name="option_id_<?php echo $ques->id; ?>[]" value="<?php echo $option->id; ?>" <?php echo (!empty($ques->answers->option_id) && $option->id == $ques->answers->option_id)?'checked':''; ?>>
                  <span class="checkmark"></span>
                </label>

              <?php }} ?>

          <?php } elseif($ques->question_type == 'mcq'){ ?>

              <?php if(!empty($ques->options)){ 
                foreach($ques->options as $option){
              ?>
                  <label class="radio-btn"><?php echo $option->options; ?>
                    <input type="radio" name="option_id_<?php echo $ques->id; ?>[]" value="<?php echo $option->id; ?>" <?php echo (!empty($ques->answers->option_id) && $option->id == $ques->answers->option_id)?'checked':''; ?>>
                    <span class="checkmark"></span>
                  </label>
              <?php }} ?>

          <?php } elseif($ques->question_type == 'multiple'){ ?>

                <?php if(!empty($ques->options)){
                  $opId = !empty($ques->answers->option_id)?explode(',',$ques->answers->option_id):'';
                  foreach($ques->options as $option){
                  $multichecked = "";
                  if(!empty($opId)){
                    if(in_array($option->id,$opId)){
                      $multichecked = 'checked';
                    }
                  }
                ?>
                  
                  <label class="checkbox-btn"><?php echo $option->options; ?>
                    <input type="checkbox" name="option_id_<?php echo $ques->id; ?>[]" value="<?php echo $option->id; ?>" <?php echo $multichecked; ?> class="<?php if($ques->id == 501 && $option->options == 'None'){ ?>none-option<?php } elseif($ques->id == 501) { ?>other-option<?php } ?> <?php if($ques->id == 503 && $option->options == 'None of the above'){ ?>none-option1<?php } elseif($ques->id == 503) { ?>other-option1<?php } ?> <?php if($ques->id == 489 && $option->options == 'Do not know'){ ?>none-option2<?php } elseif($ques->id == 489) { ?>other-option2<?php } ?> <?php if($ques->id == 491 && $option->options == 'None'){ ?>none-option3<?php } elseif($ques->id == 491) { ?>other-option3<?php } ?> <?php if($ques->id == 555 && $option->options == 'None of the Above'){ ?>none-option4<?php } elseif($ques->id == 555) { ?>other-option4<?php } ?> <?php if($ques->id == 379 && $option->options == 'None'){ ?>none-option5<?php } elseif($ques->id == 379) { ?>other-option5<?php } ?> <?php if($ques->id == 501 && $option->options == 'None'){ ?>none-option7<?php } elseif($ques->id == 501) { ?>other-option7<?php } ?> <?php if($ques->id == 487 && $option->options == 'None'){ ?>none-option8<?php } elseif($ques->id == 487) { ?>other-option8<?php } ?> <?php if($ques->id == 493 && $option->options == 'No Body'){ ?>none-option9<?php } elseif($ques->id == 493) { ?>other-option9<?php } ?> 

                      <?php if($ques->id == 496 && $option->options == 'None'){ ?>none-option10<?php } elseif($ques->id == 496) { ?>other-option10<?php } ?>

                      <?php if($ques->id == 545 && $option->options == 'None of the above'){ ?>none-option12<?php } elseif($ques->id == 545) { ?>other-option12<?php } ?>

                      <?php if($ques->id == 543 && $option->options == 'None'){ ?>none-option11<?php } elseif($ques->id == 543) { ?>other-option11<?php } ?>">
                    <span class="checkmark"></span>
                  </label>
                  
             <?php }} ?>

          <?php } ?>

          </div>
        </div>

        

      <?php }} ?>
      <input type="hidden" name="genratePdfData" class="genratePdfData" value="">
      <?php echo form_close(); ?>
     </div>

     
     
   <?php $c++; }} ?>
   </div>

      <div class="question-submit p-3">
        <div class="wdinput form-group">
           <button class="btn btn-dark mr-3 hidden" id="prev">Previous</button>
           <button class="btn btn-primary mr-3 hidden finalSub" id="submit">Submit</button>
           <button class="btn btn-primary next" id="next">Next</button>
         </div>
       </div>
 </div>


 <!-- Content -->        

</div>

<?php include('include/footer.php'); ?>

<script type="text/javascript">
  $(document).ready(function() {
    $(".loader").hide();

    $('#next').click(function() {
      $(".loader").show();
  var catId = '';

  $('.questionanswer .activeDiv').each(function(){
    if($(this).hasClass('current')){
      catId = $(this).attr('id');
      return false;
    }
  });


  if(catId != '' && catId != 'undefined'){

    var quesId = '';
    var ajaxAnswer = 1;
    
    $("#catForm_"+catId+ " .border-bottom").each(function(){
       quesId = $(this).attr('id');
       let answerValue = $("input[name='option_id_"+quesId+"[]']:checked").val();
       
       if(typeof(answerValue) == 'undefined'){
          ajaxAnswer = 0;
          return false;
       }
    });


    if(ajaxAnswer == 1){
      $.ajax({
          url:"<?php echo base_url('user/save-answer'); ?>",
          method:"POST",
          data:$("#catForm_"+catId).serialize(),
          success:function(data) {
            $("#resultData").html(data);
            $(".loader").hide();
          }
      });


      $('.current').removeClass('current').hide()
    .next().show().addClass('current');  $('.current1').removeClass('current1').removeClass('active').next().addClass('active').addClass('current1');
   

      if ($('.current').hasClass('last')) {
        $('#next').addClass('hidden');
        $('#submit').removeClass('hidden');
      }
      $('#prev').removeClass('hidden');

    } else {
        $(".loader").hide();
        alert('Please Answer to all Questions.');
    }
  }

});

$('#prev').click(function() {
  $('.current').removeClass('current').hide()
    .prev().show().addClass('current');
  $('.current1').removeClass('current1').removeClass('active').prev().addClass('active').addClass('current1');

  $("li.current1").find('span').removeClass('active1'); 
  
  if ($('.current').hasClass('first')) {
    $('#prev').addClass('hidden');

  }
  $('#next').removeClass('hidden');
  $('#submit').addClass('hidden');
});


  $('.finalSub').on("click",function() {
    var catId = '';

    $(".genratePdfData").val("saveFinalData");
    $(this).attr('disabled', true);
    $(".loader").show();
    $('.questionanswer .activeDiv').each(function(){
      if($(this).hasClass('current')){
        catId = $(this).attr('id');
        return false;
      }
    });


    if(catId != '' && catId != 'undefined'){

      var quesId = '';
      var ajaxAnswer = 1;
      
      $("#catForm_"+catId+ " .border-bottom").each(function(){
         quesId = $(this).attr('id');
         let answerValue = $("input[name='option_id_"+quesId+"[]']:checked").val();
         
         if(typeof(answerValue) == 'undefined'){
            ajaxAnswer = 0;
            return false;
         }
      });


      if(ajaxAnswer == 1){
        $.ajax({
            url:"<?php echo base_url('user/save-answer'); ?>",
            method:"POST",
            data:$("#catForm_"+catId).serialize(),
            success:function(data) {
              $("#resultData").html(data);

              if(data != ""){
                var parseData = JSON.parse(data);
                alert(parseData.msg);
                var link = document.createElement('a');
                link.href = "<?php echo base_url(); ?>uploads/"+parseData.filename;
                link.download = parseData.filename;
                link.click();
                link.remove();
              }

              $(".loader").hide();
              window.location.reload();
            }
        });
      } else {
          $(".loader").hide();
          alert('Please Answer to all Questions.');
          $(this).attr('disabled', false);
      }
    }
  });

  $(document).on('click','.none-option', function() {
    $('.other-option').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option', function() {
    $('.none-option').prop('checked',false);
  });


  $(document).on('click','.none-option12', function() {
    $('.other-option12').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option12', function() {
    $('.none-option12').prop('checked',false);
  });


  $(document).on('click','.none-option1', function() {
    $('.other-option1').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option1', function() {
    $('.none-option1').prop('checked',false);
  });

  $(document).on('click','.none-option2', function() {
    $('.other-option2').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option2', function() {
    $('.none-option2').prop('checked',false);
  });

  $(document).on('click','.none-option3', function() {
    $('.other-option3').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option3', function() {
    $('.none-option3').prop('checked',false);
  });


  $(document).on('click','.none-option4', function() {
    $('.other-option4').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option4', function() {
    $('.none-option4').prop('checked',false);
  });


  $(document).on('click','.none-option5', function() {
    $('.other-option5').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option5', function() {
    $('.none-option5').prop('checked',false);
  });


  $(document).on('click','.none-option6', function() {
    $('.other-option6').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option6', function() {
    $('.none-option6').prop('checked',false);
  });


  $(document).on('click','.none-option7', function() {
    $('.other-option7').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option7', function() {
    $('.none-option7').prop('checked',false);
  });




  $(document).on('click','.none-option8', function() {
    $('.other-option8').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option8', function() {
    $('.none-option8').prop('checked',false);
  });


$(document).on('click','.none-option9', function() {
    $('.other-option9').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option9', function() {
    $('.none-option9').prop('checked',false);
  });


  $(document).on('click','.none-option10', function() {
    $('.other-option10').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option10', function() {
    $('.none-option10').prop('checked',false);
  });


  $(document).on('click','.none-option11', function() {
    $('.other-option11').each(function(){
      $(this).prop('checked',false);
    });
  });

  $(document).on('click', '.other-option11', function() {
    $('.none-option11').prop('checked',false);
  });
  
});


</script>


