@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Accidents</h1>
            <div class="input-group">
                <span class="fa fa-search icon"></span>
                <input type="text" placeholder="Search" id="search">
            </div>
            <button id="add_data">Add Record</button>
        </div>
        <div id="test"></div>
        <div class="table">
            <br><br><br>
            LOADING...
        </div>
    </div>

    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script src="http://cdn.jsdelivr.net/jquery.cookie/1.4.0/jquery.cookie.min.js"></script>
    <script>

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = yyyy+'-'+mm+'-'+dd;

            var modal = new tingle.modal({
                footer: false,
                stickyFooter: false,
                closeMethods: ['overlay', 'button', 'escape'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
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

            var personsModal = new tingle.modal({
                footer: false,
                stickyFooter: false,
                closeMethods: ['button'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
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

            var respondersModal = new tingle.modal({
                footer: false,
                stickyFooter: false,
                closeMethods: ['button'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
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

            var viewModal = new tingle.modal({
                footer: false,
                stickyFooter: false,
                closeMethods: ['overlay', 'button', 'escape'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
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

            var viewPerson = new tingle.modal({
                footer: false,
                stickyFooter: false,
                closeMethods: ['button'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
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

            var viewResponder = new tingle.modal({
                footer: false,
                stickyFooter: false,
                closeMethods: ['button'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
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
                '<form method="post" id="accidentsForm">'+
                '<h2 id="title">Add Data</h2>'+
                '<h1>Accidents</h1>'+
                '{{ csrf_field() }}'+
                '<div class="inner-row">'+
                    '<div id="date-input" class="input-group">'+
                        '<span class="fa fa-calendar-week icon"></span>'+
                        '<input id="date" name="date" class="input" type="date" max="'+today+'" placeholder="Date" required>'+
                    '</div>'+
                    '<div id="time-input" class="input-group">'+
                        '<span class="fa fa-clock icon"></span>'+
                        '<input id="time" name="time" step="60" class="input" type="time" placeholder="Time" required>'+
                    '</div>'+
                    '<div id="place-input" class="input-group">'+
                        '<span class="fa fa-location-arrow icon"></span>'+
                        '<input id="place" name="place" class="input" type="text" placeholder="Place of Accident">'+
                        '<select id="barangay_p" name="barangay_p" class="input" placeholder="Barangay" required>'+
                            '<option value="" disabled selected>Barangay</option>'+
                            '<option value="A. Pascual">A. Pascual</option>'+
                            '<option value="Abar 1st">Abar 1st</option>'+
                            '<option value="Abar 2nd">Abar 2nd</option>'+
                            '<option value="Bagong Sikat">Bagong Sikat</option>'+
                            '<option value="Caanawan">Caanawan</option>'+
                            '<option value="Calaocan">Calaocan</option>'+
                            '<option value="Camanacsacan">Camanacsacan</option>'+
                            '<option value="Culaylay">Culaylay</option>'+
                            '<option value="Dizol">Dizol</option>'+
                            '<option value="Kaliwanagan">Kaliwanagan</option>'+
                            '<option value="Kita-Kita">Kita-Kita</option>'+
                            '<option value="Malasin">Malasin</option>'+
                            '<option value="Manicla">Manicla</option>'+
                            '<option value="Palestina">Palestina</option>'+
                            '<option value="Parang Mangga">Parang Mangga</option>'+
                            '<option value="Villa Joson (Parilla)">Villa Joson (Parilla)</option>'+
                            '<option value="Pinili">Pinili</option>'+
                            '<option value="Rafael Rueda, Sr. Pob.">Rafael Rueda, Sr. Pob.</option>'+
                            '<option value="Ferdinand E. Marcos Pob.">Ferdinand E. Marcos Pob.</option>'+
                            '<option value="Canuto Ramos Pob.">Canuto Ramos Pob.</option>'+
                            '<option value="Raymundo Eugenio Pob.">Raymundo Eugenio Pob.</option>'+
                            '<option value="Crisanto Sanchez Pob.">Crisanto Sanchez Pob.</option>'+
                            '<option value="Porais">Porais</option>'+
                            '<option value="San Agustin">San Agustin</option>'+
                            '<option value="San Juan">San Juan</option>'+
                            '<option value="San Mauricio">San Mauricio</option>'+
                            '<option value="Santo Niño 1st">Santo Niño 1st</option>'+
                            '<option value="Santo Niño 2nd">Santo Niño 2nd</option>'+
                            '<option value="Santo Niño 3rd">Santo Niño 3rd</option>'+
                            '<option value="Santo Tomas">Santo Tomas</option>'+
                            '<option value="Sibut">Sibut</option>'+
                            '<option value="Sinipit Bubon">Sinipit Bubon</option>'+
                            '<option value="Tabulac">Tabulac</option>'+
                            '<option value="Tayabo">Tayabo</option>'+
                            '<option value="Tondod">Tondod</option>'+
                            '<option value="Tulat">Tulat</option>'+
                            '<option value="Villa Floresca">Villa Floresca</option>'+
                            '<option value="Villa Marina">Villa Marina</option>'+
                            '<option value="Others">Others</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="accident-input" class="input-group">'+
                        '<span class="fa fa-car-crash icon"></span>'+
                        '<input id="accident" name="accident" class="input" type="text" placeholder="Type of Accident" required>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="persons-input" class="input-group">'+
                        '<span class="fa fa-user-injured icon"></span>'+
                        '<input id="involves" name="involves" class="input readonly" type="text" placeholder="Person/s Involved" required>'+
                    '</div>'+
                    '<button type="button" id="addPersons">Person/s</button>'+
                    '<input type="hidden" id="involvesID" name="involvesID" value="">'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="remarks-input" class="input-group">'+
                        '<span class="fa fa-clipboard icon"></span>'+
                        '<input id="remarks" name="remarks" class="input" type="text" placeholder="Remarks">'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="responders-input" class="input-group">'+
                        '<span class="fa fa-running icon"></span>'+
                        '<input id="responders" name="responders" class="input readonly" type="text" placeholder="Responders" required>'+
                    '</div>'+
                    '<button type="button" id="addResponders">Responders</button>'+
                    '<input type="hidden" id="respondersID" name="respondersID" value="" style="">'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                    '<input type="hidden" name="incident_id" id="incident_id" value="">'+
                    '<input type="hidden" name="button_action" id="button_action" value="insert">'+
                    '<button type="submit" class="tingle-btn tingle-btn--primary tingle-btn--pull-right" name="submit" id="action">Add</button>'+
                    '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeModal();">Cancel</button>'+
                '</div>'+
                '</form>'
            );

            personsModal.setContent(
                '<h1>Persons</h1>'+
                '<div class="input-group">'+
                    '<span class="fa fa-search icon"></span>'+
                    '<input type="text" placeholder="Search" id="psearch">'+
                '</div>'+
                '<div style="margin-top: 20px;">'+
                    '<table class="persons_table" style="height: 280px;">'+
                    '</table'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                        '<button type="button" class="tingle-btn tingle-btn--primary tingle-btn--pull-right" onclick="addPersons();">Add</button>'+
                        '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closePersons();">Cancel</button>'+
                '</div>'
            );

            respondersModal.setContent(
                '<h1>Responders</h1>'+
                '<div class="input-group">'+
                    '<span class="fa fa-search icon"></span>'+
                    '<input type="text" placeholder="Search" id="rsearch">'+
                '</div>'+
                '<div style="margin-top: 20px;">'+
                    '<table class="responders_table" style="height: 280px;">'+
                    '</table'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                        '<button type="button" class="tingle-btn tingle-btn--primary tingle-btn--pull-right" onclick="addResponders();">Add</button>'+
                        '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeResponders();">Cancel</button>'+
                '</div>'
            );

            viewModal.setContent(
                '<h1>Accident</h1>'+
                '<div class="inner-row" style="margin-bottom: 15px;">'+
                    '<div id="date-input" class="view-group" style="margin-right: 15px;">'+
                        '<span class="fa fa-calendar-week icon"></span>'+
                        '<div class="dateview"></div>'+
                    '</div>'+
                    '<div id="time-input" class="view-group" style="margin-right: 15px;">'+
                        '<span class="fa fa-clock icon"></span>'+
                         '<div class="timeview"></div>'+
                    '</div>'+
                    '<div id="place-input" class="view-group" style="width: 420px;">'+
                        '<span class="fa fa-location-arrow icon"></span>'+
                         '<div class="placeview" style="max-width: 420px; width: 420px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="accident-input" class="view-group" style="width: 720px;">'+
                        '<span class="fa fa-car-crash icon"></span>'+
                        '<div class="typeview" style="max-width: 720px; width: 720px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="persons-input" class="view-group" style="width: 720px;">'+
                        '<span class="fa fa-user-injured icon"></span>'+
                        '<div class="involveview" style="max-width: 720px; width: 720px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="remarks-input" class="view-group" style="width: 720px;">'+
                        '<span class="fa fa-clipboard icon"></span>'+
                        '<div class="remarkview" style="max-width: 720px; width: 720px;">None</div>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row">'+
                    '<div id="responders-input" class="view-group" style="width: 720px;">'+
                        '<span class="fa fa-running icon"></span>'+
                        '<div class="responderview" style="max-width: 720px; width: 720px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                        '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeView();">Close</button>'+
                '</div>'
            );

            viewPerson.setContent(
                '<h1>Citizen</h1>'+
                '<div class="inner-row" style="margin-bottom: 15px;">'+
                    '<div id="name-input" class="view-group" style="width: 275px;  margin-right: 15px;">'+
                        '<span class="fa fa-user icon"></span>'+
                        '<div class="lastview" style="max-width: 275px; width: 275px;"></div>'+
                    '</div>'+
                    '<div id="name-input" class="view-group" style="width: 275px;  margin-right: 15px;">'+
                        '<div class="firstview" style="max-width: 275px; width: 275px; padding: 5px 15px 5px 15px;"></div>'+
                    '</div>'+
                    '<div id="name-input" class="view-group" style="width: 140px;">'+
                        '<div class="middleview" style="max-width: 140px; width: 140px; padding: 5px 15px 5px 15px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row" style="width: 720px;">'+
                    '<div id="gender-input" class="view-group">'+
                        '<span class="fa fa-venus-mars icon"></span>'+
                        '<div class="genderview" style="max-width: 352.5px; width: 352.5px; margin-right: 15px;"></div>'+
                    '</div>'+
                    '<div id="brgy-input" class="view-group">'+
                        '<span class="fa fa-home icon"></span>'+
                        '<div class="barangayview" style="max-width: 352.5px; width: 352.5px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                    '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closePerson();">Close</button>'+
                '</div>'
            );


            viewResponder.setContent(
                '<h1>Rescuer</h1>'+
                '<div class="inner-row" style="margin-bottom: 15px;">'+
                    '<div id="name-input" class="view-group" style="width: 275px;  margin-right: 15px;">'+
                        '<span class="fa fa-user icon"></span>'+
                        '<div class="rlastview" style="max-width: 275px; width: 275px;"></div>'+
                    '</div>'+
                    '<div id="name-input" class="view-group" style="width: 275px;  margin-right: 15px;">'+
                        '<div class="rfirstview" style="max-width: 275px; width: 275px; padding: 5px 15px 5px 15px;"></div>'+
                    '</div>'+
                    '<div id="name-input" class="view-group" style="width: 140px;">'+
                        '<div class="rmiddleview" style="max-width: 140px; width: 140px; padding: 5px 15px 5px 15px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="inner-row" style="width: 720px;">'+
                    '<div id="gender-input" class="view-group">'+
                        '<span class="fa fa-venus-mars icon"></span>'+
                        '<div class="rgenderview" style="max-width: 352.5px; width: 352.5px; margin-right: 15px;"></div>'+
                    '</div>'+
                    '<div id="brgy-input" class="view-group">'+
                        '<span class="fa fa-phone icon"></span>'+
                        '<div class="rcontactview" style="max-width: 352.5px; width: 352.5px;"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                    '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeResponder();">Close</button>'+
                '</div>'
            );



            function openModal(){
                modal.open();
            }

            function closeModal(){
                // close modal
                modal.close();
            }

            function openResponders(){
                respondersModal.open();
            }

            function closeResponders(){
                respondersModal.close();
            }

            function addResponders(){
                closeResponders();
                responders = JSON.stringify($.cookie('responderValues'));
                $('#respondersID').val(responders);

                $.ajax({
                    url: "{{ route('accidents.getName2') }}",
                    method: "get",
                    data:{ id: responders },
                    success: function(data){
                        data = JSON.parse(data);
                        var string = "";
                        for (var i=1; i<=data.length; i++){
                            if(data.length != i)
                                string += data[i-1].name+", ";
                            else
                                string += data[i-1].name;
                        }
                        $('#responders').val(string);
                    }
                });

            }

            function openPersons(){
                personsModal.open();
            }

            function closePersons(){
                personsModal.close();
            }

            function addPersons(){
                closePersons();
                persons = JSON.stringify($.cookie('personValues'));
                $('#involvesID').val(persons);

                $.ajax({
                    url: "{{ route('accidents.getName') }}",
                    method: "get",
                    data:{ id: persons },
                    success: function(data){
                        data = JSON.parse(data);
                        var string = "";
                        for (var i=1; i<=data.length; i++){
                            if(data.length != i)
                                string += data[i-1].name+", ";
                            else
                                string += data[i-1].name;
                        }
                        $('#involves').val(string);
                    }
                });
            }


            function openView(){
                viewModal.open();
            }

            function closeView(){
                // close modal
                viewModal.close();
            }

            function closePerson(){
                viewPerson.close();
            }

            function closeResponder(){
                viewResponder.close();
            }



        $(document).ready(function(){
            
            
            $(".readonly").keydown(function(e){
                e.preventDefault();
            });
            
            

            var query = $('#search').val();
            var orderBy = "date";
            var pquery = $('#psearch').val();
            var rquery = $('#rsearch').val();
            var persons = [];
            var persons_name = [];

            var responders = [];
            var responders_name = [];

            function fetch_citizen(){
                $('.table').load('/accidents/getdata?query='+query+'&orderBy='+orderBy);
            }
            $(document).on('keyup', '#search', function(){
                query = $(this).val();
                query = encodeURIComponent(query.trim());
                fetch_citizen(query);
            });

            //PERSONS SEARCH

            $(document).on('keyup', '#psearch', function(){
                pquery = $(this).val();
                pquery = encodeURIComponent(query.trim());
                $('.persons_table').load('/accidents/persons?query='+pquery);
            });

            //RESPONDERS SEARCH

            $(document).on('keyup', '#rsearch', function(){
                rquery = $(this).val();
                rquery = encodeURIComponent(query.trim());
                $('.responders_table').load('/accidents/responders?query='+rquery);
            });

            $('.table').load('/accidents/getdata?query='+query+'&orderBy='+orderBy, function() {
                $('#loading').css({"visibility":"hidden","opacity":"0"});
                $('#loading').html('');
            });
            $('.persons_table').load('/accidents/persons?query=');
            $('.responders_table').load('/accidents/responders?query=');

            $(document).on('click','.drawer a', function(e){
                e.preventDefault();
                orderBy = $(this).attr('value');
                
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                $('.table').load('/accidents/getdata?query='+query+'&orderBy='+orderBy, function() {
                    $('#loading').css({"visibility":"hidden","opacity":"0"});
                    $('#loading').html('');
                });
            });
            
            $(document).on('click','.pagination a', function(e){
                e.preventDefault();
                
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                var page = $(this).attr('href').split('page=')[1];

                getIncidents(page);
            });

            function getIncidents(page){
                $('.table').load('/accidents/getdata?query='+query+'&page='+page+'&orderBy='+orderBy, function() {
                    $('#loading').css({"visibility":"hidden","opacity":"0"});
                    $('#loading').html('');
                });
            }

            $('#add_data').click(function(){
                document.getElementById("accidentsForm").reset();
                $('#button_action').val('insert');
                $('#action').val('Add');
                $('#title').text('Add Data');
                $('#action').html('Add');
                $.cookie('checkboxValues1',"", { expires: 7, path: '/' });
                $.cookie('checkboxValues2', "", { expires: 7, path: '/' })
                $.cookie('personValues',"", { expires: 7, path: '/' });
                $.cookie('responderValues',"", { expires: 7, path: '/' });
                $('.persons_table').load('/accidents/persons?query=');
                $('.responders_table').load('/accidents/responders?query=');
                openModal();
            });

            $('#addPersons').click(function(){
                openPersons();
            });

            $('#addResponders').click(function(){
                openResponders();
            });

            $("#date-input .input").focus(function(){
                $("#date-input .icon").css("color", "#000");
            })

            $("#date-input .input").blur(function(){
                $("#date-input .icon").css("color", "#b4b9bd");
            })

            $("#time-input .input").focus(function(){
                $("#time-input .icon").css("color", "#000");
            })

            $("#time-input .input").blur(function(){
                $("#time-input .icon").css("color", "#b4b9bd");
            })

            $("#place-input .input").focus(function(){
                $("#place-input .icon").css("color", "#000");
            })

            $("#place-input .input").blur(function(){
                $("#place-input .icon").css("color", "#b4b9bd");
            })

            $("#place-input .select").focus(function(){
                $("#place-input .icon").css("color", "#000");
            })

            $("#place-input .select").blur(function(){
                $("#place-input .icon").css("color", "#b4b9bd");
            })

            $("#remarks-input .input").focus(function(){
                $("#remarks-input .icon").css("color", "#000");
            })

            $("#remarks-input .input").blur(function(){
                $("#remarks-input .icon").css("color", "#b4b9bd");
            })

            $("#persons-input .input").focus(function(){
                $("#persons-input .icon").css("color", "#000");
            })

            $("#persons-input .input").blur(function(){
                $("#persons-input .icon").css("color", "#b4b9bd");
            })

            $("#responders-input .input").focus(function(){
                $("#responders-input .icon").css("color", "#000");
            })

            $("#responders-input .input").blur(function(){
                $("#responders-input .icon").css("color", "#b4b9bd");
            })

            $("#accident-input .input").focus(function(){
                $("#accident-input .icon").css("color", "#000");
            })

            $("#accident-input .input").blur(function(){
                $("#accident-input .icon").css("color", "#b4b9bd");
            })

            $("#barangay_p option").each(function(){
                if($('#barangay_p option').filter(':selected').text() == "Barangay"){
                    $("#barangay_p").css("color", "#767676");
                }
            })

            $("#barangay_p").change(function(){
                if ($('#barangay_p option').filter(':selected').text() != "Barangay") {
                    $("#barangay_p").css("color", "#000");
                }
            })



            $('#accidentsForm').on('submit', function(event){
                event.preventDefault();
                var form_data = $(this).serialize();
    
                $( "#action" ).prop( "disabled", true );
                
                $.ajax({
                    url:"{{ route('accidents.postdata') }}",
                    method: "POST",
                    data: form_data,
                    dataType: "json",
                    success:function(data){
                        console.log("success");
                        if(data.error.length > 0){
                            var error_html = '';
                            for(var count=0; count < data.error.length; count++){
                                error_html += data.error[count];
                            }

                            alertify.message('<span class="fa fa-exclamation-circle error-icon"></span>&nbsp&nbsp&nbsp&nbspSomething went wrong!.');
                        }
                        else{
                            if($('#button_action').val() == 'update'){
                                alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData updated!.');
                            }
                            if($('#button_action').val() == 'insert'){
                                alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData inserted!.');
                            }
                            document.getElementById("accidentsForm").reset();
                            $( "#action" ).prop( "disabled", false );
                            $("#barangay_p").css("color", "#767676");
                            $('#action').html('Add');
                            $('#button_action').val('insert');
                            $('.table').load('/accidents/getdata?query='+query+'&orderBy='+orderBy);
                            $('#title').text('Add Data');
                        }
                    }
                });
            });

            $(document).on('click','.editButton', function(){
                $('body').addClass("tingle-enabled");
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                var id = $(this).attr("id");
                $.cookie('checkboxValues1', "", { expires: 7, path: '/' });
                $.cookie('checkboxValues2', "", { expires: 7, path: '/' });
                $.ajax({
                    url: "{{ route('accidents.fetchdata') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){
                        var checkboxValues1 = {};
                        var checkboxValues2 = {};
                        var involves = JSON.parse(data.involvesID);
                        var responders = JSON.parse(data.respondersID);

                        involves.forEach(function(item){
                            checkboxValues1["p"+item] = true;
                        });
                        $.cookie('checkboxValues1', checkboxValues1, { expires: 7, path: '/' });


                        responders.forEach(function(item){
                            checkboxValues2["r"+item] = true;
                        });
                        $.cookie('checkboxValues2', checkboxValues2, { expires: 7, path: '/' });


                        $('.persons_table').load('/accidents/persons?query=');
                        $('.responders_table').load('/accidents/responders?query=');

                        $('#date').val(data.date);
                        $('#time').val(data.time);
                        $('#place').val(data.place[0]);
                        $('#barangay_p').val(data.place[1]);
                        $('#accident').val(data.accident);
                        $('#involvesID').val(data.involvesID);
                        $('#respondersID').val(data.respondersID);
                        $('#remarks').val(data.remarks);
                        $('#incident_id').val(id);
                        //$('#citizen_id').val(id);

                        $.ajax({
                            url: "{{ route('accidents.getName') }}",
                            method: "get",
                            data:{ id: JSON.stringify(involves) },
                            success: function(data){
                                data = JSON.parse(data);
                                var string = "";
                                for (var i=1; i<=data.length; i++){
                                    if(data.length != i)
                                        string += data[i-1].name+", ";
                                    else
                                        string += data[i-1].name;
                                }
                                $('#involves').val(string);
                            }
                        });

                        $.ajax({
                            url: "{{ route('accidents.getName2') }}",
                            method: "get",
                            data:{ id: JSON.stringify(responders) },
                            success: function(data){
                                data = JSON.parse(data);
                                var string = "";
                                for (var i=1; i<=data.length; i++){
                                    if(data.length != i)
                                        string += data[i-1].name+", ";
                                    else
                                        string += data[i-1].name;
                                }
                                $('#responders').val(string);
                                $('#loading').css({"visibility":"hidden","opacity":"0"});
                                $('#loading').html('');
                                openModal();
                            }
                        });
                        $("#barangay_p").css("color", "#000");
                        $('#button_action').val('update');
                        $('#action').html('Update');
                        $('#title').text('Edit Data');
                    }
                });
            });

            $(document).on('click','.deleteButton', function(){
                var id = $(this).attr('id');
                alertify.confirm("Are you sure you want to delete this data?.",
                function(){
                    $.ajax({
                        url: "{{ route('accidents.removedata') }}",
                        method: "get",
                        data: {id:id},
                        success: function(data){
                            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData deleted!.');
                            $('.table').load('/accidents/getdata?query='+query);
                        }
                    });
                  },
                function(){

                }).setHeader("Confirm");
            });
            
            $(document).on('change','#bulk_checkbox', function(){
                if(this.checked){
                    $(".incidentCheckbox").prop('checked', true).change();
                }
                else{
                    $(".incidentCheckbox").prop('checked', false).change();
                }
               // $('.myCheckbox').prop('checked', true);
            });
            
            $(document).on('click','#bulk_delete', function(){
                var id = [];
                $('.incidentCheckbox:checked').each(function(){
                    id.push($(this).val());
                });
                if(id.length > 0){
                    alertify.confirm("Are you sure you want to delete this data/s?.",
                    function(){
                            $.ajax({
                                url:"{{ route('accidents.massremove') }}",
                                method: "get",
                                data: {id:id},
                                success: function(data){
                                     alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData/s deleted!.');
                                    $('.table').load('/rescuers/getdata?query='+query);
                                }
                            });
                      },
                    function(){

                    }).setHeader("Confirm");
                }
                else{
                    alertify.message('<span class="fa fa-exclamation-triangle warning-icon"></span>&nbsp&nbsp&nbsp&nbspNo data/s selected.');
                }
            });

            $(document).on('click','.viewButton', function(){
                $('body').addClass("tingle-enabled");
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                var id = $(this).attr("id");
                $.cookie('checkboxValues1', "", { expires: 7, path: '/' });
                $.cookie('checkboxValues2', "", { expires: 7, path: '/' });
                $('.persons_table').load('/accidents/persons?query=');
                $('.responders_table').load('/accidents/responders?query=');
                $.ajax({
                    url: "{{ route('accidents.fetchdata') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){

                        $('.dateview').html(data.date);

                        var timeString = data.time;
                        var H = +timeString.substr(0, 2);
                        var h = (H % 12) || 12;
                        if(h<10){
                            h = '0'+h;
                        }
                        var ampm = H < 12 ? "AM" : "PM";
                        timeString = h + timeString.substr(2, 3) +' '+ ampm;

                        $('.timeview').html(timeString);
                        $('.placeview').html(data.place);
                        $('.typeview').html(data.accident);
                        if(data.remarks != null){
                            $('.remarkview').html(data.remarks);
                        }
                        else{
                            $('.remarkview').html("None");
                        }

                        var checkboxValues1 = {};
                        var checkboxValues2 = {};
                        var involves = JSON.parse(data.involvesID);
                        var responders = JSON.parse(data.respondersID);

                        involves.forEach(function(item){
                            checkboxValues1["p"+item] = true;
                        });
                        $.cookie('checkboxValues1', checkboxValues1, { expires: 7, path: '/' });


                        responders.forEach(function(item){
                            checkboxValues2["r"+item] = true;
                        });
                        $.cookie('checkboxValues2', checkboxValues2, { expires: 7, path: '/' });

                        $.ajax({
                            url: "{{ route('accidents.getName') }}",
                            method: "get",
                            data:{ id: JSON.stringify(involves) },
                            success: function(data){
                                data = JSON.parse(data);
                                var string = "";
                                for (var i=1; i<=data.length; i++){
                                    if(data.length != i)
                                        string += "<a class='c_inv' value='"+data[i-1].id+"' href=''>"+data[i-1].name+"</a>, ";
                                    else
                                        string += "<a class='c_inv' value='"+data[i-1].id+"' href=''>"+data[i-1].name+"</a>";
                                }
                                $('.involveview').html(string);
                            }
                        });

                        $.ajax({
                            url: "{{ route('accidents.getName2') }}",
                            method: "get",
                            data:{ id: JSON.stringify(responders) },
                            success: function(data){
                                data = JSON.parse(data);
                                var string = "";
                                for (var i=1; i<=data.length; i++){
                                    if(data.length != i)
                                        string += "<a class='c_respond' value='"+data[i-1].id+"' href=''>"+data[i-1].name+"</a>, ";
                                    else
                                        string += "<a class='c_respond' value='"+data[i-1].id+"' href=''>"+data[i-1].name+"</a>";
                                }
                                $('.responderview').html(string);
                                $('#loading').css({"visibility":"hidden","opacity":"0"});
                                $('#loading').html('');
                                openView();
                            }
                        });

                    }
                });
            });

            $(document).on('click','.c_inv', function(e){
                e.preventDefault();
                var id = $(this).attr("value");

                $.ajax({
                    url: "{{ route('accidents.citizendata') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){
                        $('.lastview').html(data.last_name);
                        $('.firstview').html(data.first_name);
                        if(data.middle_initial != null){
                            $('.middleview').html(data.middle_initial);
                        }
                        else{
                            $('.middleview').html("(None)");
                        }

                        $('.genderview').html(data.gender);
                        $('.barangayview').html(data.barangay);

                        viewPerson.open();
                    }
                });
            });


            $(document).on('click','.c_respond', function(e){
                e.preventDefault();
                var id = $(this).attr("value");

                $.ajax({
                    url: "{{ route('accidents.rescuerdata') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){
                        $('.rlastview').html(data.last_name);
                        $('.rfirstview').html(data.first_name);
                        if(data.middle_initial != null){
                            $('.rmiddleview').html(data.middle_initial);
                        }
                        else{
                            $('.rmiddleview').html("(None)");
                        }

                        $('.rgenderview').html(data.gender);
                        $('.rcontactview').html(data.contact);

                        viewResponder.open();
                    }
                });
            });


           $.cookie.json = true;
        });


    </script>
@endsection
