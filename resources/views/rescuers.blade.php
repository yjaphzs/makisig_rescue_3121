@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Rescuers</h1>
            <div class="input-group">
                <span class="fa fa-search icon"></span>
                <input type="text" placeholder="Search" id="search">
            </div>
            <button id="add_data">Add Record</button>
        </div>
        <div class="table">
            <br><br><br>
            LOADING...
        </div>
    </div>



    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>

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

        // set content
        modal.setContent(
            '<form method="post" id="rescuerForm">'+
            '<h1 id="title">Edit Data</h2>'+
            '<h1>Rescuer</h1>'+
            '{{ csrf_field() }}'+
            '<div id="name-input" class="input-group">'+
                '<span class="fa fa-user icon"></span>'+
                '<input id="last_name" name="last_name" class="input" type="text" placeholder="Last Name" autocomplete="off" required>'+
                '<input id="first_name" name="first_name" class="input" type="text" placeholder="First Name" autocomplete="off" required>'+
                '<input id="middle_initial" name="middle_initial" class="input" type="text" placeholder="Middle Initial" autocomplete="off">'+
            '</div>'+
            '<div id="gender-input" class="input-group">'+
                '<span class="fa fa-venus-mars icon"></span>'+
                '<select id="gender" name="gender" class="input" placeholder="Gender" required>'+
                    '<option value="" disabled selected>Gender</option>'+
                    '<option value="M">Male</option>'+
                    '<option value="F">Female</option>'+
                '</select>'+
            '</div>'+
            '<div id="brgy-input" class="input-group">'+
                '<span class="fa fa-phone icon"></span>'+
                '<input id="contact" name="contact" class="input" type="text" placeholder="Contact No." required>'+
            '</div>'+
            '<div class="btn-input tingle-modal-box__footer">'+
                '<input type="hidden" name="rescuer_id" id="rescuer_id" value="">'+
                '<input type="hidden" name="button_action" id="button_action" value="insert">'+
                '<button type="submit" class="tingle-btn tingle-btn--primary tingle-btn--pull-right" name="submit" id="action">Add</button>'+
                '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeModal();">Cancel</button>'+
            '</div>'+
            '</form>'
        );

        var incidentModal = new tingle.modal({
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


        incidentModal.setContent(
            '<h1>Accidents</h1>'

        );


        function openModal(){
            modal.open();
            $("#gender").css("color", "#767676");

        }

        function closeModal(){
            // close modal
            modal.close();
        }

        function openIncident(){
            incidentModal.open();
        }

        function closeIncident(){
            incidentModal.close();
        }


        $(document).ready(function(){

            var query = $('#search').val();
            var orderBy = "last_name";
            
            function fetch_citizen(){
                $('.table').load('/rescuers/getdata?query='+query+'&orderBy='+orderBy);
            }

            $(document).on('keyup', '#search', function(){
                query = $(this).val();
                query = encodeURIComponent(query.trim());
                fetch_citizen(query);
            });

            $('.table').load('/rescuers/getdata?query='+query+'&orderBy='+orderBy, function() {
                $('#loading').css({"visibility":"hidden","opacity":"0"});
                $('#loading').html('');
            });
            
            $(document).on('click','.drawer a', function(e){
                e.preventDefault();
                orderBy = $(this).attr('value');
                
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                $('.table').load('/rescuers/getdata?query='+query+'&orderBy='+orderBy, function() {
                    $('#loading').css({"visibility":"hidden","opacity":"0"});
                    $('#loading').html('');
                });
            });

            $(document).on('click','.pagination a', function(e){
                e.preventDefault();
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');
                var page = $(this).attr('href').split('page=')[1];

                getCitizen(page);
            });

            function getCitizen(page){
                $('.table').load('/rescuers/getdata?query='+query+'&page='+page+'&orderBy='+orderBy, function() {
                    $('#loading').css({"visibility":"hidden","opacity":"0"});
                    $('#loading').html('');
                });
            }

            $("#brgy-input .input").focus(function(){
                $("#brgy-input .icon").css("color", "#000");
            })

            $("#brgy-input .input").blur(function(){
                $("#brgy-input .icon").css("color", "#b4b9bd");
            })

            $("#gender-input .input").focus(function(){
                $("#gender-input .icon").css("color", "#000");
            })

            $("#gender-input .input").blur(function(){
                $("#gender-input .icon").css("color", "#b4b9bd");
            })

            $("#name-input .input").focus(function(){
                $("#name-input .icon").css("color", "#000");
            })

            $("#name-input .input").blur(function(){
                $("#name-input .icon").css("color", "#b4b9bd");
            })

            $('#gender option').each(function() {
                if($('#gender option').filter(':selected').text() == "Gender"){
                    $("#gender").css("color", "#767676");
                }
            });

            $('#gender').change(function() {
                if ($('#gender option').filter(':selected').text() != "Gender") {
                    $("#gender").css("color", "#000");
                }
            });


            $('#add_data').click(function(){
                openModal();
                document.getElementById("rescuerForm").reset();
                $('#button_action').val('insert');
                $('#action').val('Add');
                $('#title').text('Add Data');
                $('#action').html('Add');
            });

            $('#rescuerForm').on('submit', function(event){
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url:"{{ route('rescuers.postdata') }}",
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
                            document.getElementById("rescuerForm").reset();
                            $("#gender").css("color", "#767676");
                            $('#action').html('Add');
                            $('#button_action').val('insert');
                            $('.table').load('/rescuers/getdata?query='+query+'&orderBy='+orderBy);
                            $('#title').text('Add Data');
                        }
                    }
                });
            });

            $(document).on('click','.viewButton', function(){
                var id = $(this).attr("id");
                openIncident();
                /*
                $.ajax({
                    url: " route('rescuers.incidentfetch') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){
                        openModal();
                    }
                });
                */
            });


            $(document).on('click','.editButton', function(){
                $('body').addClass("tingle-enabled");
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{ route('rescuers.fetchdata') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){
                        $('#last_name').val(data.last_name);
                        $('#first_name').val(data.first_name);
                        $('#middle_initial').val(data.middle_initial);
                        $('#gender').val(data.gender);
                        $('#contact').val(data.contact);
                        $('#rescuer_id').val(id);
                        $('#loading').css({"visibility":"hidden","opacity":"0"});
                        $('#loading').html('');
                        openModal();
                        $("#gender").css("color", "#000");
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
                        url: "{{ route('rescuers.removedata') }}",
                        method: "get",
                        data: {id:id},
                        success: function(data){
                            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData deleted!.');
                            $('.table').load('/rescuers/getdata?query='+query);
                        }
                    });
                  },
                function(){

                }).setHeader("Confirm");
            });

            $(document).on('change','#bulk_checkbox', function(){
                if(this.checked){
                    $(".citizenCheckbox").prop('checked', true).change();
                }
                else{
                    $(".citizenCheckbox").prop('checked', false).change();
                }
               // $('.myCheckbox').prop('checked', true);
            });

            $(document).on('click','#bulk_delete', function(){
                var id = [];
                $('.citizenCheckbox:checked').each(function(){
                    id.push($(this).val());
                });
                if(id.length > 0){
                    alertify.confirm("Are you sure you want to delete this data/s?.",
                    function(){
                            $.ajax({
                                url:"{{ route('rescuers.massremove') }}",
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


        });


    </script>
@endsection
