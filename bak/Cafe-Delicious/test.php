

<!DOCTYPE html>
<html>
<head>
<title>Submit Form Without Refreshing Page</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style>
    @import "http://fonts.googleapis.com/css?family=Fauna+One|Muli";
#form{
background-color:#556b2f;
color:#D5FFFA;
border-radius:5px;
border:3px solid #d3cd3d;
padding:4px 30px;
font-weight:700;
width:350px;
font-size:12px;
float:left;
height:auto;
margin-left:35px
}
label{
font-size:15px
}
h3{
text-align:center;
font-size:21px
}
div#mainform{
width:960px;
margin:50px auto;
font-family:'Fauna One',serif
}
input[type=text]{
width:100%;
height:40px;
margin-top:10px;
border:none;
border-radius:3px;
padding:5px
}
textarea{
width:100%;
height:60px;
margin-top:10px;
border:none;
border-radius:3px;
padding:5px;
resize:none
}
input[type=radio]{
margin:10px 5px 5px
}
input[type=button]{
width:100%;
height:40px;
margin:35px 0 30px;
background-color:#f4a460;
border:1px solid #fff;
border-radius:3px;
font-family:'Fauna One',serif;
font-weight:700;
font-size:18px
}
Copy

</style>
<script>
    $(document).ready(function() {
$("#submit").click(function() {
var name = $("#name").val();
var email = $("#email").val();
var contact = $("#contact").val();
var gender = $("input[type=radio]:checked").val();
var msg = $("#msg").val();
if (name == '' || email == '' || contact == '' || gender == '' || msg == '') {
alert("Insertion Failed Some Fields are Blank....!!");
} else {
// Returns successful data submission message when the entered information is stored in database.
$.post("refreshform.php", {
name1: name,
email1: email,
contact1: contact,
gender1: gender,
msg1: msg
}, function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
});
}
});
});
</script>
</head>
<body>
<div id="mainform">
<h2>Submit Form Without Refreshing Page</h2>
<!-- Required Div Starts Here -->
<form id="form" name="form">
<h3>Fill Your Information!</h3>
<label>Name:</label>
<input id="name" placeholder="Your Name" type="text">
<label>Email:</label>
<input id="email" placeholder="Your Email" type="text">
<label>Contact No.</label>
<input id="contact" placeholder="Your Mobile No." type="text">
<label>Gender:</label>
<input name="gender" type="radio" value="male">Male
<input name="gender" type="radio" value="female">Female
<label>Message:</label>
<textarea id="msg" placeholder="Your message..">
</textarea>
<input id="submit" type="button" value="Submit">
</form>
</div>
</body>
</html>