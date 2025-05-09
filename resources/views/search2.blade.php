
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <button><span class="fa fa-filter"></span><span class="fa fa-angle-down"></span></button>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody class="content">
                    @foreach($collection as $row)
                    <tr>
                        <td></td>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['email'] }}</td>
                        <?php
                            if($row['phone'] != ""){
                                $phone_number = substr($row['phone'], 3,10);
                                $phone_number = "0".$phone_number;
                            }
                            else{
                                $phone_number = "";
                            }
                        ?>
                        <td class="phone">{{ $phone_number }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        {{ $collection->onEachSide(1)->links() }}
