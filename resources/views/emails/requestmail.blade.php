<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 12/5/2017
 * Time: 2:44 PM
 */-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neptune PPA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style type="text/css">
        h3,p{
            margin-top: 0px;
            margin-bottom: 10px;
        }
        span{
            margin-top: 0px;
            margin-bottom: 10px;
        }
        .messg-btn{
            display: inline-block;
            padding: 20px;
            background: #165dac;
            color: #fff;
            text-decoration: none;
        }
    </style>
<body style="font-family: arial;">
<center>
    <table width="80%;">

        <tr>
            <td colspan="3"><hr style="border-color: rgba(234, 234, 234, 0.33); border: 2px double #d5d5d5;"></td>
        </tr>
        <tr>
            <td colspan="3" style="background: #f1f1f1;">
                <h2 style="margin-left:10px;"><b> New Device Request In Neptune-PPA </b></h2>
            </td>
        </tr>
        <tr>
            <td colspan="3"><hr style="border-color: rgba(234, 234, 234, 0.33); border: 2px double #d5d5d5;"></td>
        </tr>
        <tr>
            <td colspan="3"><p style="font-weight: normal; font-size: 19px; margin-top: 35px;">Dear Admin,</p></td>
        </tr>
        <tr>
            <td colspan="3">
                <center>
                    <p style="font-weight: normal; font-size: 19px; margin-top: 10px;"><h1>Requested Device Details.</h1></p>
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <center>
                    <div style="background: #f1f1f1; width: 500px; padding:20px;" align="center">
                        <p style="font-weight: normal; font-size: 19px; text-align: left;">Project Name :-  {{$projectName}} </p><br>
                        <p style="font-weight: normal; font-size: 19px; text-align: left;">Category Name :-  {{$categoryName}} </p><br>
                        <p style="font-weight: normal; font-size: 19px; text-align: left;">Device Name :-  {{$deviceName}} </p><br>
                        <p style="font-weight: normal; font-size: 19px; text-align: left;">Message :-  {{$messages}} </p><br>

                    </div>
                </center>

            </td>

        </tr>

    </table>
</center>
</body>

</html>