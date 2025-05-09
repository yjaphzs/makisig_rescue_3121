@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Items Recovered</h1>
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
    <script src="http://cdn.jsdelivr.net/jquery.cookie/1.4.0/jquery.cookie.min.js"></script>
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
            '<form method="post" id="itemForm">'+
            '<h1 id="title">Edit Data</h2>'+
            '<h1>Items Recovered</h1>'+
            '{{ csrf_field() }}'+
            '<div class="inner-row">'+
                '<div id="owner-input" class="input-group">'+
                    '<span class="fa fa-user-injured icon"></span>'+
                    '<input id="owner" name="owner" class="input readonly" type="text" placeholder="Owner" required>'+
                '</div>'+
                '<button type="button" id="addOwner">Owner</button>'+
                '<input type="hidden" id="ownerID" name="ownerID" value="">'+
            '</div>'+
            '<div class="inner-row">'+
                '<div id="items-input" class="input-group">'+
                    '<span class="fa fa-clipboard icon"></span>'+
                    '<textarea id="items" name="items" class="input" placeholder="List of Items" required></textarea>'+
                '</div>'+
            '</div>'+
            '<div class="inner-row">'+
                '<div id="remarks-input" class="input-group">'+
                    '<span class="fa fa-clipboard icon"></span>'+
                    '<input id="remarks" name="remarks" class="input" type="text" placeholder="Remarks">'+
                '</div>'+
            '</div>'+
            '<div class="btn-input tingle-modal-box__footer">'+
                '<input type="hidden" name="item_id" id="item_id" value="">'+
                '<input type="hidden" name="button_action" id="button_action" value="insert">'+
                '<button type="submit" class="tingle-btn tingle-btn--primary tingle-btn--pull-right" name="submit" id="action">Add</button>'+
                '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeModal();">Cancel</button>'+
            '</div>'+
            '</form>'
        );

        var ownerModal = new tingle.modal({
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


       ownerModal.setContent(
                '<h1>Owner</h1>'+
                '<div class="input-group">'+
                    '<span class="fa fa-search icon"></span>'+
                    '<input type="text" placeholder="Search" id="osearch">'+
                '</div>'+
                '<div style="margin-top: 20px;">'+
                    '<table class="owner_table" style="height: 280px;">'+
                    '</table'+
                '</div>'+
                '<div class="btn-input tingle-modal-box__footer">'+
                        '<button type="button" class="tingle-btn tingle-btn--primary tingle-btn--pull-right" onclick="addOwner();">Add</button>'+
                        '<button type="button" class="tingle-btn tingle-btn--danger tingle-btn--pull-right" onclick="closeOwner();">Cancel</button>'+
                '</div>'
        );


        function openModal(){
            modal.open();
            $("#gender").css("color", "#767676");

        }

        function closeModal(){
            // close modal
            modal.close();
        }


        function addOwner(){
                ownerModal.close();
                owner = $.cookie('ownerValue');
                $('#ownerID').val(owner);

                $.ajax({
                    url: "{{ route('items.getName') }}",
                    method: "get",
                    data:{ id: owner },
                    success: function(data){
                        data = JSON.parse(data);
                        $('#owner').val(data);
                    }
                });

                $.removeCookie('checkboxValues3', { path: '/' });
                $.removeCookie('ownerValue', { path: '/' });
                $('.owner_table').load('/items/persons?query=');

            }

        function openOwner(){
            ownerModal.open();

        }

        function closeOwner(){
            // close modal
            ownerModal.close();
        }




        $(document).ready(function(){

            $(".readonly").keydown(function(e){
                e.preventDefault();
            });

            $('#addOwner').click(function(){

                openOwner();
            });

            var query = $('#search').val();
            var oquery = $('#osearch').val();
            var orderBy = "owner";

            function fetch_citizen(){
                $('.table').load('/items/getdata?query='+query);
            }

            $(document).on('keyup', '#osearch', function(){
                oquery = $(this).val();
                oquery = encodeURIComponent(oquery.trim());
                $('.owner_table').load('/items/persons?query='+oquery);
            });


            $(document).on('keyup', '#search', function(){
                query = $(this).val();
                query = encodeURIComponent(query.trim());
                fetch_citizen(query);
            });

            $('.table').load('/items/getdata?query='+query+'&orderBy='+orderBy, function() {
                $('#loading').css({"visibility":"hidden","opacity":"0"});
                $('#loading').html('');
            });
            $('.owner_table').load('/items/persons?query=');

            $(document).on('click','.drawer a', function(e){
                e.preventDefault();
                orderBy = $(this).attr('value');
                
                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');

                $('.table').load('/items/getdata?query='+query+'&orderBy='+orderBy, function() {
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
                $('.table').load('/items/getdata?query='+query+'&page='+page+'&orderBy='+orderBy, function() {
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
                $.removeCookie('checkboxValues3', { path: '/' });
                $.removeCookie('ownerValue', { path: '/' });
                $('.owner_table').load('/items/persons?query=');
                openModal();
                document.getElementById("itemForm").reset();
                $('#button_action').val('insert');
                $('#action').val('Add');
                $('#title').text('Add Data');
                $('#action').html('Add');
            });

            $('#itemForm').on('submit', function(event){
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url:"{{ route('items.postdata') }}",
                    method: "POST",
                    data: form_data,
                    dataType: "json",
                    success:function(data){
                        if(data.error.length > 0){
                            var error_html = '';
                            for(var count=0; count < data.error.length; count++){
                                error_html += data.error[count];
                            }
                            console.log(error_html);
                            alertify.message('<span class="fa fa-exclamation-circle error-icon"></span>&nbsp&nbsp&nbsp&nbspSomething went wrong!.');
                        }
                        else{
                            if($('#button_action').val() == 'update'){
                                alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData updated!.');
                            }
                            if($('#button_action').val() == 'insert'){
                                alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData inserted!.');
                            }
                            document.getElementById("itemForm").reset();
                            $('#action').html('Add');
                            $('#button_action').val('insert');
                            $('.table').load('/items/getdata?query='+query+'&orderBy='+orderBy);
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
                    url: " route('items.incidentfetch') }}",
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

                $.cookie('checkboxValues3', "", { expires: 7, path: '/' });
                $.ajax({
                    url: "{{ route('items.fetchdata') }}",
                    method: "get",
                    data: {id:id},
                    dataType: 'json',
                    success: function(data){;
                        var ownerID = JSON.parse(data.ownerID);
                        var checkboxValues3 = {};
                        checkboxValues3["p"+ownerID] = true;
                        $.cookie('checkboxValues3', checkboxValues3, { expires: 7, path: '/' });
                        $('.owner_table').load('/items/persons?query=');

                        $('#ownerID').val(ownerID);
                        $('#items').val(data.items);
                        $('#remarks').val(data.remarks);
                        $('#item_id').val(id);

                        $.ajax({
                            url: "{{ route('items.getName') }}",
                            method: "get",
                            data:{ id: ownerID },
                            success: function(data){
                                data = JSON.parse(data);
                                $('#owner').val(data);
                                $('#loading').css({"visibility":"hidden","opacity":"0"});
                                $('#loading').html('');
                                openModal();
                            }
                        });

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
                        url: "{{ route('items.removedata') }}",
                        method: "get",
                        data: {id:id},
                        success: function(data){
                            alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData deleted!.');
                            $('.table').load('/items/getdata?query='+query+'&orderBy='+orderBy);
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
                                url:"{{ route('items.massremove') }}",
                                method: "get",
                                data: {id:id},
                                success: function(data){
                                     alertify.message('<span class="fa fa-check-square  success-icon"></span>&nbsp&nbsp&nbsp&nbspData/s deleted!.');
                                    $('.table').load('/items/getdata?query='+query+'&orderBy='+orderBy);
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

                $.cookie.json = true;
        });


    </script>

@endsection
