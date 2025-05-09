@extends('layouts.app')

@section('content')
    
     <!-- Leaflet JS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
    <!-- Leaflet JS Javascript -->
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   crossorigin=""></script>
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div id="mapid">
    </div>
    <div class="leaflet-custom-control">
        <div class="leaflet-controls">
            <a id="leaflet-custom-marker" title="Place Maker" role="button" onclick="place_marker()">
                <span class="fa fa-map-marked"></span>
            </a>
            <a id="leaflet-custom-layer" title="Show/Hide Layer" role="button" onclick="show_hide_layer()">
                <span class="fa fa-layer-group"></span>
            </a>
            <a id="leaflet-custom-barangays" title="Show/Hide Barangays" role="button" onclick="show_hide_barangays()">
                <span class="fa fa-home"></span>
            </a>
        </div>
    </div>
    
    
     <script src="https://www.gstatic.com/firebasejs/5.8.6/firebase.js"></script>
    <script>
        var config = {
            apiKey: "AIzaSyCYxz5sy1bNU7lBniHKd1HMaQnitdILkL4",
            authDomain: "makisigrescue3121.firebaseapp.com",
            databaseURL: "https://makisigrescue3121.firebaseio.com",
            projectId: "makisigrescue3121",
            storageBucket: "makisigrescue3121.appspot.com",
            messagingSenderId: "89496200536"
        };
        firebase.initializeApp(config);
    </script>
    <!--
    <script src="https://www.gstatic.com/firebasejs/5.8.6/firebase.js"></script>
    <script>
        var config = {
            apiKey: "AIzaSyCYxz5sy1bNU7lBniHKd1HMaQnitdILkL4",
            authDomain: "makisigrescue3121.firebaseapp.com",
            databaseURL: "https://makisigrescue3121.firebaseio.com",
            projectId: "makisigrescue3121",
            storageBucket: "makisigrescue3121.appspot.com",
            messagingSenderId: "89496200536"
        };
        firebase.initializeApp(config);
    </script>-->
    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>


        var southWest = L.latLng(15.69865640321718, 120.88643074035643),
            northEast = L.latLng(15.8837436848468, 121.09680175781249),
        mybounds = L.latLngBounds(southWest, northEast);


        var map = L.map('mapid').setView([15.791995473348873, 120.98896086215971], 13);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
           /* bounds: mybounds,*/
            maxZoom: 18,
            minZoom: 11,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoieWphcGh6cyIsImEiOiJjam9hbHdtYmMwMWh0M3Ztc3U0OGE1bjlyIn0.y0xQauLsWMkIw0OLp379PQ'
        }).addTo(map);

        var emarkerIcon = L.icon({
            iconUrl: "{{ asset('images/common/emarker.png') }}",
            iconSize:     [45, 45], // size of the icon
            iconAnchor:   [22.5, 40], // point of the icon which will correspond to marker's location
            popupAnchor:  [1, -46] // point from which the popup should open relative to the iconAnchor
        });


        /*LOCATE PLUGIN WITH CONTROL
        L.control.locate({
            setView: 'always'
        }).addTo(map);
        */
        var marker;
        var position;
        var cicle;
        var num = 1;
        var markerToken = "disable";

        function place_marker(){
            var place_marker = document.getElementById("leaflet-custom-marker");
            if(markerToken == "disable"){
                markerToken = "activated";
                place_marker.style.color = "#fc8428";
            }
            else{
                if(num == 2){
                    alertify.confirm("Emergency marker will remove. Are you sure?",
                    function(){
                        markerToken = "disable";
                        map.removeLayer(marker);
                        map.removeLayer(circle);
                        rootRef2.remove();    
                        place_marker.style.color = "#444";   
                      },
                    function(){
    
                    }).setHeader("Confirm");
                }
                else{
                    markerToken = "disable";
                    place_marker.style.color = "#444";  
                }
            }
        }


        var rootRef2 = firebase.database().ref().child("Emergency");

        rootRef2.once('value', snap => {
            if (snap.exists()) {
                var place_marker = document.getElementById("leaflet-custom-marker");
                markerToken = "activated";
                num = 2;
                place_marker.style.color = "#fc8428";

                marker = new L.Marker([snap.child("latitude").val(),snap.child("longitude").val()], { draggable: true, icon: emarkerIcon });
                position = marker.getLatLng();
                marker.bindPopup("<strong>Accident: </strong>" + [snap.child("accident").val()] + "<br><strong>Date: </strong>"+[snap.child("date").val()]+"<br><strong>Time: </strong>"+[snap.child("time").val()]).addTo(map);

                circle = L.circle([position.lat, position.lng], {
                    color: "#ff6377",
                    fillColor: '#fc445c',
                    fillOpacity: .2,
                    radius: 200
                }).addTo(map);
            }
        });

        function onMapClick(e) {
            if(markerToken != "disable"){
                if(num == 2){
                    map.removeLayer(marker)
                    map.removeLayer(circle)
                    num = 1;
                }

              
                alertify.confirm("Mobile app users will notify. Are you sure you want to point in this location?.",
                function(){
                    alertify.prompt( 'Type of Accident', 'Enter type of Accident', ''
                    , function(evt, value) { 
                        
                        var today = new Date();
                        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                        
                        marker = new L.Marker(e.latlng, { draggable: true, icon: emarkerIcon });
                        position = marker.getLatLng();
                        marker.bindPopup("<strong>Accident: </strong>"+value+"<br><strong>Date: </strong>"+date+"<br><strong>Time: </strong>"+time).addTo(map);
        
                        rootRef2.child("latitude").set(position.lat);
                        rootRef2.child("longitude").set(position.lng);
                        rootRef2.child("accident").set(value);
                        rootRef2.child("date").set(date);
                        rootRef2.child("time").set(time);
                        
                        $.ajax({
                            url:"{{ route('messages.sendpushnotification') }}",
                            method: "GET",
                            success:function(data){
                                alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspNotification Sent!.');
                            }
                        });
        
                        circle = L.circle([position.lat, position.lng], {
                            color: "#ff6377",
                            fillColor: '#fc445c',
                            fillOpacity: .2,
                            radius: 200
                        }).addTo(map);
        
        
                        marker.on('dragend', function(event){
        
                            map.removeLayer(circle)
                            marker = event.target;
                            position = marker.getLatLng();
                            marker.bindPopup("<strong>Accident: </strong>"+value+"<br><strong>Date: </strong>"+date+"<br><strong>Time: </strong>"+time)
                            marker.setLatLng(new L.LatLng(position.lat, position.lng))
        
                            rootRef2.child("latitude").set(position.lat);
                            rootRef2.child("longitude").set(position.lng);
        
                            circle = L.circle([position.lat, position.lng], {
                                color: "#ff6377",
                                fillColor: '#fc445c',
                                fillOpacity: .2,
                                radius: 200
                            }).addTo(map);
        
                        });
        
                        num = 2;
                        
                    }
                    , function() { 
                        
                    
                    });
                  },
                function(){

                }).setHeader("Confirm");
            }
        }

        map.on('click', onMapClick);

        //POLYGON
        var polygon;
        var layertoken = "hide";
        function show_hide_layer() {
            var show_hide_layer = document.getElementById("leaflet-custom-layer");
            if(layertoken == "hide"){
                polygon = L.polygon([
                    [15.745708205351368,120.94505310058595],
                    [15.737901416047425,120.98316192626952],
                    [15.749756052116814,121.01749420166016],
                    [15.783829114074765,121.04753494262694],
                    [15.80232942072373,121.0367202758789],
                    [15.822809931164107,121.05766296386719],
                    [15.865746198905073,121.02848052978514],
                    [15.854847857453484,120.96771240234375],
                    [15.843948927227826,120.97869873046875],
                    [15.827434275531784,120.94728469848633],
                    [15.78184683817288,120.9316635131836],
                    [15.759049272678118,120.93097686767578],
                    [15.745708205351368,120.94505310058595]
                ]);

                polygon.setStyle({
                    color: "#ff6377",
                    fillColor: '#fc445c',
                    fillOpacity: .2
                });

                polygon.addTo(map);

                show_hide_layer.style.color = "#fc8428";
                layertoken = "show";
            }
            else{
                 map.removeLayer(polygon);
                 layertoken = "hide";
                 show_hide_layer.style.color = "#444";
            }
        }


        //
        var barangayToken = "hide";
        var barangays;
        function show_hide_barangays(){
            var show_hide_barangays = document.getElementById("leaflet-custom-barangays");
            if(barangayToken == "hide"){
                var abar1st    = L.marker([15.789714, 120.980178]).bindPopup('Abar 1st'),
                abar2nd    = L.marker([15.783150, 120.971482]).bindPopup('Abar 2nd'),
                bagong_sikat    = L.marker([15.766201, 121.032756]).bindPopup('Bagong Sikat'),
                caanawan    = L.marker([15.770305, 120.963071]).bindPopup('Caanawan'),
                calaocan    = L.marker([15.786185, 121.003260]).bindPopup('Calaocan'),
                camanacsacan    = L.marker([15.772122, 120.983140]).bindPopup('Camanacsacan'),
                culaylay    = L.marker([15.793291, 121.047727]).bindPopup('Culaylay'),
                kita_kita    = L.marker([15.826439, 121.035508]).bindPopup('Kita-kita'),
                malasin    = L.marker([15.807377, 121.000689]).bindPopup('Malasin'),
                manicla    = L.marker([15.835681, 121.008058]).bindPopup('Manicla'),
                palestina    = L.marker([15.782939, 121.013577]).bindPopup('Palestina'),
                parang_mangga    = L.marker([15.762128, 121.015019]).bindPopup('Parang Mangga'),
                pinili    = L.marker([15.7734772, 121.034951]).bindPopup('Pinili'),
                rafael_rueda = L.marker([15.799581, 120.991841]).bindPopup('Rafael Rueda, Sr. Pob.'),
                ferdinand_marcos = L.marker([15.800295, 120.997104]).bindPopup('Ferdinand E. Marcos Pob'),
                canuto_ramos = L.marker([15.792734, 120.991248]).bindPopup('Canuto Ramos Pob.'),
                raymundo_eugenio = L.marker([15.790752, 120.993435]).bindPopup('Raymundo Eugenio Pob.'),
                crisanto_sanchez = L.marker([15.793367, 120.989057]).bindPopup('Crisanto Sanchez Pob.'),
                porais = L.marker([15.771841, 121.018835]).bindPopup('Porais'),
                san_agustin = L.marker([15.793513, 121.013455]).bindPopup('San Agustin'),
                san_juan = L.marker([15.820600, 121.039258]).bindPopup('San Juan'),
                san_mauricio = L.marker([15.711888, 120.977578]).bindPopup('San Mauricio'),
                sto_tomas = L.marker([15.751795, 120.949535]).bindPopup('Sto. Tomas'),
                san_antonio_1 = L.marker([15.797960, 120.977794]).bindPopup('Santo Niño 1st'),
                san_antonio_2 = L.marker([15.807048, 120.961789]).bindPopup('Santo Niño 2nd'),
                san_antonio_3 = L.marker([15.828771, 120.948971]).bindPopup('Santo Niño 3rd'),
                sibut = L.marker([15.795725, 120.999952]).bindPopup('Sibut'),
                tayabo    = L.marker([15.845950, 121.024922]).bindPopup('Tayabo'),
                tondod    = L.marker([15.740625, 120.969552]).bindPopup('Tondod');

                barangays = L.layerGroup([abar1st,abar2nd,bagong_sikat,caanawan,calaocan,camanacsacan,culaylay,kita_kita,malasin,palestina,parang_mangga,pinili,rafael_rueda,ferdinand_marcos,canuto_ramos,raymundo_eugenio,crisanto_sanchez,porais, san_agustin, san_juan, san_mauricio, san_antonio_1, san_antonio_2, san_antonio_3, sibut, sto_tomas,tayabo,tondod]).addTo(map);
                barangayToken = "show";

                show_hide_barangays.style.color = "#fc8428"
            }
            else{
                map.removeLayer(barangays);
                barangayToken = "hide";
                show_hide_barangays.style.color = "#444"
            }
        }

        var rootRef = firebase.database().ref().child("Users");
        var markerLayers = new L.layerGroup();
        const items = [];
        var newItems = false;

        rootRef.once('value', snap => {
            snap.forEach(item => {
                var user_date = new Date(item.child("date").val());
                var today = new Date();
                var cdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var current_date = new Date(cdate);

                var user_time = item.child("time").val();
                var current_time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

                if(user_date.valueOf() < current_date.valueOf()){
                    rootRef.child(`${item.getRef().path.pieces_[1]}`).child("longitude").remove();
                    rootRef.child(`${item.getRef().path.pieces_[1]}`).child("latitude").remove();
                }
                else{
                    var utimeH = new Date("01/01/2007 " + user_time).getHours();
                    var ctimeH = new Date("01/01/2007 " + current_time).getHours();
                    if(utimeH < ctimeH){
                        rootRef.child(`${item.getRef().path.pieces_[1]}`).child("longitude").remove();
                        rootRef.child(`${item.getRef().path.pieces_[1]}`).child("latitude").remove();

                    }
                    else{
                        var utimeM = new Date("01/01/2007 " + user_time).getMinutes();
                        var ctimeM = new Date("01/01/2007 " + current_time).getMinutes();
                        var diff = ctimeM - utimeM;
                        if(diff >= 5){
                            rootRef.child(`${item.getRef().path.pieces_[1]}`).remove();
                        }
                        else{
                            items.push([ item.child("latitude").val(), item.child("longitude").val()]);
                        }
                    }
                }
            });
            convertToMarker();
            newItems = true;

        });

        rootRef.on('child_added', snap => {
            if(!newItems) return;
            var longitude = snap.child("longitude").val();
            var latitude = snap.child("latitude").val();

            items.push([ latitude, longitude ]);

            markerLayers.clearLayers();
            convertToMarker();
        });

        rootRef.on("child_removed", snap =>{

            for( var i = 0; i <= items.length; i++){
                if(JSON.stringify(items[i]) === JSON.stringify([ snap.child("latitude").val(), snap.child("longitude").val()])){
                    items.splice(i, 1);
                }
            }
            markerLayers.clearLayers();
            convertToMarker();

        });

        function convertToMarker(){

            for( var i = 0; i < items.length; i++){
                L.marker(items[i]).addTo(markerLayers);
            }
            markerLayers.addTo(map);
        }
        
        $(document).ready(function(){
            $('#loading').css({"visibility":"hidden","opacity":"0"});
            $('#loading').html(''); 
        });

        
    </script>


    <!--<script src="{{ asset('js/firebase.js') }}"></script>-->

@endsection
