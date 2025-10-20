
<style>
    .back-button-onmap {
        background-color: #fff;
        border: none;
        color: grey;
        position: absolute;
        padding: 10px;
        margin-left: 30px;
        margin-top: 50px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 25px;
        z-index: 3;
        margin: 10px 10px;
        border-radius: 0%;
        transition: color 0s;
    }

    .back-button-onmap:hover {
        color: black;
    }

    .back-button-onmap .arrow-back-button-map {
        display: inline-block;
        vertical-align: middle;
        font-weight: bold;
    }

    #map {
        height: 100%;
        width: 100%;
    }
</style>
</head>
<body>
<button class="back-button-onmap" onclick="history.back()">
    <span class="arrow-back-button-map"><b>&#x2190;</b></span>
</button>
<div id="map"></div>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgCvZqr3lafoJXGdQvXGOi4Uvu8b_bi6o&callback=initMap">
</script>

<script>
    function initMap() {
        var myCenter = new google.maps.LatLng( {{ $this->latitude }}, {{ $this->longitude }});
        var mapProp = {
            center: myCenter,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("map"), mapProp);

        var marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.BOUNCE
        });

        marker.setMap(map);
    }
</script>
</body>
</html>