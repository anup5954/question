<!--start here meta section-->
<?php include('include/meta.php'); ?>
<!--start here end meta  section-->
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


    <div class="bg-white mt-3 rounded questionanswer">
      <?php 
      $c = 0;
      $catLength = count($categories);

      if(!empty($categories)){ 
        foreach($categories as $cat){
        ?>

      

      <div class="card shadow mb-4 activeDiv <?php echo ($c == 0)?'first current':''; ?> <?php echo ($c == $catLength-1)?'last':''; ?>" style="<?php echo ($c != 0)?'display: none;':''; ?>" id="<?php echo $cat->cat_id; ?>">

        <?php echo form_open('',['id' => 'catForm_'.$cat->cat_id]); ?>

        <div class="card-header py-3 d-flex">
          <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">  Question </h6>
          <h6 class="ml-auto m-0 font-weight-bold  d-flex align-items-center"> Section <span class="text-success ml-2">(<?php echo $cat->cat_name; ?>)</span>  </h6>
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
                  $op = 0;
                  foreach($ques->options as $option){
                  $opId = !empty($ques->answers->option_id)?explode(',',$ques->answers->option_id):'';
                ?>
                  
                  <label class="checkbox-btn"><?php echo $option->options; ?>
                    <input type="checkbox" name="option_id_<?php echo $ques->id; ?>[]" value="<?php echo $option->id; ?>" <?php echo (!empty($opId[$op]) && $option->id == $opId[$op])?'checked':''; ?>>
                    <span class="checkmark"></span>
                  </label>
                  
             <?php $op++;}} ?>

          <?php } ?>

          </div>
        </div>

        

      <?php }} ?>
      <?php echo form_close(); ?>
     </div>

     
     
   <?php $c++; }} ?>
   </div>

   <div class="question-submit p-3">
          <div class="wdinput form-group">
           <button class="btn btn-dark mr-3 hidden" id="prev">Previous</button>
           <button class="btn btn-primary" id="next">Next</button>
         </div>
       </div>
 </div>


 <!-- Content -->        

</div>

<?php include('include/footer.php'); ?>

<script type="text/javascript">
  /*$(document).ready(function() {

    $('#next').click(function() {

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


  $('.finalSub').click(function() {
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
            }
        });
      } else {
          alert('Please Answer to all Questions.');
      }
    }
  });
});*/
</script>

