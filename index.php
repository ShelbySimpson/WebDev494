<html>
<head>
    <link rel="stylesheet" type="text/css" href="cssIndex.css">

    </script>
    <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" ></script>
    <script>
        function determineBrowser() {
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            return xmlhttp;
        }
        //Gathers data from the search input. Sends it to city_info.php where it is queried.
        function gatherCityData(str) {
            xmlhttp = determineBrowser();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("searchResults").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "city_info.php?q=" + str, true);
            xmlhttp.send();
        }

        $(document).ready(function () {
            $("#search").click(function () {
                $("#searchBox").slideToggle("fast");
            });
        });


        var count = 1;
        //Loads data from lists.xml
        function loadXMLDoc() {
            var xmlhttp;
            var txtA = [];
            var txt, txt2, txt3, x, y, z, i, images;
            xmlhttp = determineBrowser();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    xmlDoc = xmlhttp.responseXML;

                    //Retrieve Tags from XML
                    x = xmlDoc.getElementsByTagName("item1");
                    y = xmlDoc.getElementsByTagName("mainStatement1");
                    z = xmlDoc.getElementsByTagName("image3");

                    //Store node Values
                    txt2 = y[0].childNodes[0].nodeValue;
                    txt3 = z[0].childNodes[0].nodeValue;
                    for (i = 0; i < x.length; i++) {
                        txt = x[i].childNodes[0].nodeValue;
                        //Display node value into html
                        document.getElementById("list" + i).innerHTML = txt;

                    }

                    //Display node values into html
                    document.getElementById("image2").innerHTML = txt3;
                    document.getElementById("ulMainListing").innerHTML = txt2;

                    var mnChange = function () {

                        for (i = 0; i < x.length; i++) {
                            //Retrieve xml items and populate html list.
                            x = xmlDoc.getElementsByTagName("item" + count);
                            txt = x[i].childNodes[0].nodeValue;
                            document.getElementById("list" + i).innerHTML = txt;

                        }
                        //Retrieve xml image info and send to image2 div element
                        for (i = 0; i < z.length; i++) {
                            z = xmlDoc.getElementsByTagName("image" + count);
                            images = z[0].childNodes[0].nodeValue;
                            document.getElementById("image2").innerHTML = images;
                        }
                        count++;
                        //Used to rotate displayed images and list items.
                        setTimeout(mnChange, 10000);
                        if (count == 4) {
                            count = 1;
                        }
                    }
                    setTimeout(mnChange, 10000);
                }

            }
            xmlhttp.open("GET", "lists.xml", true);
            xmlhttp.send();
        }
    </script>


</head>

<body onload="loadXMLDoc(0)">

<header>
    <h1>Equip All Recreational</h1>
    <!--Navigation Bar-->
    <ul>
        <li><a href="#">Home </a></li>
        <li><a href="#">Fall Gear </a></li>
        <li><a href="#">Winter Gear</a></li>
        <li><a href="#">Spring Gear</a></li>
        <li><a href="#">Summer Gear</a></li>
        <li><a href="#">Login</a></li>
    </ul>

</header>
<!--Search input and table-->
<div id="search">Click to search for store locations</div
<div id="map-canvas">
    <table id="searchBox">
        <div></div>
        <form>
            <tr id="searchRow">
                <td>Search City:<input type="text" onkeyup="gatherCityData(this.value)"></td>
            </tr>
            <tr>
                <td id="searchResults"></td>
            </tr>
    </table>
    </form>
</div>
<div id="holdAll">
    <div id="firstImgBody">
        <div id="image1"><img src="images/EquipAll_seating.jpg" alt="Your everything store"/></div>


        <table style="padding-left:3">
            <tr>
                <td><h2>Your one stop everything for Recreational needs!!!</h2></td>
            </tr>
            <tr id="mainListing">
                <td id="ulMainListing"> Look no more, you have found the capital of awesome.
                    This store will change your life. We have everything
                    from making your golfing more compfy with our new
                    couches to making your camping trip perfect with
                    our new oak tables. We thought of everything
                    and spared nothing, come on in and check us
                    out!!!
                </td>
            </tr>


        </table>
    </div>
    </br>
    <!--    Displayed images-->
    <div id="image2"></div>
    <!--    List of book topics-->
    <div id="SecondImgBody">
        <table style="padding-left:3">
            <tr>
                <td><h2>We also have books for all your recreational needs!!!</h2></td>
            </tr>
            <tr id="bookNeedsListing">
                <td>
                    <ul id="ulBookListing">
                        <li id="list0"></li>
                        <li id="list1"></li>
                        <li id="list2"></li>
                        <li id="list3"></li>
                        <li id="list4"></li>
                        <li id="list5"></li>
                    </ul>
                </td>
            </tr>

        </table>
    </div>
</div>
<footer>
    <ul id="ulFooter">
        <li><a href="#">About Us</a></li>
        <li><a href="#">Customer Support</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Employment</a></li>
        <li><a href="#">FAQs</a></li>
    </ul>
</footer>

</body>

</html>