<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Register
 * @author     madan <madanchunchu@gmail.com>
 * @copyright  2018 madan
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;
$session = JFactory::getSession();

$user=$session->get('user_casillero_id');

if($user){
$app =& JFactory::getApplication();
$app->redirect('index.php?option=com_userprofile&view=user');
//$this->setRedirect(JRoute::_('', false));
}
require_once JPATH_ROOT.'/components/com_register/helpers/register.php';


$canEdit = JFactory::getUser()->authorise('core.edit', 'com_register');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_register'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
var $joomla = jQuery.noConflict(); 
$joomla(document).ready(function() {

	$joomla(":reset").on('click',function(){
        $joomla('label.error').hide();
	});

	// Wait for the DOM to be ready
	$joomla(function() {
	
		// Initialize form validation on the registration form.
		// It has the name attribute "registration"
		$joomla("form[name='registerFormOne']").validate({
			
			// Specify validation rules
			rules: {
			  // The key name on the left side is the name attribute
			  // of an input field. Validation rules are defined
			  // on the right side
			  unameTxt: "required",
			  passwordTxt: {
				required: true,
				minlength: 4
              }
			},
			// Specify validation error messages
			messages: {
			  unameTxt: "Please enter your Username",
			  passwordTxt: {
                  required: "Please provide a password",
                  minlength: "Your password must be at least 5 characters long"
              },
              emailTxt: "Please enter a valid email address"
      
			},
			// Make sure the form is submitted to the destination defined
			// in the "action" attribute of the form when valid
			submitHandler: function(form) {
					// Returns successful data submission message when the entered information is stored in database.
					/*$.post("http://boxon.justfordemo.biz/index.php/register", {
						name1: name,
						email1: email,
						task: register,
						id:  0
					}, function(data) {
						$joomla("#returnmessage").append(data); // Append returned message to message paragraph.
						if (data == "Your Query has been received, We will contact you soon.") {
							$joomla("#registerFormOne")[0].reset(); // To reset form fields on success.
						}
					});*/
			  form.submit();
			}
		});
	});
	
	// clear text start
	
	$joomla(".clearable__clear").hide();
	
	$joomla("input").on('keyup',function(){
	    
	    in_length = $joomla(this).val().length;
	    
	    if(in_length > 0){
	    
	    $joomla(this).parent().find(".clearable__clear").show();
	    
	    }else{
	        
	        $joomla(this).parent().find(".clearable__clear").hide();
	    }
	    
	});
	
	$joomla(".clearable__clear").on('click',function(){
        $joomla(this).parent().find("input").val("");
        $joomla(this).hide();
	});
	
	// clear text end
	


});
</script>

<style>
.clearable__clear{
  font-style: normal;
    font-size: 2em;
    user-select: none;
    cursor: pointer;
    position: absolute;
    top: 24px;
    right: 10px;
    opacity:0.2;
}
.lognew_sec{
    position: relative;
}
</style>

<div class="item_fields">


  <form name="registerFormOne" id="registerFormOne" method="post" action="">
    <!-- LogIn Page -->
      <div class="container">
        <div class="loggin_view">
          <div class="main_panel">
            <div class="main_heading"> Login </div>
            <div class="panel-body">
              <div class="form-group login_sec lognew_sec">
                <label>USERNAME / EMAIL ID <span class="error">*</span></label>
                <input type="text" class="form-control" name="unameTxt" id="unameTxt">
                <i class="clearable__clear">&times;</i>
              </div>
              <div class="form-group lognew_sec">
                <label>PASSWORD <span class="error">*</span></label>
                <input type="password" class="form-control" name="passwordTxt" id="passwordTxt">
                <i class="clearable__clear">&times;</i>
              </div>
              <div class="form-group">
                
                
              </div>
              <div class="form-group btn-linkblk">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <a href="<?php echo JRoute::_('/index.php/tracking'); ?>" class="btn btn-link btn-block new-usrlnk">New User? Signup</a>
                <a class="btn btn-link btn-block" href="<?php echo JRoute::_('index.php?option=com_register&view=forgotpassword'); ?>"><?php echo JText::_("COM_REGISTER_FORGOT_PASSWORD"); ?></a>
                <!-- <a href="<?php echo JRoute::_('index.php?option=com_register&view=register'); ?>" class="btn btn-primary btn-block">New User?</a>
                <a href="<?php echo JRoute::_('index.php?option=com_register&view=agentregister'); ?>" class="btn btn-primary btn-block">Agent Registration</a>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- LogIn Page -->
    <input type="hidden" name="task" value="register.login">
    <input type="hidden" name="id" value="0" />
    <input type="hidden" name="itemid" value="<?php echo $_GET['Itemid'];?>" />
  </form>
</div>
<?php if($canEdit): ?>
<a class="btn" href="<?php echo JRoute::_('index.php?option=com_register&task=register.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_REGISTER_EDIT_ITEM"); ?></a>
<?php endif; ?>
<?php if (JFactory::getUser()->authorise('core.delete','com_register.register.'.$this->item->id)) : ?>
<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal"> <?php echo JText::_("COM_REGISTER_DELETE_ITEM"); ?> </a>
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo JText::_('COM_REGISTER_DELETE_ITEM'); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo JText::sprintf('COM_REGISTER_DELETE_CONFIRM', $this->item->id); ?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal">Close</button>
    <a href="<?php echo JRoute::_('index.php?option=com_register&task=register.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger"> <?php echo JText::_('COM_REGISTER_DELETE_ITEM'); ?> </a> </div>
</div>
<?php endif; ?>
