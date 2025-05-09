@extends('layouts.app')

@section('content')
    <div id="loading" class="tingle-modal" style="visibility: visible; opacity: 1;">
        <img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">
    </div>
    <div class="row">
        <div class="ctrl-row clearfix">
            <h1>Mobile Users</h1>
            <div class="input-group">
                <span class="fa fa-search icon"></span>
                <input type="text" placeholder="Search" id="search">
            </div>
        </div>
        <div class="table">
            <br><br><br>
            LOADING...
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
    <!--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>
        $(document).ready(function(){
            var rootRef = firebase.database().ref().child("Accounts");
            var accounts = [];
            var data;

            rootRef.once('value', snap => {
                snap.forEach(item => {
                    accounts.push({ "email": item.child("Email").val(), "name": (item.child("Name").val()).replace(/ /g,"%20"), "phone": item.child("Phone").val()});
                });

                data = JSON.stringify(accounts);
                console.log(JSON.stringify(accounts));
                /*
                $.ajax({
                    url: "{{ route('mobile-users.getdata') }}",
                    method: "get",
                    data: { data: data } ,
                    success: function(result){
                        console.log(result);
                    }
                });*/
                $('.table').load('/mobile-users/getdata?data='+data, function() {
                    $('#loading').css({"visibility":"hidden","opacity":"0"});
                    $('#loading').html('');
                });
            });

            $(document).on('click','.pagination a', function(e){
                e.preventDefault();

                $('#loading').css({"visibility":"visible","opacity":"1"});
                $('#loading').html('<img src="{{ asset('images/common/loading.gif') }}" style="position: absolute; left: 0; right: 0; margin: 0 auto; top: 50%; transform: translateY(-50%); width: 60px;">');
                
                var page = $(this).attr('href').split('page=')[1];

                getUsers(page);
            });

            function getUsers(page){
                $('.table').load('/mobile-users/getdata?data='+data+'&page='+page, function() {
                    $('#loading').css({"visibility":"hidden","opacity":"0"});
                    $('#loading').html('');
                });
            }

            /*
            var query = $('#search').val();

            function fetch_citizen(){
                console.log(query);
                $.ajax({
                    url: " route('mobile-users.getdata') }}",
                    method: "get",
                    data:{ query: query },
                    success: function(data){
                        $('.table').load('/records/getdata?query='+query);
                    }
                });
            }

            $(document).on('keyup', '#search', function(){
                query = $(this).val();
                fetch_citizen(query);
            });

            $('.table').load('/records/getdata?query='+query);

            $(document).on('click','.pagination a', function(e){
                e.preventDefault();

                var page = $(this).attr('href').split('page=')[1];

                getCitizen(page);
            });

            function getCitizen(page){
                $('.table').load('/records/getdata?query='+query+'&page='+page);
            }
            */

        });


    </script>
@endsection
