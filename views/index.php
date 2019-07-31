<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Brando Travel</title>
    <link type="text/css" rel="stylesheet" href="(path)/rgbaColorPicker.css" />
    <script type="text/javascript" src="(path)/rgbaColorPicker.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">

        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
            /*  float: left;
              width: 25%;*/
        }

        #image {
            background: url(images/brando.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            display: block;
            position: relative;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        #body {
            margin: 0 15px 0 15px;
        }

        #title {
            color: red;
            font-size: 40px;
        }

        #box {
            background-color: red;
            border-radius: 2em;
            width: 90%;
            margin: auto;

        }

        #box1 {
            padding-top: 5px;
            color: white;
            padding-left: 5px;
        }

        #inputBox1, #inputBox2 {
            padding-top: 5px;
            align-content: center;
            border-radius: 1em;
            width: 90%;
            margin: 5px;
            padding-bottom: 5px;
            outline: none;
            padding-left: 8px;
        }

        .buttonHolder {
            background-color: red;
            border-radius: 5em;
            padding-left: 5px;
            color: white;
            text-align: center;
            width: 90%;
            margin: auto;
            padding-bottom: 10px;
            padding-top: 10px;
        }

        form input[type='submit'] {
            display: inline-block;
            width: 70px;
        }

        #search {
            color: white;
            background-color: red;
            border: none;
            font: caption;
        }
        #results {
            display: none;
        }
        .content{
            color: white;
            font-weight:bold;
        }
        .fontClass{
            color: #a2a2a2 !important;
            font-weight:normal !important;
        }
        ul li {
            list-style: none;
        }
        ul li::before {
            content: "\2022";  /* Add content: \2022 is the CSS Code/unicode for a bullet */
            color: white;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
            size: A3;
        }
    </style>

</head>
<body id="image">
<div style="400px">
<div style="width:26%; float:left; height:60px;" id="leftContainer">
    <form id="myForm" name="myForm" method="get" action="">

        <h1 id="title"><strong><b style="width: 100%">Brando Travel</b></strong></h1>

        <div id="box">
            <div id="body">

                <div>
                    <h2 id="box1">Starting postcode</h2>

                    <input id="inputBox1" name="start" type="text" onfocus="this.value=''" value="" placeholder="Enter Postcode">

                </div>
                <div style="margin-bottom: 10px;padding-bottom: 15px;">
                    <h2 id="box1">Destination postcode</h2>

                    <input id="inputBox2" name="destination" type="text" onfocus="this.value=''" value="" placeholder="Enter Postcode">
                </div>
                <div></div>
            </div>
        </div>

        <br>
        <div class="buttonHolder">

            <button value="Search" title="search" onclick="getResults()" type="button" id="search">Search</button>

        </div>
    </form>
</div>
</div>
    <div id="results" style="width: 65%; float:right; height:available; background:#314f60;margin-top: -38px;">
    <div class="show">

        <div class="content" style="padding-left: 50px;padding-top: 50px; padding-bottom: 20px">
            <div>Your Walk to <span id="destinationSpan" style="color: deeppink"></span></div>
        </div>
        <div class="content" style="padding-left: 50px; padding-bottom: 20px;">
            <div><span id="startDateSpan"></span></div>
        </div>
        <div class="content" style="padding-left: 50px; width: 100%; padding-bottom: 20px;">
            <div>Start time &nbsp;<span class="fontClass" style="width: 30%" id="startTimeSpan"></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End time &nbsp;<span class="fontClass" style="width: 30%" id="endTimeSpan"></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duration &nbsp;<span class="fontClass" style="width:40%;" id="durationSpan"></span></div>
        </div>

        <div class="content" style="padding-left: 50px; padding-bottom: -40px">
            <div>Directions  <span class="fontClass" id="descriptionSpan"></span></div>
        </div>
    </div>
    <form method="POST" name="saveJourneyForm" id="saveJourneyForm" >
        <input type="hidden" name="type" value="2" />
        <input type="hidden" name="startDate" id="startDate" value=""/>
        <input type="hidden" name="startTime" id="startTime" value=""/>
        <input type="hidden" name="endTime" id="endTime" value=""/>
        <input type="hidden" name="duration" id="duration" value=""/>
        <input type="hidden" name="description" id="description" value=""/>

        <div class="content" style="padding-left: 55px; padding-bottom: 20px;">

        <button style=" width: 25%; color: white; background: #FF66CC;border: none; border-radius: 3em;margin: 8px;padding: 10px;" value="Save journey" title="save" type="submit" id="save">Save Journey</button>
        </div>
    </form>


    </div>
</div>
</body>
<script>

    function getResults() {
        var formData = $('#myForm').serialize();
        var start = $('#inputBox1').val();
        var destination = $('#inputBox2').val();
        if(start && destination) {
            $( "div:hidden" ).show( "fast" );
            $("#image").css('content','');
            $("#image").css('opacity','1');
            $("#results").css('opacity','1');
            $("#leftContainer").css('opacity','1');

            $.ajax({
                type: "GET",
                url: '',
                dataType: 'json',
                data: formData + "&type=1",
                success: function (data) {
                    $('#startDate').val(data.startDate);
                    $('#startTime').val(data.startTime);
                    $('#endTime').val(data.endTime);
                    $('#duration').val(data.duration);
                    $('#description').val(data.description);

                    $('#startDateSpan').html(data.startDate);
                    $('#startTimeSpan').html(data.startTime);
                    $('#endTimeSpan').html(data.endTime);
                    $('#durationSpan').html(data.duration);
                    $('#descriptionSpan').html(data.description);
                    $('#destinationSpan').html(document.querySelector('#inputBox2').value);

                }
            });
        }else{
            alert('Starting postcode and destination postcode is required');
        }
    }

</script>
</html>