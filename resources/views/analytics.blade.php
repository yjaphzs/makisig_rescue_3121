@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Data Analysis</h1>
        </div>
        <div class="data">
            <div class="place data-sets">
                <div class="data-sets_content">
                </div>
            </div>
            <div class="months data-sets">
                <div class="data-sets_content">
                </div>
            </div>
            <div class="brgy data-sets">
                <div class="data-sets_content">
                </div>
            </div>
        </div>
    </div>

    <!--Chart.js-->
   <!--<script src="https://cdnjs.com/libraries/Chart.js"></script>-->
   <script src={{ asset('js/chart.js') }}></script>

    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>
        var modal = new tingle.modal({
            footer: false,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            cssClass: ["line-graph"],
            onOpen: function() {

            },
            onClose: function() {

            },
            beforeClose: function() {
                // here's goes some logic
                // e.g. save content before closing the modal
                return true; // close the modal
                return false; // nothing happens
            }
        });

        var modal2 = new tingle.modal({
            footer: false,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            cssClass: ["barangay-list"],
            onOpen: function() {

            },
            onClose: function() {

            },
            beforeClose: function() {
                // here's goes some logic
                // e.g. save content before closing the modal
                return true; // close the modal
                return false; // nothing happens
            }
        });

        var modal3 = new tingle.modal({
            footer: false,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            cssClass: ["barangay-list"],
            onOpen: function() {

            },
            onClose: function() {

            },
            beforeClose: function() {
                // here's goes some logic
                // e.g. save content before closing the modal
                return true; // close the modal
                return false; // nothing happens
            }
        });

        var citizenBarangay = new tingle.modal({
            footer: false,
            stickyFooter: false,
            closeMethods: ['button'],
            closeLabel: "Close",
            onOpen: function() {

            },
            onClose: function() {

            },
            beforeClose: function() {
                // here's goes some logic
                // e.g. save content before closing the modal
                return true; // close the modal
                return false; // nothing happens
            }
        });

        // set content
        modal.setContent(
                '<canvas id="myChart"></canvas>'+
                '<button id="accident_month">Generate Report</button>'
        );
        modal2.setContent(
            '<h1 style="float:left;">Citizens with Accidents this Year</h1><button id="accident_barangay" style="float:right;">Generate Report</button>'+
                '<div style="margin-top: 20px;">'+
                    '<table class="barangay_table" style="height: 400px;">'+
                        '<thead>'+
                            '<tr>'+
                                '<th></th>'+
                                '<th></th>'+
                                '<th></th>'+
                                '<th></th>'+
                            '</tr>'+
                            '<tr>'+
                                '<th></th>'+
                                '<th>Barangay</th>'+
                                '<th style="text-align:center;">Citizens with Accidents</th>'+
                                '<th></th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody class="content" style="height: 52vh;">'+

                        '</tbody>'+
                    '</table>'+
                '</div>'
        );

        modal3.setContent(
            '<h1 style="float:left;">No. of Accidents in Barangays this Year</h1><button id="accident_place" style="float:right;">Generate Report</button>'+
                '<div style="margin-top: 20px;">'+
                    '<table class="place-table" style="height: 400px;">'+
                        '<thead>'+
                            '<tr>'+
                                '<th></th>'+
                                '<th></th>'+
                                '<th></th>'+
                                '<th></th>'+
                            '</tr>'+
                            '<tr>'+
                                '<th></th>'+
                                '<th>Barangay</th>'+
                                '<th style="text-align:center;">Accidents</th>'+
                                '<th></th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody class="content" style="height: 52vh;">'+

                        '</tbody>'+
                    '</table>'+
                '</div>'
        );

        citizenBarangay.setContent(
            '<h1><span id="barangayName"></span></h1>'+
                '<div style="margin-top: 20px;">'+
                    '<table class="citizen_table" style="height: 300px;">'+
                        '<thead>'+
                            '<tr>'+
                                '<th></th>'+
                                '<th></th>'+
                                '<th></th>'+
                                '<th></th>'+
                            '</tr>'+
                            '<tr>'+
                                '<th></th>'+
                                '<th>Name</th>'+
                                '<th>Gender</th>'+
                                '<th></th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody class="content" style="height: 48vh;">'+

                        '</tbody>'+
                    '</table>'+
                '</div>'+
            '<div class="btn-input tingle-modal-box__footer">'+
                '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="citizenBarangay.close();">Cancel</button>'+
            '</div>'
        );


        new Chart(document.getElementById("myChart"), {
          type: 'line',
          data: {
            labels: ["January","February","March","April","May","June","July","August","September","October","November","December"],
            datasets: [{
                data: <?php echo json_encode($data["all"]) ?>,
                label: "No. of Accidents",
                backgroundColor: "#ce0022",
                borderColor: "#ce0022",
                fill: false
              }]
          },
          options: {
            title: {
              display: true,
              text: 'Accidents this Year'
            }
          }
        });


    $(document).ready(function(){
        
        $('#loading').css({"visibility":"hidden","opacity":"0"});
        $('#loading').html('');
                
        $(document).on('click','.months', function(e){
            modal.open();
        });
        $(document).on('click','.brgy', function(e){
            <?php
                $content = "";
                for($i = 0; $i < 38; $i++){
                    $content = $content.'<tr><td></td><td>'.$data2["brgy_name"][$i].'</td><td style="text-align: center;">'.$data2["brgy_value"][$i].'</td><td><button class="viewCitizens" data-barangay="'.$data2["brgy_name"][$i].'"><span class="fa fa-eye"></span></button></td></tr>';
                }
            ?>
            var content = '<?php echo $content; ?>';
            $('.barangay_table .content').html(content);
            modal2.open();
        });

        $(document).on('click','.place', function(e){
            <?php
                $content = "";
                for($i = 0; $i < 38; $i++){
                    $content = $content.'<tr><td></td><td>'.$data3["brgy_name"][$i].'</td><td style="text-align: center;">'.$data3["brgy_value"][$i].'</td><td><button class="viewCitizens" data-barangay="'.$data3["brgy_name"][$i].'"><span class="fa fa-eye"></span></button></td></tr>';
                }
            ?>
            var content = '<?php echo $content; ?>';
            $('.place-table .content').html(content);
            modal3.open();
        });

        var d = new Date();
        var month = new Array();
        month[0] = "January";
        month[1] = "February";
        month[2] = "March";
        month[3] = "April";
        month[4] = "May";
        month[5] = "June";
        month[6] = "July";
        month[7] = "August";
        month[8] = "September";
        month[9] = "October";
        month[10] = "November";
        month[11] = "December";
        var n = month[d.getMonth()];

        @if($data["current"] >= $data["last"]){
            $('.months .data-sets_content').html('<b><span>Total Accidents in</span><br>'+n+'</b><br><h1>{{ $data["current"] }}</h1><img src="{{ asset("images/common/line-up.png") }}">');
        }
        @elseif($data["current"] < $data["last"]){
            $('.months .data-sets_content').html('<b><span>Total Accidents in</span><br>'+n+'</b><br><h1>{{ $data["current"] }}</h1><img src="{{ asset("images/common/line-down.png") }}">');
        }
        @endif

        @if($data["current"] == 0){
            $('.months .data-sets_content').html('<b><span>Total Accidents in</span><br>'+n+'</b><br><h1>{{ $data["current"] }}</h1><img src="{{ asset("images/common/line-down.png") }}">');
        }
        @endif


        <?php
            if($data2["highest"]["brgy_name"] == null){
                $data2["highest"]["brgy_name"] = "No Record";
            }
         ?>
        $('.brgy .data-sets_content').html('<b><span>Barangay with</span><span style="display: block;">Highest Record of</span><span style="display: block;">Citizens with Accidents</span>{{ $data2["highest"]["brgy_name"] }}</b><br><h1>{{ $data2["highest"]["brgy_value"] }}</h1><img src="{{ asset("images/common/line-up.png") }}">');
        $('.place .data-sets_content').html('<b><span>Barangay with</span><span style="display: block;">Highest Record of</span><span style="display: block;">Accidents</span>{{ $data3["highest"]["brgy_name"] }}</b><br><h1>{{ $data3["highest"]["brgy_value"] }}</h1><img src="{{ asset("images/common/line-up.png") }}">');


        $(document).on('click','#accident_month', function(e){
            window.open("accidents/generate_accidents_per_month");
            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspGenerated!.');
        });

        $(document).on('click','#accident_barangay', function(e){
            window.open("accidents/generate_accidents_per_barangay");
            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspGenerated!.');
        });

        $(document).on('click','#accident_place', function(e){
            window.open("accidents/generate_accidents_per_place");
            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspGenerated!.');
        });

        $(document).on('click','.viewCitizens', function(e){
            var barangay = $(this).attr('data-barangay');

            $("#barangayName").html(barangay);

            $.ajax({
                url: "{{ route('analytics.citizensBarangay') }}",
                method: "get",
                data:{ barangay: barangay },
                success: function(data){
                    data = JSON.parse(data);
                    var content = "";

                    for(var i = 0; i < data.length; i++){
                        console.log(data);
                        var middle_initial = data[i][0].middle_initial;
                        if(middle_initial == null){
                            middle_initial = "";
                        }
                        content += '<tr>'+
                                    '<td></td>'+
                                    '<td>'+data[i][0].first_name+' '+middle_initial+' '+data[i][0].last_name+'</td>'+
                                    '<td>'+data[i][0].gender+'</td>'+
                                    '<td></td>'+
                                    '</tr>';
                    }

                    $('.citizen_table .content').html(content);
                    citizenBarangay.open();
                }
            });
        });

    });
    </script>
@endsection
