
<style>
.ActivateBtn{


}


body{

}


.panel{

}


</style>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verfiection</title>
</head>
<body style="background: #e7e7e7;">
    <div class="panel" style="background: white;border-radius: 8px;margin-top:10%;margin-right: 10%;margin-left:10%;padding-bottom:14px;">
        <h4  style='text-align:center;padding:10%'>Just One Step Activate Your Account</h4>
        <br>
        <a class="ActivateBtn" style="display:block;background-color:#337ab7;padding:16px;margin:8%;border-radius:6px;color:white;text-align:center;" href="{{ route("Activate",['token'=>$verf]) }}">Click Here To Active Account</a>
     </div>
</body>
</html>



