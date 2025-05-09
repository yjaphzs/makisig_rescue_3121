<style>
    .content {
        display:block;
        text-align: center;
        padding: 30px 20px;
    }

    td {
        text-align: center;
    }
    table {
        margin: 0 auto;
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
    }

    h2 {
        text-align: left;
        margin: 0;
    }
    small {
        display: block;
        text-align: left;
    }

    .title-container {
        display: -webkit-flex;
        display: flex;
    }

    .image-container {
        max-width: 60px;
        margin-right: 10px;
    }

    .image-container img {
        width: 100%;
    }

    .details-container {
        margin-left: 70px;
    }
</style>
<?php
    $ctr = 0;
    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
?>
<div class="content">
    <div class="title-container">
        <div class="image-container">
            <img src="{{ asset('images/common/logo.png') }}" alt="San Jose City Seal">
        </div>
        <div class="details-container">
            <h2>Makisig Rescue 3121</h2>
            <small>San Jose City<br>N.E. 09179329939</small>
        </div>
    </div>
    <h3>Total Accidents in Year {{ $year }}</h3>
    <table>
        <thead>
            <tr>
                <th>Month Name</th>
                <th>No. of Accidents</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accidents as $row)
                <tr>
                    <td>{{ $months[$ctr] }}</td>
                    <td>{{ $row }}</td>
                </tr>
                <?php $ctr = $ctr + 1; ?>
            @endforeach
            <tr>
                <td><b>TOTAL:</b></td>
                <td>{{ $total }}</td>
            </tr>
        </tbody>
    </table>
</div>
